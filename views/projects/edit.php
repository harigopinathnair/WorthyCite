<?php
$pageTitle = 'Edit Project';
ob_start();
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Project</h1>
        <p class="page-subtitle"><?= htmlspecialchars($project['name']) ?></p>
    </div>
    <div class="page-actions">
        <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>" class="btn btn-secondary">← Back</a>
    </div>
</div>

<div class="page-body">
    <div class="card" style="max-width:640px;">
        <div class="card-body">
            <form method="POST" action="<?= APP_URL ?>/projects/<?= $project['id'] ?>/update">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                
                <div class="form-group">
                    <label class="form-label" for="name">Project Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($project['name']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="domain">Domain</label>
                    <input type="text" id="domain" name="domain" class="form-control" value="<?= htmlspecialchars($project['domain']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="3"><?= htmlspecialchars($project['description'] ?? '') ?></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="active" <?= $project['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="paused" <?= $project['status'] === 'paused' ? 'selected' : '' ?>>Paused</option>
                        <option value="archived" <?= $project['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
                    </select>
                </div>
                
                <div style="display:flex;gap:12px;justify-content:space-between;margin-top:24px;">
                    <div style="display:flex;gap:12px;">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                    <form method="POST" action="<?= APP_URL ?>/projects/<?= $project['id'] ?>/delete" style="display:inline;">
                        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                        <button type="submit" class="btn btn-danger" data-confirm="Delete this project and all its data?">
                            <i data-lucide="trash-2" style="width:16px;height:16px;"></i> Delete
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
