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
// Dashboard stats queries (same as before)
$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_product WHERE seller_id=?");
$statement->execute([$seller_id]);
$total_product = $statement->fetchColumn();
$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_order o JOIN tbl_product p ON o.product_id = p.p_id JOIN tbl_payment pay ON o.payment_id = pay.payment_id WHERE p.seller_id=? AND pay.payment_status='Pending'");
$statement->execute([$seller_id]);
$total_order_pending = $statement->fetchColumn();
$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_order o JOIN tbl_product p ON o.product_id = p.p_id JOIN tbl_payment pay ON o.payment_id = pay.payment_id WHERE p.seller_id=? AND pay.payment_status='Completed'");
$statement->execute([$seller_id]);
$total_order_completed = $statement->fetchColumn();
$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_order o JOIN tbl_product p ON o.product_id = p.p_id JOIN tbl_payment pay ON o.payment_id = pay.payment_id WHERE p.seller_id=? AND pay.shipping_status='Pending'");
$statement->execute([$seller_id]);
$total_shipping_pending = $statement->fetchColumn();
$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_order o JOIN tbl_product p ON o.product_id = p.p_id JOIN tbl_payment pay ON o.payment_id = pay.payment_id WHERE p.seller_id=? AND pay.shipping_status='Completed'");
$statement->execute([$seller_id]);
$total_shipping_completed = $statement->fetchColumn();
$statement = $pdo->prepare("SELECT SUM(o.unit_price * o.quantity) FROM tbl_order o JOIN tbl_product p ON o.product_id = p.p_id JOIN tbl_payment pay ON o.payment_id = pay.payment_id WHERE p.seller_id=? AND pay.payment_status='Completed'");
$statement->execute([$seller_id]);
$total_earning = $statement->fetchColumn();
if(!$total_earning) $total_earning = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller Panel</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="admin/css/_all-skins.min.css">
    <style>
        .main-header .logo { background:#222d32; color:#fff; }
        .main-header .navbar { background:#3c8dbc; }
        .main-sidebar { background:#222d32; }
        .content-wrapper { background:#f4f6f9; }
        .small-box {
            color:#fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(44,62,80,0.08);
            transition: transform 0.15s, box-shadow 0.15s;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
        }
        .small-box:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 8px 24px rgba(44,62,80,0.16);
            z-index: 2;
        }
        .small-box .icon {
            position: absolute;
            top: 18px;
            right: 24px;
            z-index: 0;
            font-size: 64px;
            color: rgba(255,255,255,0.18);
            transition: color 0.2s;
        }
        .small-box .inner {
            position: relative;
            z-index: 1;
            padding: 24px 24px 32px 24px;
        }
        .small-box h3 {
            font-size: 2.6rem;
            font-weight: 700;
            margin: 0 0 8px 0;
            letter-spacing: 1px;
        }
        .small-box p {
            font-size: 1.1rem;
            font-weight: 500;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .row {
            margin-bottom: 0;
        }
        @media (max-width: 991px) {
            .col-lg-4 {
                margin-bottom: 24px;
            }
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
<?php include('seller-sidebar.php'); ?>
    <div class="content-wrapper" style="min-height:100vh;">
        <section class="content-header">
            <h1>Dashboard</h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-lg-4 col-xs-12">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?php echo $total_product; ?></h3>
                            <p>Products</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <div class="small-box bg-maroon">
                        <div class="inner">
                            <h3><?php echo $total_order_pending; ?></h3>
                            <p>Pending Orders</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-clipboard"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php echo $total_order_completed; ?></h3>
                            <p>Completed Orders</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-xs-12">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo $total_shipping_pending; ?></h3>
                            <p>Pending Shipping</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo $total_shipping_completed; ?></h3>
                            <p>Completed Shipping</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3><?php echo $total_earning; ?></h3>
                            <p>Earnings</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money"></i>
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