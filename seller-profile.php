<?php
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("seller-header.php");
if(!isset($_SESSION['seller'])) {
    header('Location: seller-login.php');
    exit;
}
$seller_id = $_SESSION['seller']['id'];

// Fetch seller info
$stmt = $pdo->prepare('SELECT * FROM sellers WHERE id = ?');
$stmt->execute([$seller_id]);
$seller = $stmt->fetch(PDO::FETCH_ASSOC);

$info_success = '';
$info_error = '';
$pass_success = '';
$pass_error = '';

// Update info
if(isset($_POST['update_info'])) {
    $fullname = trim($_POST['fullname']);
    $company_name = trim($_POST['company_name']);
    $company_address = trim($_POST['company_address']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gstno = trim($_POST['gstno']);
    if($fullname == '' || $email == '') {
        $info_error = 'Full Name and Email are required.';
    } else {
        $stmt = $pdo->prepare('UPDATE sellers SET fullname=?, company_name=?, company_address=?, email=?, phone=?, gstno=? WHERE id=?');
        $stmt->execute([$fullname, $company_name, $company_address, $email, $phone, $gstno, $seller_id]);
        $info_success = 'Profile updated successfully.';
        // Update session
        $_SESSION['seller']['fullname'] = $fullname;
        $_SESSION['seller']['company_name'] = $company_name;
        $_SESSION['seller']['company_address'] = $company_address;
        $_SESSION['seller']['email'] = $email;
        $_SESSION['seller']['phone'] = $phone;
        $_SESSION['seller']['gstno'] = $gstno;
        // Refresh seller info
        $stmt = $pdo->prepare('SELECT * FROM sellers WHERE id = ?');
        $stmt->execute([$seller_id]);
        $seller = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Update password
if(isset($_POST['update_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    if($old_password == '' || $new_password == '' || $confirm_password == '') {
        $pass_error = 'All password fields are required.';
    } else if($new_password != $confirm_password) {
        $pass_error = 'New password and confirm password do not match.';
    } else if(!password_verify($old_password, $seller['password'])) {
        $pass_error = 'Old password is incorrect.';
    } else {
        $hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('UPDATE sellers SET password=? WHERE id=?');
        $stmt->execute([$hashed, $seller_id]);
        $pass_success = 'Password updated successfully.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller Panel - Profile</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="admin/css/_all-skins.min.css">
    <link rel="stylesheet" href="admin/css/style.css">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
<?php include('seller-sidebar.php'); ?>
    <div class="content-wrapper" style="min-height:100vh;">
        <section class="content-header">
            <div class="content-header-left">
                <h1>My Profile</h1>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Profile Information</h3>
                        </div>
                        <div class="box-body">
                            <?php if($info_success) echo '<div class="alert alert-success">'.$info_success.'</div>'; ?>
                            <?php if($info_error) echo '<div class="alert alert-danger">'.$info_error.'</div>'; ?>
                            <form method="post">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($seller['fullname'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" name="company_name" class="form-control" value="<?= htmlspecialchars($seller['company_name'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Company Address</label>
                                    <textarea name="company_address" class="form-control" rows="3" placeholder="Enter complete company address"><?= htmlspecialchars($seller['company_address'] ?? '') ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($seller['email'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($seller['phone'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label>GST No</label>
                                    <input type="text" name="gstno" class="form-control" value="<?= htmlspecialchars($seller['gstno'] ?? '') ?>">
                                </div>
                                <button type="submit" name="update_info" class="btn btn-primary">Update Info</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Change Password</h3>
                        </div>
                        <div class="box-body">
                            <?php if($pass_success) echo '<div class="alert alert-success">'.$pass_success.'</div>'; ?>
                            <?php if($pass_error) echo '<div class="alert alert-danger">'.$pass_error.'</div>'; ?>
                            <form method="post">
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input type="password" name="old_password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="new_password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input type="password" name="confirm_password" class="form-control">
                                </div>
                                <button type="submit" name="update_password" class="btn btn-warning">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="admin/js/jquery-2.2.3.min.js"></script>
<script src="admin/js/bootstrap.min.js"></script>
<script src="admin/js/app.min.js"></script>
</body>
</html> 