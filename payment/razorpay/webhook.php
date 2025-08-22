<?php
include("../../admin/inc/config.php");
include("config.php");

// Get the webhook payload
$webhook_body = file_get_contents('php://input');
$webhook_signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';

// Verify webhook signature
try {
    $api = new Razorpay\Api\Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
    $api->utility->verifyWebhookSignature($webhook_body, $webhook_signature, RAZORPAY_WEBHOOK_SECRET);
    
    // Parse the webhook data
    $webhook_data = json_decode($webhook_body, true);
    
    // Handle different webhook events
    switch($webhook_data['event']) {
        case 'payment.captured':
            // Payment was successful
            $payment_id = $webhook_data['payload']['payment']['entity']['id'];
            $order_id = $webhook_data['payload']['payment']['entity']['order_id'];
            $amount = $webhook_data['payload']['payment']['entity']['amount'] / 100; // Convert from paise
            
            // Update payment status in database
            $statement = $pdo->prepare("UPDATE tbl_payment SET payment_status = 'Completed' WHERE txnid = ?");
            $statement->execute(array($payment_id));
            
            // Log successful payment
            error_log("Razorpay Webhook: Payment captured - ID: $payment_id, Amount: $amount");
            break;
            
        case 'payment.failed':
            // Payment failed
            $payment_id = $webhook_data['payload']['payment']['entity']['id'];
            $error_code = $webhook_data['payload']['payment']['entity']['error_code'] ?? '';
            $error_description = $webhook_data['payload']['payment']['entity']['error_description'] ?? '';
            
            // Update payment status in database
            $statement = $pdo->prepare("UPDATE tbl_payment SET payment_status = 'Failed' WHERE txnid = ?");
            $statement->execute(array($payment_id));
            
            // Log failed payment
            error_log("Razorpay Webhook: Payment failed - ID: $payment_id, Error: $error_code - $error_description");
            break;
            
        case 'refund.processed':
            // Refund was processed
            $refund_id = $webhook_data['payload']['refund']['entity']['id'];
            $payment_id = $webhook_data['payload']['refund']['entity']['payment_id'];
            $amount = $webhook_data['payload']['refund']['entity']['amount'] / 100;
            
            // Update payment status to refunded
            $statement = $pdo->prepare("UPDATE tbl_payment SET payment_status = 'Refunded' WHERE txnid = ?");
            $statement->execute(array($payment_id));
            
            // Log refund
            error_log("Razorpay Webhook: Refund processed - Refund ID: $refund_id, Payment ID: $payment_id, Amount: $amount");
            break;
            
        default:
            // Handle other events if needed
            error_log("Razorpay Webhook: Unhandled event - " . $webhook_data['event']);
            break;
    }
    
    // Return success response
    http_response_code(200);
    echo json_encode(['status' => 'success']);
    
} catch(Exception $e) {
    // Log error and return error response
    error_log("Razorpay Webhook Error: " . $e->getMessage());
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?> 