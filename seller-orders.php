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
    $statement = $pdo->prepare("UPDATE tbl_payment SET payment_status='Completed' WHERE id=?");
    $statement->execute(array($id));

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
    $statement = $pdo->prepare("UPDATE tbl_payment SET shipping_status='Completed' WHERE id=?");
    $statement->execute(array($id));

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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller Panel - Orders</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="admin/css/_all-skins.min.css">
    <link rel="stylesheet" href="admin/css/dataTables.bootstrap.css">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
<?php include('seller-sidebar.php'); ?>
    <div class="content-wrapper" style="min-height:100vh;">
        <section class="content-header">
            <div class="content-header-left">
                <h1>View Orders</h1>
            </div>
        </section>
        <section class="content">
            <?php
            if($error_message != '') {
                echo "<div class='callout callout-danger'><p>".$error_message."</p></div>";
            }
            if($success_message != '') {
                echo "<div class='callout callout-success'><p>".$success_message."</p></div>";
            }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-body table-responsive">
                            <table id="example1" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Product Details</th>
                                        <th>Payment Information</th>
                                        <th>Paid Amount</th>
                                        <th>Payment Status</th>
                                        <th>Shipping Status</th>
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
                                    <tr class="<?php if($row['payment_status']=='Pending'){echo 'bg-r';}else{echo 'bg-g';} ?>">
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <b>Id:</b> <?php echo $row['customer_id']; ?><br>
                                            <b>Name:</b><br> <?php echo $row['customer_name']; ?><br>
                                            <b>Email:</b><br> <?php echo $row['customer_email']; ?><br><br>
                                            <a href="#" data-toggle="modal" data-target="#model-<?php echo $i; ?>"class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Send Message</a>
                                            <div id="model-<?php echo $i; ?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title" style="font-weight: bold;">Send Message</h4>
                                                        </div>
                                                        <div class="modal-body" style="font-size: 14px">
                                                            <form action="" method="post">
                                                                <input type="hidden" name="cust_id" value="<?php echo $row['customer_id']; ?>">
                                                                <input type="hidden" name="payment_id" value="<?php echo $row['payment_id']; ?>">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <td>Subject</td>
                                                                        <td>
                                                                            <input type="text" name="subject_text" class="form-control" style="width: 100%;">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Message</td>
                                                                        <td>
                                                                            <textarea name="message_text" class="form-control" cols="30" rows="10" style="width:100%;height: 200px;"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><input type="submit" value="Send Message" name="form1"></td>
                                                                    </tr>
                                                                </table>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            foreach ($orders as $row1) {
                                                echo '<b>Product:</b> '.$row1['product_name'];
                                                echo '<br>(<b>Size:</b> '.$row1['size'];
                                                echo ', <b>Color:</b> '.$row1['color'].')';
                                                echo '<br>(<b>Quantity:</b> '.$row1['quantity'];
                                                echo ', <b>Unit Price:</b> '.$row1['unit_price'].')';
                                                echo '<br><br>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if($row['payment_method'] == 'PayPal'): ?>
                                                <b>Payment Method:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                                                <b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
                                                <b>Date:</b> <?php echo $row['payment_date']; ?><br>
                                                <b>Transaction Id:</b> <?php echo $row['txnid']; ?><br>
                                            <?php elseif($row['payment_method'] == 'Stripe'): ?>
                                                <b>Payment Method:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                                                <b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
                                                <b>Date:</b> <?php echo $row['payment_date']; ?><br>
                                                <b>Transaction Id:</b> <?php echo $row['txnid']; ?><br>
                                                <b>Card Number:</b> <?php echo $row['card_number']; ?><br>
                                                <b>Card CVV:</b> <?php echo $row['card_cvv']; ?><br>
                                                <b>Expire Month:</b> <?php echo $row['card_month']; ?><br>
                                                <b>Expire Year:</b> <?php echo $row['card_year']; ?><br>
                                            <?php elseif($row['payment_method'] == 'Bank Deposit'): ?>
                                                <b>Payment Method:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                                                <b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
                                                <b>Date:</b> <?php echo $row['payment_date']; ?><br>
                                                <b>Transaction Information:</b> <br><?php echo $row['bank_transaction_info']; ?><br>
                                            <?php endif; ?>
                                        </td>
                                        <td>₹<?php echo $row['paid_amount']; ?></td>
                                        <td>
                                            <?php echo $row['payment_status']; ?>
                                            <br><br>
                                            <?php
                                                if($row['payment_status']=='Pending'){
                                                    ?>
                                                    <a href="seller-orders.php?mark_payment_complete=<?php echo $row['id']; ?>" class="btn btn-success btn-xs" style="width:100%;margin-bottom:4px;">Mark Complete</a>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $row['shipping_status']; ?>
                                            <br><br>
                                            <?php
                                            if($row['payment_status']=='Completed') {
                                                if($row['shipping_status']=='Pending'){
                                                    ?>
                                                    <a href="seller-orders.php?mark_shipping_complete=<?php echo $row['id']; ?>" class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Mark Complete</a>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['tracking_id']; ?></td>
                                        <td><?php echo $row['invoice_number']; ?></td>
                                        <td>
                                            <a href="invoice.php?payment_id=<?php echo $row['payment_id']; ?>" class="btn btn-info btn-sm" target="_blank" style="width:100%;margin-bottom:4px;">View Invoice</a>
                                            <a href="track-order.php?tracking_id=<?php echo $row['tracking_id']; ?>" class="btn btn-success btn-sm" target="_blank" style="width:100%;margin-bottom:4px;">Track Order</a>
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
    </div>
</div>
<script src="admin/js/jquery-2.2.3.min.js"></script>
<script src="admin/js/bootstrap.min.js"></script>
<script src="admin/js/app.min.js"></script>
<script src="admin/js/jquery.dataTables.min.js"></script>
<script src="admin/js/dataTables.bootstrap.min.js"></script>
<script>
$(function () {
    $('#example1').DataTable();
});
</script>
</body>
</html> 