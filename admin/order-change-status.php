<?php require_once('header.php'); ?>

<?php
if( !isset($_REQUEST['id']) || !isset($_REQUEST['task']) ) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
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

	$statement = $pdo->prepare("UPDATE tbl_payment SET payment_status=? WHERE id=?");
	$statement->execute(array($_REQUEST['task'],$_REQUEST['id']));

	// Automatic email when payment marked complete
	if ($_REQUEST['task'] == 'Completed') {
	    // Get payment info
	    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
	    $statement->execute(array($_REQUEST['id']));
	    $payment = $statement->fetch(PDO::FETCH_ASSOC);
	    if ($payment) {
	        $cust_email = $payment['customer_email'];
	        $cust_name = $payment['customer_name'];
	        $payment_id = $payment['payment_id'];
	        $cust_id = $payment['customer_id'];
	        // Get admin email
	        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
	        $statement->execute();
	        $settings = $statement->fetch(PDO::FETCH_ASSOC);
	        $admin_email = $settings ? $settings['contact_email'] : 'emartz6976@gmail.com';
	        // Prepare email
	        $subject = 'Your Payment is Completed';
	        $body = 'Dear ' . htmlspecialchars($cust_name) . ',<br><br>Your payment (Payment ID: ' . htmlspecialchars($payment_id) . ') has been marked as <b>Completed</b> by admin.<br>Thank you for shopping with us!<br><br>Regards,<br>E-martz Team';
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
	                error_log("Email sending failed in order-change-status: " . $e->getMessage());
	            }
	        } else {
	            error_log("Invalid email address in order-change-status: " . $cust_email);
	        }

	    }
	}

	header('location: order.php');
?>