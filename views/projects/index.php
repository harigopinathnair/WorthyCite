<?php
$pageTitle = 'Projects';
ob_start();
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Projects</h1>
        <p class="page-subtitle">Manage your sites and track their backlinks</p>
    </div>
    <div class="page-actions">
        <?php if (isset($projectLimit) && $projectLimit['allowed']): ?>
            <a href="<?= APP_URL ?>/projects/create" class="btn btn-primary">
                <i data-lucide="plus" style="width:16px;height:16px;"></i> New Project
            </a>
        <?php else: ?>
            <a href="<?= APP_URL ?>/billing" class="btn btn-upgrade">
                <i data-lucide="zap" style="width:16px;height:16px;"></i> Upgrade to Add More
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($projectLimit) && $projectLimit['max'] !== -1): ?>
<div style="padding:0 32px;">
    <div class="limit-banner <?= !$projectLimit['allowed'] ? 'at-limit' : '' ?> animate-in">
        <div class="limit-info">
            <span class="limit-label">
                <i data-lucide="globe" style="width:14px;height:14px;"></i>
                Projects: <strong><?= $projectLimit['current'] ?></strong> of <strong><?= $projectLimit['max'] ?></strong> used
            </span>
            <div class="limit-bar-wrap">
                <div class="limit-bar" style="width:<?= min(100, ($projectLimit['current'] / max(1, $projectLimit['max'])) * 100) ?>%"></div>
            </div>
        </div>
        <?php if (!$projectLimit['allowed']): ?>
            <a href="<?= APP_URL ?>/billing" class="btn btn-sm btn-upgrade">Upgrade</a>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<div class="page-body">
    <?php if (empty($projects)): ?>
        <div class="card">
            <div class="empty-state">
                <div class="empty-state-icon">🌐</div>
                <div class="empty-state-title">No Projects Yet</div>
                <div class="empty-state-text">Add your first website to start tracking backlinks.</div>
                <a href="<?= APP_URL ?>/projects/create" class="btn btn-primary">
                    <i data-lucide="plus" style="width:16px;height:16px;"></i> Add Your First Project
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="grid-auto">
            <?php foreach ($projects as $project): ?>
                <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>" class="project-card animate-in" style="text-decoration:none;color:inherit;">
                    <div class="project-card-header">
                        <div class="project-favicon">
                            <?= strtoupper(substr($project['name'], 0, 1)) ?>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div class="project-name"><?= htmlspecialchars($project['name']) ?></div>
                            <div class="project-domain"><?= htmlspecialchars($project['domain']) ?></div>
                        </div>
                        <span class="badge badge-<?= $project['status'] ?>"><?= ucfirst($project['status']) ?></span>
                    </div>
                    
                    <?php if (!empty($project['description'])): ?>
                        <p style="font-size:13px;color:var(--text-secondary);margin-bottom:8px;"><?= htmlspecialchars(substr($project['description'], 0, 80)) ?></p>
                    <?php endif; ?>
                    
                    <div class="project-stats">
                        <div class="project-stat">
                            <div class="project-stat-value text-accent"><?= $project['backlink_count'] ?? 0 ?></div>
                            <div class="project-stat-label">Backlinks</div>
                        </div>
                        <div class="project-stat">
                            <div class="project-stat-value text-success"><?= $project['active_count'] ?? 0 ?></div>
                            <div class="project-stat-label">Active</div>
                        </div>
                        <div class="project-stat">
                            <div class="project-stat-value text-warning"><?= $project['alert_count'] ?? 0 ?></div>
                            <div class="project-stat-label">Alerts</div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
