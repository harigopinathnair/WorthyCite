<?php
$pageTitle = 'Contact Us — Worthycite';
$currentPage = 'contact';
ob_start();
?>

<div class="public-page-header">
    <div class="container text-center">
        <h1 class="page-title">Get in Touch</h1>
        <p class="page-subtitle">Have questions about our tracking platform? We're here to help.</p>
    </div>
</div>

<section class="contact-section">
    <div class="container">
        <div class="grid-2">
            
            <div class="contact-info">
                <h2>Message us directly.</h2>
                <p class="text-secondary mt-16 mb-24">For technical support, billing inquiries, or feature requests, send us a secure message. We aim to respond to all inquiries within 24 hours.</p>
                
                <div class="info-block">
                    <div class="info-icon"><i data-lucide="mail"></i></div>
                    <div>
                        <strong>Email Support</strong>
                        <p class="text-muted">support@worthycite.com</p>
                    </div>
                </div>
                
                <div class="info-block mt-16">
                    <div class="info-icon"><i data-lucide="message-square"></i></div>
                    <div>
                        <strong>Live Chat</strong>
                        <p class="text-muted">Available 9am-5pm EST inside your dashboard.</p>
                    </div>
                </div>
            </div>
            
            <div class="contact-form">
                <?php if (!empty($flash)): ?>
                    <div class="flash-message flash-<?= $flash['type'] ?>">
                        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?>
                        <?= htmlspecialchars($flash['message']) ?>
                    </div>
                <?php endif; ?>
                
                <form action="#" method="POST">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" placeholder="Jane Doe" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" placeholder="jane@company.com" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subject</label>
                        <select class="form-control" required>
                            <option value="">Select a topic...</option>
                            <option value="sales">Sales / Pricing Inquiry</option>
                            <option value="support">Technical Support</option>
                            <option value="billing">Billing Issue</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" rows="5" placeholder="How can we help you today?" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    <p class="text-muted mt-16 text-center" style="font-size: 11px;">By submitting this form, you agree to our Privacy Policy.</p>
                </form>
            </div>
            
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/public.php';
