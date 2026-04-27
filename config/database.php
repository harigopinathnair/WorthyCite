<?php
/**
 * Worthycite - Database Configuration
 * PDO-based MySQL connection
 */

if (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1')) {
    // Offline / Local Settings
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'worthycitdb');
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    // Online / Production Settings
    define('DB_HOST', 'localhost'); // Often localhost on shared hosting
    define('DB_NAME', 'nqatsxqe_worthycite26');
    define('DB_USER', 'nqatsxqe_citeworthy26');
    define('DB_PASS', 'Rankmonk98@');
}
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    return $pdo;
}
