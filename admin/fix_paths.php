<?php
// This is a diagnostic script to check and fix paths

// Define the base path to the parent directory
$basePath = '../';

// Check if the config file exists
$configPath = $basePath . 'config/config.php';
if (file_exists($configPath)) {
    echo "✅ Config file exists at: $configPath<br>";
} else {
    echo "❌ Config file NOT found at: $configPath<br>";
    
    // Check if there's a config directory
    if (is_dir($basePath . 'config')) {
        echo "✅ Config directory exists<br>";
        
        // List files in the config directory
        $files = scandir($basePath . 'config');
        echo "Files in config directory: " . implode(", ", $files) . "<br>";
    } else {
        echo "❌ Config directory NOT found<br>";
    }
}

// Check if the db.php file exists
$dbPath = $basePath . 'includes/db.php';
if (file_exists($dbPath)) {
    echo "✅ DB file exists at: $dbPath<br>";
} else {
    echo "❌ DB file NOT found at: $dbPath<br>";
}

// Check if the header.php file exists
$headerPath = $basePath . 'includes/header.php';
if (file_exists($headerPath)) {
    echo "✅ Header file exists at: $headerPath<br>";
    
    // Check the content of the header file
    $headerContent = file_get_contents($headerPath);
    echo "<br><strong>First few lines of header.php:</strong><br>";
    echo nl2br(htmlspecialchars(substr($headerContent, 0, 500))) . "<br>";
} else {
    echo "❌ Header file NOT found at: $headerPath<br>";
}

echo "<br><strong>Current Directory Structure:</strong><br>";
function listFiles($dir, $indent = 0) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo str_repeat('&nbsp;', $indent * 4) . $file . "<br>";
            if (is_dir($dir . '/' . $file)) {
                listFiles($dir . '/' . $file, $indent + 1);
            }
        }
    }
}
listFiles($basePath);
?>