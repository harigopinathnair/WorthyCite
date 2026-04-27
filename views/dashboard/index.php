<?php
$pageTitle = 'Dashboard';
ob_start();
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Welcome back, <?= htmlspecialchars($user['name']) ?>! Here's your backlink overview.</p>
    </div>
    <div class="page-actions">
        <a href="<?= APP_URL ?>/projects/create" class="btn btn-primary">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> New Project
        </a>
    </div>
</div>

<div class="page-body">
    <!-- Stat Cards -->
    <div class="stats-grid">
        <div class="stat-card accent animate-in">
            <div class="stat-icon accent">
                <i data-lucide="globe" style="width:24px;height:24px;"></i>
            </div>
            <div>
                <div class="stat-value"><?= $totalProjects ?></div>
                <div class="stat-label">Total Projects</div>
            </div>
        </div>
        
        <div class="stat-card success animate-in">
            <div class="stat-icon success">
                <i data-lucide="link" style="width:24px;height:24px;"></i>
            </div>
            <div>
                <div class="stat-value"><?= $activeBacklinks ?></div>
                <div class="stat-label">Active Backlinks</div>
            </div>
        </div>
        
        <div class="stat-card danger animate-in">
            <div class="stat-icon danger">
                <i data-lucide="unlink" style="width:24px;height:24px;"></i>
            </div>
            <div>
                <div class="stat-value"><?= $lostBacklinks ?></div>
                <div class="stat-label">Lost Backlinks</div>
            </div>
        </div>
        
        <div class="stat-card warning animate-in">
            <div class="stat-icon warning">
                <i data-lucide="bell-ring" style="width:24px;height:24px;"></i>
            </div>
            <div>
                <div class="stat-value"><?= $unreadAlerts ?></div>
                <div class="stat-label">Unread Alerts</div>
            </div>
        </div>
    </div>
    
    <!-- Charts & Alerts Row -->
    <div class="grid-2 mb-32">
        <!-- Backlink Trend Chart -->
        <div class="card animate-in">
            <div class="card-header">
                <h3 class="card-title">Backlink Trends</h3>
                <span class="text-muted" style="font-size:12px;">Last 6 months</span>
            </div>
            <div class="chart-container">
                <canvas id="backlinkChart"></canvas>
                <script type="application/json" id="chartData"><?= json_encode($monthlyStats) ?></script>
            </div>
        </div>
        
        <!-- Recent Alerts -->
        <div class="card animate-in">
            <div class="card-header">
                <h3 class="card-title">Recent Alerts</h3>
                <?php if ($unreadAlerts > 0): ?>
                    <a href="<?= APP_URL ?>/alerts" class="btn btn-sm btn-secondary">View All</a>
                <?php endif; ?>
            </div>
            <div class="card-body" style="padding:0;">
                <?php if (empty($recentAlerts)): ?>
                    <div class="empty-state" style="padding:40px 20px;">
                        <div class="empty-state-icon">🎉</div>
                        <div class="empty-state-title">All Clear!</div>
                        <div class="empty-state-text">No alerts at the moment. LinkSquad is watching your backlinks.</div>
                    </div>
                <?php else: ?>
                    <ul class="alert-list">
                        <?php foreach (array_slice($recentAlerts, 0, 5) as $alert): ?>
                            <li class="alert-item <?= !$alert['is_read'] ? 'unread' : '' ?>" data-alert-id="<?= $alert['id'] ?>">
                                <div class="alert-icon <?= $alert['severity'] ?>">
                                    <?php
                                    $icons = ['404_error' => '🔴', 'anchor_missing' => '⚠️', 'url_changed' => '🔄', 'timeout' => '⏱️'];
                                    echo $icons[$alert['alert_type']] ?? '🔔';
                                    ?>
                                </div>
                                <div class="alert-content">
                                    <div class="alert-title"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $alert['alert_type']))) ?></div>
                                    <div class="alert-message"><?= htmlspecialchars($alert['message']) ?></div>
                                    <div class="alert-meta">
                                        <?php if (!empty($alert['project_name'])): ?>
                                            <span><?= htmlspecialchars($alert['project_name']) ?></span>
                                        <?php endif; ?>
                                        <span><?= date('M j, g:i A', strtotime($alert['created_at'])) ?></span>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Backlinks -->
    <div class="card animate-in mb-32">
        <div class="card-header">
            <h3 class="card-title">Recent Backlinks</h3>
            <a href="<?= APP_URL ?>/projects" class="btn btn-sm btn-secondary">View Projects</a>
        </div>
        <?php if (empty($recentBacklinks)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">🔗</div>
                <div class="empty-state-title">No Backlinks Yet</div>
                <div class="empty-state-text">Create a project and start adding backlinks to track them.</div>
                <a href="<?= APP_URL ?>/projects/create" class="btn btn-primary">Create Project</a>
            </div>
        <?php else: ?>
            <div class="table-container" style="border:none;border-radius:0;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Source URL</th>
                            <th>Target URL</th>
                            <th>Anchor</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>DA</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentBacklinks as $bl): ?>
                            <tr>
                                <td><span class="truncate text-mono" style="font-size:12px;" title="<?= htmlspecialchars($bl['source_url']) ?>"><?= htmlspecialchars($bl['source_url']) ?></span></td>
                                <td><span class="truncate text-mono" style="font-size:12px;" title="<?= htmlspecialchars($bl['target_url']) ?>"><?= htmlspecialchars($bl['target_url']) ?></span></td>
                                <td><?= htmlspecialchars($bl['anchor_text'] ?? '—') ?></td>
                                <td><span class="badge badge-info"><?= htmlspecialchars($bl['project_name']) ?></span></td>
                                <td>
                                    <span class="badge badge-<?= $bl['status'] ?>">
                                        <span class="pulse-dot <?= $bl['status'] ?>"></span>
                                        <?= ucfirst($bl['status']) ?>
                                    </span>
                                </td>
                                <td><span class="text-mono"><?= $bl['da_score'] ?></span></td>
                                <td class="text-muted" style="font-size:13px;"><?= $bl['acquired_date'] ? date('M j, Y', strtotime($bl['acquired_date'])) : '—' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
