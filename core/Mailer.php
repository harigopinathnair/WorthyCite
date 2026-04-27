<?php
/**
 * Worthycite - Mailer Helper
 */
class Mailer {
    
    public static function send(string $to, string $subject, string $htmlBody): bool {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: " . MAIL_FROM_NAME . " <" . MAIL_FROM . ">\r\n";
        $headers .= "X-Mailer: Worthycite/1.0\r\n";
        
        return @mail($to, $subject, $htmlBody, $headers);
    }
    
    public static function sendAlert(string $to, string $userName, array $alert): bool {
        $severityColors = [
            'critical' => '#f43f5e',
            'warning'  => '#f59e0b',
            'info'     => '#6366f1'
        ];
        $color = $severityColors[$alert['severity']] ?? '#6366f1';
        
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:0;background:#0a0e27;font-family:Inter,sans-serif;">';
        $html .= '<div style="max-width:600px;margin:40px auto;background:#131738;border-radius:16px;overflow:hidden;border:1px solid rgba(99,102,241,0.2);">';
        $html .= '<div style="background:linear-gradient(135deg,#6366f1,#8b5cf6);padding:32px;text-align:center;">';
        $html .= '<h1 style="color:#fff;margin:0;font-size:24px;">⚡ Worthycite Alert</h1>';
        $html .= '</div>';
        $html .= '<div style="padding:32px;">';
        $html .= '<p style="color:#94a3b8;margin:0 0 16px;">Hi ' . htmlspecialchars($userName) . ',</p>';
        $html .= '<div style="background:rgba(99,102,241,0.1);border-left:4px solid ' . $color . ';padding:16px;border-radius:8px;margin:16px 0;">';
        $html .= '<p style="color:#e2e8f0;margin:0;font-weight:600;">' . htmlspecialchars(ucfirst(str_replace('_', ' ', $alert['alert_type']))) . '</p>';
        $html .= '<p style="color:#94a3b8;margin:8px 0 0;">' . htmlspecialchars($alert['message']) . '</p>';
        $html .= '</div>';
        $html .= '<a href="' . APP_URL . '/alerts" style="display:inline-block;margin-top:24px;padding:12px 24px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;text-decoration:none;border-radius:8px;font-weight:600;">View in Dashboard</a>';
        $html .= '</div>';
        $html .= '<div style="padding:16px 32px;border-top:1px solid rgba(99,102,241,0.1);text-align:center;">';
        $html .= '<p style="color:#475569;font-size:12px;margin:0;">Worthycite - Backlink Tracking & Management</p>';
        $html .= '</div></div></body></html>';
        
        return self::send($to, '⚡ Worthycite Alert: ' . ucfirst(str_replace('_', ' ', $alert['alert_type'])), $html);
    }
    
    public static function sendMonthlyReport(string $to, string $userName, array $reportData): bool {
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:0;background:#0a0e27;font-family:Inter,sans-serif;">';
        $html .= '<div style="max-width:600px;margin:40px auto;background:#131738;border-radius:16px;overflow:hidden;border:1px solid rgba(99,102,241,0.2);">';
        $html .= '<div style="background:linear-gradient(135deg,#6366f1,#8b5cf6);padding:32px;text-align:center;">';
        $html .= '<h1 style="color:#fff;margin:0;font-size:24px;">📊 Monthly Backlink Report</h1>';
        $html .= '<p style="color:rgba(255,255,255,0.8);margin:8px 0 0;">' . $reportData['period'] . '</p>';
        $html .= '</div>';
        $html .= '<div style="padding:32px;">';
        $html .= '<p style="color:#94a3b8;margin:0 0 24px;">Hi ' . htmlspecialchars($userName) . ', here\'s your monthly summary:</p>';
        
        // Stats boxes
        $stats = [
            ['label' => 'Total Backlinks', 'value' => $reportData['total'] ?? 0, 'color' => '#6366f1'],
            ['label' => 'New This Month', 'value' => $reportData['new'] ?? 0, 'color' => '#10b981'],
            ['label' => 'Lost', 'value' => $reportData['lost'] ?? 0, 'color' => '#f43f5e'],
            ['label' => 'Active', 'value' => $reportData['active'] ?? 0, 'color' => '#06b6d4'],
        ];
        
        $html .= '<div style="display:flex;flex-wrap:wrap;gap:12px;margin:16px 0;">';
        foreach ($stats as $stat) {
            $html .= '<div style="flex:1;min-width:120px;background:rgba(99,102,241,0.1);padding:16px;border-radius:8px;text-align:center;">';
            $html .= '<div style="color:' . $stat['color'] . ';font-size:28px;font-weight:700;">' . $stat['value'] . '</div>';
            $html .= '<div style="color:#94a3b8;font-size:12px;margin-top:4px;">' . $stat['label'] . '</div>';
            $html .= '</div>';
        }
        $html .= '</div>';
        
        $html .= '<a href="' . APP_URL . '/reports" style="display:inline-block;margin-top:24px;padding:12px 24px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;text-decoration:none;border-radius:8px;font-weight:600;">View Full Report</a>';
        $html .= '</div>';
        $html .= '<div style="padding:16px 32px;border-top:1px solid rgba(99,102,241,0.1);text-align:center;">';
        $html .= '<p style="color:#475569;font-size:12px;margin:0;">Worthycite - Backlink Tracking & Management</p>';
        $html .= '</div></div></body></html>';
        
        return self::send($to, '📊 Worthycite Monthly Report - ' . ($reportData['period'] ?? ''), $html);
    }
}
