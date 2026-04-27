<?php
/**
 * Worthycite - Base Controller
 */
class Controller {
    
    protected function view(string $view, array $data = []): void {
        extract($data);
        $viewFile = VIEWS_PATH . '/' . str_replace('.', '/', $view) . '.php';
        if (!file_exists($viewFile)) {
            die("View not found: $view");
        }
        require $viewFile;
    }
    
    protected function redirect(string $path): void {
        header('Location: ' . APP_URL . '/' . ltrim($path, '/'));
        exit;
    }
    
    protected function json(array $data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function requireAuth(): void {
        if (!Auth::check()) {
            $this->redirect('');
        }
        
        $user = Auth::user();
        if ($user && $user['plan'] === 'free') {
            $requestUri = $_SERVER['REQUEST_URI'] ?? '';
            // Allow access to billing and logout directly even if expired
            if (strpos($requestUri, '/billing') === false && strpos($requestUri, '/logout') === false) {
                // Check if older than 7 days
                $createdAt = strtotime($user['created_at']);
                if (time() > $createdAt + (7 * 24 * 60 * 60)) {
                    $this->flash('warning', 'Your 7-day free trial has expired. Please choose a plan to continue accessing the platform.');
                    $this->redirect('billing');
                }
            }
        }
    }
    
    protected function validateCSRF(): bool {
        return isset($_POST['csrf_token']) && $_POST['csrf_token'] === ($_SESSION['csrf_token'] ?? '');
    }
    
    protected function generateCSRF(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    protected function flash(string $type, string $message): void {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
    
    protected function getFlash(): ?array {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }
}
