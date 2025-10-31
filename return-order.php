<?php
session_start();
require_once('admin/inc/config.php');

// Check if the customer is logged in
if(!isset($_SESSION['customer'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to request returns.']);
    exit;
}

// Check if customer is active
$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
$statement->execute(array($_SESSION['customer']['cust_id'], 0));
$total = $statement->rowCount();
if($total) {
    echo json_encode(['success' => false, 'message' => 'Your account is inactive. Please contact support.']);
    exit;
}

// Validate input
if(!isset($_POST['order_id']) || empty($_POST['order_id'])) {
    echo json_encode(['success' => false, 'message' => 'Order ID is required.']);
    exit;
}

if(!isset($_POST['return_reason']) || empty(trim($_POST['return_reason']))) {
    echo json_encode(['success' => false, 'message' => 'Return reason is required.']);
    exit;
}

$order_id = $_POST['order_id'];
$return_reason = trim($_POST['return_reason']);
$customer_id = $_SESSION['customer']['cust_id'];

try {
    // Verify order belongs to the customer and check current status
    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=? AND customer_id=?");
    $statement->execute(array($order_id, $customer_id));
    $order = $statement->fetch(PDO::FETCH_ASSOC);
    
    if(!$order) {
        echo json_encode(['success' => false, 'message' => 'Order not found or you do not have permission to return this order.']);
        exit;
    }
    
    // Check if order can be returned (only Delivered orders)
    if($order['order_status'] !== 'Delivered') {
        echo json_encode(['success' => false, 'message' => 'Only delivered orders can be returned. Current status: ' . $order['order_status']]);
        exit;
    }

    // Check if order is already returned
    if($order['order_status'] === 'Returned') {
        echo json_encode(['success' => false, 'message' => 'This order has already been returned.']);
        exit;
    }

    // Check if return was previously rejected by admin
    if($order['order_status'] === 'Return Rejected') {
        echo json_encode(['success' => false, 'message' => 'Your return request for this order was rejected by admin. You cannot request return again for this order.']);
        exit;
    }
    
    // Update order status to Returned with reason and set return_approved_by_admin to 0 (pending approval)
    $statement = $pdo->prepare("UPDATE tbl_payment SET order_status='Returned', return_reason=?, return_approved_by_admin=0 WHERE id=? AND customer_id=?");
    $statement->execute(array($return_reason, $order_id, $customer_id));
    
    if($statement->rowCount() > 0) {
        // Optional: Send notification email to admin/seller about return request
        // This can be added later if needed
        
        echo json_encode(['success' => true, 'message' => 'Return request has been submitted successfully. It will be reviewed by admin/seller.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to submit return request. Please try again.']);
    }
    
} catch(Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing the return request.']);
    error_log("Return order error: " . $e->getMessage());
}
?>
