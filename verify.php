<?php require_once('header.php'); ?>

<?php
$page_title = 'Verification';
$success_message = '';
$error_message = '';

// Customer Account Verification
if(isset($_REQUEST['token']))
{
    $token = strip_tags($_REQUEST['token']);

    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_token=?");
    $statement->execute(array($token));
    $total = $statement->rowCount();
    
    if($total) {
        $result = $statement->fetch();
        $email = $result['cust_email'];
        
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_token=?, cust_status=? WHERE cust_email=?");
        $statement->execute(array('', 1, $email));
        $page_title = 'Registration Successful';
        $success_message = '<p style="color:green;">Your email is verified successfully. You can now login to our website.</p><p><a href="'.BASE_URL.'login.php" style="color:#167ac6;font-weight:bold;">Click here to login</a></p>';
    } else {
        header('location: '.BASE_URL.'login.php');
        exit;
    }
}

// Newsletter Subscription Verification
if(isset($_REQUEST['key']))
{
    $email = strip_tags($_REQUEST['email']);
    $key = strip_tags($_REQUEST['key']);

    $statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=? AND subs_hash=?");
    $statement->execute(array($email, $key));
    $total = $statement->rowCount();

    if($total) {
        $statement = $pdo->prepare("UPDATE tbl_subscriber SET subs_hash=?, subs_active=? WHERE subs_email=?");
        $statement->execute(array('', 1, $email));
        $page_title = 'Subscription Successful';
        $success_message = '<p style="color:green;">Your subscription is confirmed. Thank you for subscribing to our newsletter!</p><p><a href="'.BASE_URL.'" style="color:#167ac6;font-weight:bold;">Go to Homepage</a></p>';
    } else {
        header('location: '.BASE_URL);
        exit;
    }
}
?>

<div class="page-banner" style="background-color:#444;">
    <div class="inner">
        <h1><?php echo $page_title; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <?php 
                        if($error_message != '') {
                            echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                        }
                        if($success_message != '') {
                            echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                        }
                    ?>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>