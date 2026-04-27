<?php
$pageTitle = htmlspecialchars($project['name']);
ob_start();
?>

<div class="page-header">
    <div>
        <h1 class="page-title" style="display:flex;align-items:center;gap:12px;">
            <span class="project-favicon" style="width:36px;height:36px;font-size:16px;border-radius:8px;"><?= strtoupper(substr($project['name'], 0, 1)) ?></span>
            <?= htmlspecialchars($project['name']) ?>
        </h1>
        <p class="page-subtitle text-mono"><?= htmlspecialchars($project['domain']) ?></p>
    </div>
    <div class="page-actions">
        <?php if (isset($backlinkLimit) && $backlinkLimit['allowed']): ?>

            <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>/backlinks/create" class="btn btn-primary">
                <i data-lucide="plus" style="width:16px;height:16px;"></i> Add Backlink
            </a>
        <?php else: ?>
            <a href="<?= APP_URL ?>/billing" class="btn btn-upgrade">
                <i data-lucide="zap" style="width:16px;height:16px;"></i> Upgrade for More
            </a>
        <?php endif; ?>
        <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>/edit" class="btn btn-secondary">
            <i data-lucide="settings" style="width:16px;height:16px;"></i> Edit
        </a>
    </div>
</div>

<!-- Stats -->
<div style="padding:24px 32px 0;">
    <div class="stats-grid" style="grid-template-columns:repeat(4, 1fr);">
        <div class="stat-card accent animate-in">
            <div class="stat-icon accent"><i data-lucide="link" style="width:22px;height:22px;"></i></div>
            <div>
                <div class="stat-value"><?= $project['backlink_count'] ?? 0 ?></div>
                <div class="stat-label">Total Backlinks</div>
            </div>
        </div>
        <div class="stat-card success animate-in">
            <div class="stat-icon success"><i data-lucide="check-circle" style="width:22px;height:22px;"></i></div>
            <div>
                <div class="stat-value"><?= $project['active_count'] ?? 0 ?></div>
                <div class="stat-label">Active</div>
            </div>
        </div>
        <div class="stat-card danger animate-in">
            <div class="stat-icon danger"><i data-lucide="x-circle" style="width:22px;height:22px;"></i></div>
            <div>
                <div class="stat-value"><?= $project['lost_count'] ?? 0 ?></div>
                <div class="stat-label">Lost</div>
            </div>
        </div>
        <div class="stat-card info animate-in">
            <div class="stat-icon info"><i data-lucide="shopping-cart" style="width:22px;height:22px;"></i></div>
            <div>
                <div class="stat-value"><?= $project['order_count'] ?? 0 ?></div>
                <div class="stat-label">Orders</div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($backlinkLimit) && $backlinkLimit['max'] !== -1): ?>
<div style="padding:16px 32px 0;">
    <div class="limit-banner <?= !$backlinkLimit['allowed'] ? 'at-limit' : '' ?> animate-in">
        <div class="limit-info">
            <span class="limit-label">
                <i data-lucide="link" style="width:14px;height:14px;"></i>
                Backlinks: <strong><?= $backlinkLimit['current'] ?></strong> of <strong><?= $backlinkLimit['max'] ?></strong> used
            </span>
            <div class="limit-bar-wrap">
                <div class="limit-bar" style="width:<?= min(100, ($backlinkLimit['current'] / max(1, $backlinkLimit['max'])) * 100) ?>%"></div>
            </div>
        </div>
        <?php if (!$backlinkLimit['allowed']): ?>
            <a href="<?= APP_URL ?>/billing" class="btn btn-sm btn-upgrade">Upgrade</a>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Tabs -->
<div class="tabs">
    <a class="tab-link <?= $tab === 'backlinks' ? 'active' : '' ?>" data-tab="backlinks" href="#">Backlinks</a>
    <a class="tab-link <?= $tab === 'orders' ? 'active' : '' ?>" data-tab="orders" href="#">Orders</a>
</div>

<div class="page-body">
    <!-- Backlinks Tab -->
    <div id="backlinks" class="tab-content <?= $tab === 'backlinks' ? 'active' : '' ?>">
        <?php if (empty($backlinks)): ?>
            <div class="card">
                <div class="empty-state">
                    <div class="empty-state-icon">🔗</div>
                    <div class="empty-state-title">No Backlinks Yet</div>
                    <div class="empty-state-text">Start tracking backlinks for this project.</div>
                    <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>/backlinks/create" class="btn btn-primary">
                        <i data-lucide="plus" style="width:16px;height:16px;"></i> Add Backlink
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="table-container" style="border:none;border-radius:0;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Source URL</th>
                                <th>Target URL</th>
                                <th>Vendor</th>
                                <th>Anchor Text</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>DA</th>
                                <th>Acquired</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($backlinks as $bl): ?>
                                <tr>
                                    <td><a href="<?= htmlspecialchars($bl['source_url']) ?>" target="_blank" class="truncate" style="font-size:12px;font-family:'JetBrains Mono',monospace;" title="<?= htmlspecialchars($bl['source_url']) ?>"><?= htmlspecialchars($bl['source_url']) ?></a></td>
                                    <td><span class="truncate text-mono" style="font-size:12px;" title="<?= htmlspecialchars($bl['target_url']) ?>"><?= htmlspecialchars($bl['target_url']) ?></span></td>
                                    <td>
                                        <?php if (!empty($bl['vendor_id'])): ?>
                                            <a href="<?= APP_URL ?>/contacts/<?= $bl['vendor_id'] ?>/edit" class="badge badge-info" style="font-family:'DM Sans';font-weight:600;font-size:11px;text-decoration:none;"><?= htmlspecialchars($bl['vendor_name'] ?? 'Vendor #' . $bl['vendor_id']) ?></a>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($bl['anchor_text'] ?? '—') ?></td>
                                    <td><span class="badge badge-<?= $bl['link_type'] ?>"><?= ucfirst($bl['link_type']) ?></span></td>
                                    <td>
                                        <span class="badge badge-<?= $bl['status'] ?>">
                                            <span class="pulse-dot <?= $bl['status'] ?>"></span>
                                            <?= ucfirst($bl['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-mono"><?= $bl['da_score'] ?></td>
                                    <td class="text-muted" style="font-size:13px;"><?= $bl['acquired_date'] ? date('M j, Y', strtotime($bl['acquired_date'])) : '—' ?></td>
                                    <td>
                                        <form method="POST" action="<?= APP_URL ?>/backlinks/<?= $bl['id'] ?>/delete" style="display:inline;">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" data-confirm="Remove this backlink?">
                                                <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Orders Tab -->
    <div id="orders" class="tab-content <?= $tab === 'orders' ? 'active' : '' ?>">
        <?php if (empty($orders)): ?>
            <div class="card">
                <div class="empty-state">
                    <div class="empty-state-icon">🛒</div>
                    <div class="empty-state-title">No Orders</div>
                    <div class="empty-state-text">Place a backlink order for this project.</div>
                    <a href="<?= APP_URL ?>/orders/create" class="btn btn-primary">Order Backlinks</a>
                </div>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="table-container" style="border:none;border-radius:0;">
                    <table class="data-table">
                        <thead>
                            <tr><th>Target URL</th><th>Desired Anchor</th><th>Priority</th><th>Status</th><th>Created</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><span class="truncate text-mono" style="font-size:12px;"><?= htmlspecialchars($order['target_url']) ?></span></td>
                                    <td><?= htmlspecialchars($order['desired_anchor'] ?? '—') ?></td>
                                    <td><span class="badge badge-priority-<?= $order['priority'] ?>"><?= ucfirst($order['priority']) ?></span></td>
                                    <td><span class="badge badge-<?= $order['status'] === 'completed' ? 'active' : ($order['status'] === 'cancelled' ? 'lost' : 'pending') ?>"><?= ucfirst(str_replace('_', ' ', $order['status'])) ?></span></td>
                                    <td class="text-muted" style="font-size:13px;"><?= date('M j, Y', strtotime($order['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
