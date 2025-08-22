<?php
session_start();
include("../../admin/inc/config.php");
include("../../admin/inc/functions.php");

// Handle payment failure
$_SESSION['error_message'] = 'Payment was cancelled or failed. Please try again.';

// Log the failure for debugging
$failure_data = [
    'timestamp' => date('Y-m-d H:i:s'),
    'customer_id' => $_SESSION['customer']['cust_id'] ?? 'unknown',
    'error' => $_GET['error'] ?? 'Payment cancelled',
    'razorpay_order_id' => $_GET['razorpay_order_id'] ?? '',
    'razorpay_payment_id' => $_GET['razorpay_payment_id'] ?? ''
];

// You can log this to a file or database for debugging
error_log('Razorpay Payment Failure: ' . json_encode($failure_data));

// Clear any stored payment data
unset($_SESSION['razorpay_order']);
unset($_SESSION['razorpay_checkout_data']);

// Redirect back to checkout
header('location: ../../checkout.php');
exit();
?> 