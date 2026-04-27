<?php
/**
 * Main App Layout - Authenticated pages
 */
$currentPage = isset($_GET['url']) ? explode('/', trim($_GET['url'], '/'))[0] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Dashboard' ?> — Worthycite</title>
    <meta name="description" content="Worthycite - Track, monitor, and manage your backlinks efficiently.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400..800;1,9..40,400..800&family=JetBrains+Mono:wght@400..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/app.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚡</text></svg>">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>const APP_URL = '<?= APP_URL ?>';</script>
</head>
<body>
    <div class="app-layout">
        <!-- Mobile Toggle -->
        <button class="mobile-toggle" aria-label="Toggle menu">
            <i data-lucide="menu" style="width:20px;height:20px;"></i>
        </button>
        <div class="mobile-overlay"></div>
        
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="logo">W</div>
                <h1>Worthycite</h1>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Main</div>
                    <a href="<?= APP_URL ?>/dashboard" class="nav-link <?= $currentPage === 'dashboard' || $currentPage === '' ? 'active' : '' ?>">
                        <i data-lucide="layout-dashboard"></i>
                        Dashboard
                    </a>
                    <a href="<?= APP_URL ?>/projects" class="nav-link <?= $currentPage === 'projects' ? 'active' : '' ?>">
                        <i data-lucide="globe"></i>
                        Portfolios
                    </a>
                    <a href="<?= APP_URL ?>/contacts" class="nav-link <?= $currentPage === 'contacts' ? 'active' : '' ?>">
                        <i data-lucide="users"></i>
                        Vendor Contacts
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Backlinks</div>
                    <a href="<?= APP_URL ?>/orders" class="nav-link <?= $currentPage === 'orders' ? 'active' : '' ?>">
                        <i data-lucide="shopping-cart"></i>
                        Order Backlinks
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Monitoring</div>
                    <a href="<?= APP_URL ?>/alerts" class="nav-link <?= $currentPage === 'alerts' ? 'active' : '' ?>">
                        <i data-lucide="bell"></i>
                        Alerts
                        <?php if (!empty($unreadAlerts) && $unreadAlerts > 0): ?>
                            <span class="nav-badge"><?= $unreadAlerts ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?= APP_URL ?>/reports" class="nav-link <?= $currentPage === 'reports' ? 'active' : '' ?>">
                        <i data-lucide="bar-chart-3"></i>
                        Reports
                    </a>
                    <a href="<?= APP_URL ?>/billing" class="nav-link <?= $currentPage === 'billing' ? 'active' : '' ?>">
                        <i data-lucide="credit-card"></i>
                        Billing
                    </a>
                    
                </div>
            </nav>
            
            <?php if (($user['plan'] ?? 'free') === 'free'): ?>
            <div class="sidebar-upgrade">
                <div class="upgrade-card">
                    <div class="upgrade-icon">👑</div>
                    <div class="upgrade-title">Upgrade to Pro</div>
                    <div class="upgrade-text">Track up to 5 websites &amp; 500 backlinks each</div>
                    <a href="<?= APP_URL ?>/billing" class="btn btn-upgrade">Upgrade Now</a>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?></div>
                    <div class="user-info">
                        <div class="user-name"><?= htmlspecialchars($user['name'] ?? 'User') ?></div>
                        <div class="user-plan"><?= ucfirst($user['plan'] ?? 'free') ?> Plan</div>
                    </div>
                    <a href="<?= APP_URL ?>/logout" title="Logout" style="color:var(--text-muted);">
                        <i data-lucide="log-out" style="width:18px;height:18px;"></i>
                    </a>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <?php if (!empty($flash)): ?>
                <div style="padding: 16px 32px 0;">
                    <div class="flash-message flash-<?= $flash['type'] ?>">
                        <?= $flash['type'] === 'error' ? '⚠️' : ($flash['type'] === 'warning' ? '⚡' : '✅') ?>
                        <?= htmlspecialchars($flash['message']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?= $content ?? '' ?>
        </main>
    </div>
    
    <script src="<?= APP_URL ?>/assets/js/app.js"></script>
    <script>lucide.createIcons();</script>
</body>
</html>
