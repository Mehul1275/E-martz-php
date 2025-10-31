<?php require_once('header.php'); ?>
<?php require_once('inc/tracking_functions.php'); ?>

<style>
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

.modern-page-header .subtitle {
    margin-top: 0.5rem;
    opacity: 0.9;
    font-size: 1.1rem;
}

.modern-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
}

.modern-filter-bar {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
}

.modern-table-container {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
}

.modern-table-container .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.modern-table-container table {
    margin-bottom: 0;
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

.modern-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
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

.search-box:hover {
    border-color: #a78bfa;
    box-shadow: 0 2px 8px rgba(167, 139, 250, 0.1);
}

.customer-info {
    background: #f8f9fc;
    padding: 0.75rem;
    border-radius: 8px;
    border: 2px solid #667eea;
    width: 220px;
    min-height: 110px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    overflow: visible;
    box-sizing: border-box;
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
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    overflow: visible;
    box-sizing: border-box;
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
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    overflow: visible;
    box-sizing: border-box;
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

.modern-btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.modern-btn-primary:hover {
    background: linear-gradient(135deg, #5a67d8, #6b46c1);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
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

.modern-btn-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.modern-btn-danger:hover {
    background: linear-gradient(135deg, #c82333, #a71e2a);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    color: white;
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

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
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

.modern-modal .modal-content {
    border-radius: 10px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.modern-modal .modal-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 10px 10px 0 0;
    padding: 1.5rem;
}

.modern-modal .modal-header h4 {
    margin: 0;
    font-weight: 600;
}

.modern-modal .modal-body {
    padding: 2rem;
}

.modern-modal .form-control {
    border: 2px solid #e3e6f0;
    border-radius: 6px;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.modern-modal .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.order-row-pending {
    background: linear-gradient(135deg, #fff8f0 0%, #ffeaa7 100%) !important;
}

.order-row-completed {
    background: linear-gradient(135deg, #f0fff4 0%, #c3e6cb 100%) !important;
}

/* Animation keyframes */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.fade-in {
    animation: fadeIn 0.6s ease-out;
}

.slide-in {
    animation: slideIn 0.8s ease-out;
}

/* Responsive design */
@media (max-width: 768px) {
    .filter-bar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-bar .modern-form-control {
        min-width: auto;
        width: 100%;
    }
    
    .modern-table {
        font-size: 0.8rem;
    }
    
    .modern-table thead th,
    .modern-table tbody td {
        padding: 0.5rem 0.25rem;
    }
    
    .action-buttons {
        gap: 0.125rem;
    }
    
    .modern-btn-sm {
        padding: 0.3rem 0.6rem;
        font-size: 0.7rem;
    }
}

@media (max-width: 1200px) {
    .modern-table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .modern-table {
        min-width: 1200px;
        width: auto;
    }
    
    .modern-table tbody td {
        white-space: nowrap;
        min-width: 120px;
    }
    
    .modern-table thead th {
        white-space: nowrap;
        min-width: 120px;
    }
}

.stats-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stats-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.5rem;
    font-weight: 600;
}

.stats-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #667eea;
}

.stats-row {
    margin-bottom: 2rem;
}

/* Enhanced Modal Styles */
#sendMessageModal .modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    overflow: hidden;
}

#sendMessageModal .modal-header {
    padding: 1.5rem 2rem;
    border-bottom: none;
}

#sendMessageModal .modal-body {
    padding: 2rem;
    background: #ffffff;
}

#sendMessageModal .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

#sendMessageModal .btn-primary:hover {
    background: linear-gradient(135deg, #5a67d8, #6b46c1);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

#sendMessageModal .btn-default:hover {
    background: #f8f9fc;
    border-color: #e3e6f0;
    transform: translateY(-1px);
}

.customer-info-display {
    transition: all 0.3s ease;
}

.customer-info-display:hover {
    background: #f1f5f9 !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Animation for modal appearance */
.modal.fade .modal-dialog {
    transform: scale(0.8) translateY(-50px);
    transition: all 0.3s ease;
}

.modal.fade.in .modal-dialog {
    transform: scale(1) translateY(0);
}

/* Loading animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.fa-spin {
    animation: spin 1s linear infinite;
}
</style>

<?php
// PHPMailer includes and namespace imports
require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error_message = '';
if(isset($_POST['form1'])) {
    $valid = 1;
    if(empty($_POST['subject_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if(empty($_POST['message_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if($valid == 1) {

        $subject_text = strip_tags($_POST['subject_text']);
        $message_text = strip_tags($_POST['message_text']);

        // Getting Customer Email Address
        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
        $statement->execute(array($_POST['cust_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $cust_email = $row['cust_email'];
        }

        // Getting Admin Email Address
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $admin_email = $row['contact_email'];
        }

        $order_detail = '';
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
        	
        	if($row['payment_method'] == 'PayPal'):
        		$payment_details = '
Transaction Id: '.$row['txnid'].'<br>
        		';
        	elseif($row['payment_method'] == 'Stripe'):
				$payment_details = '
Transaction Id: '.$row['txnid'].'<br>
Card number: '.$row['card_number'].'<br>
Card CVV: '.$row['card_cvv'].'<br>
Card Month: '.$row['card_month'].'<br>
Card Year: '.$row['card_year'].'<br>
        		';
        	elseif($row['payment_method'] == 'Bank Deposit'):
				$payment_details = '
Transaction Details: <br>'.$row['bank_transaction_info'];
        	endif;

            $order_detail .= '
Customer Name: '.$row['customer_name'].'<br>
Customer Email: '.$row['customer_email'].'<br>
Payment Method: '.$row['payment_method'].'<br>
Payment Date: '.$row['payment_date'].'<br>
Payment Details: <br>'.$payment_details.'<br>
Paid Amount: '.$row['paid_amount'].'<br>
Payment Status: '.$row['payment_status'].'<br>
Shipping Status: '.$row['shipping_status'].'<br>
Payment Id: '.$row['payment_id'].'<br>
            ';
        }

        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $i++;
            $order_detail .= '
<br><b><u>Product Item '.$i.'</u></b><br>
Product Name: '.$row['product_name'].'<br>
Size: '.$row['size'].'<br>
Color: '.$row['color'].'<br>
Quantity: '.$row['quantity'].'<br>
Unit Price: '.$row['unit_price'].'<br>
            ';
        }

        $statement = $pdo->prepare("INSERT INTO tbl_customer_message (subject,message,order_detail,cust_id,type) VALUES (?,?,?,?,?)");
        $statement->execute(array($subject_text,$message_text,$order_detail,$_POST['cust_id'],'email'));

        // sending email
        if (!empty($cust_email) && filter_var($cust_email, FILTER_VALIDATE_EMAIL)) {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'emartz6976@gmail.com';
                $mail->Password   = 'saeq xbcv bhuh tgby'; // Updated App Password for mail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->CharSet    = 'UTF-8';

                //Recipients
                $mail->setFrom('emartz6976@gmail.com', 'E-martz Admin');
                $mail->addAddress($cust_email);     // Add a recipient
                $mail->addReplyTo($admin_email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject_text;
                $mail->Body    = $message_text; // Use $message_text here

                $mail->send();
                $success_message = 'Your email to customer is sent successfully.';
            } catch (Exception $e) {
                $error_message = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }
        } else {
            $error_message = 'Invalid customer email address. Please check the customer email in the database.';
        }



    }
}

// Handle return approval
if(isset($_GET['approve_return'])) {
    $id = $_GET['approve_return'];
    $statement = $pdo->prepare("UPDATE tbl_payment SET return_approved_by_admin=1 WHERE id=?");
    $statement->execute(array($id));

    // Send email to customer about return approval
    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
    $statement->execute(array($id));
    $order = $statement->fetch(PDO::FETCH_ASSOC);

    if($order && !empty($order['customer_email'])) {
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

            $mail->setFrom('emartz6976@gmail.com', 'E-martz Admin');
            $mail->addAddress($order['customer_email']);

            $mail->isHTML(true);
            $mail->Subject = 'Return Request Approved - Order #' . $order['payment_id'];
            $mail->Body    = 'Dear ' . $order['customer_name'] . ',<br><br>Your return request for order #' . $order['payment_id'] . ' has been approved by admin. The return process will be initiated shortly.<br><br>Thank you for shopping with us.<br><br>Best regards,<br>E-martz Team';

            $mail->send();
        } catch (Exception $e) {
            // Log error but don't stop execution
            error_log("Return approval email failed: " . $mail->ErrorInfo);
        }
    }

    header('Location: order.php');
    exit;
}

// Handle return rejection (mark as Return Rejected)
if(isset($_GET['reject_return'])) {
    $id = $_GET['reject_return'];
    $statement = $pdo->prepare("UPDATE tbl_payment SET order_status='Return Rejected', return_approved_by_admin=0 WHERE id=?");
    $statement->execute(array($id));

    // Send email to customer about return rejection
    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
    $statement->execute(array($id));
    $order = $statement->fetch(PDO::FETCH_ASSOC);

    if($order && !empty($order['customer_email'])) {
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

            $mail->setFrom('emartz6976@gmail.com', 'E-martz Admin');
            $mail->addAddress($order['customer_email']);

            $mail->isHTML(true);
            $mail->Subject = 'Return Request Rejected - Order #' . $order['payment_id'];
            $mail->Body    = 'Dear ' . $order['customer_name'] . ',<br><br>We regret to inform you that your return request for order #' . $order['payment_id'] . ' has been rejected by admin. If you have any questions, please contact our customer support.<br><br>Thank you for shopping with us.<br><br>Best regards,<br>E-martz Team';

            $mail->send();
        } catch (Exception $e) {
            // Log error but don't stop execution
            error_log("Return rejection email failed: " . $mail->ErrorInfo);
        }
    }

    header('Location: order.php');
    exit;
}
?>
<?php
if($error_message != '') {
    echo "<script>alert('".$error_message."')</script>";
}
if($success_message != '') {
    echo "<script>alert('".$success_message."')</script>";
}
?>

<!-- Modern Page Header -->
<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-shopping-cart"></i>
        Order Management
    </h1>
    <div class="subtitle">Manage and track all customer orders efficiently</div>
</div>

<?php
// Get order statistics
$stmt = $pdo->query("SELECT COUNT(*) as total_orders FROM tbl_payment");
$total_orders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];

$stmt = $pdo->query("SELECT COUNT(*) as pending_orders FROM tbl_payment WHERE payment_status = 'Pending'");
$pending_orders = $stmt->fetch(PDO::FETCH_ASSOC)['pending_orders'];

$stmt = $pdo->query("SELECT COUNT(*) as completed_orders FROM tbl_payment WHERE payment_status = 'Completed'");
$completed_orders = $stmt->fetch(PDO::FETCH_ASSOC)['completed_orders'];

$stmt = $pdo->query("SELECT SUM(paid_amount) as total_revenue FROM tbl_payment WHERE payment_status = 'Completed'");
$total_revenue = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?: 0;

$stmt = $pdo->query("SELECT COUNT(*) as shipped_orders FROM tbl_payment WHERE shipping_status = 'Shipped'");
$shipped_orders = $stmt->fetch(PDO::FETCH_ASSOC)['shipped_orders'];

$stmt = $pdo->query("SELECT COUNT(*) as pending_shipping FROM tbl_payment WHERE payment_status = 'Completed' AND shipping_status = 'Pending'");
$pending_shipping = $stmt->fetch(PDO::FETCH_ASSOC)['pending_shipping'];
?>

<div class="stats-row fade-in">
    <div class="row">
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="stats-number"><?php echo $total_orders; ?></div>
                <div class="stats-label">Total Orders</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fa fa-clock-o" style="color: #f6c23e;"></i>
                </div>
                <div class="stats-number" style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo $pending_orders; ?></div>
                <div class="stats-label">Pending Orders</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fa fa-check-circle" style="color: #1cc88a;"></i>
                </div>
                <div class="stats-number" style="background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo $completed_orders; ?></div>
                <div class="stats-label">Completed Orders</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fa fa-hourglass-half" style="color: #fd7e14;"></i>
                </div>
                <div class="stats-number" style="background: linear-gradient(135deg, #fd7e14 0%, #e55a4e 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo $pending_shipping; ?></div>
                <div class="stats-label">Pending Shipping</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fa fa-truck" style="color: #17a2b8;"></i>
                </div>
                <div class="stats-number" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo $shipped_orders; ?></div>
                <div class="stats-label">Complete Shipping</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fa fa-rupee" style="color: #28a745;"></i>
                </div>
                <div class="stats-number" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">₹<?php echo number_format($total_revenue, 0); ?></div>
                <div class="stats-label">Total Revenue</div>
            </div>
        </div>
    </div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-6">
            <input type="text" id="orderSearch" class="search-box" placeholder="🔍 Search orders by customer, product, payment ID...">
        </div>
        <div class="col-md-3">
            <select id="statusFilter" class="search-box">
                <option value="">All Status</option>
                <option value="Pending">Pending Orders</option>
                <option value="Completed">Completed Orders</option>
                <option value="Cancelled">Cancelled Orders</option>
                <option value="Returned">Returned Orders</option>
            </select>
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Total Orders: <span id="totalCount">0</span>
            </div>
        </div>
    </div>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
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
            	$statement = $pdo->prepare("SELECT * FROM tbl_payment ORDER by id DESC");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr class="<?php if($row['payment_status']=='Pending'){echo 'bg-r';}else{echo 'bg-g';} ?>">
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
                                echo '<button type="button" class="modern-btn modern-btn-warning modern-btn-sm send-message-btn" style="width:100%;margin-bottom:4px;" data-customer-id="'.$row['customer_id'].'" data-payment-id="'.$row['payment_id'].'" data-customer-name="'.htmlspecialchars($row['customer_name']).'" data-customer-email="'.htmlspecialchars($row['customer_email']).'"><i class="fa fa-envelope"></i> Send Message</button>';
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
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                           $statement1->execute(array($row['payment_id']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
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
                        		<div><strong>Card:</strong> ****<?php echo substr($row['card_number'], -4); ?></div>
                        	<?php elseif($row['payment_method'] == 'Bank Deposit'): ?>
                                <div style="font-weight: 600; color: #2196f3; margin-bottom: 0.5rem;"><i class="fa fa-bank"></i> Bank Deposit</div>
                        		<div><strong>Payment ID:</strong> <?php echo htmlspecialchars($row['payment_id']); ?></div>
								<div><strong>Date:</strong> <?php echo htmlspecialchars($row['payment_date']); ?></div>
                        		<div><strong>Details:</strong> <?php echo htmlspecialchars(substr($row['bank_transaction_info'], 0, 50)) . '...'; ?></div>
                        	<?php elseif($row['payment_method'] == 'Cash on Delivery'): ?>
                                <div style="font-weight: 600; color: #2196f3; margin-bottom: 0.5rem;"><i class="fa fa-money"></i> Cash on Delivery</div>
                        		<div><strong>Payment ID:</strong> <?php echo htmlspecialchars($row['payment_id']); ?></div>
								<div><strong>Date:</strong> <?php echo htmlspecialchars($row['payment_date']); ?></div>
                        		<div><strong>Transaction ID:</strong> <?php echo htmlspecialchars($row['txnid']); ?></div>
                        	<?php elseif($row['payment_method'] == 'Razorpay'): ?>
                                <div style="font-weight: 600; color: #2196f3; margin-bottom: 0.5rem;"><i class="fa fa-credit-card-alt"></i> Razorpay</div>
                        		<div><strong>Payment ID:</strong> <?php echo htmlspecialchars($row['payment_id']); ?></div>
								<div><strong>Date:</strong> <?php echo htmlspecialchars($row['payment_date']); ?></div>
                        		<div><strong>Transaction ID:</strong> <?php echo htmlspecialchars($row['txnid']); ?></div>
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
                                    <a href="order-change-status.php?id=<?php echo $row['id']; ?>&task=Completed" class="modern-btn modern-btn-success modern-btn-sm" style="width:100%;margin-bottom:4px;"><i class="fa fa-check"></i> Mark Complete</a>
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
                                    <a href="shipping-change-status.php?id=<?php echo $row['id']; ?>&task=Completed" class="modern-btn modern-btn-warning modern-btn-sm" style="width:100%;margin-bottom:4px;"><i class="fa fa-truck"></i> Mark Complete</a>
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
                                // Details and actions are handled in Return Orders page
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
                                // Allow deleting cancelled orders
                                echo '<a href="#" class="modern-btn modern-btn-danger modern-btn-sm" data-href="order-delete.php?id='.$row['id'].'" data-toggle="modal" data-target="#confirm-delete" style="width:100%;"><i class="fa fa-trash"></i> Delete</a>';
                            } else {
                                echo '<div class="action-buttons" style="flex-direction:column; width:100%;">';
                                echo '<a href="../invoice.php?payment_id='.$row['payment_id'].'" class="modern-btn modern-btn-info modern-btn-sm" target="_blank" style="width:100%;margin-bottom:4px;"><i class="fa fa-file-text"></i> View Invoice</a>';
                                if(!empty($row['tracking_id']) && $row['shipping_status'] != 'Completed') {
                                    echo '<a href="../track-order.php?tracking_id='.$row['tracking_id'].'" class="modern-btn modern-btn-success modern-btn-sm" target="_blank" style="width:100%;margin-bottom:4px;"><i class="fa fa-map-marker"></i> Track Order</a>';
                                }
                                echo '<a href="#" class="modern-btn modern-btn-danger modern-btn-sm" data-href="order-delete.php?id='.$row['id'].'" data-toggle="modal" data-target="#confirm-delete" style="width:100%;"><i class="fa fa-trash"></i> Delete</a>';
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
	</div>
</section>

<script>
// Modern table search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('orderSearch');
    const statusFilter = document.getElementById('statusFilter');
    const table = document.getElementById('ordersTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    const totalCountSpan = document.getElementById('totalCount');
    
    // Update total count initially
    updateTotalCount();

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value.toLowerCase();
        let visibleCount = 0;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let showRow = true;

            // Search filter
            if (searchTerm) {
                let found = false;
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].textContent.toLowerCase().includes(searchTerm)) {
                        found = true;
                        break;
                    }
                }
                if (!found) showRow = false;
            }

            // Status filter
            if (statusTerm && showRow) {
                const statusCell = cells[5]; // Payment Status column
                if (statusCell && !statusCell.textContent.toLowerCase().includes(statusTerm)) {
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
        
        totalCountSpan.textContent = visibleCount;
    }
    
    function updateTotalCount() {
        totalCountSpan.textContent = rows.length;
    }

    searchInput.addEventListener('keyup', filterTable);
    statusFilter.addEventListener('change', filterTable);
});

// Send Message Modal Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle send message button clicks
    document.querySelectorAll('.send-message-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const customerId = this.getAttribute('data-customer-id');
            const paymentId = this.getAttribute('data-payment-id');
            const customerName = this.getAttribute('data-customer-name');
            const customerEmail = this.getAttribute('data-customer-email');
            
            // Populate customer details
            document.getElementById('customerDetails').innerHTML = `
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span><strong>Name:</strong> ${customerName}</span>
                    <span><strong>Email:</strong> ${customerEmail}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span><strong>Customer ID:</strong> #${customerId}</span>
                    <span><strong>Payment ID:</strong> ${paymentId}</span>
                </div>
            `;
            
            // Set form values
            document.getElementById('cust_id').value = customerId;
            document.getElementById('payment_id').value = paymentId;
            
            // Clear form fields
            document.getElementById('subject_text').value = '';
            document.getElementById('message_text').value = '';
            
            // Show modal
            $('#sendMessageModal').modal('show');
        });
    });
    
    // Handle form focus effects
    const formInputs = document.querySelectorAll('#sendMessageModal input, #sendMessageModal textarea');
    formInputs.forEach(function(input) {
        input.addEventListener('focus', function() {
            this.style.borderColor = '#667eea';
            this.style.boxShadow = '0 0 0 3px rgba(102, 126, 234, 0.1)';
        });
        
        input.addEventListener('blur', function() {
            this.style.borderColor = '#e3e6f0';
            this.style.boxShadow = 'none';
        });
    });
    
    // Handle modal events
    $('#sendMessageModal').on('hidden.bs.modal', function() {
        // Reset form when modal is closed
        document.getElementById('messageForm').reset();
        document.getElementById('cust_id').value = '';
        document.getElementById('payment_id').value = '';
    });
    
    // Handle form submission
    document.getElementById('messageForm').addEventListener('submit', function(e) {
        const subject = document.getElementById('subject_text').value.trim();
        const message = document.getElementById('message_text').value.trim();
        
        if (!subject || !message) {
            e.preventDefault();
            alert('Please fill in both subject and message fields.');
            return false;
        }
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sending...';
        submitBtn.disabled = true;
        
        // Re-enable button after 3 seconds (in case of error)
        setTimeout(function() {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });
});
</script>


<!-- Send Message Modal -->
<div class="modal fade" id="sendMessageModal" tabindex="-1" role="dialog" aria-labelledby="sendMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 10px 10px 0 0;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" id="sendMessageModalLabel" style="font-weight: 600; margin: 0;">
                    <i class="fa fa-envelope"></i> Send Message to Customer
                </h4>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="customer-info-display" style="background: #f8f9fc; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border-left: 4px solid #667eea;">
                    <h5 style="margin: 0 0 0.5rem 0; color: #667eea; font-weight: 600;">
                        <i class="fa fa-user"></i> Customer Information
                    </h5>
                    <div id="customerDetails" style="color: #5a5c69; font-size: 0.95rem;">
                        <!-- Customer details will be populated here -->
                    </div>
                </div>
                
                <form id="messageForm" action="" method="post">
                    <input type="hidden" id="cust_id" name="cust_id" value="">
                    <input type="hidden" id="payment_id" name="payment_id" value="">
                    
                    <div class="form-group">
                        <label for="subject_text" style="font-weight: 600; color: #5a5c69; margin-bottom: 0.5rem;">
                            <i class="fa fa-tag"></i> Subject
                        </label>
                        <input type="text" id="subject_text" name="subject_text" class="form-control" 
                               style="border: 2px solid #e3e6f0; border-radius: 8px; padding: 0.75rem; font-size: 1rem; transition: all 0.3s ease;"
                               placeholder="Enter message subject..." required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message_text" style="font-weight: 600; color: #5a5c69; margin-bottom: 0.5rem;">
                            <i class="fa fa-comment"></i> Message
                        </label>
                        <textarea id="message_text" name="message_text" class="form-control" 
                                  style="border: 2px solid #e3e6f0; border-radius: 8px; padding: 0.75rem; font-size: 1rem; min-height: 200px; resize: vertical; transition: all 0.3s ease;"
                                  placeholder="Type your message here..." required></textarea>
                    </div>
                    
                    <div class="form-actions" style="text-align: right; margin-top: 1.5rem;">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right: 10px; padding: 0.75rem 1.5rem; border-radius: 6px;">
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" name="form1" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none; padding: 0.75rem 1.5rem; border-radius: 6px; font-weight: 600;">
                            <i class="fa fa-paper-plane"></i> Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>