<?php
$pageTitle = 'Register';
$pageSubtitle = 'Create your free account';
$nameVal = htmlspecialchars($_GET['name'] ?? '', ENT_QUOTES);
$emailVal = htmlspecialchars($_GET['email'] ?? '', ENT_QUOTES);
ob_start();
?>

<form method="POST" action="<?= APP_URL ?>/register">
    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
    
    <div class="form-group">
        <label class="form-label" for="name">Full Name</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="John Doe" value="<?= $nameVal ?>" required autofocus>
    </div>
    
    <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com" value="<?= $emailVal ?>" required>
    </div>
    
    <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Min. 6 characters" required minlength="6">
    </div>
    
    <div class="form-group">
        <label class="form-label" for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="••••••••" required>
    </div>
    
    <button type="submit" class="btn btn-primary btn-lg" style="width:100%; justify-content:center; margin-top:8px;">
        Create Account
    </button>
    
    <div class="auth-footer">
        Already have an account? <a href="<?= APP_URL ?>/login">Sign in</a>
    </div>
</form>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/auth.php';
