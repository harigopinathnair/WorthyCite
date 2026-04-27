<?php
/**
 * Worthycite Testing Bootstrap
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Load app config (without the spl_autoload part if possible, or just let it be)
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

// Define testing constants
define('TESTING', true);
