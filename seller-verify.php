<?php require_once('header.php'); ?>

<?php
// If no email is present, redirect to homepage
if( !isset($_REQUEST['email']) ) {
    header('location: '.BASE_URL);
    exit;
}

$page_title = 'Seller Verification';
$success_message = '';
$error_message = '';

// Seller Account Verification
if(isset($_REQUEST['token']))
{
    $email = strip_tags($_REQUEST['email']);
    $token = strip_tags($_REQUEST['token']);

    $statement = $pdo->prepare("SELECT * FROM sellers WHERE email=? AND token=?");
    $statement->execute(array($email, $token));
    $total = $statement->rowCount();
    
    if($total) {
        $statement = $pdo->prepare("UPDATE sellers SET token=?, email_verified=?, status=? WHERE email=?");
        $statement->execute(array('', 1, 1, $email));
        $page_title = 'Seller Registration Successful';
        $success_message = '<p style="color:green;">Your email is verified successfully. You can now login to your seller account.</p><p><a href="'.BASE_URL.'seller-login.php" style="color:#167ac6;font-weight:bold;">Click here to login</a></p>';
    } else {
        header('location: '.BASE_URL.'seller-login.php');
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