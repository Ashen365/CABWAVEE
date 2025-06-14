<?php
$host = 'localhost';
$username = 'root';
$password = ''; // Default password for XAMPP/WAMP
$dbname = 'cabwave';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Database connected successfully!";
?>