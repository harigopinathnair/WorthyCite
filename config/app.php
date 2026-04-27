<?php
/**
 * Worthycite - Application Configuration
 */

// App Info
define('APP_NAME', 'Worthycite');
define('APP_VERSION', '1.0.0');
// App URL
if (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1')) {
    define('APP_URL', 'http://localhost/worthycite');
} else {
    define('APP_URL', 'https://worthycite.com'); // Replace with your actual production URL
}
define('APP_ROOT', dirname(__DIR__));

// Paths
define('VIEWS_PATH', APP_ROOT . '/views');
define('CONTROLLERS_PATH', APP_ROOT . '/controllers');
define('MODELS_PATH', APP_ROOT . '/models');
define('CORE_PATH', APP_ROOT . '/core');

// Session
define('SESSION_NAME', 'worthycite_session');
define('SESSION_LIFETIME', 86400); // 24 hours

// Email
define('MAIL_FROM', 'alerts@worthycite.com');
define('MAIL_FROM_NAME', 'Worthycite Alerts');

// LinkSquad
define('LINKSQUAD_USER_AGENT', 'WorthyciteBot/1.0 (+http://worthycite.com)');
define('LINKSQUAD_TIMEOUT', 30); // seconds
define('LINKSQUAD_MAX_REDIRECTS', 5);

// Plans
define('PLANS', [
    'free'       => ['projects' => 1,  'backlinks_per_project' => 25,  'price' => 0],
    'starter'    => ['projects' => 10, 'backlinks_per_project' => 100, 'price' => 19],
    'pro'        => ['projects' => 5,  'backlinks_per_project' => 500, 'price' => 99],
    'elite'      => ['projects' => 10, 'total_backlinks' => 5000,      'price' => 199],
]);

// Autoload core, models, controllers
spl_autoload_register(function ($class) {
    $paths = [CORE_PATH, MODELS_PATH, CONTROLLERS_PATH];
    foreach ($paths as $path) {
        $file = $path . '/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
