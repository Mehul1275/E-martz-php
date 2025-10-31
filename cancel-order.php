<?php
session_start();
require_once('admin/inc/config.php');

// PHPMailer includes and namespace imports
require_once('PHPMailer-master/src/PHPMailer.php');
require_once('PHPMailer-master/src/SMTP.php');
require_once('PHPMailer-master/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Check if the customer is logged in
if(!isset($_SESSION['customer'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to cancel orders.']);
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

$order_id = $_POST['order_id'];
$cancel_reason = isset($_POST['cancel_reason']) ? trim($_POST['cancel_reason']) : '';
$customer_id = $_SESSION['customer']['cust_id'];

try {
    // Verify order belongs to the customer and check current status
    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=? AND customer_id=?");
    $statement->execute(array($order_id, $customer_id));
    $order = $statement->fetch(PDO::FETCH_ASSOC);
    
    if(!$order) {
        echo json_encode(['success' => false, 'message' => 'Order not found or you do not have permission to cancel this order.']);
        exit;
    }
    
    // Check if order can be cancelled (only Pending or Confirmed orders)
    if(!in_array($order['order_status'], ['Pending', 'Confirmed'])) {
        echo json_encode(['success' => false, 'message' => 'This order cannot be cancelled. Current status: ' . $order['order_status']]);
        exit;
    }
    
    // Update order status to Cancelled
    $statement = $pdo->prepare("UPDATE tbl_payment SET order_status='Cancelled', cancel_reason=? WHERE id=? AND customer_id=?");
    $statement->execute(array($cancel_reason, $order_id, $customer_id));
    
    if($statement->rowCount() > 0) {
        // Send email to customer about order cancellation
        if(!empty($order['customer_email'])) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'emartz6976@gmail.com';
                $mail->Password   = 'saeq xbcv bhuh tgby';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->CharSet    = 'UTF-8';

                $mail->setFrom('emartz6976@gmail.com', 'E-martz Customer Support');
                $mail->addAddress($order['customer_email']);

                $mail->isHTML(true);
                $mail->Subject = 'Order Cancelled - Order #' . $order['payment_id'];
                $mail->Body    = 'Dear ' . $order['customer_name'] . ',<br><br>Your order #' . $order['payment_id'] . ' has been successfully cancelled.' . (!empty($cancel_reason) ? '<br><br><strong>Cancellation Reason:</strong> ' . htmlspecialchars($cancel_reason) : '') . '<br><br>If you have any questions, please contact our customer support.<br><br>Thank you for shopping with us.<br><br>Best regards,<br>E-martz Team';

                $mail->send();
            } catch (Exception $e) {
                // Log error but don't stop execution
                error_log("Order cancellation email failed: " . $mail->ErrorInfo);
            }
        }

        echo json_encode(['success' => true, 'message' => 'Order has been successfully cancelled.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to cancel the order. Please try again.']);
    }
    
} catch(Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred while cancelling the order.']);
    error_log("Cancel order error: " . $e->getMessage());
}
?>
