<?php
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("seller-header.php");
if(!isset($_SESSION['seller'])) {
    header('Location: seller-login.php');
    exit;
}
$seller_id = $_SESSION['seller']['id'];

// PHPMailer includes and namespace imports
require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/PHPMailer-master/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error_message = '';
$success_message = '';
if(isset($_POST['form1'])) {
    $valid = 1;
    if(empty($_POST['subject_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if(empty($_POST['message_text'])) {
        $valid = 0;
        $error_message .= 'Message can not be empty\n';
    }
    if($valid == 1) {
        $subject_text = strip_tags($_POST['subject_text']);
        $message_text = strip_tags($_POST['message_text']);
        // Get customer email
        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
        $statement->execute(array($_POST['cust_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $cust_email = $row['cust_email'];
            $cust_phone = $row['cust_phone'];
        }
        // Get admin email for reply-to
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $admin_email = $row['contact_email'];
        }
        // Compose order detail
        $order_detail = '';
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $order_detail .= 'Customer Name: '.$row['customer_name'].'<br>';
            $order_detail .= 'Customer Email: '.$row['customer_email'].'<br>';
            $order_detail .= 'Payment Method: '.$row['payment_method'].'<br>';
            $order_detail .= 'Payment Date: '.$row['payment_date'].'<br>';
            $order_detail .= 'Paid Amount: '.$row['paid_amount'].'<br>';
            $order_detail .= 'Payment Status: '.$row['payment_status'].'<br>';
            $order_detail .= 'Shipping Status: '.$row['shipping_status'].'<br>';
            $order_detail .= 'Payment Id: '.$row['payment_id'].'<br>';
        }
        $i=0;
        $statement = $pdo->prepare("SELECT o.*, p.seller_id FROM tbl_order o JOIN tbl_product p ON o.product_id = p.p_id WHERE o.payment_id=? AND p.seller_id=?");
        $statement->execute(array($_POST['payment_id'], $seller_id));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $i++;
            $order_detail .= '<br><b><u>Product Item '.$i.'</u></b><br>';
            $order_detail .= 'Product Name: '.$row['product_name'].'<br>';
            $order_detail .= 'Size: '.$row['size'].'<br>';
            $order_detail .= 'Color: '.$row['color'].'<br>';
            $order_detail .= 'Quantity: '.$row['quantity'].'<br>';
            $order_detail .= 'Unit Price: '.$row['unit_price'].'<br>';
        }
        // Store message in DB
        $statement = $pdo->prepare("INSERT INTO tbl_customer_message (subject,message,order_detail,cust_id,type) VALUES (?,?,?,?,?)");
        $statement->execute(array($subject_text,$message_text,$order_detail,$_POST['cust_id'],'email'));
        // Send email
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
            $mail->setFrom('emartz6976@gmail.com', 'E-martz Seller');
            $mail->addAddress($cust_email);
            $mail->addReplyTo($admin_email);
            $mail->isHTML(true);
            $mail->Subject = $subject_text;
            $mail->Body    = $message_text;
            $mail->send();
            $success_message = 'Your email to customer is sent successfully.';
        } catch (Exception $e) {
            $error_message = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }

    }
}
// Mark Complete actions
if(isset($_GET['mark_payment_complete'])) {
    $id = $_GET['mark_payment_complete'];
    
    // Check if order is cancelled or returned - don't allow payment updates
    $statement = $pdo->prepare("SELECT order_status FROM tbl_payment WHERE id=?");
    $statement->execute(array($id));
    $order = $statement->fetch(PDO::FETCH_ASSOC);
    $order_status = isset($order['order_status']) ? $order['order_status'] : 'Pending';
    
    if(!in_array($order_status, ['Cancelled', 'Returned'])) {
        $statement = $pdo->prepare("UPDATE tbl_payment SET payment_status='Completed', order_status='Confirmed' WHERE id=?");
        $statement->execute(array($id));
    }

    // Send email notification to customer
    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
    $statement->execute(array($id));
    $payment = $statement->fetch(PDO::FETCH_ASSOC);
    
    if ($payment) {
        $cust_email = $payment['customer_email'];
        $cust_name = $payment['customer_name'];
        $payment_id = $payment['payment_id'];
        
        // Get admin email for reply-to
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $settings = $statement->fetch(PDO::FETCH_ASSOC);
        $admin_email = $settings ? $settings['contact_email'] : 'emartz6976@gmail.com';
        
        // Prepare email
        $subject = 'Your Payment is Completed';
        $body = 'Dear ' . htmlspecialchars($cust_name) . ',<br><br>Your payment (Payment ID: ' . htmlspecialchars($payment_id) . ') has been marked as <b>Completed</b> by the seller.<br>Thank you for shopping with us!<br><br>Regards,<br>E-martz Team';
        
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
            $mail->setFrom('emartz6976@gmail.com', 'E-martz Seller');
            $mail->addAddress($cust_email);
            $mail->addReplyTo($admin_email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->send();
        } catch (Exception $e) {
            // Optionally log error
        }
    }
    
    header('Location: seller-orders.php');
    exit;
}

if(isset($_GET['mark_shipping_complete'])) {
    $id = $_GET['mark_shipping_complete'];
    
    // Check if order is cancelled or returned - don't allow shipping updates
    $statement = $pdo->prepare("SELECT order_status FROM tbl_payment WHERE id=?");
    $statement->execute(array($id));
    $order = $statement->fetch(PDO::FETCH_ASSOC);
    $order_status = isset($order['order_status']) ? $order['order_status'] : 'Pending';
    
    if(!in_array($order_status, ['Cancelled', 'Returned'])) {
        $statement = $pdo->prepare("UPDATE tbl_payment SET shipping_status='Completed', order_status='Delivered' WHERE id=?");
        $statement->execute(array($id));
    }

    // Send email notification to customer
    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
    $statement->execute(array($id));
    $payment = $statement->fetch(PDO::FETCH_ASSOC);
    
    if ($payment) {
        $cust_email = $payment['customer_email'];
        $cust_name = $payment['customer_name'];
        $payment_id = $payment['payment_id'];
        
        // Get admin email for reply-to
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $settings = $statement->fetch(PDO::FETCH_ASSOC);
        $admin_email = $settings ? $settings['contact_email'] : 'emartz6976@gmail.com';
        
        // Prepare email
        $subject = 'Your Order Has Been Shipped';
        $body = 'Dear ' . htmlspecialchars($cust_name) . ',<br><br>Your order (Payment ID: ' . htmlspecialchars($payment_id) . ') has been <b>shipped/delivered</b> to you.<br>Thank you for shopping with us!<br><br>Regards,<br>E-martz Team';
        
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
            $mail->setFrom('emartz6976@gmail.com', 'E-martz Seller');
            $mail->addAddress($cust_email);
            $mail->addReplyTo($admin_email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->send();
        } catch (Exception $e) {
            // Optionally log error
        }
    }
    
    header('Location: seller-orders.php');
    exit;
}

// Handle return approval
if(isset($_GET['approve_return'])) {
    $id = $_GET['approve_return'];
    $statement = $pdo->prepare("UPDATE tbl_payment SET return_approved_by_admin=1 WHERE id=?");
    $statement->execute(array($id));
    header('Location: seller-orders.php');
    exit;
}

// Handle return rejection (change status back to delivered)
if(isset($_GET['reject_return'])) {
    $id = $_GET['reject_return'];
    $statement = $pdo->prepare("UPDATE tbl_payment SET order_status='Delivered', return_reason=NULL, return_approved_by_admin=0 WHERE id=?");
    $statement->execute(array($id));
    header('Location: seller-orders.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Orders - Seller Panel</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="admin/css/_all-skins.min.css">
    <link rel="stylesheet" href="assets/css/seller-modern.css">
    
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
    /* Modern Admin Panel Styles for Seller Orders */
    .modern-page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .modern-page-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .seller-filter-bar {
        background: white;
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: 1px solid #e3e6f0;
    }

    .seller-filter-bar .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .seller-filter-bar .filter-header h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .seller-filter-bar .filter-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .seller-filter-bar .filter-content {
        padding: 1rem;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .seller-filter-bar .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .seller-filter-bar .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .seller-filter-bar .filter-label {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .seller-filter-bar .seller-form-control {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .seller-filter-bar .seller-form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .seller-filter-bar .seller-filter-select {
        padding: 0.8rem 1rem;
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .seller-filter-bar .seller-filter-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .seller-filter-bar .filter-summary {
        padding: 1rem;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .seller-filter-bar .results-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .seller-filter-bar .results-count {
        font-size: 0.9rem;
        font-weight: 600;
    }

    .seller-filter-bar .seller-btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
    }

    .seller-filter-bar .seller-modern-btn-secondary {
        background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
        color: #5a5c69;
    }

    .seller-filter-bar .seller-modern-btn-secondary:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        color: #5a5c69;
        text-decoration: none;
    }

    .modern-table-container {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #e3e6f0;
    }

    .modern-table-container thead th {
        background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
        border: none;
        font-weight: 600;
        color: #5a5c69;
        padding: 1rem 0.75rem;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .modern-table-container tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e3e6f0;
    }

    .modern-table-container tbody tr:hover {
        background-color: #f8f9fc;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .customer-info {
        background: #f8f9fc;
        padding: 0.75rem;
        border-radius: 8px;
        border: 2px solid #667eea;
        width: 220px;
        min-height: 110px;
        font-size: 0.85rem;
        line-height: 1.3;
    }

    .product-info {
        background: #fff8f0;
        padding: 0.75rem;
        border-radius: 8px;
        border: 2px solid #ffa726;
        margin-bottom: 0.5rem;
        width: 220px;
        min-height: 110px;
        font-size: 0.85rem;
        line-height: 1.3;
    }

    .payment-info {
        background: #f0f8ff;
        padding: 0.75rem;
        border-radius: 8px;
        border: 2px solid #2196f3;
        width: 220px;
        min-height: 110px;
        font-size: 0.85rem;
        line-height: 1.3;
    }

    .amount-display {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2e7d32;
        background: #e8f5e8;
        padding: 0.5rem;
        border-radius: 6px;
        text-align: center;
    }

    .status-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: center;
        min-width: 80px;
    }

    .status-pending {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-completed {
        background: linear-gradient(135deg, #d4edda, #00b894);
        color: #155724;
        border: 1px solid #00b894;
    }

    .status-active {
        background: linear-gradient(135deg, #d1ecf1, #17a2b8);
        color: #0c5460;
        border: 1px solid #17a2b8;
    }

    .status-inactive {
        background: linear-gradient(135deg, #f8d7da, #dc3545);
        color: #721c24;
        border: 1px solid #dc3545;
    }

    .modern-btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-align: center;
        justify-content: center;
    }

    .modern-btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
    }

    .modern-btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .modern-btn-success:hover {
        background: linear-gradient(135deg, #218838, #1ea080);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        color: white;
        text-decoration: none;
    }

    .modern-btn-warning {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        color: #212529;
    }

    .modern-btn-warning:hover {
        background: linear-gradient(135deg, #e0a800, #e8590c);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(255, 193, 7, 0.3);
        color: #212529;
        text-decoration: none;
    }

    .modern-btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }

    .modern-btn-info:hover {
        background: linear-gradient(135deg, #138496, #117a8b);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(23, 162, 184, 0.3);
        color: white;
        text-decoration: none;
    }

    .tracking-id {
        font-family: 'Courier New', monospace;
        background: #f8f9fc;
        padding: 0.5rem;
        border-radius: 4px;
        border: 1px solid #e3e6f0;
        font-weight: 600;
        color: #495057;
    }

    .invoice-number {
        font-family: 'Courier New', monospace;
        background: #fff8f0;
        padding: 0.5rem;
        border-radius: 4px;
        border: 1px solid #ffeaa7;
        font-weight: 600;
        color: #856404;
    }

    .order-row-pending {
        background: linear-gradient(135deg, #fff8f0 0%, #ffeaa7 100%) !important;
    }

    .order-row-completed {
        background: linear-gradient(135deg, #f0fff4 0%, #c3e6cb 100%) !important;
    }

    .search-box {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .search-box:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .slide-in {
        animation: slideIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed seller-orders-page">
<div class="wrapper">
<?php include('seller-sidebar.php'); ?>
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="seller-page-header fade-in" style="margin-top: 20px;">
            <h1 class="seller-page-title">
                <i class="fa fa-shopping-cart"></i>
                Order Management
            </h1>
            <p class="seller-page-subtitle">Track and manage your customer orders efficiently</p>
        </div>

        <section class="content" style="padding: 0 40px;">
            <!-- Alert Messages -->
            <?php if($error_message != ''): ?>
                <div class="alert alert-danger seller-alert fade-in">
                    <i class="fa fa-exclamation-circle"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <?php if($success_message != ''): ?>
                <div class="alert alert-success seller-alert fade-in">
                    <i class="fa fa-check-circle"></i>
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <!-- Filter & Search Bar -->
            <div class="seller-filter-bar slide-in">
                <div class="filter-header">
                    <h3><i class="fa fa-filter"></i> Filter & Search Orders</h3>
                    <div class="filter-actions">
                        <button id="clearFilters" class="seller-btn-sm seller-modern-btn-secondary">
                            <i class="fa fa-refresh"></i> Clear
                        </button>
                    </div>
                </div>
                <div class="filter-content">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-search"></i> Search Orders
                            </label>
                            <div class="seller-search-box">
                                <i class="fa fa-search"></i>
                                <input type="text" id="searchOrders" 
                                       placeholder="Search by customer name, payment ID..." 
                                       class="seller-form-control">
                            </div>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-credit-card"></i> Payment Status
                            </label>
                            <select id="paymentStatusFilter" class="seller-form-control seller-filter-select">
                                <option value="">All Payment Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-truck"></i> Shipping Status
                            </label>
                            <select id="shippingStatusFilter" class="seller-form-control seller-filter-select">
                                <option value="">All Shipping Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-list-alt"></i> Order Status
                            </label>
                            <select id="orderStatusFilter" class="seller-form-control seller-filter-select">
                                <option value="">All Order Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Shipped">Shipped</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="Returned">Returned</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="filter-summary">
                        <div class="results-info">
                            <span class="results-count">
                                <i class="fa fa-list"></i>
                                Showing <span id="orderCount">0</span> orders
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Orders Table -->
            <div class="modern-table-container slide-in">
                <div class="table-responsive">
                    <table id="ordersTable" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Product Details</th>
                                <th>Payment Information</th>
                                <th>Paid Amount</th>
                                <th>Payment Status</th>
                                <th>Shipping Status</th>
                                <th>Order Status</th>
                                <th>Tracking ID</th>
                                <th>Invoice</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=0;
                        $statement = $pdo->prepare("SELECT * FROM tbl_payment ORDER BY id DESC");
                        $statement->execute();
                        $payments = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($payments as $row) {
                            $statement1 = $pdo->prepare(
                                "SELECT o.* FROM tbl_order o
                                 JOIN tbl_product p ON o.product_id = p.p_id
                                 WHERE o.payment_id = ? AND p.seller_id = ?"
                            );
                            $statement1->execute(array($row['payment_id'], $seller_id));
                            $orders = $statement1->fetchAll(PDO::FETCH_ASSOC);
                            if(count($orders) == 0) continue;
                            $i++;
                            ?>
                            <tr class="<?php echo ($row['payment_status']=='Pending') ? 'order-row-pending' : 'order-row-completed'; ?>">
                                <td><?php echo $i; ?></td>
                                <td>
                                    <div class="customer-info">
                                        <div style="font-weight: 600; color: #667eea; margin-bottom: 0.5rem;">
                                            <i class="fa fa-user"></i> Customer #<?php echo $row['customer_id']; ?>
                                        </div>
                                        <div><strong>Name:</strong> <?php echo htmlspecialchars($row['customer_name']); ?></div>
                                        <div><strong>Email:</strong> <?php echo htmlspecialchars($row['customer_email']); ?></div>
                                    </div>
                                    <div style="margin-top: 0.75rem;">
                                        <?php
                                        $order_status = isset($row['order_status']) ? $row['order_status'] : 'Pending';
                                        if($order_status != 'Cancelled') {
                                            echo '<button type="button" class="modern-btn modern-btn-warning modern-btn-sm send-message-btn" style="width:100%;margin-bottom:4px;" '
                                                .'data-customer-id="'.htmlspecialchars($row['customer_id']).'" '
                                                .'data-payment-id="'.htmlspecialchars($row['payment_id']).'" '
                                                .'data-customer-name="'.htmlspecialchars($row['customer_name']).'" '
                                                .'data-customer-email="'.htmlspecialchars($row['customer_email']).'">'
                                                .'<i class="fa fa-envelope"></i> Send Message'
                                                .'</button>';
                                        } else {
                                            echo '<div class="status-badge status-inactive" style="width:100%; text-align:center;">';
                                            echo '<strong>Order Cancelled</strong><br>';
                                            if(!empty($row['cancel_reason'])) {
                                                echo '<small>Reason: ' . htmlspecialchars($row['cancel_reason']) . '</small>';
                                            }
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td>
                                   <?php
                                   foreach ($orders as $row1) {
                                        echo '<div class="product-info">';
                                        echo '<div style="font-weight: 600; color: #ffa726; margin-bottom: 0.25rem;"><i class="fa fa-cube"></i> ' . htmlspecialchars($row1['product_name']) . '</div>';
                                        echo '<div><strong>Size:</strong> ' . htmlspecialchars($row1['size']) . ' | <strong>Color:</strong> ' . htmlspecialchars($row1['color']) . '</div>';
                                        echo '<div><strong>Qty:</strong> ' . htmlspecialchars($row1['quantity']) . ' | <strong>Price:</strong> ₹' . htmlspecialchars($row1['unit_price']) . '</div>';
                                        echo '</div>';
                                   }
                                   ?>
                                </td>
                                <td>
                                    <div class="payment-info">
                                	<?php if($row['payment_method'] == 'PayPal'): ?>
                                        <div style="font-weight: 600; color: #2196f3; margin-bottom: 0.5rem;"><i class="fa fa-paypal"></i> PayPal</div>
                                		<div><strong>Payment ID:</strong> <?php echo htmlspecialchars($row['payment_id']); ?></div>
                                		<div><strong>Date:</strong> <?php echo htmlspecialchars($row['payment_date']); ?></div>
                                		<div><strong>Transaction ID:</strong> <?php echo htmlspecialchars($row['txnid']); ?></div>
                                	<?php elseif($row['payment_method'] == 'Stripe'): ?>
                                        <div style="font-weight: 600; color: #2196f3; margin-bottom: 0.5rem;"><i class="fa fa-credit-card"></i> Stripe</div>
                                		<div><strong>Payment ID:</strong> <?php echo htmlspecialchars($row['payment_id']); ?></div>
							<div><strong>Date:</strong> <?php echo htmlspecialchars($row['payment_date']); ?></div>
                                		<div><strong>Transaction ID:</strong> <?php echo htmlspecialchars($row['txnid']); ?></div>
                                		<?php if(!empty($row['card_number'])): ?>
                                		<div><strong>Card:</strong> ****<?php echo substr($row['card_number'], -4); ?></div>
                                		<?php endif; ?>
                                	<?php elseif($row['payment_method'] == 'Razorpay'): ?>
                                        <div style="font-weight: 600; color: #2196f3; margin-bottom: 0.5rem;"><i class="fa fa-credit-card"></i> Razorpay</div>
                                		<div><strong>Payment ID:</strong> <?php echo htmlspecialchars($row['payment_id']); ?></div>
							<div><strong>Date:</strong> <?php echo htmlspecialchars($row['payment_date']); ?></div>
                                		<div><strong>Transaction ID:</strong> <?php echo htmlspecialchars($row['txnid']); ?></div>
                                	<?php elseif($row['payment_method'] == 'Bank Deposit'): ?>
                                        <div style="font-weight: 600; color: #2196f3; margin-bottom: 0.5rem;"><i class="fa fa-bank"></i> Bank Deposit</div>
                                		<div><strong>Payment ID:</strong> <?php echo htmlspecialchars($row['payment_id']); ?></div>
							<div><strong>Date:</strong> <?php echo htmlspecialchars($row['payment_date']); ?></div>
                                		<?php if(!empty($row['bank_transaction_info'])): ?>
                                		<div><strong>Details:</strong> <?php echo htmlspecialchars(substr($row['bank_transaction_info'], 0, 50)) . '...'; ?></div>
                                		<?php endif; ?>
                                	<?php elseif($row['payment_method'] == 'Cash on Delivery'): ?>
                                        <div style="font-weight: 600; color: #2196f3; margin-bottom: 0.5rem;"><i class="fa fa-money"></i> Cash on Delivery</div>
                                		<div><strong>Payment ID:</strong> <?php echo htmlspecialchars($row['payment_id']); ?></div>
							<div><strong>Date:</strong> <?php echo htmlspecialchars($row['payment_date']); ?></div>
                                		<div><strong>Transaction ID:</strong> <?php echo htmlspecialchars($row['txnid']); ?></div>
                                	<?php else: ?>
                                        <!-- Fallback for any other payment method or missing data -->
                                        <div style="font-weight: 600; color: #2196f3; margin-bottom: 0.5rem;">
                                            <i class="fa fa-credit-card"></i> <?php echo htmlspecialchars($row['payment_method'] ?: 'Unknown Payment Method'); ?>
                                        </div>
                                		<div><strong>Payment ID:</strong> <?php echo htmlspecialchars($row['payment_id']); ?></div>
							<div><strong>Date:</strong> <?php echo htmlspecialchars($row['payment_date']); ?></div>
                                		<?php if(!empty($row['txnid'])): ?>
                                		<div><strong>Transaction ID:</strong> <?php echo htmlspecialchars($row['txnid']); ?></div>
                                		<?php endif; ?>
                                		<?php if(!empty($row['bank_transaction_info'])): ?>
                                		<div><strong>Details:</strong> <?php echo htmlspecialchars(substr($row['bank_transaction_info'], 0, 50)) . '...'; ?></div>
                                		<?php endif; ?>
                                	<?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="amount-display">
                                        ₹<?php echo number_format($row['paid_amount'], 2); ?>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                    $payment_class = $row['payment_status'] == 'Pending' ? 'status-pending' : 'status-completed';
                                    echo '<span class="status-badge ' . $payment_class . '">' . $row['payment_status'] . '</span>';
                                    ?>
                                    <br><br>
                                    <?php
                                        // Hide payment Mark Complete for cancelled/returned orders
                                        $order_status = isset($row['order_status']) ? $row['order_status'] : 'Pending';
                                        if($row['payment_status']=='Pending' && !in_array($order_status, ['Cancelled','Returned'])){
                                            ?>
                                            <a href="seller-orders.php?mark_payment_complete=<?php echo $row['id']; ?>" class="modern-btn modern-btn-success modern-btn-sm" style="width:100%;margin-bottom:4px;"><i class="fa fa-check"></i> Mark Complete</a>
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    $shipping_class = $row['shipping_status'] == 'Pending' ? 'status-pending' : 'status-completed';
                                    echo '<span class="status-badge ' . $shipping_class . '">' . $row['shipping_status'] . '</span>';
                                    ?>
                                    <br><br>
                                    <?php
                                    // Only allow shipping actions if order is not cancelled or returned
                                    $order_status = isset($row['order_status']) ? $row['order_status'] : 'Pending';
                                    if($row['payment_status']=='Completed' && !in_array($order_status, ['Cancelled', 'Returned'])) {
                                        if($row['shipping_status']=='Pending'){
                                            ?>
                                            <a href="seller-orders.php?mark_shipping_complete=<?php echo $row['id']; ?>" class="modern-btn modern-btn-warning modern-btn-sm" style="width:100%;margin-bottom:4px;"><i class="fa fa-truck"></i> Mark Complete</a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    // Display order status with colored badges
                                    $order_status = isset($row['order_status']) ? $row['order_status'] : 'Pending';
                                    $status_class = '';
                                    switch($order_status) {
                                        case 'Pending': $status_class = 'status-pending'; break;
                                        case 'Confirmed': $status_class = 'status-completed'; break;
                                        case 'Shipped': $status_class = 'status-completed'; break;
                                        case 'Delivered': $status_class = 'status-active'; break;
                                        case 'Cancelled': $status_class = 'status-inactive'; break;
                                        case 'Returned': $status_class = 'status-pending'; break;
                                        case 'Return Rejected': $status_class = 'status-inactive'; break;
                                        default: $status_class = 'status-pending';
                                    }
                                    echo '<span class="status-badge ' . $status_class . '">' . $order_status . '</span>';
                                    
                                    // Show cancellation/return details if applicable
                                    if($order_status == 'Cancelled' && !empty($row['cancel_reason'])) {
                                        echo '<br><small><strong>Reason:</strong> ' . htmlspecialchars($row['cancel_reason']) . '</small>';
                                    }
                                    if($order_status == 'Returned') {
                                        // Details and actions are handled in Return Orders section
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if(!empty($row['tracking_id'])): ?>
                                        <div class="tracking-id"><?php echo htmlspecialchars($row['tracking_id']); ?></div>
                                    <?php else: ?>
                                        <span class="status-badge status-pending">Not Set</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(!empty($row['invoice_number'])): ?>
                                        <div class="invoice-number"><?php echo htmlspecialchars($row['invoice_number']); ?></div>
                                    <?php else: ?>
                                        <span class="status-badge status-pending">Not Generated</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $order_status = isset($row['order_status']) ? $row['order_status'] : 'Pending';
                                    if($order_status == 'Cancelled') {
                                        echo '<div class="status-badge status-inactive" style="width:100%; text-align:center; margin-bottom:8px;">';
                                        echo '<strong>Order Cancelled</strong><br>';
                                        if(!empty($row['cancel_reason'])) {
                                            echo '<small>Reason: ' . htmlspecialchars($row['cancel_reason']) . '</small>';
                                        }
                                        echo '</div>';
                                    } else {
                                        echo '<div class="action-buttons" style="flex-direction:column; width:100%;">';
                                        echo '<a href="invoice.php?payment_id='.$row['payment_id'].'" class="modern-btn modern-btn-info modern-btn-sm" target="_blank" style="width:100%;margin-bottom:4px;"><i class="fa fa-file-text"></i> View Invoice</a>';
                                        if(!empty($row['tracking_id']) && $row['shipping_status'] != 'Completed') {
                                            echo '<a href="track-order.php?tracking_id='.$row['tracking_id'].'" class="modern-btn modern-btn-success modern-btn-sm" target="_blank" style="width:100%;margin-bottom:4px;"><i class="fa fa-map-marker"></i> Track Order</a>';
                                        }
                                        echo '</div>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </section>
    </div>
</div>
<!-- Send Message Modal -->
<div class="modal fade" id="sellerSendMessageModal" tabindex="-1" role="dialog" aria-labelledby="sellerSendMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 10px 10px 0 0;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" id="sellerSendMessageModalLabel" style="font-weight: 600; margin: 0;">
                    <i class="fa fa-envelope"></i> Send Message to Customer
                </h4>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="customer-info-display" style="background: #f8f9fc; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border-left: 4px solid #667eea;">
                    <h5 style="margin: 0 0 0.5rem 0; color: #667eea; font-weight: 600;">
                        <i class="fa fa-user"></i> Customer Information
                    </h5>
                    <div id="sellerMessageCustomerDetails" style="color: #5a5c69; font-size: 0.95rem;"></div>
                </div>
                <form id="sellerMessageForm" action="" method="post">
                    <input type="hidden" id="seller_cust_id" name="cust_id" value="">
                    <input type="hidden" id="seller_payment_id" name="payment_id" value="">
                    <div class="form-group">
                        <label for="seller_subject_text">Subject</label>
                        <input type="text" id="seller_subject_text" name="subject_text" class="form-control" placeholder="Enter subject">
                    </div>
                    <div class="form-group">
                        <label for="seller_message_text">Message</label>
                        <textarea id="seller_message_text" name="message_text" class="form-control" rows="6" placeholder="Write your message to customer..."></textarea>
                    </div>
                    <div style="text-align: right;">
                        <button type="submit" name="form1" class="seller-modern-btn seller-modern-btn-primary"><i class="fa fa-paper-plane"></i> Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="admin/js/jquery-2.2.3.min.js"></script>
<script src="admin/js/bootstrap.min.js"></script>
<script src="admin/js/app.min.js"></script>
<script src="admin/js/jquery.dataTables.min.js"></script>
<script src="admin/js/dataTables.bootstrap.min.js"></script>
<script>
// Modern seller order management functionality
document.addEventListener('DOMContentLoaded', function() {
    // Ensure content is visible immediately
    $('.fade-in, .slide-in').css({
        'opacity': '1',
        'visibility': 'visible',
        'transform': 'translateY(0) translateX(0)'
    });
    
    $('.content, section.content, .seller-table-container, .seller-filter-bar, .seller-page-header').css({
        'opacity': '1',
        'visibility': 'visible',
        'display': 'block'
    });
    
    // Add animations (optional enhancement)
    setTimeout(function() {
        $('.fade-in').addClass('visible');
        $('.slide-in').addClass('visible');
    }, 100);
    
    // Auto-focus search on page load
    $('#searchOrders').focus();
    
    // Enhanced search and filter functionality
    const searchInput = document.getElementById('searchOrders');
    const paymentStatusFilter = document.getElementById('paymentStatusFilter');
    const shippingStatusFilter = document.getElementById('shippingStatusFilter');
    const orderStatusFilter = document.getElementById('orderStatusFilter');
    const table = document.querySelector('#ordersTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    const orderCountSpan = document.getElementById('orderCount');
    
    // Update order count initially
    updateOrderCount();

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const paymentTerm = paymentStatusFilter.value.toLowerCase();
        const shippingTerm = shippingStatusFilter.value.toLowerCase();
        const orderTerm = orderStatusFilter.value.toLowerCase();
        let visibleCount = 0;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let showRow = true;

            // Search filter - search across all visible text in the row
            if (searchTerm) {
                let found = false;
                const rowText = row.textContent.toLowerCase();
                if (rowText.includes(searchTerm)) {
                    found = true;
                }
                if (!found) showRow = false;
            }

            // Payment Status filter
            if (paymentTerm && showRow) {
                const paymentCell = cells[5]; // Payment Status column
                if (paymentCell && !paymentCell.textContent.toLowerCase().includes(paymentTerm)) {
                    showRow = false;
                }
            }
            
            // Shipping Status filter
            if (shippingTerm && showRow) {
                const shippingCell = cells[6]; // Shipping Status column
                if (shippingCell && !shippingCell.textContent.toLowerCase().includes(shippingTerm)) {
                    showRow = false;
                }
            }
            
            // Order Status filter
            if (orderTerm && showRow) {
                const orderCell = cells[7]; // Order Status column
                if (orderCell && !orderCell.textContent.toLowerCase().includes(orderTerm)) {
                    showRow = false;
                }
            }

            if (showRow) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
        
        orderCountSpan.textContent = visibleCount;
    }
    
    function updateOrderCount() {
        orderCountSpan.textContent = rows.length;
    }

    // Event listeners for filters
    if (searchInput) searchInput.addEventListener('keyup', filterTable);
    if (paymentStatusFilter) paymentStatusFilter.addEventListener('change', filterTable);
    if (shippingStatusFilter) shippingStatusFilter.addEventListener('change', filterTable);
    if (orderStatusFilter) orderStatusFilter.addEventListener('change', filterTable);
    
    // Enhanced hover effects for info boxes
    const infoBoxes = document.querySelectorAll('.customer-info, .product-info, .payment-info');
    infoBoxes.forEach(function(box) {
        box.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
        });
        
        box.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
    
    // Enhanced button interactions
    const modernBtns = document.querySelectorAll('.modern-btn, .seller-modern-btn');
    modernBtns.forEach(function(btn) {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Global Send Message modal (mirror admin behavior)
    $(document).on('click', '.send-message-btn', function() {
        var customerId = $(this).data('customer-id');
        var paymentId = $(this).data('payment-id');
        var customerName = $(this).data('customer-name');
        var customerEmail = $(this).data('customer-email');
        $('#sellerMessageCustomerDetails').html(
            '<div style="display:flex;justify-content:space-between;margin-bottom:6px;">'
            + '<span><strong>Name:</strong> ' + customerName + '</span>'
            + '<span><strong>Email:</strong> ' + customerEmail + '</span>'
            + '</div>'
            + '<div style="display:flex;justify-content:space-between;">'
            + '<span><strong>Customer ID:</strong> #' + customerId + '</span>'
            + '<span><strong>Payment ID:</strong> ' + paymentId + '</span>'
            + '</div>'
        );
        $('#seller_cust_id').val(customerId);
        $('#seller_payment_id').val(paymentId);
        $('#seller_subject_text').val('');
        $('#seller_message_text').val('');
        $('#sellerSendMessageModal').modal('show');
        setTimeout(function(){ $('#seller_subject_text').focus(); }, 200);
    });
    
    // Status badge animations
    const statusBadges = document.querySelectorAll('.status-badge, .seller-status-badge');
    statusBadges.forEach(function(badge) {
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
</body>
</html>