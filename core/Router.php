<?php
/**
 * Worthycite - Simple Router
 */
class Router {
    private static array $routes = [];
    
    public static function get(string $path, string $controller, string $method): void {
        self::$routes['GET'][$path] = ['controller' => $controller, 'method' => $method];
    }
    
    public static function post(string $path, string $controller, string $method): void {
        self::$routes['POST'][$path] = ['controller' => $controller, 'method' => $method];
    }
    
    public static function dispatch(): void {
        $url = $_GET['url'] ?? '';
        
        if (empty($url)) {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            // Remove the base path if the project is in a subdirectory
            $scriptName = dirname($_SERVER['SCRIPT_NAME']);
            $url = str_replace($scriptName, '', $uri);
        }
        
        $url = trim($url, '/');
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Check exact match first
        if (isset(self::$routes[$method][$url])) {
            $route = self::$routes[$method][$url];
            $controller = new $route['controller']();
            $action = $route['method'];
            $controller->$action();
            return;
        }
        
        // Check parameterized routes
        foreach (self::$routes[$method] ?? [] as $pattern => $route) {
            $regex = preg_replace('/\{([a-zA-Z_]+)\}/', '([^/]+)', $pattern);
            if (preg_match('#^' . $regex . '$#', $url, $matches)) {
                array_shift($matches);
                $controller = new $route['controller']();
                $action = $route['method'];
                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }
        
        // 404
        http_response_code(404);
        echo '<h1>404 - Page Not Found</h1>';
    }
}
