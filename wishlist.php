<?php
require_once('header.php');
if (!isset($_SESSION['customer']['cust_id'])) {
    echo '<div class="container" style="margin:40px auto;text-align:center;"><h2>Please <a href="login.php">login</a> to view your wishlist.</h2></div>';
    require_once('footer.php');
    exit;
}
$customer_id = $_SESSION['customer']['cust_id'];
$statement = $pdo->prepare('SELECT w.product_id, p.p_name, p.p_featured_photo, p.p_current_price, p.p_old_price, p.p_qty FROM tbl_wishlist w JOIN tbl_product p ON w.product_id = p.p_id WHERE w.customer_id = ?');
$statement->execute([$customer_id]);
$wishlist = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<title>E-martz | Wishlist </title>
<!-- Modern Wishlist Page Styles -->
<style>
/* Page Header Styling - Match Contact Us and Cart pages */
.page-header {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.10);
    margin-bottom: 30px;
    text-align: center;
    border-bottom: 4px solid #1e40af;
}

.page-header h1 {
    color: #0f172a;
    margin-bottom: 12px;
    font-weight: 600;
    font-size: 32px;
}

.page-header .text-muted {
    color: #475569;
    font-size: 18px;
    margin: 0;
}

.wishlist-empty {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin: 40px auto;
    max-width: 600px;
}

.wishlist-empty i {
    font-size: 4rem;
    color: #e9ecef;
    margin-bottom: 20px;
}

.wishlist-empty h2 {
    color: #495057;
    margin-bottom: 15px;
    font-weight: 600;
}

.wishlist-empty p {
    color: #6c757d;
    margin-bottom: 30px;
}

.wishlist-item {
    background: white !important;
    border: 1px solid #e9ecef !important;
    border-radius: 12px !important;
    padding: 25px !important;
    margin-bottom: 20px !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06) !important;
    transition: all 0.3s ease;
}

.wishlist-item:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12) !important;
    transform: translateY(-2px);
}

.wishlist-item img {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.wishlist-item .product-name {
    font-weight: 600;
    color: #2c3e50;
    text-decoration: none;
    font-size: 18px;
    line-height: 1.3;
}

.wishlist-item .product-name:hover {
    color: #007bff;
    text-decoration: none;
}

.wishlist-item .price-section {
    margin-top: 12px;
}

.wishlist-item .current-price {
    color: #28a745;
    font-weight: 700;
    font-size: 18px;
}

.wishlist-item .old-price {
    color: #6c757d;
    text-decoration: line-through;
    margin-left: 10px;
    font-size: 16px;
}

.wishlist-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    align-items: center;
    margin-top: 15px;
}

.wishlist-btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.wishlist-btn-primary {
    background: #007bff;
    color: white;
}

.wishlist-btn-primary:hover {
    background: #0056b3;
    color: white;
    transform: translateY(-1px);
}

.wishlist-btn-danger {
    background: #dc3545;
    color: white;
    padding: 10px 12px;
}

.wishlist-btn-danger:hover {
    background: #c82333;
    color: white;
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .wishlist-actions {
        justify-content: center;
        flex-direction: column;
        gap: 8px;
    }
    
    .wishlist-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <div class="page-header">
                    <h1>My Wishlist</h1>
                    <p class="text-muted">Save your favorite items for later</p>
                </div>
                <?php if (empty($wishlist)): ?>
                    <div class="wishlist-empty">
                        <i class="fa fa-heart"></i>
                        <h2>Your Wishlist is Empty</h2>
                        <p>Start adding products to your wishlist to save them for later!</p>
                        <a href="index.php" class="wishlist-btn wishlist-btn-primary">
                            <i class="fa fa-shopping-bag"></i> Start Shopping
                        </a>
                    </div>
                <?php else: ?>
                    <div class="wishlist-list">
                        <?php foreach ($wishlist as $item): ?>
                            <div class="row wishlist-item">
                                <div class="col-md-2 col-xs-4 text-center">
                                    <a href="product.php?id=<?php echo $item['product_id']; ?>">
                                        <img src="assets/uploads/<?php echo $item['p_featured_photo']; ?>" alt="<?php echo htmlspecialchars($item['p_name']); ?>" style="max-width:90px;max-height:90px;object-fit:contain;">
                                    </a>
                                </div>
                                <div class="col-md-5 col-xs-8">
                                    <a href="product.php?id=<?php echo $item['product_id']; ?>" class="product-name">
                                        <?php echo htmlspecialchars($item['p_name']); ?>
                                    </a>
                                    <div class="price-section">
                                        <span class="current-price">₹<?php echo number_format((float)$item['p_current_price']); ?></span>
                                        <?php if($item['p_old_price']): ?>
                                            <span class="old-price">₹<?php echo number_format((float)$item['p_old_price']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-5 col-xs-12">
                                    <div class="wishlist-actions">
                                        <?php if((int)$item['p_qty'] > 0): ?>
                                            <form method="post" action="" style="display:inline;">
                                                <input type="hidden" name="add_to_cart_id" value="<?php echo $item['product_id']; ?>">
                                                <button type="submit" class="wishlist-btn wishlist-btn-primary">
                                                    <i class="fa fa-shopping-cart"></i> Add to Cart
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="wishlist-oos" style="background:linear-gradient(135deg,#ff416c,#ff4b2b);color:#fff;padding:8px 14px;border-radius:20px;font-weight:700;letter-spacing:.3px;display:inline-flex;align-items:center;gap:8px;">
                                                <i class="fa fa-ban"></i> Out of Stock
                                            </span>
                                        <?php endif; ?>
                                        <form method="post" action="" style="display:inline;">
                                            <input type="hidden" name="remove_wishlist_id" value="<?php echo $item['product_id']; ?>">
                                            <button type="submit" class="wishlist-btn wishlist-btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['add_to_cart_id'])) {
    $pid = (int)$_POST['add_to_cart_id'];
    // Fetch product details for the product being added
    $stmt = $pdo->prepare("SELECT p_name, p_current_price, p_featured_photo, p_qty FROM tbl_product WHERE p_id = ?");
    $stmt->execute([$pid]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        // Product not found, redirect back
        echo "<script>window.location='wishlist.php';</script>";
        exit;
    }
    // Block adding out-of-stock products
    if ((int)$product['p_qty'] <= 0) {
        echo "<script>window.location='wishlist.php';</script>";
        exit;
    }
    // Add to cart logic (simplified: qty=1, no size/color)
    if (!isset($_SESSION['cart_p_id'])) {
        $_SESSION['cart_p_id'][1] = $pid;
        $_SESSION['cart_size_id'][1] = 0;
        $_SESSION['cart_size_name'][1] = '';
        $_SESSION['cart_color_id'][1] = 0;
        $_SESSION['cart_color_name'][1] = '';
        $_SESSION['cart_p_qty'][1] = 1;
        $_SESSION['cart_p_current_price'][1] = $product['p_current_price'];
        $_SESSION['cart_p_name'][1] = $product['p_name'];
        $_SESSION['cart_p_featured_photo'][1] = $product['p_featured_photo'];
    } else {
        $i = count($_SESSION['cart_p_id']) + 1;
        $_SESSION['cart_p_id'][$i] = $pid;
        $_SESSION['cart_size_id'][$i] = 0;
        $_SESSION['cart_size_name'][$i] = '';
        $_SESSION['cart_color_id'][$i] = 0;
        $_SESSION['cart_color_name'][$i] = '';
        $_SESSION['cart_p_qty'][$i] = 1;
        $_SESSION['cart_p_current_price'][$i] = $product['p_current_price'];
        $_SESSION['cart_p_name'][$i] = $product['p_name'];
        $_SESSION['cart_p_featured_photo'][$i] = $product['p_featured_photo'];
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