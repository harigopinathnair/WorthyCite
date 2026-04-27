<?php
$pageTitle = 'Backlinks — ' . htmlspecialchars($project['name']);
ob_start();
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Backlinks</h1>
        <p class="page-subtitle"><?= htmlspecialchars($project['name']) ?> — <?= htmlspecialchars($project['domain']) ?></p>
    </div>
    <div class="page-actions">
        <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>/backlinks/create" class="btn btn-primary">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> Add Backlink
        </a>
        <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>" class="btn btn-secondary">← Back to Project</a>
    </div>
</div>

<div class="page-body">
    <!-- Filters -->
    <div class="filter-bar">
        <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>/backlinks" class="filter-chip <?= empty($statusFilter) ? 'active' : '' ?>">All</a>
        <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>/backlinks?status=active" class="filter-chip <?= $statusFilter === 'active' ? 'active' : '' ?>">Active</a>
        <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>/backlinks?status=pending" class="filter-chip <?= $statusFilter === 'pending' ? 'active' : '' ?>">Pending</a>
        <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>/backlinks?status=lost" class="filter-chip <?= $statusFilter === 'lost' ? 'active' : '' ?>">Lost</a>
        <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>/backlinks?status=warning" class="filter-chip <?= $statusFilter === 'warning' ? 'active' : '' ?>">Warning</a>
    </div>
    
    <?php if (empty($backlinks)): ?>
        <div class="card">
            <div class="empty-state">
                <div class="empty-state-icon">🔗</div>
                <div class="empty-state-title">No Backlinks Found</div>
                <div class="empty-state-text"><?= $statusFilter ? 'No backlinks with this status.' : 'Add your first backlink to start tracking.' ?></div>
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
                            <th>Anchor Text</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>DA</th>
                            <th>Last Checked</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($backlinks as $bl): ?>
                            <tr>
                                <td><a href="<?= htmlspecialchars($bl['source_url']) ?>" target="_blank" class="truncate" style="font-size:12px;font-family:'JetBrains Mono',monospace;"><?= htmlspecialchars($bl['source_url']) ?></a></td>
                                <td><span class="truncate text-mono" style="font-size:12px;"><?= htmlspecialchars($bl['target_url']) ?></span></td>
                                <td><?= htmlspecialchars($bl['anchor_text'] ?? '—') ?></td>
                                <td><span class="badge badge-<?= $bl['link_type'] ?>"><?= ucfirst($bl['link_type']) ?></span></td>
                                <td>
                                    <span class="badge badge-<?= $bl['status'] ?>">
                                        <span class="pulse-dot <?= $bl['status'] ?>"></span>
                                        <?= ucfirst($bl['status']) ?>
                                    </span>
                                </td>
                                <td class="text-mono"><?= $bl['da_score'] ?></td>
                                <td class="text-muted" style="font-size:13px;"><?= $bl['last_checked'] ? date('M j, g:i A', strtotime($bl['last_checked'])) : 'Never' ?></td>
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

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
