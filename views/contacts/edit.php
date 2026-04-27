<?php
$pageTitle = 'Edit Contact';
ob_start();
?>

<div class="page-header">
    <div class="d-flex justify-between items-center w-full">
        <div>
            <h1 class="page-title">Edit Contact</h1>
            <p class="page-subtitle">Update relationship details for <?= htmlspecialchars($contact['name']) ?></p>
        </div>
        <a href="<?= APP_URL ?>/contacts" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<div class="card animate-in" style="max-width: 800px; margin: 0 auto;">
    <div class="card-body">
        <form action="<?= APP_URL ?>/contacts/<?= $contact['id'] ?>/update" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
            
            <div class="grid-2">
                <div class="form-group mb-24">
                    <label class="form-label">Contact Name / Company <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($contact['name']) ?>">
                </div>
                
                <div class="form-group mb-24">
                    <label class="form-label">Vendor Type</label>
                    <select name="type" class="form-control">
                        <option value="" <?= empty($contact['type']) ? 'selected' : '' ?>>Select Type...</option>
                        <option value="affiliate" <?= $contact['type'] === 'affiliate' ? 'selected' : '' ?>>Affiliate</option>
                        <option value="contributor" <?= $contact['type'] === 'contributor' ? 'selected' : '' ?>>Contributor / Author</option>
                        <option value="outreach" <?= $contact['type'] === 'outreach' ? 'selected' : '' ?>>Outreach Partner</option>
                        <option value="marketplace" <?= $contact['type'] === 'marketplace' ? 'selected' : '' ?>>Link Marketplace</option>
                        <option value="directory" <?= $contact['type'] === 'directory' ? 'selected' : '' ?>>Directory</option>
                        <option value="interview" <?= $contact['type'] === 'interview' ? 'selected' : '' ?>>Interview / PR</option>
                        <option value="other" <?= $contact['type'] === 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
            </div>
            
            <div class="grid-2">
                <div class="form-group mb-24">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($contact['email'] ?? '') ?>">
                </div>
                
                <div class="form-group mb-24">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($contact['phone'] ?? '') ?>">
                </div>
            </div>
            
            <div class="form-group mb-24">
                <label class="form-label">Main Website / Portfolio</label>
                <input type="url" name="website" class="form-control" value="<?= htmlspecialchars($contact['website'] ?? '') ?>">
            </div>
            
            <div class="form-group mb-24">
                <label class="form-label">Notes & Formatting Rules</label>
                <textarea name="notes" class="form-control" rows="4"><?= htmlspecialchars($contact['notes'] ?? '') ?></textarea>
            </div>
            
            <div class="d-flex justify-end gap-16 mt-32">
                <a href="<?= APP_URL ?>/contacts" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Contact</button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
