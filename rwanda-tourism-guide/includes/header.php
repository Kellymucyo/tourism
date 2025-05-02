<?php
require_once __DIR__ . '/config.php'; // Load configuration

// Initialize language (default to English if not set)
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Load translations
$translations = require_once __DIR__ . "/languages/{$_SESSION['lang']}.php";
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $translations['page_title'] ?? 'Rwanda Tourism Guide'; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php">
                <img src="<?php echo BASE_URL; ?>/assets/images/logo.png" alt="Rwanda Tourism Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/index.php"><?php echo $translations['home'] ?? 'Home'; ?></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="destinationsDropdown" role="button" data-bs-toggle="dropdown">
                            <?php echo $translations['destinations'] ?? 'Destinations'; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/pages/destinations.php?category=park"><?php echo $translations['national_parks'] ?? 'National Parks'; ?></a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/pages/destinations.php?category=museum"><?php echo $translations['museums'] ?? 'Museums'; ?></a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/pages/destinations.php?category=cultural"><?php echo $translations['cultural_sites'] ?? 'Cultural Sites'; ?></a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/pages/destinations.php"><?php echo $translations['all_destinations'] ?? 'All Destinations'; ?></a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/pages/events.php"><?php echo $translations['events'] ?? 'Events & Festivals'; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/pages/blog.php"><?php echo $translations['blog'] ?? 'Travel Blog'; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/pages/travel_tips.php"><?php echo $translations['travel_tips'] ?? 'Travel Tips'; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/pages/contact.php"><?php echo $translations['contact'] ?? 'Contact'; ?></a>
                    </li>
                </ul>
                
                <!-- Language Switcher (Updated) -->
                <form method="POST" action="<?php echo BASE_URL; ?>/includes/change_language.php" class="d-inline me-2">
                    <select name="language" class="form-select" onchange="this.form.submit()">
                        <option value="en" <?php echo ($_SESSION['lang'] === 'en') ? 'selected' : ''; ?>>English</option>
                        <option value="rw" <?php echo ($_SESSION['lang'] === 'rw') ? 'selected' : ''; ?>>Kinyarwanda</option>
                        <option value="fr" <?php echo ($_SESSION['lang'] === 'fr') ? 'selected' : ''; ?>>Français</option>
                        <option value="sw" <?php echo ($_SESSION['lang'] === 'sw') ? 'selected' : ''; ?>>Swahili</option>
                    </select>
                </form>
                
                <!-- User Account -->
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> <?php echo $translations['my_account'] ?? 'My Account'; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/profile.php"><?php echo $translations['profile'] ?? 'Profile'; ?></a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/logout.php"><?php echo $translations['logout'] ?? 'Logout'; ?></a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/user/login.php" class="btn btn-outline-light me-2"><?php echo $translations['login'] ?? 'Login'; ?></a>
                    <a href="<?php echo BASE_URL; ?>/user/register.php" class="btn btn-light"><?php echo $translations['register'] ?? 'Register'; ?></a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <!-- Main Content Container -->
    <div class="container mt-4">
        