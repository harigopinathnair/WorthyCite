<?php
/**
 * Worthycite - Authentication Helper
 */
class Auth {
    
    public static function check(): bool {
        return isset($_SESSION['user_id']);
    }
    
    public static function user(): ?array {
        if (!self::check()) return null;
        static $user = null;
        if ($user === null) {
            $userModel = new User();
            $user = $userModel->findById($_SESSION['user_id']);
        }
        return $user;
    }
    
    public static function id(): ?int {
        return $_SESSION['user_id'] ?? null;
    }
    
    public static function login(int $userId): void {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;
        $_SESSION['login_time'] = time();
    }
    
    public static function logout(): void {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
    
    public static function attempt(string $email, string $password): bool {
        $userModel = new User();
        $user = $userModel->findByEmail($email);
        if ($user && password_verify($password, $user['password_hash'])) {
            self::login($user['id']);
            return true;
        }
        return false;
    }
    
    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}
