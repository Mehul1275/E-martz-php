<?php require_once('header.php'); ?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);
$shipping_title = $row['shipping_title'];
$shipping_content = $row['shipping_content'];
$shipping_banner = $row['shipping_banner'];
$shipping_meta_title = $row['shipping_meta_title'];
$shipping_meta_keyword = $row['shipping_meta_keyword'];
$shipping_meta_description = $row['shipping_meta_description'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($shipping_meta_title); ?></title>
    <meta name="keywords" content="<?php echo htmlspecialchars($shipping_meta_keyword); ?>">
    <meta name="description" content="<?php echo htmlspecialchars($shipping_meta_description); ?>">
</head>
<body>
<?php require_once('header.php'); ?>
<div class="page-banner" style="background-color:#232f3e;<?php if($shipping_banner) echo 'background-image:url(assets/uploads/'.$shipping_banner.');background-size:cover;background-position:center;'; ?>">
    <div class="inner">
        <h1 style="color:#fff;"><?php echo htmlspecialchars($shipping_title); ?></h1>
    </div>
</div>
<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content" style="background:#fff;padding:30px 20px 30px 20px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                    <?php echo $shipping_content; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>
</body>
</html> 