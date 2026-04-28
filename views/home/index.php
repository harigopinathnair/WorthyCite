<?php
$pageTitle = 'Worthycite — The Professional Backlink CRM for SEO Teams';
$currentPage = 'home';
ob_start();
?>

<!-- Sleek/Keap Style Hero -->
<section class="hero-section sleek-hero">
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>
    <div class="container hero-container">
        <div class="hero-content">
            <h1 class="hero-title">
                The Backlink CRM for Data-Driven Marketers.
            </h1>
            
            <p class="hero-subtitle">
                Stop managing links in messy spreadsheets. Worthycite is the centralized CRM to track, monitor, and report on your entire backlink portfolio in real-time.
            </p>
            
            <div class="hero-actions">
                <a href="<?= APP_URL ?>/register" class="btn btn-primary btn-xl">
                    Start My Backlink CRM
                </a>
                <span class="hero-note">Free plan available. No credit card required.</span>
            </div>
        </div>
        
        <div class="hero-visual">
            <img src="<?= APP_URL ?>/assets/img/hero-dash.png" alt="Worthycite CRM Dashboard" class="hero-image-mockup">
        </div>
    </div>
</section>



<!-- Feature 1 - CRM Focus -->
<section class="feature-block block-white">
    <div class="container">
        <div class="feature-row">
            <div class="feature-text">
                <div class="feature-tag text-accent">Portfolio Monitoring</div>
                <h2>Centralized Link CRM & Relationship Management</h2>
                <p>Scaling link building is impossible on a spreadsheet. Worthycite gives you a high-level view of your entire portfolio, tracking every domain, anchor, and relationship in one place.</p>
                
                <ul class="clean-list mt-24">
                    <li><i data-lucide="check-circle-2" class="text-success"></i> <strong>Automated Monitoring:</strong> Real-time checks for link status and indexation.</li>
                    <li><i data-lucide="check-circle-2" class="text-success"></i> <strong>Anchor Tracking:</strong> Ensure your target anchors stay exactly as negotiated.</li>
                    <li><i data-lucide="check-circle-2" class="text-success"></i> <strong>White-Label Reports:</strong> Generate professional tracking reports in seconds.</li>
                </ul>
            </div>
            <div class="feature-visual">
                <div class="placeholder-graphic" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1)); border: 1px solid var(--border); border-radius: 20px; aspect-ratio: 4/3; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="database" style="width:100px; height:100px; color:var(--accent); opacity:0.8;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Feature 2 - Link Alerts -->
<section class="feature-block block-gray">
    <div class="container">
        <div class="feature-row reverse">
            <div class="feature-text">
                <div class="feature-tag text-blue">Intelligence Alerts</div>
                <h2>Never Lose a High-Value Backlink Again.</h2>
                <p>Worthycite's monitoring engine continuously pings your portfolio, alerting you the moment a link drops, changes to nofollow, or returns a 404.</p>
                
                <ul class="clean-list mt-24">
                    <li><i data-lucide="check-circle-2" class="text-success"></i> <strong>Instant Notifications:</strong> Get email or SMS alerts for lost links.</li>
                    <li><i data-lucide="check-circle-2" class="text-success"></i> <strong>Nofollow Detection:</strong> Know immediately if a contract is breached.</li>
                    <li><i data-lucide="check-circle-2" class="text-success"></i> <strong>Detailed Logging:</strong> Full history of every link's status and uptime.</li>
                </ul>
                
                <a href="<?= APP_URL ?>/features" class="btn btn-secondary mt-24">Explore CRM Features</a>
            </div>
            <div class="feature-visual">
                <img src="<?= APP_URL ?>/assets/img/backlink-mockup.png" alt="Backlink CRM Monitoring mockup" class="feature-img">
            </div>
        </div>
    </div>
</section>



<!-- Bottom CTA -->
<section class="final-cta">
    <div class="final-cta-orb final-cta-orb-1"></div>
    <div class="final-cta-orb final-cta-orb-2"></div>
    <div class="container">
        <div class="final-cta-grid">

            <!-- Left: Copy -->
            <div class="final-cta-left">
                <div class="final-cta-badge">
                    <span class="badge-dot"></span>
                    Centralized Link Monitoring & Intelligence
                </div>
                <h2 class="final-cta-heading">Scale your backlink portfolio with confidence.</h2>
                <p class="final-cta-sub">Be among the first SEO teams to build with Worthycite — track link acquisition, monitor uptime, and simplify reporting from day one.</p>

                <div class="final-cta-trust">
                    <div class="trust-item">
                        <strong>Early</strong>
                        <span>Adopter Access</span>
                    </div>
                    <div class="trust-divider"></div>
                    <div class="trust-item">
                        <strong>Free</strong>
                        <span>Plan available</span>
                    </div>
                    <div class="trust-divider"></div>
                    <div class="trust-item">
                        <strong>No CC</strong>
                        <span>Required to start</span>
                    </div>
                </div>
            </div>

            <!-- Right: Form card -->
            <div class="final-cta-right">
                <div class="final-cta-card">
                    <div class="final-cta-card-header">
                        <div class="card-avatars">
                            <span class="card-avatar">A</span>
                            <span class="card-avatar">J</span>
                            <span class="card-avatar">M</span>
                        </div>
                        <p class="card-social-proof">Be an <strong>early adopter</strong> — free plan available</p>
                    </div>

                    <form action="<?= APP_URL ?>/register" method="GET" class="final-cta-form">
                        <div class="final-form-group">
                            <label for="cta-name">Your Name</label>
                            <input type="text" id="cta-name" name="name" placeholder="Jane Smith" required class="final-form-input">
                        </div>
                        <div class="final-form-group">
                            <label for="cta-email">Work Email</label>
                            <input type="email" id="cta-email" name="email" placeholder="jane@company.com" required class="final-form-input">
                        </div>
                        <button type="submit" class="final-cta-btn">
                            Get My Free Backlink CRM
                            <i data-lucide="arrow-right"></i>
                        </button>
                        <p class="final-card-note">No credit card required &nbsp;·&nbsp; Cancel anytime &nbsp;·&nbsp; Free plan available</p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/public.php';
?>
