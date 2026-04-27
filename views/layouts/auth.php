<?php
/**
 * Auth Layout - Login/Register pages
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Worthycite' ?> — Backlink Tracking & Management</title>
    <meta name="description" content="Worthycite - Premium backlink tracking, monitoring, and management SaaS platform.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400..800;1,9..40,400..800&family=JetBrains+Mono:wght@400..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/app.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚡</text></svg>">
</head>
<body>
    <div class="auth-layout">
        <div class="auth-card">
            <div class="auth-logo">
                <div class="logo">W</div>
                <h2>Worthycite</h2>
                <p><?= $pageSubtitle ?? 'Backlink Tracking & Management' ?></p>
            </div>
            
            <?php if (!empty($flash)): ?>
                <div class="flash-message flash-<?= $flash['type'] ?>">
                    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?>
                    <?= htmlspecialchars($flash['message']) ?>
                </div>
            <?php endif; ?>
            
            <?= $content ?? '' ?>
        </div>
    </div>
</body>
</html>
