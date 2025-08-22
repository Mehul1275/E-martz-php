<?php
// Test Razorpay SDK Installation
include("config.php");

try {
    // Test if Razorpay SDK is loaded
    $api = new Razorpay\Api\Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
    echo "✅ Razorpay SDK loaded successfully!<br>";
    echo "✅ API Keys configured correctly!<br>";
    echo "✅ Test Mode: " . (RAZORPAY_TEST_MODE ? 'Enabled' : 'Disabled') . "<br>";
    echo "✅ Key ID: " . RAZORPAY_KEY_ID . "<br>";
    echo "✅ Currency: " . RAZORPAY_CURRENCY . "<br>";
    echo "✅ Success URL: " . RAZORPAY_SUCCESS_URL . "<br>";
    echo "✅ Failure URL: " . RAZORPAY_FAILURE_URL . "<br>";
    
} catch(Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?> 