<?php 
declare(strict_types=1);
require_once('header.php'); 
?>
<title>Seller Registration</title>
<style>
.error-msg{color:#e74c3c;font-size:12px;margin-top:6px;display:none;opacity:0;transition:opacity .2s ease}
.invalid{border-color:#e74c3c !important}
.error-msg.show{display:block;opacity:1}
</style>
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
    } else {
        if(!preg_match('/^[A-Za-z ]{3,}$/', $_POST['fullname'])){
            $valid = 0;
            $error_message .= 'Full Name must contain only letters and spaces (min 3).<br>';
        }
    }
    if(empty($_POST['company_name'])) {
        $valid = 0;
        $error_message .= 'Company Name is required.<br>';
    } else if(strlen(trim($_POST['company_name'])) < 3){
        $valid = 0;
        $error_message .= 'Company Name must be at least 3 characters.<br>';
    }
    if(empty($_POST['company_address'])) {
        $valid = 0;
        $error_message .= 'Company Address is required.<br>';
    } else if(strlen(trim($_POST['company_address'])) < 10){
        $valid = 0;
        $error_message .= 'Company Address must be at least 10 characters.<br>';
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
    } else if(!preg_match('/^\d{10}$/', $_POST['phone'])){
        $valid = 0;
        $error_message .= 'Phone number must be a 10-digit numeric value.<br>';
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
        // Password: minimum 8 chars, with complexity
        $pass = $_POST['password'];
        if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', $pass)){
            $valid = 0;
            $error_message .= 'Password must be 8+ chars with uppercase, lowercase, number and special character.<br>';
        }
        if($_POST['password'] != $_POST['re_password']) {
            $valid = 0;
            $error_message .= 'Passwords do not match.<br>';
        }
    }
    if(empty($_POST['agree_terms'])){
        $valid = 0;
        $error_message .= 'You must agree to the Seller Terms and Conditions.<br>';
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

<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header" style="margin-bottom: 30px;">
                    <h1>Seller Registration</h1>
                    <p class="text-muted">Join our marketplace and start selling your products to thousands of customers</p>
                </div>
                
                <div class="seller-registration-container" style="background:#fff; padding: 30px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid var(--color-primary);">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <form action="" method="post">
                                <?php $csrf->echoInputField(); ?>
                                
                                <?php
                                if($error_message != '') {
                                    echo "<div class='alert alert-danger'><i class='fa fa-exclamation-circle'></i> ".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> ".$success_message."</div>";
                                }
                                ?>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fullname">Full Name *</label>
                                            <input type="text" class="form-control" name="fullname" id="fullname" value="<?php if(isset($_POST['fullname'])){echo $_POST['fullname'];} ?>" >
                                            <span class="error-msg" id="fullname_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_name">Company Name *</label>
                                            <input type="text" class="form-control" name="company_name" id="company_name" value="<?php if(isset($_POST['company_name'])){echo $_POST['company_name'];} ?>" >
                                            <span class="error-msg" id="company_name_error"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="company_address">Company Address *</label>
                                    <textarea class="form-control" name="company_address" id="company_address" rows="3" placeholder="Enter complete company address" ><?php if(isset($_POST['company_address'])){echo $_POST['company_address'];} ?></textarea>
                                    <span class="error-msg" id="company_address_error"></span>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address *</label>
                                            <input type="email" class="form-control" name="email" id="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" >
                                            <span class="error-msg" id="email_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone Number *</label>
                                            <input type="tel" class="form-control" name="phone" id="phone" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];} ?>"  maxlength="10" inputmode="numeric" pattern="\d{10}" oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)">
                                            <span class="error-msg" id="phone_error"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gstno">GST Number</label>
                                            <input type="text" class="form-control" name="gstno" id="gstno" value="<?php if(isset($_POST['gstno'])){echo $_POST['gstno'];} ?>" placeholder="Optional - for business verification">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password *</label>
                                            <input type="password" class="form-control" name="password" id="password" >
                                            <span class="error-msg" id="password_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="re_password">Confirm Password *</label>
                                    <input type="password" class="form-control" name="re_password" id="re_password" >
                                    <span class="error-msg" id="re_password_error"></span>
                                </div>
                                
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="agree_terms" id="agree_terms" > 
                                            I agree to the <a href="seller-tnc.php" target="_blank">Seller Terms and Conditions</a>
                                        </label>
                                        <span class="error-msg" id="agree_terms_error"></span>
                                    </div>
                                </div>
                                
                                <div class="form-group text-center">
                                    <input type="submit" class="btn btn-primary btn-lg" value="Register as Seller" name="form1" style="padding: 12px 40px;">
                                </div>
                                
                                <div class="text-center" style="margin-top: 20px;">
                                    <p class="text-muted">Already have a seller account?</p>
                                    <a href="seller-login.php" class="btn btn-success">
                                        <i class="fa fa-sign-in"></i> Login to Dashboard
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?> 
<script>
(function(){
    function setError(el, msg){
        var err = document.getElementById(el.id + '_error');
        if(err){ err.textContent = msg || ''; err.classList.toggle('show', !!msg); }
        el.classList.toggle('invalid', !!msg);
    }
    function minText(id, n, label){
        var el = document.getElementById(id);
        var ok = el.value.trim().length >= n;
        return setError(el, ok?'':label+' must be at least '+n+' characters.'), ok;
    }
    function validateName(){
        var el = document.getElementById('fullname');
        var ok = /^[A-Za-z ]{3,}$/.test(el.value.trim());
        return setError(el, ok?'':'Enter at least 3 letters (letters and spaces only).'), ok;
    }
    function validateEmail(){
        var el = document.getElementById('email');
        var ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(el.value.trim());
        return setError(el, ok?'':'Enter a valid email address.'), ok;
    }
    function validatePhone(){
        var el = document.getElementById('phone');
        var ok = /^\d{10}$/.test(el.value.trim());
        return setError(el, ok?'':'Enter a 10-digit phone number.'), ok;
    }
    function validatePassword(){
        var el = document.getElementById('password');
        var ok = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/.test(el.value);
        return setError(el, ok?'':'Password must be 8+ chars with upper, lower, number, special.'), ok;
    }
    function validateConfirm(){
        var p1 = document.getElementById('password');
        var el = document.getElementById('re_password');
        var ok = el.value === p1.value && el.value.length>0;
        return setError(el, ok?'':'Passwords do not match.'), ok;
    }
    function validateTerms(){
        var el = document.getElementById('agree_terms');
        var err = document.getElementById('agree_terms_error');
        var ok = el && el.checked;
        if(err){ err.textContent = ok?'':'You must agree to the Seller Terms and Conditions.'; err.classList.toggle('show', !ok); }
        return ok;
    }
    var form = document.querySelector('form[action=""][method="post"]');
    if(!form) return;
    [['fullname',validateName],['company_name',function(){return minText('company_name',3,'Company Name')}],['company_address',function(){return minText('company_address',10,'Company Address')}],['email',validateEmail],['phone',validatePhone],['password',validatePassword],['re_password',validateConfirm]].forEach(function(pair){
        var id = pair[0], fn = pair[1];
        var el = document.getElementById(id);
        if(!el) return;
        el.addEventListener('input', fn);
    });
    var terms = document.getElementById('agree_terms');
    if(terms){ terms.addEventListener('change', validateTerms); }
    form.addEventListener('submit', function(e){
        var ok = [validateName(), minText('company_name',3,'Company Name'), minText('company_address',10,'Company Address'), validateEmail(), validatePhone(), validatePassword(), validateConfirm(), validateTerms()].every(Boolean);
        if(!ok){ e.preventDefault(); }
    });
})();
</script>