<?php
declare(strict_types=1);

// Error Reporting for PHP 8.4
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Setting up the time zone
date_default_timezone_set('America/Los_Angeles');

// Database Configuration
$dbhost = 'localhost';
$dbname = 'ecommerceweb';
$dbuser = 'root';
$dbpass = '';



// Email Configuration
$smtp_host = 'smtp.gmail.com';
$smtp_port = 587;
$smtp_username = 'your-email@gmail.com'; // Change this to your email
$smtp_password = 'your-app-password'; // Change this to your app password
$smtp_from_email = 'your-email@gmail.com'; // Change this to your email
$smtp_from_name = 'E-Mart';

// URL Configuration
if (!defined('BASE_URL')) {
    define("BASE_URL", "http://localhost/E-martz-php/");
}
if (!defined('ADMIN_URL')) {
    define("ADMIN_URL", BASE_URL . "admin" . "/");
}

// Database Connection with PHP 8.4 compatible error handling
try {
    $pdo = new PDO(
        "mysql:host={$dbhost};dbname={$dbname};charset=utf8mb4",
        $dbuser, 
        $dbpass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ]
    );
} catch (PDOException $exception) {
    error_log("Database connection failed: " . $exception->getMessage());
    die("Database connection failed. Please check your configuration.");
}