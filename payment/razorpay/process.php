<?php
session_start();
include("../../admin/inc/config.php");
include("../../admin/inc/functions.php");
include("config.php");

// Check if user is logged in
if(!isset($_SESSION['customer']['cust_id'])) {
    header('location: ../../login.php');
    exit();
}

// Check if cart is empty
if(!isset($_SESSION['cart_p_id']) || empty($_SESSION['cart_p_id'])) {
    header('location: ../../cart.php');
    exit();
}

// Debug: Check session variables
error_log("Razorpay Debug - Customer ID: " . ($_SESSION['customer']['cust_id'] ?? 'not set'));
error_log("Razorpay Debug - Cart Items: " . count($_SESSION['cart_p_id'] ?? []));

// Calculate total amount
$total_amount = 0;
foreach($_SESSION['cart_p_current_price'] as $key => $value) {
    $total_amount += $value * $_SESSION['cart_p_qty'][$key];
}

// Add shipping cost if any
$shipping_cost = 0; // You can add shipping calculation here
$final_total = $total_amount + $shipping_cost;

// Debug: Check amount calculation
error_log("Razorpay Debug - Total Amount: " . $total_amount);
error_log("Razorpay Debug - Final Total: " . $final_total);

// Convert to paise (Razorpay expects amount in paise)
$amount_in_paise = $final_total * 100;

// Generate unique order ID
$order_id = 'ORDER_' . time() . '_' . $_SESSION['customer']['cust_id'];

// Store order details in session for later use
$_SESSION['razorpay_order'] = [
    'order_id' => $order_id,
    'amount' => $final_total,
    'amount_paise' => $amount_in_paise,
    'customer_id' => $_SESSION['customer']['cust_id'],
    'customer_name' => $_SESSION['customer']['cust_name'],
    'customer_email' => $_SESSION['customer']['cust_email'],
    'customer_phone' => $_SESSION['customer']['cust_phone'] ?? ''
];

try {
    // Initialize Razorpay
    $api = new Razorpay\Api\Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
    
    // Debug: Log API initialization
    error_log("Razorpay Debug - API initialized successfully");
    
    // Create order
    $orderData = [
        'receipt' => $order_id,
        'amount' => $amount_in_paise,
        'currency' => RAZORPAY_CURRENCY,
        'notes' => [
            'customer_id' => $_SESSION['customer']['cust_id'],
            'customer_name' => $_SESSION['customer']['cust_name']
        ]
    ];
    
    // Debug: Log order data
    error_log("Razorpay Debug - Order Data: " . json_encode($orderData));
    
    $razorpayOrder = $api->order->create($orderData);
    $razorpayOrderId = $razorpayOrder['id'];
    
    // Debug: Log order creation
    error_log("Razorpay Debug - Order created: " . $razorpayOrderId);
    
    // Store Razorpay order ID
    $_SESSION['razorpay_order']['razorpay_order_id'] = $razorpayOrderId;
    
    // Prepare checkout data
    $checkoutData = [
        'key' => RAZORPAY_KEY_ID,
        'amount' => $amount_in_paise,
        'currency' => RAZORPAY_CURRENCY,
        'name' => 'E-Martz Store',
        'description' => 'Order Payment',
        'image' => 'http://localhost/E-martz-php/assets/img/logo.png',
        'order_id' => $razorpayOrderId,
        'callback_url' => RAZORPAY_SUCCESS_URL,
        'cancel_url' => RAZORPAY_FAILURE_URL,
        'prefill' => [
            'name' => $_SESSION['customer']['cust_name'],
            'email' => $_SESSION['customer']['cust_email'],
            'contact' => $_SESSION['customer']['cust_phone'] ?? ''
        ],
        'notes' => [
            'customer_id' => $_SESSION['customer']['cust_id'],
            'order_id' => $order_id
        ],
        'theme' => [
            'color' => '#3399cc'
        ]
    ];
    
    // Store checkout data in session
    $_SESSION['razorpay_checkout_data'] = $checkoutData;
    
} catch(Exception $e) {
    // Handle error
    error_log("Razorpay Error: " . $e->getMessage());
    error_log("Razorpay Error Stack: " . $e->getTraceAsString());
    $_SESSION['error_message'] = 'Payment initialization failed: ' . $e->getMessage();
    header('location: ../../checkout.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Payment - E-Martz</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <style>
        .payment-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .loading {
            text-align: center;
            padding: 40px 0;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body style="background: #f8f9fa;">
    <div class="payment-container">
        <div class="loading">
            <div class="spinner"></div>
            <h4>Processing Payment...</h4>
            <p>Please wait while we redirect you to the payment gateway.</p>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = <?php echo json_encode($checkoutData); ?>;
        
        options.handler = function (response) {
            // Handle successful payment
            window.location.href = '<?php echo RAZORPAY_SUCCESS_URL; ?>?razorpay_payment_id=' + response.razorpay_payment_id + '&razorpay_order_id=' + response.razorpay_order_id + '&razorpay_signature=' + response.razorpay_signature;
        };
        
        options.modal = {
            ondismiss: function() {
                // Handle payment cancellation
                window.location.href = '<?php echo RAZORPAY_FAILURE_URL; ?>';
            }
        };
        
        var rzp = new Razorpay(options);
        rzp.open();
    </script>
</body>
</html> 