<?php
$pageTitle = 'Help & Documentation — Worthycite';
$currentPage = 'help';
ob_start();
?>

<div class="public-page-header">
    <div class="container text-center">
        <h1 class="page-title">How can we help?</h1>
        <p class="page-subtitle">Search our knowledge base or browse categories below.</p>
        <div class="mt-24" style="max-width:600px; margin: 0 auto;">
            <input type="text" class="form-control form-control-lg" placeholder="Search for articles, guides..." style="text-align:center;">
        </div>
    </div>
</div>

<section class="help-section">
    <div class="container">
        <div class="grid-3">
            <div class="help-card">
                <div class="help-icon"><i data-lucide="rocket"></i></div>
                <h3>Getting Started</h3>
                <p>Learn how to add your first project, import backlinks, and set up your first audit.</p>
                <a href="#" class="help-link">View tutorials <i data-lucide="chevron-right"></i></a>
            </div>
            <div class="help-card">
                <div class="help-icon"><i data-lucide="link"></i></div>
                <h3>Backlink Tracking</h3>
                <p>Understanding index status, Nofollow/Dofollow, rel=sponsored, and resolving link alerts.</p>
                <a href="#" class="help-link">View tutorials <i data-lucide="chevron-right"></i></a>
            </div>
            <div class="help-card">
                <div class="help-icon"><i data-lucide="sparkles"></i></div>
                <h3>Advanced Features</h3>
                <p>A deep dive into the specialized factors critical for higher search engine placement.</p>
                <a href="#" class="help-link">View tutorials <i data-lucide="chevron-right"></i></a>
            </div>
            <div class="help-card">
                <div class="help-icon"><i data-lucide="credit-card"></i></div>
                <h3>Billing & Plans</h3>
                <p>Manage your subscription, change payment methods, or upgrade your limits.</p>
                <a href="#" class="help-link">View tutorials <i data-lucide="chevron-right"></i></a>
            </div>
            <div class="help-card">
                <div class="help-icon"><i data-lucide="users"></i></div>
                <h3>Team Management</h3>
                <p>Invite team members, assign roles, and collaborate on link building tasks.</p>
                <a href="#" class="help-link">View tutorials <i data-lucide="chevron-right"></i></a>
            </div>
            <div class="help-card">
                <div class="help-icon"><i data-lucide="mail"></i></div>
                <h3>Contact Support</h3>
                <p>Can't find what you're looking for? Our dedicated team is here to assist.</p>
                <a href="<?= APP_URL ?>/contact" class="help-link">Get in touch <i data-lucide="chevron-right"></i></a>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/public.php';
