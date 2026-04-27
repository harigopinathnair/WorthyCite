<?php
$pageTitle = 'CRM Features — Worthycite';
$currentPage = 'features';
ob_start();
?>

<div class="public-page-header">
    <div class="container text-center">
        <h1 class="page-title">The Ultimate Backlink CRM Ecosystem.</h1>
        <p class="page-subtitle">Centralized link monitoring, portfolio intelligence, and white-label reporting.</p>
    </div>
</div>

<section class="features-detail-section">
    <div class="container">
        
        <div class="feature-row reverse">
            <div class="feature-image">
                <div class="placeholder-graphic" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(138, 180, 248, 0.1)); border: 1px solid var(--border); border-radius: 16px; aspect-ratio: 16/9; display: flex; align-items: center; justify-content: center; position: relative;">
                    <i data-lucide="line-chart" style="width: 80px; height: 80px; color: var(--success); opacity: 0.8;"></i>
                    <div style="position: absolute; left: 20px; bottom: 20px; background: var(--bg-card); padding: 10px; border-radius: 8px; border: 1px solid var(--border);"><i data-lucide="alert-triangle" class="text-danger"></i> Link Lost Alert</div>
                </div>
            </div>
            <div class="feature-text">
                <h2>Automated Portfolio Tracking</h2>
                <p>Scaling your link profile requires constant vigilance. Worthycite ping your entire portfolio every 24 hours to ensure your investments remain active and indexed.</p>
                <ul class="clean-list">
                    <li><strong>Status Monitoring:</strong> Real-time detection of 404s, 500s, and redirects.</li>
                    <li><strong>Dofollow/Nofollow Pulse:</strong> Maintain the integrity of your link profile with instant breach alerts.</li>
                    <li><strong>White-Label Reports:</strong> Professional, automated reports for your team or clients.</li>
                </ul>
            </div>
        </div>

        <div class="feature-row mt-64">
             <div class="feature-image">
                <div class="placeholder-graphic" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 197, 253, 0.1)); border: 1px solid var(--border); border-radius: 16px; aspect-ratio: 16/9; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="users" style="width: 80px; height: 80px; color: var(--blue); opacity: 0.8;"></i>
                </div>
            </div>
            <div class="feature-text">
                <h2>Relationship & Asset Management</h2>
                <p>Organize your backlink profile by vendor, campaign, or asset. Our CRM helps you track the source of every link, making it easy to manage outreach partners and calculate ROI.</p>
                <ul class="clean-list">
                    <li><strong>Vendor Tagging:</strong> Associate links with specific providers or outreach teams.</li>
                    <li><strong>Cost Tracking:</strong> Monitor your acquisition spend and link value over time.</li>
                    <li><strong>Portfolio Segmentation:</strong> Group sites into custom portfolios for easier cross-site tracking.</li>
                </ul>
            </div>
        </div>

    </div>
</section>

<section class="cta-section">
    <div class="container text-center">
        <h2>Modernize your link management today</h2>
        <a href="<?= APP_URL ?>/register" class="btn btn-primary btn-lg mt-16">Start My Backlink CRM</a>
    </div>
</section>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/public.php';
?>

