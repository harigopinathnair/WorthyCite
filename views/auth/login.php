<?php
$pageTitle = 'Login';
$pageSubtitle = 'Sign in to your account';
ob_start();
?>

<form method="POST" action="<?= APP_URL ?>/login">
    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
    
    <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com" required autofocus>
    </div>
    
    <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
    </div>
    
    <button type="submit" class="btn btn-primary btn-lg" style="width:100%; justify-content:center; margin-top:8px;">
        Sign In
    </button>
    
    <div class="auth-footer">
        Don't have an account? <a href="<?= APP_URL ?>/register">Create one</a>
    </div>
</form>

<?php
$content = ob_get_clean();
require VIEWS_PATH . '/layouts/auth.php';
