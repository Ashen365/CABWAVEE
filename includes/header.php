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
    <title><?php echo SITE_NAME; ?> - Premium Cab Service</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo $basePath; ?>assets/images/logo.svg">
    
    <!-- Preload Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Magic UI Library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/magic-ui/dist/magic-ui.min.css">
    
    <!-- GSAP Animation Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/main.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/header.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/responsive.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/animations.css">
</head>
<body class="page-transition">
    <header>
        <div class="container">
            <div class="logo">
                <img src="<?php echo $basePath; ?>assets/images/logo.svg" alt="<?php echo SITE_NAME; ?> Logo">
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo $basePath; ?>index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="<?php echo $basePath; ?>services.php"><i class="fas fa-concierge-bell"></i> Services</a></li>
                    <li><a href="<?php echo $basePath; ?>fare-calculator.php"><i class="fas fa-calculator"></i> Fare Calculator</a></li>
                    <li><a href="<?php echo $basePath; ?>pricing.php"><i class="fas fa-tags"></i> Pricing</a></li>
                    <li><a href="<?php echo $basePath; ?>contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
                    <?php if(isLoggedIn()): ?>
                        <?php if(isAdmin()): ?>
                            <li><a href="<?php echo $basePath; ?>admin/index.php"><i class="fas fa-user-shield"></i> Admin Dashboard</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo $basePath; ?>dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo $basePath; ?>logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo $basePath; ?>login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li><a href="<?php echo $basePath; ?>register.php"><i class="fas fa-user-plus"></i> Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">
        <?php if(isset($error) && $error): ?>
            <?php echo showError($error); ?>
        <?php endif; ?>
        
        <?php if(isset($success) && $success): ?>
            <?php echo showSuccess($success); ?>
        <?php endif; ?>