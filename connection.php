<?php
// Enable error reporting for debugging (optional)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$host = 'localhost'; // Update with your database host
$dbname = 'alexotpstorage'; // Update with your database name
$username = 'root'; // Update with your database username
$password = ''; // Update with your database password

// Create PDO instance
try {
    $pdo = new PDO('mysql:host=localhost;dbname=alexotpstorage', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}
?>
