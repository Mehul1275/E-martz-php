<?php
require_once('header.php');
if (!isset($_SESSION['customer']['cust_id'])) {
    echo '<div class="container" style="margin:40px auto;text-align:center;"><h2>Please <a href="login.php">login</a> to view your wishlist.</h2></div>';
    require_once('footer.php');
    exit;
}
$customer_id = $_SESSION['customer']['cust_id'];
$statement = $pdo->prepare('SELECT w.product_id, p.p_name, p.p_featured_photo, p.p_current_price, p.p_old_price FROM tbl_wishlist w JOIN tbl_product p ON w.product_id = p.p_id WHERE w.customer_id = ?');
$statement->execute([$customer_id]);
$wishlist = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container" style="margin:40px auto;max-width:900px;">
    <h2 style="margin-bottom:30px;">My Wishlist</h2>
    <?php if (empty($wishlist)): ?>
        <div class="alert alert-info">Your wishlist is empty.</div>
    <?php else: ?>
        <div class="wishlist-list">
            <?php foreach ($wishlist as $item): ?>
                <div class="row wishlist-item" style="background:#fff;border:1px solid #eee;border-radius:8px;padding:18px 10px 10px 10px;margin-bottom:18px;align-items:center;">
                    <div class="col-md-2 col-xs-4 text-center">
                        <a href="product.php?id=<?php echo $item['product_id']; ?>">
                            <img src="assets/uploads/<?php echo $item['p_featured_photo']; ?>" alt="<?php echo htmlspecialchars($item['p_name']); ?>" style="max-width:90px;max-height:90px;object-fit:contain;">
                        </a>
                    </div>
                    <div class="col-md-5 col-xs-8">
                        <a href="product.php?id=<?php echo $item['product_id']; ?>" style="font-size:18px;font-weight:600;display:block;line-height:1.2;">
                            <?php echo htmlspecialchars($item['p_name']); ?>
                        </a>
                        <div style="margin-top:8px;font-size:16px;">
                            <span style="color:#0d1452;font-weight:700;">₹<?php echo $item['p_current_price']; ?></span>
                            <?php if($item['p_old_price']): ?>
                                <del style="color:#888;margin-left:8px;">₹<?php echo $item['p_old_price']; ?></del>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-xs-12 text-right" style="margin-top:10px;">
                        <form method="post" action="" style="display:inline;">
                            <input type="hidden" name="add_to_cart_id" value="<?php echo $item['product_id']; ?>">
                            <button type="submit" class="btn btn-warning" style="margin-right:8px;">Add to Cart</button>
                        </form>
                        <form method="post" action="" style="display:inline;">
                            <input type="hidden" name="remove_wishlist_id" value="<?php echo $item['product_id']; ?>">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php
// Handle Add to Cart
if (isset($_POST['add_to_cart_id'])) {
    $pid = (int)$_POST['add_to_cart_id'];
    // Add to cart logic (same as product.php, simplified: qty=1, no size/color)
    if (!isset($_SESSION['cart_p_id'])) {
        $_SESSION['cart_p_id'][1] = $pid;
        $_SESSION['cart_size_id'][1] = 0;
        $_SESSION['cart_size_name'][1] = '';
        $_SESSION['cart_color_id'][1] = 0;
        $_SESSION['cart_color_name'][1] = '';
        $_SESSION['cart_p_qty'][1] = 1;
        $_SESSION['cart_p_current_price'][1] = $item['p_current_price'];
        $_SESSION['cart_p_name'][1] = $item['p_name'];
        $_SESSION['cart_p_featured_photo'][1] = $item['p_featured_photo'];
    } else {
        $i = count($_SESSION['cart_p_id']) + 1;
        $_SESSION['cart_p_id'][$i] = $pid;
        $_SESSION['cart_size_id'][$i] = 0;
        $_SESSION['cart_size_name'][$i] = '';
        $_SESSION['cart_color_id'][$i] = 0;
        $_SESSION['cart_color_name'][$i] = '';
        $_SESSION['cart_p_qty'][$i] = 1;
        $_SESSION['cart_p_current_price'][$i] = $item['p_current_price'];
        $_SESSION['cart_p_name'][$i] = $item['p_name'];
        $_SESSION['cart_p_featured_photo'][$i] = $item['p_featured_photo'];
    }
    echo "<script>window.location='cart.php';</script>";
    exit;
}
// Handle Remove from Wishlist
if (isset($_POST['remove_wishlist_id'])) {
    $pid = (int)$_POST['remove_wishlist_id'];
    $stmt = $pdo->prepare('DELETE FROM tbl_wishlist WHERE customer_id = ? AND product_id = ?');
    $stmt->execute([$customer_id, $pid]);
    echo "<script>window.location='wishlist.php';</script>";
    exit;
}
require_once('footer.php'); 