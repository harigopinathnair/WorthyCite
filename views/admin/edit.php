<?php
$pageTitle = 'Edit User #' . $user['id'];
ob_start();

$createdAt = strtotime($user['created_at']);
$trialEndsAt = $createdAt + (7 * 24 * 60 * 60);
$trialActive = time() < $trialEndsAt;

$userModel = new User();
$limits = $userModel->getPlanLimits($user['id']);
?>

<div class="page-header">
    <div class="d-flex justify-between items-center w-full">
        <div>
            <h1 class="page-title">Editing: <?= htmlspecialchars($user['name']) ?></h1>
            <p class="text-muted"><?= htmlspecialchars($user['email']) ?> — Joined: <?= date('M j, Y', $createdAt) ?></p>
        </div>
        <a href="<?= APP_URL ?>/admin" class="btn btn-secondary">← Back to Dashboard</a>
    </div>
</div>

<div class="grid-16 mt-24">
    
    <!-- User Status & Upgrade -->
    <div class="col-span-16 lg:col-span-6 card">
        <div class="card-header border-b">
            <h2 class="card-title">Core Properties</h2>
        </div>
        <div class="card-body">
            <form action="<?= APP_URL ?>/admin/users/<?= $user['id'] ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                
                <div class="form-group mb-16">
                    <label class="form-label" for="plan">Current Tier</label>
                    <select id="plan" name="plan" class="form-control" style="background:var(--bg-secondary); color:var(--text-bright);">
                        <option value="free" <?= $user['plan'] === 'free' ? 'selected' : '' ?>>Free Trial</option>
                        <option value="pro" <?= $user['plan'] === 'pro' ? 'selected' : '' ?>>Pro ($99/mo)</option>
                        <option value="elite" <?= $user['plan'] === 'elite' ? 'selected' : '' ?>>Elite ($199/mo)</option>
                        <option value="starter" <?= $user['plan'] === 'starter' ? 'selected' : '' ?>>Starter</option>
                    </select>
                </div>
                
                <div class="mb-24">
                    <label class="form-label">Trial Status:</label>
                    <?php if ($trialActive): ?>
                        <span class="badge badge-success">Active (Ends <?= date('M j, H:i', $trialEndsAt) ?>)</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Expired</span>
                    <?php endif; ?>
                </div>
                
                <div class="card-header border-b mb-16 px-0" style="padding-bottom: 8px;">
                    <h3 class="card-title text-sm mt-24">Manual Quota Overrides</h3>
                    <p class="text-xs text-muted mb-8">Leave empty to use default tier limits.</p>
                </div>
                
                <div class="form-group mb-16">
                    <label class="form-label" for="custom_projects_limit">Projects Limit <small class="text-muted">(Default: <?= PLANS[$user['plan']]['projects'] ?? 1 ?>)</small></label>
                    <input type="number" id="custom_projects_limit" name="custom_projects_limit" class="form-control" value="<?= $user['custom_projects_limit'] ?>" placeholder="Custom override...">
                </div>
                
                <div class="form-group mb-16">
                    <label class="form-label" for="custom_total_backlinks">Total Backlinks Limit</label>
                    <input type="number" id="custom_total_backlinks" name="custom_total_backlinks" class="form-control" value="<?= $user['custom_total_backlinks'] ?>" placeholder="Custom override...">
                </div>
                

                
                <button type="submit" class="btn btn-primary w-full">Save Quota & Plan</button>
            </form>
        </div>
    </div>
    
    <!-- User Overview -->
    <div class="col-span-16 lg:col-span-10 card">
        <div class="card-header">
            <h2 class="card-title">Live Quota Status</h2>
        </div>
        <div class="card-body">
            <div class="stats-grid" style="grid-template-columns: 1fr 1fr;">
                <div class="stat-card" style="padding: 16px;">
                    <div class="stat-label mb-8">Allowed Projects</div>
                    <div class="stat-value text-accent"><?= $limits['projects'] === -1 ? 'Unlimited' : $limits['projects'] ?></div>
                </div>
                
                <div class="stat-card" style="padding: 16px;">
                    <div class="stat-label mb-8">Allowed Backlinks</div>
                    <div class="stat-value text-blue">
                        <?php if (isset($limits['total_backlinks'])): ?>
                            <?= number_format($limits['total_backlinks']) ?> Total
                        <?php else: ?>
                            <?= number_format($limits['backlinks_per_project']) ?> Per Project
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="stat-card" style="padding: 16px;">
                    <div class="stat-label mb-8">Account Standing</div>
                    <div class="stat-value text-success">Good</div>
                </div>
            </div>
            
            <p class="text-sm mt-24 text-muted"><strong>Note:</strong> Changing the tier above implicitly updates the "Live Quotas" unless overridden by custom numeric values below it. Super Admin changes take effect instantly for the target user.</p>
        </div>
    </div>
    
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
