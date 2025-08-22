<?php 
declare(strict_types=1);
require_once('header.php'); 
?>
<title>Seller Registration</title>
<?php
require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error_message = '';
$success_message = '';

if (isset($_POST['form1'])) {
    $valid = 1;
    if(empty($_POST['fullname'])) {
        $valid = 0;
        $error_message .= 'Full Name is required.<br>';
    }
    if(empty($_POST['company_name'])) {
        $valid = 0;
        $error_message .= 'Company Name is required.<br>';
    }
    if(empty($_POST['company_address'])) {
        $valid = 0;
        $error_message .= 'Company Address is required.<br>';
    }
    if(empty($_POST['email'])) {
        $valid = 0;
        $error_message .= 'Email is required.<br>';
    } else {
        if (!validate_email($_POST['email'])) {
            $valid = 0;
            $error_message .= 'Email address is invalid.<br>';
        } else {
            $statement = $pdo->prepare("SELECT * FROM sellers WHERE email=?");
            $statement->execute([$_POST['email']]);
            if($statement->rowCount()) {
                $valid = 0;
                $error_message .= 'Email address already exists.<br>';
            }
        }
    }
    if(empty($_POST['phone'])) {
        $valid = 0;
        $error_message .= 'Phone number is required.<br>';
    }
    if(empty($_POST['gstno'])) {
        $valid = 0;
        $error_message .= 'GST No. is required.<br>';
    }
    if(empty($_POST['password']) || empty($_POST['re_password'])) {
        $valid = 0;
        $error_message .= 'Password and Confirm Password are required.<br>';
    }
    if(!empty($_POST['password']) && !empty($_POST['re_password'])) {
        if($_POST['password'] != $_POST['re_password']) {
            $valid = 0;
            $error_message .= 'Passwords do not match.<br>';
        }
    }
    if($valid == 1) {
        $token = generate_token();
        $password_hash = hash_password($_POST['password']);
        
        // Save to database with email verification
        $statement = $pdo->prepare("INSERT INTO sellers (fullname, company_name, company_address, email, phone, gstno, password, token, email_verified, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, 0)");
        $statement->execute([
            sanitize_input($_POST['fullname']),
            sanitize_input($_POST['company_name']),
            sanitize_input($_POST['company_address']),
            sanitize_input($_POST['email']),
            sanitize_input($_POST['phone']),
            sanitize_input($_POST['gstno']),
            $password_hash,
            $token
        ]);

        // Send email for confirmation
        $to = $_POST['email'];
        $subject = 'Seller Account Verification - E-Mart';
        $verify_link = BASE_URL.'seller-verify.php?email='.$to.'&token='.$token;
        $message = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <h2 style="color: #333;">Welcome to E-Mart Seller Platform!</h2>
            <p>Thank you for registering as a seller on E-Mart. To complete your registration, please verify your email address by clicking the link below:</p>
            <p style="margin: 20px 0;">
                <a href="'.$verify_link.'" style="background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">Verify Email Address</a>
            </p>
            <p>Or copy and paste this link in your browser:</p>
            <p style="word-break: break-all; color: #666;">'.$verify_link.'</p>
            <p>If you did not create this account, please ignore this email.</p>
            <p>Best regards,<br>E-Mart Team</p>
        </div>';

        // PHPMailer SMTP email sending
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'emartz6976@gmail.com';
            $mail->Password   = 'ddxy twfj zkne ejnv'; // E-martz App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            //Recipients
            $mail->setFrom('emartz6976@gmail.com', 'E-Mart Admin');
            $mail->addAddress($to);
            $mail->addReplyTo('emartz6976@gmail.com', 'E-Mart Admin');

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            $success_message = 'Registration successful! Please check your email and click the verification link to activate your account.';
        } catch (Exception $e) {
            $error_message = 'Registration successful but verification email could not be sent. Please contact support. Mailer Error: ' . $mail->ErrorInfo;
        }
        
        unset($_POST);
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_seller_registration = $row['banner_seller_registration'];
}
?>
<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/<?php echo $banner_seller_registration; ?>);">
    <div class="inner">
        <h1>Seller Registration</h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>
                                <div class="col-md-6 form-group">
                                    <label>Full Name *</label>
                                    <input type="text" class="form-control" name="fullname" value="<?php if(isset($_POST['fullname'])){echo $_POST['fullname'];} ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Company Name *</label>
                                    <input type="text" class="form-control" name="company_name" value="<?php if(isset($_POST['company_name'])){echo $_POST['company_name'];} ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Company Address *</label>
                                    <textarea class="form-control" name="company_address" rows="3" placeholder="Enter complete company address"><?php if(isset($_POST['company_address'])){echo $_POST['company_address'];} ?></textarea>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Email *</label>
                                    <input type="email" class="form-control" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Phone No. *</label>
                                    <input type="text" class="form-control" name="phone" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];} ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>GST No. *</label>
                                    <input type="text" class="form-control" name="gstno" value="<?php if(isset($_POST['gstno'])){echo $_POST['gstno'];} ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Password *</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Confirm Password *</label>
                                    <input type="password" class="form-control" name="re_password">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label></label>
                                    <input type="submit" class="btn btn-danger" value="Register" name="form1">
                                </div>
                                <div class="col-md-12 form-group" style="margin-top:10px;">
                                    <span>Already have a seller account? <a href="seller-login.php">Login here</a></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?> 