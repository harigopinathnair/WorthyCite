<?php
/**
 * Worthycite - LinkSquad Module
 * Daily Backlink Monitoring Cron Job
 * 
 * Run via cron: php c:\xampp\htdocs\worthycite\cron\linksquad.php
 * Or via browser: http://localhost/worthycite/cron/linksquad.php?key=YOUR_SECRET
 * 
 * Checks all active backlinks for:
 * 1. 404 errors (page not found)
 * 2. URL changes/redirects
 * 3. Missing anchor text
 */

// Security: only run from CLI or with secret key
$isCLI = (php_sapi_name() === 'cli');
$secretKey = 'worthycite_linksquad_2026'; // Change this in production

if (!$isCLI && ($_GET['key'] ?? '') !== $secretKey) {
    http_response_code(403);
    die('Access denied.');
}

// Bootstrap
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/config/app.php';

echo "=== LinkSquad Backlink Monitor ===\n";
echo "Started: " . date('Y-m-d H:i:s') . "\n\n";

$backlinkModel = new Backlink();
$alertModel = new Alert();
$userModel = new User();

// Get all active backlinks that need checking
$backlinks = $backlinkModel->getActiveBacklinks();
$totalChecked = 0;
$issuesFound = 0;

echo "Found " . count($backlinks) . " backlinks to check.\n\n";

foreach ($backlinks as $bl) {
    $totalChecked++;
    echo "[{$totalChecked}/" . count($backlinks) . "] Checking: {$bl['source_url']}\n";
    
    $result = checkBacklink($bl);
    
    // Log the result
    logCheck($bl['id'], $result);
    
    // Update last_checked timestamp
    $backlinkModel->update($bl['id'], ['last_checked' => date('Y-m-d H:i:s')]);
    
    // Process issues
    if (!empty($result['issues'])) {
        $issuesFound++;
        $severity = 'warning';
        
        foreach ($result['issues'] as $issue) {
            echo "  ⚠ ISSUE: {$issue['type']} - {$issue['message']}\n";
            
            // Determine severity
            if ($issue['type'] === '404_error') {
                $severity = 'critical';
                $backlinkModel->update($bl['id'], ['status' => 'lost']);
            } elseif ($issue['type'] === 'anchor_missing') {
                $severity = 'warning';
                $backlinkModel->update($bl['id'], ['status' => 'warning']);
            } elseif ($issue['type'] === 'url_changed') {
                $severity = 'warning';
                $backlinkModel->update($bl['id'], ['status' => 'warning']);
            }
            
            // Create alert
            $alertId = $alertModel->createAlert([
                'user_id'     => $bl['user_id'],
                'project_id'  => $bl['project_id'],
                'backlink_id' => $bl['id'],
                'alert_type'  => $issue['type'],
                'severity'    => $severity,
                'message'     => $issue['message'],
                'details'     => $issue['details'] ?? null,
                'email_sent'  => 0
            ]);
            
            // Send immediate email for critical issues
            $user = $userModel->findById($bl['user_id']);
            if ($user && $user['email_notifications']) {
                $alertData = [
                    'alert_type' => $issue['type'],
                    'severity'   => $severity,
                    'message'    => $issue['message']
                ];
                
                $emailSent = Mailer::sendAlert($user['email'], $user['name'], $alertData);
                if ($emailSent) {
                    $alertModel->update($alertId, ['email_sent' => 1]);
                    echo "  📧 Email alert sent to {$user['email']}\n";
                }
            }
        }
    } else {
        // No issues - ensure status is active
        if ($bl['status'] !== 'active') {
            $backlinkModel->update($bl['id'], ['status' => 'active']);
        }
        echo "  ✓ OK (HTTP {$result['http_status']}, anchor: " . ($result['anchor_found'] ? 'found' : 'N/A') . ")\n";
    }
    
    // Small delay to be nice to servers
    usleep(500000); // 0.5 second delay between checks
}

echo "\n=== Summary ===\n";
echo "Total checked: {$totalChecked}\n";
echo "Issues found: {$issuesFound}\n";
echo "Completed: " . date('Y-m-d H:i:s') . "\n";


/**
 * Check a single backlink
 */
function checkBacklink(array $backlink): array {
    $result = [
        'http_status'    => null,
        'anchor_found'   => null,
        'url_redirected' => false,
        'new_url'        => null,
        'response_time'  => null,
        'error'          => null,
        'issues'         => []
    ];
    
    $startTime = microtime(true);
    
    // Build cURL request
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $backlink['source_url'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => LINKSQUAD_MAX_REDIRECTS,
        CURLOPT_TIMEOUT        => LINKSQUAD_TIMEOUT,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_USERAGENT      => LINKSQUAD_USER_AGENT,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_ENCODING       => '', // accept all encodings
        CURLOPT_HTTPHEADER     => [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.5'
        ]
    ]);
    
    $response = curl_exec($ch);
    $result['response_time'] = round((microtime(true) - $startTime) * 1000);
    
    if (curl_errno($ch)) {
        $result['error'] = curl_error($ch);
        $result['issues'][] = [
            'type'    => 'timeout',
            'message' => "Could not reach {$backlink['source_url']}: " . curl_error($ch),
            'details' => "cURL error: " . curl_error($ch)
        ];
        curl_close($ch);
        return $result;
    }
    
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    $result['http_status'] = $httpStatus;
    
    curl_close($ch);
    
    // Check 1: HTTP Status (404 detection)
    if ($httpStatus === 404) {
        $result['issues'][] = [
            'type'    => '404_error',
            'message' => "Source page returning 404 Not Found: {$backlink['source_url']}",
            'details' => "HTTP Status: 404. The page where your backlink was placed no longer exists."
        ];
    } elseif ($httpStatus >= 400) {
        $result['issues'][] = [
            'type'    => '404_error',
            'message' => "Source page returning HTTP {$httpStatus}: {$backlink['source_url']}",
            'details' => "HTTP Status: {$httpStatus}. The page may have been removed or is experiencing issues."
        ];
    }
    
    // Check 2: URL Redirect Detection
    if ($effectiveUrl !== $backlink['source_url']) {
        $result['url_redirected'] = true;
        $result['new_url'] = $effectiveUrl;
        
        // Only flag as issue if domain changed significantly
        $originalHost = parse_url($backlink['source_url'], PHP_URL_HOST);
        $newHost = parse_url($effectiveUrl, PHP_URL_HOST);
        
        if ($originalHost !== $newHost) {
            $result['issues'][] = [
                'type'    => 'url_changed',
                'message' => "URL redirected to a different domain: {$effectiveUrl}",
                'details' => "Original: {$backlink['source_url']}\nRedirected to: {$effectiveUrl}"
            ];
        }
    }
    
    // Check 3: Anchor Text Verification
    if (!empty($backlink['anchor_text']) && $httpStatus === 200 && $response) {
        $anchorText = $backlink['anchor_text'];
        $targetUrl = $backlink['target_url'];
        
        // Parse the HTML and look for links
        $anchorFound = false;
        
        // Method 1: Check for exact anchor text in links
        if (preg_match_all('/<a\s[^>]*href=["\']([^"\']*)["\'][^>]*>(.*?)<\/a>/si', $response, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $href = $match[1];
                $linkText = strip_tags($match[2]);
                
                // Check if the link points to our target URL and contains our anchor
                if ((stripos($href, $targetUrl) !== false || stripos($targetUrl, $href) !== false) &&
                    stripos(trim($linkText), $anchorText) !== false) {
                    $anchorFound = true;
                    break;
                }
            }
        }
        
        // Method 2: Fallback - just check if anchor text exists anywhere in links pointing to target
        if (!$anchorFound) {
            $targetDomain = parse_url($targetUrl, PHP_URL_HOST);
            if ($targetDomain && preg_match_all('/<a\s[^>]*href=["\']([^"\']*)["\'][^>]*>(.*?)<\/a>/si', $response, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $href = $match[1];
                    $linkText = strip_tags($match[2]);
                    
                    if (stripos($href, $targetDomain) !== false && stripos(trim($linkText), $anchorText) !== false) {
                        $anchorFound = true;
                        break;
                    }
                }
            }
        }
        
        $result['anchor_found'] = $anchorFound;
        
        if (!$anchorFound) {
            $result['issues'][] = [
                'type'    => 'anchor_missing',
                'message' => "Anchor text \"{$anchorText}\" not found on {$backlink['source_url']}",
                'details' => "Expected anchor text: \"{$anchorText}\"\nTarget URL: {$targetUrl}\nThe link may have been removed or the anchor text was changed."
            ];
        }
    }
    
    return $result;
}

/**
 * Log the check result to linksquad_logs table
 */
function logCheck(int $backlinkId, array $result): void {
    $db = getDB();
    $stmt = $db->prepare(
        "INSERT INTO linksquad_logs (backlink_id, http_status, anchor_found, url_redirected, new_url, response_time_ms, error_message) 
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([
        $backlinkId,
        $result['http_status'],
        $result['anchor_found'] !== null ? ($result['anchor_found'] ? 1 : 0) : null,
        $result['url_redirected'] ? 1 : 0,
        $result['new_url'],
        $result['response_time'],
        $result['error']
    ]);
}
