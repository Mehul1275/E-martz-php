<?php 
declare(strict_types=1);
require_once('header.php'); 
?>
<title>Seller Login</title>
<?php
$error_message = '';
if(isset($_POST['form1'])) {
    if(empty($_POST['email']) || empty($_POST['password'])) {
        $error_message = 'Email and Password are required.';
    } else {
        $email = sanitize_input($_POST['email']);
        $password = $_POST['password']; // Don't sanitize password before verification
        
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
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_seller_login = $row['banner_seller_login'];
}
?>
<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/<?php echo htmlspecialchars($banner_seller_login, ENT_QUOTES, 'UTF-8'); ?>);">
    <div class="inner">
        <h1>Seller Login</h1>
    </div>
</div>
<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                ?>
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" class="form-control" name="email" value="<?php if(isset($_POST['email'])){echo htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');} ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Password *</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success" value="Login" name="form1">
                                </div>
                                <p> become E-martz seller</p>
                                <div class="form-group">
                                    <a href="seller-registration.php" class="btn btn-primary" style="width:100%;margin-bottom:10px;">Sign Up</a>
                                </div>
                                <a href="forget-password.php" style="color:#e4144d;">Forget Password?</a>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?> 