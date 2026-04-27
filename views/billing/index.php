<?php
$pageTitle = 'Billing & Plans';
ob_start();

$planFeatures = [
    'free' => [
        'name'     => 'Free',
        'icon'     => '🌱',
        'color'    => 'var(--text-muted)',
        'features' => [
            '1 Website',
            '25 Backlinks per project',
            'Basic content analysis',
            'Basic backlink monitoring',
            'Email alerts',
            'Monthly reports',
        ],
        'limits'   => ['1 website', '25 backlinks/project'],
    ],
    'pro' => [
        'name'     => 'Pro',
        'icon'     => '⚡',
        'color'    => 'var(--accent)',
        'badge'    => '<i data-lucide="star" style="width:12px; height:12px; margin-right:4px;"></i> POPULAR',
        'features' => [
            '5 Websites',
            '500 Backlinks per project',
            'Advanced content analysis',
            'Advanced backlink monitoring',
            'Priority email alerts',
            'Detailed monthly reports',
            'LinkSquad automated checks',
            'Priority support',
        ],
        'limits'   => ['5 websites', '500 backlinks/project'],
    ],
    'elite' => [
        'name'     => 'Elite',
        'icon'     => '🚀',
        'color'    => 'var(--blue)',
        'features' => [
            '10 Websites',
            '5,000 Backlinks (shared map)',
            'Advanced content analysis',
            'Unlimited backlink monitoring',
            'Priority SMS & email alerts',
            'Customizable reports',
            'LinkSquad automated checks',
            'Priority 24/7 VIP support',
        ],
        'limits'   => ['10 websites', '5000 backlinks shared'],
    ],
];
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Billing & Plans</h1>
        <p class="page-subtitle">Manage your subscription and unlock more features</p>
    </div>
</div>

<div class="page-body">
    <!-- Current Plan Banner -->
    <div class="billing-current-plan animate-in">
        <div class="current-plan-info">
            <div class="current-plan-icon">
                <?= $currentPlan === 'free' ? '🌱' : ($currentPlan === 'pro' ? '⚡' : '🚀') ?>
            </div>
            <div>
                <div class="current-plan-label">Current Plan</div>
                <div class="current-plan-name"><?= ucfirst($currentPlan) ?></div>
            </div>
        </div>
        <div class="current-plan-usage">
            <div class="usage-item">
                <span class="usage-label">Projects</span>
                <div class="usage-bar-wrap">
                    <div class="usage-bar" style="width: <?= $projectLimit['max'] === -1 ? '10' : min(100, ($projectLimit['current'] / max(1, $projectLimit['max'])) * 100) ?>%"></div>
                </div>
                <span class="usage-count"><?= $projectLimit['current'] ?> / <?= $projectLimit['max'] === -1 ? '∞' : $projectLimit['max'] ?></span>
            </div>
        </div>
    </div>

    <!-- Pricing Cards -->
    <div class="pricing-grid">
        <?php foreach (['free', 'pro', 'elite'] as $planKey): ?>
            <?php $plan = $planFeatures[$planKey]; $planData = $plans[$planKey]; $isCurrent = ($currentPlan === $planKey); ?>
            <div class="pricing-card <?= $isCurrent ? 'current' : '' ?> <?= $planKey === 'pro' ? 'featured' : '' ?> animate-in">
                <?php if (!empty($plan['badge'])): ?>
                    <div class="pricing-badge"><?= $plan['badge'] ?></div>
                <?php endif; ?>
                <?php if ($isCurrent): ?>
                    <div class="pricing-badge current-badge">CURRENT</div>
                <?php endif; ?>
                
                <div class="pricing-header">
                    <div class="pricing-icon"><?= $plan['icon'] ?></div>
                    <h3 class="pricing-plan-name"><?= $plan['name'] ?></h3>
                    <div class="pricing-price">
                        <span class="price-amount">$<?= $planData['price'] ?></span>
                        <span class="price-period">/month</span>
                    </div>
                </div>
                
                <div class="pricing-features">
                    <?php foreach ($plan['features'] as $feature): ?>
                        <div class="pricing-feature">
                            <i data-lucide="check" style="width:16px;height:16px;color:var(--success);flex-shrink:0;"></i>
                            <span><?= $feature ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="pricing-action">
                    <?php if ($isCurrent): ?>
                        <button class="btn btn-secondary btn-block" disabled>Current Plan</button>
                    <?php else: ?>
                        <form method="POST" action="<?= APP_URL ?>/billing/upgrade">
                            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                            <input type="hidden" name="plan" value="<?= $planKey ?>">
                            <?php if ($planData['price'] > ($plans[$currentPlan]['price'] ?? 0)): ?>
                                <button type="submit" class="btn btn-upgrade btn-block">
                                    <i data-lucide="zap" style="width:16px;height:16px;"></i>
                                    Upgrade to <?= $plan['name'] ?>
                                </button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-secondary btn-block" data-confirm="Are you sure you want to switch to the <?= $plan['name'] ?> plan? Your limits will be reduced.">
                                    Switch to <?= $plan['name'] ?>
                                </button>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Plan Comparison Table -->
    <div class="card animate-in" style="margin-top:32px;">
        <div class="card-header">
            <h3 class="card-title">Plan Comparison</h3>
        </div>
        <div class="table-container" style="border:none;border-radius:0;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Free</th>
                        <th style="color:var(--accent);">Pro</th>
                        <th style="color:var(--blue);">Elite</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Websites</strong></td>
                        <td>1</td>
                        <td>5</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td><strong>Backlinks Tracking</strong></td>
                        <td>25/project</td>
                        <td>500/project</td>
                        <td>5,000 Total (shared pools)</td>
                    </tr>
                    <tr>
                        <td><strong>Advanced Content Analysis</strong></td>
                        <td>Basic</td>
                        <td>Advanced</td>
                        <td>Priority</td>
                    </tr>
                    <tr>
                        <td><strong>Backlink monitoring</strong></td>
                        <td>Basic</td>
                        <td>Advanced</td>
                        <td>Unlimited</td>
                    </tr>
                    <tr>
                        <td><strong>LinkSquad auto-checks</strong></td>
                        <td><i data-lucide="x" style="width:16px;height:16px;color:var(--danger);"></i></td>
                        <td><i data-lucide="check" style="width:16px;height:16px;color:var(--success);"></i></td>
                        <td><i data-lucide="check" style="width:16px;height:16px;color:var(--success);"></i></td>
                    </tr>
                    <tr>
                        <td><strong>Email alerts</strong></td>
                        <td><i data-lucide="check" style="width:16px;height:16px;color:var(--success);"></i></td>
                        <td><i data-lucide="check" style="width:16px;height:16px;color:var(--success);"></i></td>
                        <td><i data-lucide="check" style="width:16px;height:16px;color:var(--success);"></i> (SMS optional)</td>
                    </tr>
                    <tr>
                        <td><strong>Monthly reports</strong></td>
                        <td><i data-lucide="check" style="width:16px;height:16px;color:var(--success);"></i></td>
                        <td><i data-lucide="check" style="width:16px;height:16px;color:var(--success);"></i></td>
                        <td><i data-lucide="check" style="width:16px;height:16px;color:var(--success);"></i> (Customizable)</td>
                    </tr>
                    <tr>
                        <td><strong>Priority support</strong></td>
                        <td><i data-lucide="x" style="width:16px;height:16px;color:var(--danger);"></i></td>
                        <td><i data-lucide="check" style="width:16px;height:16px;color:var(--success);"></i></td>
                        <td><i data-lucide="check" style="width:16px;height:16px;color:var(--success);"></i> (24/7 VIP)</td>
                    </tr>
                    <tr>
                        <td><strong>Price</strong></td>
                        <td>Free forever</td>
                        <td><strong>$99/month</strong></td>
                        <td><strong>$199/month</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
