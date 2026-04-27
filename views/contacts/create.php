<?php
$pageTitle = 'Add Vendor Contact';
ob_start();
?>

<div class="page-header">
    <div class="d-flex justify-between items-center w-full">
        <div>
            <h1 class="page-title">Add Vendor Contact</h1>
            <p class="page-subtitle">Save a new link building relationship</p>
        </div>
        <a href="<?= APP_URL ?>/contacts" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<div class="card animate-in" style="max-width: 800px; margin: 0 auto;">
    <div class="card-body">
        <form action="<?= APP_URL ?>/contacts/store" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
            
            <div class="grid-2">
                <div class="form-group mb-24">
                    <label class="form-label">Contact Name / Company <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. John Doe or ACME SEO">
                </div>
                
                <div class="form-group mb-24">
                    <label class="form-label">Vendor Type</label>
                    <select name="type" class="form-control">
                        <option value="">Select Type...</option>
                        <option value="affiliate">Affiliate</option>
                        <option value="contributor">Contributor / Author</option>
                        <option value="outreach">Outreach Partner</option>
                        <option value="marketplace">Link Marketplace</option>
                        <option value="directory">Directory</option>
                        <option value="interview">Interview / PR</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            
            <div class="grid-2">
                <div class="form-group mb-24">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="contact@example.com">
                </div>
                
                <div class="form-group mb-24">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                </div>
            </div>
            
            <div class="form-group mb-24">
                <label class="form-label">Main Website / Portfolio</label>
                <input type="url" name="website" class="form-control" placeholder="https://example.com">
            </div>
            
            <div class="form-group mb-24">
                <label class="form-label">Notes & Formatting Rules</label>
                <textarea name="notes" class="form-control" rows="4" placeholder="Any specific requirements, pricing, or relationship history..."></textarea>
            </div>
            
            <div class="d-flex justify-end gap-16 mt-32">
                <a href="<?= APP_URL ?>/contacts" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Contact</button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/app.php';
