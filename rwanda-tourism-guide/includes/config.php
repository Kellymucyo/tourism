<?php
// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Base configuration
define('BASE_URL', 'http://localhost/rwanda-tourism-guide');
define('DEFAULT_LANG', 'en');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'rwanda_tourism');

// Session handling
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400,
        'cookie_secure' => false,    // Set to true if using HTTPS
        'cookie_httponly' => true,
        'use_strict_mode' => true
    ]);
}

// Initialize language
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = DEFAULT_LANG;
}

// Load translations
$translations = [];
$lang_file = __DIR__ . '/languages/' . $_SESSION['lang'] . '.php';
if (file_exists($lang_file)) {
    $translations = require $lang_file;
}

// Database connection
try {
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database connection error. Please try again later.");
}

// Timezone
date_default_timezone_set('Africa/Kigali');
?>