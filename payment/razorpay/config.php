<?php
// Razorpay Configuration
// Replace with your actual Razorpay API keys

// Test Mode (Change to false for production)
define('RAZORPAY_TEST_MODE', true);

// API Keys
if(RAZORPAY_TEST_MODE) {
    // Test Keys
    define('RAZORPAY_KEY_ID', 'rzp_test_Z13yNpfkNBKNXC');
    define('RAZORPAY_KEY_SECRET', 'nR8K7eNdAYEfl0Og3n4n69kc');
} else {
    // Live Keys
    define('RAZORPAY_KEY_ID', 'rzp_live_YOUR_LIVE_KEY_ID');
    define('RAZORPAY_KEY_SECRET', 'YOUR_LIVE_KEY_SECRET');
}

// Currency
define('RAZORPAY_CURRENCY', 'INR');

// Webhook Secret (Generate from Razorpay Dashboard)
define('RAZORPAY_WEBHOOK_SECRET', 'YOUR_WEBHOOK_SECRET');

// Success and Failure URLs
define('RAZORPAY_SUCCESS_URL', 'http://localhost/E-martz-php/payment/razorpay/success.php');
define('RAZORPAY_FAILURE_URL', 'http://localhost/E-martz-php/payment/razorpay/failure.php');

// Include Razorpay SDK
require_once 'vendor/autoload.php';
?> 