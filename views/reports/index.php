<?php
$pageTitle = 'Reports';
ob_start();
$months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Monthly Reports</h1>
        <p class="page-subtitle">Track your backlink performance over time</p>
    </div>
    <div class="page-actions">
        <form method="POST" action="<?= APP_URL ?>/reports/generate" style="display:flex;gap:8px;align-items:center;">
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
            <select name="project_id" class="form-control" style="width:auto;padding:8px 12px;">
                <option value="0">All Projects</option>
                <?php foreach ($projects as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="month" class="form-control" style="width:auto;padding:8px 12px;">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= $m ?>" <?= $m == date('n') ? 'selected' : '' ?>><?= $months[$m-1] ?></option>
                <?php endfor; ?>
            </select>
            <select name="year" class="form-control" style="width:auto;padding:8px 12px;">
                <?php for ($y = date('Y'); $y >= date('Y') - 2; $y--): ?>
                    <option value="<?= $y ?>"><?= $y ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" class="btn btn-primary">
                <i data-lucide="refresh-cw" style="width:16px;height:16px;"></i> Generate
            </button>
        </form>
    </div>
</div>

<div class="page-body">
    <?php if (empty($reports)): ?>
        <div class="card">
            <div class="empty-state">
                <div class="empty-state-icon">📊</div>
                <div class="empty-state-title">No Reports Yet</div>
                <div class="empty-state-text">Generate your first monthly report using the button above.</div>
            </div>
        </div>
    <?php else: ?>
        <div class="grid-auto">
            <?php foreach ($reports as $report): ?>
                <div class="card animate-in">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title"><?= $months[$report['report_month'] - 1] ?> <?= $report['report_year'] ?></h3>
                            <?php if (!empty($report['project_name'])): ?>
                                <span class="text-muted" style="font-size:12px;"><?= htmlspecialchars($report['project_name']) ?></span>
                            <?php endif; ?>
                        </div>
                        <span class="badge badge-info">Report</span>
                    </div>
                    <div class="card-body">
                        <div class="project-stats" style="grid-template-columns:repeat(2, 1fr);gap:16px;">
                            <div class="project-stat" style="text-align:left;">
                                <div class="project-stat-value text-accent"><?= $report['total_backlinks'] ?></div>
                                <div class="project-stat-label">Total Backlinks</div>
                            </div>
                            <div class="project-stat" style="text-align:left;">
                                <div class="project-stat-value text-success"><?= $report['new_backlinks'] ?></div>
                                <div class="project-stat-label">New This Month</div>
                            </div>
                            <div class="project-stat" style="text-align:left;">
                                <div class="project-stat-value text-danger"><?= $report['lost_backlinks'] ?></div>
                                <div class="project-stat-label">Lost</div>
                            </div>
                            <div class="project-stat" style="text-align:left;">
                                <div class="project-stat-value text-info"><?= $report['active_backlinks'] ?></div>
                                <div class="project-stat-label">Active</div>
                            </div>
                        </div>
                        
                        <?php if ($report['avg_da'] > 0): ?>
                            <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border-light);">
                                <div class="flex items-center justify-between">
                                    <span class="text-muted" style="font-size:12px;">Average DA</span>
                                    <span class="text-mono" style="font-weight:600;color:var(--accent-light);"><?= number_format($report['avg_da'], 1) ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <span class="text-muted" style="font-size:11px;">Generated: <?= date('M j, Y g:i A', strtotime($report['generated_at'])) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
