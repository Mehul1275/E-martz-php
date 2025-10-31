<?php 
declare(strict_types=1);
require_once('header.php'); 
?>

<style>
.error-msg{color:#e74c3c;font-size:12px;margin-top:6px;display:none;opacity:0;transition:opacity .2s ease}
.invalid{border-color:#e74c3c !important}
.error-msg.show{display:block;opacity:1}
</style>

<?php
// PHPMailer includes and namespace imports
require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_registration = $row['banner_registration'];
}
?>

<?php
if (isset($_POST['form1'])) {

    $valid = 1;

    if(empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_123."<br>";
    } else {
        // Name: only letters and spaces, min 3 chars
        if(!preg_match('/^[A-Za-z ]{3,}$/', $_POST['cust_name'])){
            $valid = 0;
            $error_message .= 'Name must be at least 3 letters and spaces only.<br>';
        }
    }

    if(empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_131."<br>";
    } else {
        if (!validate_email($_POST['cust_email'])) {
            $valid = 0;
            $error_message .= LANG_VALUE_134."<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute([$_POST['cust_email']]);
            $total = $statement->rowCount();                            
            if($total) {
                $valid = 0;
                $error_message .= LANG_VALUE_147."<br>";
            }
        }
    }

    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_124."<br>";
    } else {
        // Mobile: exactly 10 digits
        if(!preg_match('/^\d{10}$/', $_POST['cust_phone'])){
            $valid = 0;
            $error_message .= 'Mobile number must be exactly 10 digits.<br>';
        }
    }

    if(empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_125."<br>";
    }

    if(empty($_POST['cust_country'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_126."<br>";
    }

    if(empty($_POST['cust_city'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_127."<br>";
    }

    if(empty($_POST['cust_state'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_128."<br>";
    }

    if(empty($_POST['cust_zip'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_129."<br>";
    }

    if( empty($_POST['cust_password']) || empty($_POST['cust_re_password']) ) {
        $valid = 0;
        $error_message .= LANG_VALUE_138."<br>";
    }

    if( !empty($_POST['cust_password']) && !empty($_POST['cust_re_password']) ) {
        // Password complexity: 6-8+ chars with upper, lower, number, special
        $pass = $_POST['cust_password'];
        if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}$/', $pass)){
            $valid = 0;
            $error_message .= 'Password must be 6+ chars with uppercase, lowercase, number and special character.<br>';
        }
        if($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= LANG_VALUE_139."<br>";
        }
    }

    if($valid == 1) {

        $token = generate_token();
        $cust_datetime = date('Y-m-d H:i:s');
        $cust_timestamp = time();

        // saving into the database
        $statement = $pdo->prepare("INSERT INTO tbl_customer (
                                        cust_name,
                                        cust_cname,
                                        cust_email,
                                        cust_phone,
                                        cust_country,
                                        cust_address,
                                        cust_city,
                                        cust_state,
                                        cust_zip,
                                        cust_password,
                                        cust_token,
                                        cust_datetime,
                                        cust_timestamp,
                                        cust_status
                                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute([
            sanitize_input($_POST['cust_name']),
            sanitize_input($_POST['cust_name']),
            sanitize_input($_POST['cust_email']),
            sanitize_input($_POST['cust_phone']),
            sanitize_input($_POST['cust_country']),
            sanitize_input($_POST['cust_address']),
            sanitize_input($_POST['cust_city']),
            sanitize_input($_POST['cust_state']),
            sanitize_input($_POST['cust_zip']),
            hash_password($_POST['cust_password']),
            $token,
            $cust_datetime,
            $cust_timestamp,
            0
        ]);

        // Send verification email
        try {
            $mail = new PHPMailer(true);
            
            // Server settings - using same settings as admin panel
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
            $mail->addAddress($_POST['cust_email'], sanitize_input($_POST['cust_name']));
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = LANG_VALUE_150;
            $mail->Body = LANG_VALUE_151 . '<br><br><a href="' . BASE_URL . 'verify.php?token=' . $token . '">Click here to verify your email</a>';
            
            $mail->send();
            $success_message = LANG_VALUE_152;
        } catch (Exception $e) {
            // If email fails, still show success but log the error
            error_log("Email sending failed: " . $e->getMessage());
            $success_message = LANG_VALUE_152;
        }
    }
}
?>

<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header" style="margin-bottom: 30px;">
                    <h1>Customer Registration</h1>
                    <p class="text-muted">Create your account to start shopping with E-martz</p>
                </div>
                
                <div class="registration-container" style="background:#fff; padding: 30px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid var(--color-primary);">
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
                                            <label for="cust_name"><?php echo LANG_VALUE_102; ?> *</label>
                                            <input type="text" class="form-control" name="cust_name" id="cust_name" value="<?php if(isset($_POST['cust_name'])){echo $_POST['cust_name'];} ?>" >
                                            <span class="error-msg" id="cust_name_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cust_cname"><?php echo LANG_VALUE_103; ?></label>
                                            <input type="text" class="form-control" name="cust_cname" id="cust_cname" value="<?php if(isset($_POST['cust_cname'])){echo $_POST['cust_cname'];} ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cust_email"><?php echo LANG_VALUE_94; ?> *</label>
                                            <input type="email" class="form-control" name="cust_email" id="cust_email" value="<?php if(isset($_POST['cust_email'])){echo $_POST['cust_email'];} ?>" >
                                            <span class="error-msg" id="cust_email_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cust_phone"><?php echo LANG_VALUE_104; ?> *</label>
                                            <input type="tel" class="form-control" name="cust_phone" id="cust_phone" value="<?php if(isset($_POST['cust_phone'])){echo $_POST['cust_phone'];} ?>"  maxlength="10" inputmode="numeric" pattern="\d{10}" oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)">
                                            <span class="error-msg" id="cust_phone_error"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="cust_address"><?php echo LANG_VALUE_105; ?> *</label>
                                    <textarea name="cust_address" class="form-control" id="cust_address" rows="3" ><?php if(isset($_POST['cust_address'])){echo $_POST['cust_address'];} ?></textarea>
                                    <span class="error-msg" id="cust_address_error"></span>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cust_country"><?php echo LANG_VALUE_106; ?> *</label>
                                        <select name="cust_country" class="form-control select2" id="cust_country" >
                                                <option value="">Select Country</option>
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                                                foreach ($result as $row) {
                                                    ?>
                                                    <option value="<?php echo $row['country_id']; ?>" <?php if(isset($_POST['cust_country']) && $_POST['cust_country']==$row['country_id']) {echo 'selected';} ?>><?php echo $row['country_name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cust_state"><?php echo LANG_VALUE_108; ?> *</label>
                                        <input type="text" class="form-control" name="cust_state" id="cust_state" value="<?php if(isset($_POST['cust_state'])){echo $_POST['cust_state'];} ?>" >
                                        <span class="error-msg" id="cust_state_error"></span>
                                    </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cust_city"><?php echo LANG_VALUE_107; ?> *</label>
                                        <input type="text" class="form-control" name="cust_city" id="cust_city" value="<?php if(isset($_POST['cust_city'])){echo $_POST['cust_city'];} ?>" >
                                        <span class="error-msg" id="cust_city_error"></span>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cust_zip"><?php echo LANG_VALUE_109; ?> *</label>
                                            <input type="text" class="form-control" name="cust_zip" id="cust_zip" value="<?php if(isset($_POST['cust_zip'])){echo $_POST['cust_zip'];} ?>" >
                                            <span class="error-msg" id="cust_zip_error"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cust_password"><?php echo LANG_VALUE_96; ?> *</label>
                                            <input type="password" class="form-control" name="cust_password" id="cust_password" >
                                            <span class="error-msg" id="cust_password_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cust_re_password"><?php echo LANG_VALUE_98; ?> *</label>
                                            <input type="password" class="form-control" name="cust_re_password" id="cust_re_password" >
                                            <span class="error-msg" id="cust_re_password_error"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group text-center">
                                    <input type="submit" class="btn btn-primary btn-lg" value="<?php echo LANG_VALUE_15; ?>" name="form1" style="padding: 12px 40px;">
                                </div>
                                
                                <div class="text-center" style="margin-top: 20px;">
                                    <p class="text-muted">Already have an account?</p>
                                    <a href="login.php" class="btn btn-success">
                                        <i class="fa fa-sign-in"></i> Sign In to Your Account
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
    function validateName(){
        var el = document.getElementById('cust_name');
        var v = el.value.trim();
        if(!/^[A-Za-z ]{3,}$/.test(v)) return setError(el,'Enter at least 3 letters (letters and spaces only).'), false;
        return setError(el,''), true;
    }
    function validateEmail(){
        var el = document.getElementById('cust_email');
        var v = el.value.trim();
        var ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
        return setError(el, ok?'':'Enter a valid email address.'), ok;
    }
    function validatePhone(){
        var el = document.getElementById('cust_phone');
        var ok = /^\d{10}$/.test(el.value.trim());
        return setError(el, ok?'':'Enter a 10-digit mobile number.'), ok;
    }
    function minText(id, n, label){
        var el = document.getElementById(id);
        var ok = el.value.trim().length >= n;
        return setError(el, ok?'':label+' must be at least '+n+' characters.'), ok;
    }
    function validateZip(){
        var el = document.getElementById('cust_zip');
        var v = el.value.trim();
        var ok = /^[0-9A-Za-z\- ]{3,10}$/.test(v);
        return setError(el, ok?'':'Enter a valid ZIP/Postal code.'), ok;
    }
    function validatePassword(){
        var el = document.getElementById('cust_password');
        var v = el.value;
        var ok = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}$/.test(v);
        return setError(el, ok?'':'Password must be 6+ chars with upper, lower, number, special.'), ok;
    }
    function validateConfirm(){
        var p1 = document.getElementById('cust_password');
        var el = document.getElementById('cust_re_password');
        var ok = el.value === p1.value && el.value.length>0;
        return setError(el, ok?'':'Passwords do not match.'), ok;
    }
    var form = document.querySelector('form[action=""][method="post"]');
    if(!form) return;
    ['cust_name','cust_email','cust_phone','cust_address','cust_state','cust_city','cust_zip','cust_password','cust_re_password'].forEach(function(id){
        var el = document.getElementById(id);
        if(!el) return;
        el.addEventListener('input', function(){
            switch(id){
                case 'cust_name': validateName(); break;
                case 'cust_email': validateEmail(); break;
                case 'cust_phone': validatePhone(); break;
                case 'cust_address': minText('cust_address', 5, 'Address'); break;
                case 'cust_state': minText('cust_state', 2, 'State'); break;
                case 'cust_city': minText('cust_city', 2, 'City'); break;
                case 'cust_zip': validateZip(); break;
                case 'cust_password': validatePassword(); validateConfirm(); break;
                case 'cust_re_password': validateConfirm(); break;
            }
        });
    });
    form.addEventListener('submit', function(e){
        var ok = [
            validateName(),
            validateEmail(),
            validatePhone(),
            minText('cust_address',5,'Address'),
            minText('cust_state',2,'State'),
            minText('cust_city',2,'City'),
            validateZip(),
            validatePassword(),
            validateConfirm()
        ].every(Boolean);
        if(!ok){ e.preventDefault(); }
    });
})();
</script>