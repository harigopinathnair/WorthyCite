<?php
class AuthController extends Controller {
    
    public function loginForm(): void {
        if (Auth::check()) {
            $this->redirect('dashboard');
        }
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $this->view('auth.login', compact('csrf', 'flash'));
    }
    
    public function login(): void {
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request. Please try again.');
            $this->redirect('login');
        }
        
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $this->flash('error', 'Please fill in all fields.');
            $this->redirect('login');
        }
        
        if (Auth::attempt($email, $password)) {
            $this->flash('success', 'Welcome back!');
            $this->redirect('dashboard');
        } else {
            $this->flash('error', 'Invalid email or password.');
            $this->redirect('login');
        }
    }
    
    public function registerForm(): void {
        if (Auth::check()) {
            $this->redirect('dashboard');
        }
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $this->view('auth.register', compact('csrf', 'flash'));
    }
    
    public function register(): void {
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request. Please try again.');
            $this->redirect('register');
        }
        
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validation
        $errors = [];
        if (empty($name)) $errors[] = 'Name is required.';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
        if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
        if ($password !== $confirmPassword) $errors[] = 'Passwords do not match.';
        
        if (!empty($errors)) {
            $this->flash('error', implode(' ', $errors));
            $this->redirect('register');
        }
        
        // Check for existing user
        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            $this->flash('error', 'An account with this email already exists.');
            $this->redirect('register');
        }
        
        // Create user
        $userId = $userModel->register([
            'name'     => $name,
            'email'    => $email,
            'password' => $password
        ]);
        
        Auth::login($userId);
        $this->flash('success', 'Welcome to Worthycite! Your account has been created.');
        $this->redirect('dashboard');
    }
    
    public function logout(): void {
        Auth::logout();
        $this->redirect('');
    }
}
