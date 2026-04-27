<?php
$pageTitle = 'Pricing & Plans — Worthycite';
$currentPage = 'pricing';
ob_start();
?>

<div class="public-page-header">
    <div class="container text-center">
        <h1 class="page-title">Simple, transparent pricing.</h1>
        <p class="page-subtitle">Choose the plan that fits your SEO strategy. No hidden fees.</p>
    </div>
</div>

<section class="pricing-section">
    <div class="container">
        
        <div class="pricing-grid">
            <!-- Free Plan -->
            <div class="pricing-card">
                <div class="pricing-header">
                    <div class="pricing-plan-name">Free Tier</div>
                    <div class="pricing-price">
                        <span class="price-amount">$0</span>
                        <span class="price-period">/mo</span>
                    </div>
                    <p class="text-secondary mt-16 text-center">Perfect for testing the platform.</p>
                </div>
                
                <div class="pricing-features">
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> 1 Project / Website</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> 25 Backlinks tracked</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> Custom content exports</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> Weekly status updates</div>
                </div>
                
                <div class="pricing-action">
                    <a href="<?= APP_URL ?>/register" class="btn btn-secondary btn-block">Get Started Free</a>
                </div>
            </div>
            
            <!-- Pro Plan -->
            <div class="pricing-card featured">
                <div class="pricing-badge"><i data-lucide="star" style="width:12px; height:12px; margin-right:4px;"></i> Most Popular</div>
                <div class="pricing-header">
                    <div class="pricing-plan-name">Pro</div>
                    <div class="pricing-price">
                        <span class="price-amount">$99</span>
                        <span class="price-period">/mo</span>
                    </div>
                    <p class="text-secondary mt-16 text-center">For serious marketers and agencies.</p>
                </div>
                
                <div class="pricing-features">
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> 5 Projects / Websites</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> 500 Backlinks tracked</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> Advanced content analysis</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> Daily automated checks</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> Priority support</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> Instant lost link alerts</div>
                </div>
                
                <div class="pricing-action">
                    <a href="<?= APP_URL ?>/register?plan=pro" class="btn btn-primary btn-block">Start 7-Day Free Trial</a>
                </div>
            </div>

            <!-- Elite Plan -->
            <div class="pricing-card">
                <div class="pricing-header">
                    <div class="pricing-plan-name">Elite</div>
                    <div class="pricing-price">
                        <span class="price-amount">$199</span>
                        <span class="price-period">/mo</span>
                    </div>
                    <p class="text-secondary mt-16 text-center">For SEO teams scaling up link tracking.</p>
                </div>
                
                <div class="pricing-features">
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> 10 Projects / Websites</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> 5,000 Backlinks (shared limit)</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> VIP content analysis</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> Daily automated checks</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> 24/7 Priority VIP support</div>
                    <div class="pricing-feature"><i class="text-success" data-lucide="check-circle-2"></i> Client reporting exports</div>
                </div>
                
                <div class="pricing-action">
                    <a href="<?= APP_URL ?>/register?plan=elite" class="btn btn-secondary btn-block">Scale With Elite</a>
                </div>
            </div>
        </div>

        <div class="faq-container mt-32">
            <h3 class="text-center mb-24">Frequently Asked Questions</h3>
            <div class="grid-2">
                <div class="faq-item">
                    <h4>Do I need a credit card for the free plan?</h4>
                    <p class="text-muted">No! The free plan is completely free forever. You only need a credit card when upgrading to a paid plan.</p>
                </div>

                <div class="faq-item">
                    <h4>How often are backlinks checked?</h4>
                    <p class="text-muted">Free plans are checked weekly. Pro and Enterprise plans enjoy daily automated checking for indexation and dofollow status.</p>
                </div>
                <div class="faq-item">
                    <h4>Can I cancel anytime?</h4>
                    <p class="text-muted">Absolutely. There are no long-term contracts. You can downgrade or cancel your subscription right from your dashboard at any time.</p>
                </div>
            </div>
        </div>
        
    </div>
</section>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/public.php';
