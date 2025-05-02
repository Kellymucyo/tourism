<?php
require_once __DIR__ . '/config.php';

$allowed_langs = ['en', 'rw', 'fr', 'sw'];
if (isset($_POST['language']) && in_array($_POST['language'], $allowed_langs)) {
    $_SESSION['lang'] = $_POST['language'];
    
    // Store in cookie for persistence (1 month)
    setcookie('lang', $_POST['language'], time() + (30 * 24 * 60 * 60), '/');
}

// Redirect back
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL));
exit();
?>