<?php 
declare(strict_types=1);
require_once('header.php'); 
?>

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

<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/<?php echo htmlspecialchars($banner_login, ENT_QUOTES, 'UTF-8'); ?>);">
    <div class="inner">
        <h1><?php echo LANG_VALUE_10; ?></h1>
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
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_94; ?> *</label>
                                    <input type="email" class="form-control" name="cust_email">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_96; ?> *</label>
                                    <input type="password" class="form-control" name="cust_password">
                                </div>
                                <div class="form-group">
                                    <label for=""></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="submit" class="btn btn-success" value="Login" name="form1" style="width:100%;">
                                        </div>
                                        <div class="col-md-6">
                                            <a href="registration.php" class="btn btn-primary" style="width:100%;">Sign Up</a>
                                        </div>
                                    </div>
                                </div>
                                <p style="text-align:center;margin-top:10px;">new customer? create your account</p>
                                <a href="forget-password.php" style="color:#e4144d;"><?php echo LANG_VALUE_97; ?>?</a>
                            </div>
                        </div>                        
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>