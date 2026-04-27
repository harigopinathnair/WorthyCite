<?php
$pageTitle = 'Create Project';
ob_start();
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Create Project</h1>
        <p class="page-subtitle">Add a new site to track its backlinks</p>
    </div>
    <div class="page-actions">
        <a href="<?= APP_URL ?>/projects" class="btn btn-secondary">← Back to Projects</a>
    </div>
</div>

<div class="page-body">
    <div class="card" style="max-width:640px;">
        <div class="card-body">
            <form method="POST" action="<?= APP_URL ?>/projects/store">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                
                <div class="form-group">
                    <label class="form-label" for="name">Project Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="My Awesome Site" required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="domain">Domain</label>
                    <input type="text" id="domain" name="domain" class="form-control" placeholder="example.com" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="description">Description (Optional)</label>
                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Brief description of this project..."></textarea>
                </div>
                
                <div style="display:flex;gap:12px;margin-top:24px;">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="plus" style="width:16px;height:16px;"></i> Create Project
                    </button>
                    <a href="<?= APP_URL ?>/projects" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
