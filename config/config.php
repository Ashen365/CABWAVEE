<?php
// Application configuration
define('SITE_NAME', 'CABWAVE');
define('SITE_URL', 'http://localhost/CABWAVE');

// Session configuration
session_start();

// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to check if user is admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Function to redirect user
function redirect($url) {
    header("Location: $url");
    exit();
}

// Function to sanitize input data
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Display error message
function showError($message) {
    return "<div class='alert alert-danger'>$message</div>";
}

// Display success message
function showSuccess($message) {
    return "<div class='alert alert-success'>$message</div>";
}
?>