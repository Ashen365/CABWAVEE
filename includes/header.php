<?php
// Determine if we're in a subdirectory
$isInSubdir = strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false;
$basePath = $isInSubdir ? '../' : '';

// Include required files with appropriate path
require_once $basePath . 'config/config.php';
require_once $basePath . 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/magic-ui/dist/magic-ui.min.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/main.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/header.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/responsive.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1><?php echo SITE_NAME; ?></h1>
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo $basePath; ?>index.php">Home</a></li>
                    <li><a href="<?php echo $basePath; ?>services.php">Services</a></li>
                    <li><a href="<?php echo $basePath; ?>fare-calculator.php">Fare Calculator</a></li>
                    <li><a href="<?php echo $basePath; ?>pricing.php">Pricing</a></li>
                    <li><a href="<?php echo $basePath; ?>contact.php">Contact</a></li>
                    <?php if(isLoggedIn()): ?>
                        <?php if(isAdmin()): ?>
                            <li><a href="<?php echo $basePath; ?>admin/index.php">Admin Dashboard</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo $basePath; ?>dashboard.php">Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo $basePath; ?>logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo $basePath; ?>login.php">Login</a></li>
                        <li><a href="<?php echo $basePath; ?>register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container"></main>
        <?php if(isset($error) && $error): ?>
            <?php echo showError($error); ?>
        <?php endif; ?>
        
        <?php if(isset($success) && $success): ?>
            <?php echo showSuccess($success); ?>
        <?php endif; ?>