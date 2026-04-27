<?php
$pageTitle = 'CiteLord Dashboard';
ob_start();
?>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">CiteLord Administration</h1>
        <p class="text-muted">Master control panel for Worthycite.</p>
    </div>
    <div>
        <a href="<?= APP_URL ?>/admin/citecore" class="btn btn-primary">
            <i data-lucide="brain"></i> CiteCore Brain
        </a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: var(--accent);">
            <i data-lucide="users"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Users</div>
            <div class="stat-value"><?= number_format($metrics['total_users']) ?></div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success);">
            <i data-lucide="folders"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Active Projects</div>
            <div class="stat-value"><?= number_format($metrics['active_projects']) ?></div>
        </div>
    </div>
</div>

<div class="card mt-24">
    <div class="card-header">
        <h2 class="card-title">All Users</h2>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Plan</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>#<?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <span class="badge badge-<?= $user['plan'] === 'elite' ? 'success' : ($user['plan'] === 'pro' ? 'primary' : 'secondary') ?>">
                                <?= ucfirst($user['plan']) ?>
                            </span>
                            <?php if ($user['custom_projects_limit'] !== null): ?>
                                <span class="badge badge-warning" title="Custom Override Configured">OVR</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                        <td>
                            <a href="<?= APP_URL ?>/admin/users/<?= $user['id'] ?>" class="btn btn-secondary btn-sm">Edit / Quotas</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-24">No users found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
