<?php
/**
 * Public Layout - For landing, pricing, features, etc.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Worthycite — AI Content Optimization & Backlink Intelligence' ?></title>
    <meta name="description" content="Optimize content and track valuable backlinks to dominate search and traditional SEO.">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚡</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400..800;1,9..40,400..800&family=JetBrains+Mono:wght@400..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/app.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="public-body">
    <!-- Navigation -->
    <nav class="public-nav">
        <!-- Changed from .container to .container-fluid or max-width 100% wrapper for full-width nav -->
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 40px; display: flex; justify-content: space-between; align-items: center; height: 100%;">
            <a href="<?= APP_URL ?>/" class="public-brand">
                <div class="logo">W</div>
                <span>Worthycite</span>
            </a>
            
            <div class="public-nav-links">
                <a href="<?= APP_URL ?>/features" class="<?= ($currentPage ?? '') === 'features' ? 'active' : '' ?>">Features</a>
                <a href="<?= APP_URL ?>/pricing" class="<?= ($currentPage ?? '') === 'pricing' ? 'active' : '' ?>">Pricing</a>
                <a href="<?= APP_URL ?>/help" class="<?= ($currentPage ?? '') === 'help' ? 'active' : '' ?>">Help Docs</a>
                <a href="<?= APP_URL ?>/contact" class="<?= ($currentPage ?? '') === 'contact' ? 'active' : '' ?>">Contact</a>
            </div>
            
            <div class="public-nav-actions">
                <?php if (Auth::check()): ?>
                    <a href="<?= APP_URL ?>/dashboard" class="btn btn-secondary">Dashboard</a>
                <?php else: ?>
                    <a href="<?= APP_URL ?>/login" class="nav-login-link">Log In</a>
                    <a href="<?= APP_URL ?>/register" class="btn btn-upgrade">Get Started Free</a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-nav-toggle" aria-label="Toggle Navigation">
                <i data-lucide="menu"></i>
            </button>
        </div>
    </nav>
    
    <!-- Mobile Menu -->
    <div class="mobile-nav-menu">
        <div class="mobile-nav-content">
            <a href="<?= APP_URL ?>/features">Features</a>
            <a href="<?= APP_URL ?>/pricing">Pricing</a>
            <a href="<?= APP_URL ?>/help">Help Docs</a>
            <a href="<?= APP_URL ?>/contact">Contact</a>
            <div class="mobile-nav-divider"></div>
            <?php if (Auth::check()): ?>
                <a href="<?= APP_URL ?>/dashboard">Dashboard</a>
            <?php else: ?>
                <a href="<?= APP_URL ?>/login">Log In</a>
                <a href="<?= APP_URL ?>/register" style="color:var(--accent);">Get Started Free</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="public-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="public-brand">
                        <div class="logo">W</div>
                        <span>Worthycite</span>
                    </div>
                    <p class="footer-desc">The ultimate platform for intelligent backlink tracking. Dominate search engine rankings.</p>
                </div>
                
                <div class="footer-links">
                    <h3>Product</h3>
                    <a href="<?= APP_URL ?>/features">Features</a>
                    <a href="<?= APP_URL ?>/pricing">Pricing</a>
                    <a href="<?= APP_URL ?>/register">Start Free Trial</a>
                </div>
                
                <div class="footer-links">
                    <h3>Resources</h3>
                    <a href="<?= APP_URL ?>/help">Help Center</a>
                    <a href="<?= APP_URL ?>/contact">Contact Support</a>
                    <a href="#">Blog</a>
                    <a href="#">API Docs</a>
                </div>
                
                <div class="footer-links">
                    <h3>Legal</h3>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> Worthycite. All rights reserved.</p>
                <div class="social-links">
                    <a href="#"><i data-lucide="twitter"></i></a>
                    <a href="#"><i data-lucide="github"></i></a>
                    <a href="#"><i data-lucide="linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
        
        // Mobile menu toggle
        const toggle = document.querySelector('.mobile-nav-toggle');
        const menu = document.querySelector('.mobile-nav-menu');
        
        if (toggle && menu) {
            toggle.addEventListener('click', () => {
                menu.classList.toggle('active');
            });
        }
        
        // Flash messages
        document.querySelectorAll('.flash-message').forEach(flash => {
            setTimeout(() => {
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 300);
            }, 5000);
        });

        // Scroll reveal
        function revealScrollElements() {
            document.querySelectorAll('.scroll-reveal').forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    el.classList.add('is-visible');
                }
            });
        }
        revealScrollElements();
        window.addEventListener('scroll', revealScrollElements, { passive: true });
    </script>
    <script src="<?= APP_URL ?>/assets/js/app.js"></script>
    <script>
        // Init Lucide icons
        if (typeof lucide !== 'undefined') lucide.createIcons();
    </script>

    <?php if (!Auth::check()): ?>
    <!-- Exit Intent Newsletter Popup -->
    <div class="exit-popup-overlay" id="exitPopupOverlay"></div>
    <div class="exit-popup" id="exitPopup" role="dialog" aria-modal="true" aria-labelledby="exitPopupTitle">
        <button class="exit-popup-close" id="exitPopupClose" aria-label="Close popup">
            <i data-lucide="x"></i>
        </button>

        <div class="exit-popup-glow"></div>

        <div class="exit-popup-badge">
            <span>Free Weekly SEO Intelligence</span>
        </div>

        <h2 class="exit-popup-title" id="exitPopupTitle">Wait — before you go!</h2>
        <p class="exit-popup-desc">
            Get actionable SEO strategies delivered to your inbox every week. Join <strong>3,000+</strong> marketers who stay ahead of the search curve.
        </p>

        <form class="exit-popup-form" id="exitPopupForm">
            <div class="exit-popup-input-wrap">
                <i data-lucide="mail" class="exit-popup-input-icon"></i>
                <input
                    type="email"
                    id="exitPopupEmail"
                    class="exit-popup-input"
                    placeholder="your@email.com"
                    required
                    autocomplete="email"
                >
            </div>
            <button type="submit" class="exit-popup-submit" id="exitPopupSubmit">
                <span class="exit-popup-submit-text">Get Free SEO Tips</span>
                <i data-lucide="arrow-right"></i>
            </button>
        </form>

        <p class="exit-popup-note">No spam, ever. Unsubscribe in one click.</p>

        <div class="exit-popup-social-proof">
            <div class="exit-popup-avatars">
                <span class="exit-popup-avatar" style="background: #6366f1;">S</span>
                <span class="exit-popup-avatar" style="background: #8b5cf6;">M</span>
                <span class="exit-popup-avatar" style="background: #ec4899;">R</span>
            </div>
            <span class="exit-popup-social-text">Joined this week</span>
        </div>
    </div>

    <script>
    (function() {
        const POPUP_KEY   = 'wc_nl_dismissed';
        const POPUP_DAYS  = 7;
        const MOBILE_DELAY = 45000; // 45s inactivity on mobile

        // Don't show if already dismissed recently
        const dismissed = localStorage.getItem(POPUP_KEY);
        if (dismissed && Date.now() < parseInt(dismissed, 10)) return;

        const overlay = document.getElementById('exitPopupOverlay');
        const popup   = document.getElementById('exitPopup');
        const closeBtn= document.getElementById('exitPopupClose');
        const form    = document.getElementById('exitPopupForm');
        const emailIn = document.getElementById('exitPopupEmail');
        const submitBtn = document.getElementById('exitPopupSubmit');
        let shown = false;

        function showPopup() {
            if (shown) return;
            shown = true;
            overlay.classList.add('active');
            popup.classList.add('active');
            // Re-init lucide for the new icons
            if (typeof lucide !== 'undefined') lucide.createIcons();
            document.body.style.overflow = 'hidden';
        }

        function hidePopup(rememberDays) {
            overlay.classList.remove('active');
            popup.classList.remove('active');
            document.body.style.overflow = '';
            if (rememberDays) {
                localStorage.setItem(POPUP_KEY, Date.now() + rememberDays * 86400000);
            }
        }

        // --- Desktop: exit intent (mouse leaves top of viewport) ---
        if (window.matchMedia('(pointer: fine)').matches) {
            let armed = false;
            // Arm the trigger after 5 seconds on page (avoid instant fire)
            setTimeout(() => { armed = true; }, 5000);

            document.addEventListener('mouseout', function(e) {
                if (!armed || shown) return;
                if (!e.relatedTarget && e.clientY <= 0) {
                    showPopup();
                }
            });
        } else {
            // --- Mobile: show after inactivity ---
            let timer = setTimeout(showPopup, MOBILE_DELAY);
            ['scroll', 'touchstart', 'click'].forEach(evt => {
                document.addEventListener(evt, () => {
                    clearTimeout(timer);
                    timer = setTimeout(showPopup, MOBILE_DELAY);
                }, { passive: true });
            });
        }

        // Close handlers
        closeBtn.addEventListener('click', () => hidePopup(POPUP_DAYS));
        overlay.addEventListener('click', () => hidePopup(POPUP_DAYS));
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && shown) hidePopup(POPUP_DAYS);
        });

        // Form submit (AJAX)
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = emailIn.value.trim();
            if (!email) return;

            submitBtn.disabled = true;
            submitBtn.querySelector('.exit-popup-submit-text').textContent = 'Subscribing…';

            fetch('<?= APP_URL ?>/newsletter/subscribe', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'email=' + encodeURIComponent(email)
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    form.innerHTML = '<div class="exit-popup-success"><i data-lucide="check-circle-2"></i><span>' + data.message + '</span></div>';
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                    setTimeout(() => hidePopup(30), 3000); // Don't show for 30 days after success
                } else {
                    submitBtn.disabled = false;
                    submitBtn.querySelector('.exit-popup-submit-text').textContent = 'Get Free SEO Tips';
                    emailIn.classList.add('shake');
                    setTimeout(() => emailIn.classList.remove('shake'), 600);
                }
            })
            .catch(() => {
                submitBtn.disabled = false;
                submitBtn.querySelector('.exit-popup-submit-text').textContent = 'Get Free SEO Tips';
            });
        });
    })();
    </script>
    <?php endif; ?>

</body>
</html>
