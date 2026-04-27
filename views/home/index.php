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

<!-- Logo Band -->
<section class="logo-band">
    <div class="container text-center">
        <p class="logo-band-title">TRUSTED BY 3,000+ FAST-GROWING BRANDS & AGENCIES</p>
        <div class="logo-grid scroll-reveal">
            <div class="brand-logo">HubSpot</div>
            <div class="brand-logo">Shopify</div>
            <div class="brand-logo">Intercom</div>
            <div class="brand-logo">Zendesk</div>
            <div class="brand-logo">Typeform</div>
            <div class="brand-logo">Mailchimp</div>
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

<!-- Testimonial Block -->
<section class="testimonial-section">
    <div class="container text-center">
        <div class="testimonial-content scroll-reveal">
            <div class="stars">
                <i data-lucide="star"></i><i data-lucide="star"></i><i data-lucide="star"></i><i data-lucide="star"></i><i data-lucide="star"></i>
            </div>
            <blockquote class="testimonial-quote">
                "Worthycite completely replaced our messy spreadsheets. The automated tracking and CRM efficiency is an absolute game-changer—we finally have a single source of truth for our link building."
            </blockquote>
            <div class="testimonial-author">
                <img src="https://i.pravatar.cc/150?img=32" alt="Sarah J.">
                <div>
                    <strong>Sarah Jenkins</strong>
                    <span>Head of SEO, TechGrowth</span>
                </div>
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
                <p class="final-cta-sub">Join thousands of SEO teams using Worthycite to track link acquisition, monitor uptime, and simplify reporting.</p>

                <div class="final-cta-trust">
                    <div class="trust-item">
                        <strong>3,000+</strong>
                        <span>Teams onboarded</span>
                    </div>
                    <div class="trust-divider"></div>
                    <div class="trust-item">
                        <strong>★ 4.9</strong>
                        <span>Avg. user rating</span>
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
                        <p class="card-social-proof">Join <strong>3,000+ brands</strong> already growing</p>
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
