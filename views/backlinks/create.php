<?php
$pageTitle = 'Add Backlink';
ob_start();
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Add Backlink</h1>
        <p class="page-subtitle"><?= htmlspecialchars($project['name']) ?> — <?= htmlspecialchars($project['domain']) ?></p>
    </div>
    <div class="page-actions">
        <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>?tab=backlinks" class="btn btn-secondary">← Back</a>
    </div>
</div>

<div class="page-body">
    <div class="card" style="max-width:640px;">
        <div class="card-body">
            <form method="POST" action="<?= APP_URL ?>/projects/<?= $project['id'] ?>/backlinks/store">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                
                <div class="form-group">
                    <label class="form-label" for="source_url">Source URL</label>
                    <input type="url" id="source_url" name="source_url" class="form-control" placeholder="https://example.com/blog-post" required>
                    <small style="color:var(--text-muted);font-size:12px;">The page where the backlink is placed</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="target_url">Target URL</label>
                    <input type="url" id="target_url" name="target_url" class="form-control" placeholder="https://<?= htmlspecialchars($project['domain']) ?>/page" required value="https://<?= htmlspecialchars($project['domain']) ?>/">
                    <small style="color:var(--text-muted);font-size:12px;">The page on your site being linked to</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="anchor_text">Anchor Text</label>
                    <input type="text" id="anchor_text" name="anchor_text" class="form-control" placeholder="Your keyword or brand name">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="link_type">Link Type</label>
                        <select id="link_type" name="link_type" class="form-control">
                            <option value="dofollow">Dofollow</option>
                            <option value="nofollow">Nofollow</option>
                            <option value="ugc">UGC</option>
                            <option value="sponsored">Sponsored</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="da_score">Domain Authority (DA)</label>
                        <input type="number" id="da_score" name="da_score" class="form-control" min="0" max="100" placeholder="0-100" value="0">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="acquired_date">Acquired Date</label>
                    <input type="date" id="acquired_date" name="acquired_date" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                
                <div class="form-group mt-16">
                    <label class="form-label" for="vendor_id">Linked Vendor / Contact (Optional)</label>
                    <select id="vendor_id" name="vendor_id" class="form-control">
                        <option value="">-- No Vendor Linked --</option>
                        <?php if(!empty($vendors)): foreach($vendors as $vendor): ?>
                            <option value="<?= $vendor['id'] ?>"><?= htmlspecialchars($vendor['name']) ?> (<?= ucfirst($vendor['type']) ?>)</option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                
                <div style="display:flex;gap:12px;margin-top:24px;">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="plus" style="width:16px;height:16px;"></i> Add Backlink
                    </button>
                    <a href="<?= APP_URL ?>/projects/<?= $project['id'] ?>?tab=backlinks" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
