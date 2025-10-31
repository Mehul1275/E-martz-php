<?php 
declare(strict_types=1);
require_once('header.php'); 
?>

<style>
.error-msg{color:#e74c3c;font-size:12px;margin-top:6px;display:none;opacity:0;transition:opacity .2s ease}
.invalid{border-color:#e74c3c !important}
.error-msg.show{display:block;opacity:1}
</style>

<!-- fetching row banner login -->
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_login = $row['banner_login'];
}
?>

<!-- login form -->
<?php
if(isset($_POST['form1'])) {
        
    if(empty($_POST['cust_email']) || empty($_POST['cust_password'])) {
        $error_message = LANG_VALUE_132.'<br>';
    } else {
        
        $cust_email = sanitize_input($_POST['cust_email']);
        $cust_password = $_POST['cust_password']; // Don't sanitize password before verification

        // Extra backend validation (non-invasive)
        if(!validate_email($cust_email)){
            $error_message .= LANG_VALUE_134.'<br>';
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
        $statement->execute([$cust_email]);
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        if($total == 0) {
            $error_message .= LANG_VALUE_133.'<br>';
        } else {
            $row = $result[0];
            $cust_status = $row['cust_status'];
            $row_password = $row['cust_password'];

            // Password check: support both password_hash and legacy md5
            if (verify_password($cust_password, $row_password)) {
                if($cust_status == 0) {
                    $error_message .= LANG_VALUE_148.'<br>';
                } else {
                    $_SESSION['customer'] = $row;
                    header("location: ".BASE_URL."dashboard.php");
                    exit();
                }
            } else if (hash_equals($row_password, md5($cust_password))) {
                // Legacy md5 check - upgrade to password_hash
                if($cust_status == 0) {
                    $error_message .= LANG_VALUE_148.'<br>';
                } else {
                    $_SESSION['customer'] = $row;
                    // Upgrade to password_hash
                    $new_hash = hash_password($cust_password);
                    $statement = $pdo->prepare("UPDATE tbl_customer SET cust_password=? WHERE cust_email=?");
                    $statement->execute([$new_hash, $cust_email]);
                    $_SESSION['customer']['cust_password'] = $new_hash;
                    header("location: ".BASE_URL."dashboard.php");
                    exit();
                }
            } else {
                $error_message .= LANG_VALUE_139.'<br>';
            }
        }
    }
}
?>

<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header" style="margin-bottom: 30px;">
                    <h1>Customer Login</h1>
                    <p class="text-muted">Sign in to your E-martz account to continue shopping</p>
                </div>
                
                <div class="login-container" style="background:#fff; padding: 30px 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid var(--color-primary);">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="form-section" style="max-width:450px;margin:0 auto;">
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
                                    
                                    <div class="form-group">
                                        <label for="cust_email"><?php echo LANG_VALUE_94; ?> *</label>
                                        <input type="email" class="form-control" name="cust_email" id="cust_email" >
                                        <span class="error-msg" id="cust_email_error"></span>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="cust_password"><?php echo LANG_VALUE_96; ?> *</label>
                                        <input type="password" class="form-control" name="cust_password" id="cust_password" >
                                        <span class="error-msg" id="cust_password_error"></span>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary btn-block" value="<?php echo LANG_VALUE_4; ?>" name="form1">
                                    </div>
                                    
                                    <div class="text-center" style="margin-top: 20px;">
                                        <p class="text-muted">Don't have an account?</p>
                                        <a href="registration.php" class="btn btn-success btn-block" style="margin-bottom: 15px;">
                                            <i class="fa fa-user-plus"></i> Create New Account
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
        var el = document.getElementById('cust_email');
        var v = el.value.trim();
        var ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
        return setError(el, ok?'':'Enter a valid email address.'), ok;
    }
    function validatePassword(){
        var el = document.getElementById('cust_password');
        var ok = el.value.length > 0;
        return setError(el, ok?'':'Password is required.'), ok;
    }
    var form = document.querySelector('form[action=""][method="post"]');
    if(!form) return;
    ['cust_email','cust_password'].forEach(function(id){
        var el = document.getElementById(id);
        if(!el) return;
        el.addEventListener('input', function(){
            if(id==='cust_email') validateEmail();
            if(id==='cust_password') validatePassword();
        });
    });
    form.addEventListener('submit', function(e){
        var ok = [validateEmail(), validatePassword()].every(Boolean);
        if(!ok){ e.preventDefault(); }
    });
})();
</script>