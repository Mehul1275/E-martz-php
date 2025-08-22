<?php
session_start();
include("../../admin/inc/config.php");
include("../../admin/inc/functions.php");
include("../../admin/inc/tracking_functions.php");
include("config.php");

// PHPMailer includes and namespace imports
require_once __DIR__ . '/../../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../../PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../../PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verify payment signature
$razorpay_payment_id = $_GET['razorpay_payment_id'] ?? '';
$razorpay_order_id = $_GET['razorpay_order_id'] ?? '';
$razorpay_signature = $_GET['razorpay_signature'] ?? '';

if(empty($razorpay_payment_id) || empty($razorpay_order_id) || empty($razorpay_signature)) {
    header('location: ../../checkout.php?error=invalid_payment');
    exit();
}

try {
    // Verify signature
    $attributes = array(
        'razorpay_order_id' => $razorpay_order_id,
        'razorpay_payment_id' => $razorpay_payment_id,
        'razorpay_signature' => $razorpay_signature
    );
    
    $api = new Razorpay\Api\Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
    $api->utility->verifyPaymentSignature($attributes);
    
    // Payment verified successfully
    $payment_date = date('Y-m-d H:i:s');
    $payment_id = time();
    
    // Insert payment record
    $statement = $pdo->prepare("INSERT INTO tbl_payment (
        customer_id, customer_name, customer_email, payment_date,
        txnid, paid_amount, card_number, card_cvv, card_month, card_year,
        bank_transaction_info, payment_method, payment_status, shipping_status, payment_id
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    
    $statement->execute(array(
        $_SESSION['customer']['cust_id'],
        $_SESSION['customer']['cust_name'],
        $_SESSION['customer']['cust_email'],
        $payment_date,
        $razorpay_payment_id,
        $_SESSION['razorpay_order']['amount'],
        '', '', '', '',
        'Razorpay Payment ID: ' . $razorpay_payment_id,
        'Razorpay',
        'Completed',
        'Pending',
        $payment_id
    ));
    
    // Generate invoice number and tracking ID
    $lastId = $pdo->lastInsertId();
    $invoice_number = 'INV' . str_pad($lastId, 8, '0', STR_PAD_LEFT);
    $tracking_id = generateUniqueTrackingId($pdo);
    $statement = $pdo->prepare("UPDATE tbl_payment SET invoice_number=?, tracking_id=? WHERE id=?");
    $statement->execute(array($invoice_number, $tracking_id, $lastId));
    
    // Get product stock information
    $i = 0;
    $statement = $pdo->prepare("SELECT * FROM tbl_product");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    foreach ($result as $row) {
        $i++;
        $arr_p_id[$i] = $row['p_id'];
        $arr_p_qty[$i] = $row['p_qty'];
    }

    // Prepare cart arrays
    $i = 0;
    foreach($_SESSION['cart_p_id'] as $key => $value) {
        $i++;
        $arr_cart_p_id[$i] = $value;
    }
    
    $i = 0;
    foreach($_SESSION['cart_p_name'] as $key => $value) {
        $i++;
        $arr_cart_p_name[$i] = $value;
    }
    
    $i = 0;
    foreach($_SESSION['cart_size_name'] as $key => $value) {
        $i++;
        $arr_cart_size_name[$i] = $value;
    }
    
    $i = 0;
    foreach($_SESSION['cart_color_name'] as $key => $value) {
        $i++;
        $arr_cart_color_name[$i] = $value;
    }
    
    $i = 0;
    foreach($_SESSION['cart_p_qty'] as $key => $value) {
        $i++;
        $arr_cart_p_qty[$i] = $value;
    }
    
    $i = 0;
    foreach($_SESSION['cart_p_current_price'] as $key => $value) {
        $i++;
        $arr_cart_p_current_price[$i] = $value;
    }
    
    // Insert order items using same structure as bank deposit
    for($i=1;$i<=count($arr_cart_p_name);$i++) {
        $statement = $pdo->prepare("INSERT INTO tbl_order (
                        product_id,
                        product_name,
                        size, 
                        color,
                        quantity, 
                        unit_price, 
                        payment_id
                        ) 
                        VALUES (?,?,?,?,?,?,?)");
        $sql = $statement->execute(array(
                        $arr_cart_p_id[$i],
                        $arr_cart_p_name[$i],
                        $arr_cart_size_name[$i],
                        $arr_cart_color_name[$i],
                        $arr_cart_p_qty[$i],
                        $arr_cart_p_current_price[$i],
                        $payment_id
                    ));

        // Update the stock
        for($j=1;$j<=count($arr_p_id);$j++)
        {
            if($arr_p_id[$j] == $arr_cart_p_id[$i]) 
            {
                $current_qty = $arr_p_qty[$j];
                break;
            }
        }
        $final_quantity = $current_qty - $arr_cart_p_qty[$i];
        $statement = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
        $statement->execute(array($final_quantity,$arr_cart_p_id[$i]));
    }
    
    // Clear cart
    unset($_SESSION['cart_p_id']);
    unset($_SESSION['cart_size_id']);
    unset($_SESSION['cart_size_name']);
    unset($_SESSION['cart_color_id']);
    unset($_SESSION['cart_color_name']);
    unset($_SESSION['cart_p_qty']);
    unset($_SESSION['cart_p_current_price']);
    unset($_SESSION['cart_p_name']);
    unset($_SESSION['cart_p_featured_photo']);
    unset($_SESSION['razorpay_order']);
    
    // Send email notification to customer
    try {
        $mail = new PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'emartz6976@gmail.com';
        $mail->Password   = 'saeq xbcv bhuh tgby';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // Recipients
        $mail->setFrom('emartz6976@gmail.com', 'E-martz');
        $mail->addAddress($_SESSION['customer']['cust_email']);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Payment Successful - Order Confirmed';
        
        // Build order details for email
        $order_details = '';
        for($i=1;$i<=count($arr_cart_p_name);$i++) {
            $order_details .= '<tr>';
            $order_details .= '<td>' . $arr_cart_p_name[$i] . '</td>';
            $order_details .= '<td>' . $arr_cart_size_name[$i] . '</td>';
            $order_details .= '<td>' . $arr_cart_color_name[$i] . '</td>';
            $order_details .= '<td>' . $arr_cart_p_qty[$i] . '</td>';
            $order_details .= '<td>₹' . number_format($arr_cart_p_current_price[$i], 2) . '</td>';
            $order_details .= '<td>₹' . number_format($arr_cart_p_current_price[$i] * $arr_cart_p_qty[$i], 2) . '</td>';
            $order_details .= '</tr>';
        }
        
        $mail->Body = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <h2 style="color: #28a745;">Payment Successful!</h2>
            <p>Dear ' . $_SESSION['customer']['cust_name'] . ',</p>
            <p>Your payment has been processed successfully and your order has been confirmed.</p>
            
            <h3>Order Details:</h3>
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="border: 1px solid #ddd; padding: 8px;">Product</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Size</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Color</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Qty</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Unit Price</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $order_details . '
                </tbody>
            </table>
            
            <p><strong>Payment ID:</strong> ' . $razorpay_payment_id . '</p>
            <p><strong>Invoice Number:</strong> ' . $invoice_number . '</p>
            <p><strong>Total Amount:</strong> ₹' . number_format($_SESSION['razorpay_order']['amount'], 2) . '</p>
            <p><strong>Payment Method:</strong> Razorpay</p>
            <p><strong>Payment Status:</strong> Completed</p>
            <p><strong>Order Date:</strong> ' . $payment_date . '</p>
            
            <p>Your order will be processed and shipped soon. You will receive tracking information once your order is dispatched.</p>
            
            <p>Thank you for shopping with E-martz!</p>
        </div>';
        
        $mail->send();
    } catch (Exception $e) {
        // Email failed but order was successful, so we continue
        error_log("Razorpay Order Email failed: " . $e->getMessage());
    }
    
    // Send notification to admin
    try {
        // Get admin email from settings
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $admin_email = $row['contact_email'];
        }
        
        if (!empty($admin_email) && filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
            $admin_mail = new PHPMailer(true);
            
            // Server settings
            $admin_mail->isSMTP();
            $admin_mail->Host       = 'smtp.gmail.com';
            $admin_mail->SMTPAuth   = true;
            $admin_mail->Username   = 'emartz6976@gmail.com';
            $admin_mail->Password   = 'saeq xbcv bhuh tgby';
            $admin_mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $admin_mail->Port       = 587;
            $admin_mail->CharSet    = 'UTF-8';

            // Recipients
            $admin_mail->setFrom('emartz6976@gmail.com', 'E-martz System');
            $admin_mail->addAddress($admin_email);
            
            // Content
            $admin_mail->isHTML(true);
            $admin_mail->Subject = 'New Razorpay Order Received - Payment ID: ' . $razorpay_payment_id;
            
            $admin_mail->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h2 style="color: #28a745;">New Razorpay Order</h2>
                <p>A new order has been placed with successful payment via Razorpay.</p>
                
                <h3>Order Details:</h3>
                <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="border: 1px solid #ddd; padding: 8px;">Product</th>
                            <th style="border: 1px solid #ddd; padding: 8px;">Size</th>
                            <th style="border: 1px solid #ddd; padding: 8px;">Color</th>
                            <th style="border: 1px solid #ddd; padding: 8px;">Qty</th>
                            <th style="border: 1px solid #ddd; padding: 8px;">Unit Price</th>
                            <th style="border: 1px solid #ddd; padding: 8px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $order_details . '
                    </tbody>
                </table>
                
                <h3>Customer Information:</h3>
                <p><strong>Customer Name:</strong> ' . $_SESSION['customer']['cust_name'] . '</p>
                <p><strong>Customer Email:</strong> ' . $_SESSION['customer']['cust_email'] . '</p>
                <p><strong>Customer ID:</strong> ' . $_SESSION['customer']['cust_id'] . '</p>
                
                <h3>Payment Information:</h3>
                <p><strong>Payment ID:</strong> ' . $razorpay_payment_id . '</p>
                <p><strong>Invoice Number:</strong> ' . $invoice_number . '</p>
                <p><strong>Total Amount:</strong> ₹' . number_format($_SESSION['razorpay_order']['amount'], 2) . '</p>
                <p><strong>Payment Method:</strong> Razorpay</p>
                <p><strong>Payment Status:</strong> Completed</p>
                <p><strong>Order Date:</strong> ' . $payment_date . '</p>
                
                <p style="color: #28a745; font-weight: bold;">Payment has been completed successfully. Please process this order for shipping.</p>
            </div>';
            
            $admin_mail->send();
        }
    } catch (Exception $e) {
        // Admin email failed but order was successful, so we continue
        error_log("Razorpay Admin Email failed: " . $e->getMessage());
    }
    
    $_SESSION['success_message'] = 'Payment successful! Your order has been placed and confirmed.';
    header('location: ../../payment_success.php');
    
} catch(Exception $e) {
    $_SESSION['error_message'] = 'Payment verification failed: ' . $e->getMessage();
    header('location: ../../checkout.php');
}
?> 