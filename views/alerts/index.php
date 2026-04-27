<?php
$pageTitle = 'Alerts';
ob_start();
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Alerts</h1>
        <p class="page-subtitle">LinkSquad monitoring notifications</p>
    </div>
    <div class="page-actions">
        <?php if ($unreadAlerts > 0): ?>
            <form method="POST" action="<?= APP_URL ?>/alerts/read-all" style="display:inline;">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <button type="submit" class="btn btn-secondary">
                    <i data-lucide="check-check" style="width:16px;height:16px;"></i> Mark All Read
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>

<div class="page-body">
    <!-- Filter -->
    <div class="filter-bar">
        <a href="<?= APP_URL ?>/alerts" class="filter-chip <?= empty($typeFilter) ? 'active' : '' ?>">All</a>
        <a href="<?= APP_URL ?>/alerts?type=404_error" class="filter-chip <?= $typeFilter === '404_error' ? 'active' : '' ?>">🔴 404 Error</a>
        <a href="<?= APP_URL ?>/alerts?type=anchor_missing" class="filter-chip <?= $typeFilter === 'anchor_missing' ? 'active' : '' ?>">⚠️ Anchor Missing</a>
        <a href="<?= APP_URL ?>/alerts?type=url_changed" class="filter-chip <?= $typeFilter === 'url_changed' ? 'active' : '' ?>">🔄 URL Changed</a>
        <a href="<?= APP_URL ?>/alerts?type=timeout" class="filter-chip <?= $typeFilter === 'timeout' ? 'active' : '' ?>">⏱️ Timeout</a>
    </div>
    
    <?php if (empty($alerts)): ?>
        <div class="card">
            <div class="empty-state">
                <div class="empty-state-icon">🛡️</div>
                <div class="empty-state-title">No Alerts</div>
                <div class="empty-state-text">LinkSquad is actively monitoring your backlinks. You'll be notified of any issues.</div>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <ul class="alert-list">
                <?php foreach ($alerts as $alert): ?>
                    <li class="alert-item <?= !$alert['is_read'] ? 'unread' : '' ?>" data-alert-id="<?= $alert['id'] ?>">
                        <div class="alert-icon <?= $alert['severity'] ?>">
                            <?php
                            $icons = ['404_error' => '🔴', 'anchor_missing' => '⚠️', 'url_changed' => '🔄', 'timeout' => '⏱️', 'order_complete' => '✅', 'report_ready' => '📊'];
                            echo $icons[$alert['alert_type']] ?? '🔔';
                            ?>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">
                                <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $alert['alert_type']))) ?>
                                <?php if ($alert['severity'] === 'critical'): ?>
                                    <span class="badge badge-lost" style="margin-left:6px;">Critical</span>
                                <?php endif; ?>
                            </div>
                            <div class="alert-message"><?= htmlspecialchars($alert['message']) ?></div>
                            <?php if (!empty($alert['details'])): ?>
                                <div class="alert-message text-mono" style="font-size:11px;margin-top:4px;"><?= htmlspecialchars($alert['details']) ?></div>
                            <?php endif; ?>
                            <div class="alert-meta">
                                <?php if (!empty($alert['project_name'])): ?>
                                    <span>📁 <?= htmlspecialchars($alert['project_name']) ?></span>
                                <?php endif; ?>
                                <span>🕐 <?= date('M j, Y g:i A', strtotime($alert['created_at'])) ?></span>
                                <?php if ($alert['email_sent']): ?>
                                    <span>📧 Email sent</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (!$alert['is_read']): ?>
                            <button class="btn btn-sm btn-secondary" onclick="markAlertRead(<?= $alert['id'] ?>, '<?= $csrf ?>')" title="Mark as read">
                                <i data-lucide="check" style="width:14px;height:14px;"></i>
                            </button>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
