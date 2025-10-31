<?php 
declare(strict_types=1);
require_once('header.php'); 
?>
<title>Seller Login</title>
<style>
.error-msg{color:#e74c3c;font-size:12px;margin-top:6px;display:none;opacity:0;transition:opacity .2s ease}
.invalid{border-color:#e74c3c !important}
.error-msg.show{display:block;opacity:1}
</style>
<?php
$error_message = '';
if(isset($_POST['form1'])) {
    if(empty($_POST['email']) || empty($_POST['password'])) {
        $error_message = 'Email and Password are required.';
    } else {
        $email = sanitize_input($_POST['email']);
        $password = $_POST['password']; // Don't sanitize password before verification

        // Extra backend validation
        if(!validate_email($email)){
            $error_message = 'Please enter a valid email address.';
        }
        
        $statement = $pdo->prepare("SELECT * FROM sellers WHERE email=?");
        $statement->execute([$email]);
        $seller = $statement->fetch(PDO::FETCH_ASSOC);
        
        if($seller && verify_password($password, $seller['password'])) {
            if($seller['email_verified'] != 1) {
                $error_message = 'Please verify your email address before logging in. Check your email for the verification link.';
            } elseif($seller['status'] != 1) {
                $error_message = 'Your account is inactive. Please contact support.';
            } else {
                $_SESSION['seller'] = [
                    'id' => $seller['id'],
                    'fullname' => $seller['fullname'],
                    'company_name' => $seller['company_name'],
                    'company_address' => $seller['company_address'],
                    'email' => $seller['email'],
                    'phone' => $seller['phone'],
                    'gstno' => $seller['gstno'],
                    'status' => $seller['status']
                ];
                header('Location: seller-dashboard.php');
                exit();
            }
        } else {
            $error_message = 'Invalid email or password.';
        }
    }
}
?>

<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header" style="margin-bottom: 30px;">
                    <h1>Seller Login</h1>
                    <p class="text-muted">Access your seller dashboard to manage your products and orders</p>
                </div>
                
                <div class="seller-login-container" style="background:#fff; padding: 30px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid var(--color-primary);">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <form action="" method="post">
                                <?php $csrf->echoInputField(); ?>
                                
                                <?php
                                if($error_message != '') {
                                    echo "<div class='alert alert-danger'><i class='fa fa-exclamation-circle'></i> ".$error_message."</div>";
                                }
                                ?>
                                
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?php if(isset($_POST['email'])){echo htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');} ?>" >
                                    <span class="error-msg" id="email_error"></span>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password *</label>
                                    <input type="password" class="form-control" name="password" id="password" >
                                    <span class="error-msg" id="password_error"></span>
                                </div>
                                
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-block" value="Login to Dashboard" name="form1">
                                </div>
                                
                                <div class="text-center" style="margin-top: 20px;">
                                    <p class="text-muted">New to E-martz? Become a seller today!</p>
                                    <a href="seller-registration.php" class="btn btn-success btn-block" style="margin-bottom: 15px;">
                                        <i class="fa fa-store"></i> Register as Seller
                                    </a>
                                    <a href="forget-password.php" style="color: var(--color-primary);">
                                        <i class="fa fa-key"></i> Forgot Password?
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
    function validateEmail(){
        var el = document.getElementById('email');
        var ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(el.value.trim());
        return setError(el, ok?'':'Enter a valid email address.'), ok;
    }
    function validatePassword(){
        var el = document.getElementById('password');
        var ok = el.value.length > 0;
        return setError(el, ok?'':'Password is required.'), ok;
    }
    var form = document.querySelector('form[action=""][method="post"]');
    if(!form) return;
    ['email','password'].forEach(function(id){
        var el = document.getElementById(id);
        if(!el) return;
        el.addEventListener('input', function(){
            if(id==='email') validateEmail();
            if(id==='password') validatePassword();
        });
    });
    form.addEventListener('submit', function(e){
        var ok = [validateEmail(), validatePassword()].every(Boolean);
        if(!ok){ e.preventDefault(); }
    });
})();
</script>