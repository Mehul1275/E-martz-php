<?php
session_start();
include("../../admin/inc/config.php");
include("../../admin/inc/functions.php");
include("config.php");

echo "<h2>Razorpay Debug Information</h2>";

// Check if user is logged in
echo "<h3>Session Information:</h3>";
if(isset($_SESSION['customer']['cust_id'])) {
    echo "✅ Customer ID: " . $_SESSION['customer']['cust_id'] . "<br>";
    echo "✅ Customer Name: " . $_SESSION['customer']['cust_name'] . "<br>";
    echo "✅ Customer Email: " . $_SESSION['customer']['cust_email'] . "<br>";
} else {
    echo "❌ Customer not logged in<br>";
}

// Check cart
echo "<h3>Cart Information:</h3>";
if(isset($_SESSION['cart_p_id']) && !empty($_SESSION['cart_p_id'])) {
    echo "✅ Cart has " . count($_SESSION['cart_p_id']) . " items<br>";
    foreach($_SESSION['cart_p_id'] as $key => $value) {
        echo "- Item ID: $value, Qty: " . $_SESSION['cart_p_qty'][$key] . ", Price: " . $_SESSION['cart_p_current_price'][$key] . "<br>";
    }
} else {
    echo "❌ Cart is empty<br>";
}

// Check Razorpay configuration
echo "<h3>Razorpay Configuration:</h3>";
echo "✅ Test Mode: " . (RAZORPAY_TEST_MODE ? 'Enabled' : 'Disabled') . "<br>";
echo "✅ Key ID: " . RAZORPAY_KEY_ID . "<br>";
echo "✅ Currency: " . RAZORPAY_CURRENCY . "<br>";
echo "✅ Success URL: " . RAZORPAY_SUCCESS_URL . "<br>";
echo "✅ Failure URL: " . RAZORPAY_FAILURE_URL . "<br>";

// Test Razorpay SDK
echo "<h3>Razorpay SDK Test:</h3>";
try {
    $api = new Razorpay\Api\Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
    echo "✅ Razorpay SDK loaded successfully<br>";
    
    // Test API connection
    $testOrder = $api->order->create([
        'receipt' => 'test_' . time(),
        'amount' => 100,
        'currency' => 'INR'
    ]);
    echo "✅ API connection successful - Test Order ID: " . $testOrder['id'] . "<br>";
    
} catch(Exception $e) {
    echo "❌ Razorpay SDK Error: " . $e->getMessage() . "<br>";
}

echo "<br><a href='../../checkout.php'>Back to Checkout</a>";
?> 