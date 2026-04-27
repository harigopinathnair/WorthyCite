<?php
$pageTitle = 'New Order';
ob_start();
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Order Backlinks</h1>
        <p class="page-subtitle">Place a new backlink order</p>
    </div>
    <div class="page-actions">
        <a href="<?= APP_URL ?>/orders" class="btn btn-secondary">← Back to Orders</a>
    </div>
</div>

<div class="page-body">
    <div class="card" style="max-width:640px;">
        <div class="card-body">
            <?php if (empty($projects)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">🌐</div>
                    <div class="empty-state-title">No Projects</div>
                    <div class="empty-state-text">Create a project first before placing an order.</div>
                    <a href="<?= APP_URL ?>/projects/create" class="btn btn-primary">Create Project</a>
                </div>
            <?php else: ?>
                <form method="POST" action="<?= APP_URL ?>/orders/store">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                    
                    <div class="form-group">
                        <label class="form-label" for="project_id">Project</label>
                        <select id="project_id" name="project_id" class="form-control" required>
                            <option value="">Select a project...</option>
                            <?php foreach ($projects as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?> (<?= htmlspecialchars($p['domain']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="target_url">Target URL</label>
                        <input type="url" id="target_url" name="target_url" class="form-control" placeholder="https://yoursite.com/page" required>
                        <small style="color:var(--text-muted);font-size:12px;">The page you want to get backlinks for</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="desired_anchor">Desired Anchor Text</label>
                        <input type="text" id="desired_anchor" name="desired_anchor" class="form-control" placeholder="Your target anchor text">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="source_preference">Source Preference (Optional)</label>
                        <input type="text" id="source_preference" name="source_preference" class="form-control" placeholder="Preferred source domain or niche">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="priority">Priority</label>
                        <select id="priority" name="priority" class="form-control">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="notes">Notes</label>
                        <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Any additional requirements or instructions..."></textarea>
                    </div>
                    
                    <div style="display:flex;gap:12px;margin-top:24px;">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="shopping-cart" style="width:16px;height:16px;"></i> Place Order
                        </button>
                        <a href="<?= APP_URL ?>/orders" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
