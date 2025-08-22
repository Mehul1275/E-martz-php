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

// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $pdo->prepare('DELETE FROM tbl_rating WHERE rt_id = ?');
    $stmt->execute([$delete_id]);
    echo '<div class="alert alert-success">Review deleted successfully.</div>';
}

// Fetch only reviews for this seller's products
$stmt = $pdo->prepare('SELECT r.rt_id, r.p_id, r.cust_id, r.subject, r.comment, r.rating, p.p_name, p.p_featured_photo, c.cust_name, r.created_at FROM tbl_rating r JOIN tbl_product p ON r.p_id = p.p_id JOIN tbl_customer c ON r.cust_id = c.cust_id WHERE p.seller_id = ? ORDER BY r.rt_id DESC');
$stmt->execute([$seller_id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="admin/css/dataTables.bootstrap.css">
<script src="admin/js/jquery-2.2.3.min.js"></script>
<script src="admin/js/bootstrap.min.js"></script>
<script src="admin/js/app.min.js"></script>
<script src="admin/js/jquery.dataTables.min.js"></script>
<script src="admin/js/dataTables.bootstrap.min.js"></script>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller Panel - Product Reviews</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="admin/css/_all-skins.min.css">
    <link rel="stylesheet" href="admin/css/dataTables.bootstrap.css">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
<?php include('seller-sidebar.php'); ?>
    <div class="content-wrapper" style="min-height:100vh;">
        <section class="content-header">
            <div class="content-header-left">
                <h1>Product Reviews</h1>
            </div>
        </section>
        <section class="content">
            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="reviews-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Subject</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach($reviews as $review): $i++; ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td>
                                    <img src="assets/uploads/<?= htmlspecialchars($review['p_featured_photo']) ?>" alt="" style="width:50px;height:50px;object-fit:cover;margin-right:8px;vertical-align:middle;">
                                    <?= htmlspecialchars($review['p_name']) ?>
                                </td>
                                <td><?= htmlspecialchars($review['cust_name']) ?></td>
                                <td><?= isset($review['subject']) ? htmlspecialchars($review['subject']) : 'N/A' ?></td>
                                <td>
                                    <?php for($j=1;$j<=5;$j++): ?>
                                        <?php if($j <= $review['rating']): ?><i class="fa fa-star" style="color:#f5b301;"></i><?php else: ?><i class="fa fa-star-o"></i><?php endif; ?>
                                    <?php endfor; ?>
                                </td>
                                <td><?= nl2br(htmlspecialchars($review['comment'])) ?></td>
                                <td><?= isset($review['created_at']) ? date('Y-m-d H:i', strtotime($review['created_at'])) : 'N/A' ?></td>
                                <td>
                                    <a href="seller-reviews.php?delete=<?= $review['rt_id'] ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this review?');"><i class="fa fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
$(document).ready(function() {
  $('#reviews-table').DataTable();
});
</script>
</body>
</html> 