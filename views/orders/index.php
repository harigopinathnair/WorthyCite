<?php
$pageTitle = 'Orders';
ob_start();
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Backlink Orders</h1>
        <p class="page-subtitle">Request and manage new backlink orders</p>
    </div>
    <div class="page-actions">
        <a href="<?= APP_URL ?>/orders/create" class="btn btn-primary">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> New Order
        </a>
    </div>
</div>

<div class="page-body">
    <?php if (empty($orders)): ?>
        <div class="card">
            <div class="empty-state">
                <div class="empty-state-icon">🛒</div>
                <div class="empty-state-title">No Orders Yet</div>
                <div class="empty-state-text">Place your first backlink order to get started.</div>
                <a href="<?= APP_URL ?>/orders/create" class="btn btn-primary">
                    <i data-lucide="plus" style="width:16px;height:16px;"></i> Place First Order
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="table-container" style="border:none;border-radius:0;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Target URL</th>
                            <th>Desired Anchor</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <a href="<?= APP_URL ?>/projects/<?= $order['project_id'] ?>" style="font-weight:500;">
                                        <?= htmlspecialchars($order['project_name']) ?>
                                    </a>
                                    <div class="text-mono text-muted" style="font-size:11px;"><?= htmlspecialchars($order['domain']) ?></div>
                                </td>
                                <td><span class="truncate text-mono" style="font-size:12px;"><?= htmlspecialchars($order['target_url']) ?></span></td>
                                <td><?= htmlspecialchars($order['desired_anchor'] ?? '—') ?></td>
                                <td><span class="badge badge-priority-<?= $order['priority'] ?>"><?= ucfirst($order['priority']) ?></span></td>
                                <td>
                                    <span class="badge badge-<?= $order['status'] === 'completed' ? 'active' : ($order['status'] === 'cancelled' ? 'lost' : ($order['status'] === 'in_progress' ? 'info' : 'pending')) ?>">
                                        <?= ucfirst(str_replace('_', ' ', $order['status'])) ?>
                                    </span>
                                </td>
                                <td class="text-muted" style="font-size:13px;"><?= date('M j, Y', strtotime($order['created_at'])) ?></td>
                                <td>
                                    <div style="display:flex;gap:6px;">
                                        <?php if ($order['status'] === 'pending'): ?>
                                            <form method="POST" action="<?= APP_URL ?>/orders/<?= $order['id'] ?>/update" style="display:inline;">
                                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                                <input type="hidden" name="status" value="in_progress">
                                                <button class="btn btn-sm btn-secondary" title="Start">▶</button>
                                            </form>
                                        <?php elseif ($order['status'] === 'in_progress'): ?>
                                            <form method="POST" action="<?= APP_URL ?>/orders/<?= $order['id'] ?>/update" style="display:inline;">
                                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                                <input type="hidden" name="status" value="completed">
                                                <button class="btn btn-sm btn-success" title="Complete">✓</button>
                                            </form>
                                        <?php endif; ?>
                                        <form method="POST" action="<?= APP_URL ?>/orders/<?= $order['id'] ?>/delete" style="display:inline;">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                            <button class="btn btn-sm btn-danger" data-confirm="Cancel this order?" title="Cancel">✕</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
