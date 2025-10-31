<?php require_once('header.php'); ?>

<?php
if( !isset($_REQUEST['id']) || !isset($_REQUEST['task']) ) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$order = $statement->fetch(PDO::FETCH_ASSOC);
	if( !$order ) {
		header('location: logout.php');
		exit;
	}
	
	// Check if order is cancelled or returned - don't allow shipping updates
	$order_status = isset($order['order_status']) ? $order['order_status'] : 'Pending';
	if(in_array($order_status, ['Cancelled', 'Returned'])) {
		header('location: order.php?error=cannot_ship_cancelled_returned');
		exit;
	}
}
?>

<?php
	require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
	require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';
	require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	// Update shipping status and order status
	if($_REQUEST['task'] == 'Completed') {
		// When shipping is completed, set order status to 'Delivered'
		$statement = $pdo->prepare("UPDATE tbl_payment SET shipping_status=?, order_status='Delivered' WHERE id=?");
		$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));
	} else {
		// For other shipping status updates
		$statement = $pdo->prepare("UPDATE tbl_payment SET shipping_status=? WHERE id=?");
		$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));
	}

	// Automatic email when shipping marked complete
	if ($_REQUEST['task'] == 'Completed') {
	    // Get payment info
	    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
	    $statement->execute(array($_REQUEST['id']));
	    $payment = $statement->fetch(PDO::FETCH_ASSOC);
	    if ($payment) {
	        $cust_email = $payment['customer_email'];
	        $cust_name = $payment['customer_name'];
	        $payment_id = $payment['payment_id'];
	        // Get admin email
	        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
	        $statement->execute();
	        $settings = $statement->fetch(PDO::FETCH_ASSOC);
	        $admin_email = $settings ? $settings['contact_email'] : 'emartz6976@gmail.com';
	        // Prepare email
	        $subject = 'Your Order Has Been Shipped';
	        $body = 'Dear ' . htmlspecialchars($cust_name) . ',<br><br>Your order (Payment ID: ' . htmlspecialchars($payment_id) . ') has been <b>shipped/delivered</b> to you.<br>Thank you for shopping with us!<br><br>Regards,<br>E-martz Team';
	        if (!empty($cust_email) && filter_var($cust_email, FILTER_VALIDATE_EMAIL)) {
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
	                $mail->addAddress($cust_email);
	                $mail->addReplyTo($admin_email);
	                $mail->isHTML(true);
	                $mail->Subject = $subject;
	                $mail->Body    = $body;
	                $mail->send();
	            } catch (Exception $e) {
	                // Optionally log error
	                error_log("Email sending failed in shipping-change-status: " . $e->getMessage());
	            }
	        } else {
	            error_log("Invalid email address in shipping-change-status: " . $cust_email);
	        }
	    }
	}

	header('location: order.php');
?>