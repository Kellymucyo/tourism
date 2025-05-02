<?php
require_once '../../includes/config.php';

// Destroy the admin session
unset($_SESSION['admin_logged_in']);

// Redirect to login page
header("Location: login.php");
exit();
?>