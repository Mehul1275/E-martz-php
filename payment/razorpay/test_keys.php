<?php
include("config.php");

echo "<h2>Razorpay API Keys Test</h2>";

// Test the API keys
try {
    $api = new Razorpay\Api\Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
    
    // Try to create a test order
    $orderData = [
        'receipt' => 'test_order_' . time(),
        'amount' => 100, // 1 rupee in paise
        'currency' => 'INR',
        'notes' => [
            'test' => 'true'
        ]
    ];
    
    $order = $api->order->create($orderData);
    
    echo "✅ API Keys are working correctly!<br>";
    echo "✅ Test Order ID: " . $order['id'] . "<br>";
    echo "✅ Order Amount: " . $order['amount'] . " paise<br>";
    echo "✅ Order Currency: " . $order['currency'] . "<br>";
    echo "✅ Order Status: " . $order['status'] . "<br>";
    
} catch(Exception $e) {
    echo "❌ API Keys Error: " . $e->getMessage() . "<br>";
    echo "❌ Error Code: " . $e->getCode() . "<br>";
    
    if($e->getCode() == 401) {
        echo "❌ Authentication failed - Check your API keys<br>";
    } elseif($e->getCode() == 400) {
        echo "❌ Bad request - Check your order data<br>";
    }
}

echo "<br><a href='../../checkout.php'>Back to Checkout</a>";
?> 