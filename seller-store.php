<?php
require_once('header.php');
// Validate seller id
$sellerId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($sellerId <= 0) {
	echo '<div class="page" style="padding:40px 0;"><div class="container"><div class="alert alert-danger">Invalid seller.</div></div></div>';
	require_once('footer.php');
	exit;
}

// Fetch seller info
$statement = $pdo->prepare('SELECT * FROM sellers WHERE id = ? AND status = 1 AND email_verified = 1');
$statement->execute([$sellerId]);
$seller = $statement->fetch(PDO::FETCH_ASSOC);
if (!$seller) {
	echo '<div class="page" style="padding:40px 0;"><div class="container"><div class="alert alert-warning">Seller not found or inactive.</div></div></div>';
	require_once('footer.php');
	exit;
}

// Fetch seller products (active only)
$prodStmt = $pdo->prepare('SELECT * FROM tbl_product WHERE seller_id = ? AND p_is_active = 1 ORDER BY p_id DESC');
$prodStmt->execute([$sellerId]);
$products = $prodStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<title>Top Brand: <?php echo htmlspecialchars($seller['company_name']); ?> - Premium Products by <?php echo htmlspecialchars($seller['fullname']); ?></title>
<div class="page" style="padding: 40px 0; background: #f8fafc;">
	<div class="container">
		<!-- Page Header -->
		<div class="row">
			<div class="col-md-12">
				<div class="page-header" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-bottom: 30px; border-left: 5px solid var(--color-primary);">
					<h1 style="margin: 0; font-size: 28px; font-weight: 700; color: var(--color-neutral-900); display: flex; align-items: center;">
						<i class="fa fa-certificate" style="color: var(--color-primary); margin-right: 15px; font-size: 24px;"></i>
						Top Brand: <?php echo htmlspecialchars($seller['company_name']); ?>
					</h1>
					<p style="margin: 8px 0 0 0; font-size: 16px; color: var(--color-neutral-600);">
						Premium products by <?php echo htmlspecialchars($seller['fullname']); ?>
					</p>
				</div>
			</div>
		</div>

		<!-- Products Grid -->
		<div class="products-grid">
			<div class="row">
				<?php if (empty($products)): ?>
					<div class="col-md-12">
						<div class="alert alert-info" style="text-align: center; padding: 40px; border-radius: 12px;">
							<i class="fa fa-info-circle" style="font-size: 48px; color: #17a2b8; margin-bottom: 15px;"></i>
							<h4>No Products Available</h4>
							<p>This seller hasn't added any products yet. Please check back later!</p>
						</div>
					</div>
				<?php else: ?>
					<?php foreach ($products as $row): ?>
						<div class="col-md-4 col-sm-6">
							<div class="product-card">
								<div class="product-image<?php if($row['p_qty'] == 0) echo ' oos'; ?>">
									<a href="product.php?id=<?php echo $row['p_id']; ?>">
										<img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="<?php echo htmlspecialchars($row['p_name']); ?>">
									</a>
									<?php if($row['p_qty'] == 0): ?>
										<div class="oos-badge"><i class="fa fa-ban"></i> Out of Stock</div>
									<?php endif; ?>
									<?php if($row['p_old_price'] != '' && $row['p_old_price'] > $row['p_current_price']): ?>
										<div class="discount-badge">
											<?php echo round((($row['p_old_price'] - $row['p_current_price']) / $row['p_old_price']) * 100); ?>% OFF
										</div>
									<?php endif; ?>
									<?php if(isset($_SESSION['customer']['cust_id'])): ?>
										<div class="wishlist-icon">
											<i class="fa fa-heart wishlist-heart" data-product="<?php echo $row['p_id']; ?>" onclick="toggleWishlist(<?php echo $row['p_id']; ?>, this)"></i>
										</div>
									<?php endif; ?>
								</div>
								<div class="product-content">
									<h3><a href="product.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></h3>
									<div class="product-rating">
										<?php
										$t_rating = 0;
										$statement1 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
										$statement1->execute(array($row['p_id']));
										$tot_rating = $statement1->rowCount();
										if($tot_rating == 0) {
											$avg_rating = 0;
										} else {
											$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
											foreach ($result1 as $row1) {
												$t_rating = $t_rating + $row1['rating'];
											}
											$avg_rating = $t_rating / $tot_rating;
										}
										?>
										<div class="rating">
											<?php
											if($avg_rating == 0) {
												echo '<span class="text-muted">No reviews</span>';
											}
											elseif($avg_rating == 1.5) {
												echo '
													<i class="fa fa-star"></i>
													<i class="fa fa-star-half-o"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
												';
											} 
											elseif($avg_rating == 2.5) {
												echo '
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-half-o"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
												';
											}
											elseif($avg_rating == 3.5) {
												echo '
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-half-o"></i>
													<i class="fa fa-star-o"></i>
												';
											}
											elseif($avg_rating == 4.5) {
												echo '
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-half-o"></i>
												';
											}
											else {
												for($i=1;$i<=5;$i++) {
													?>
													<?php if($i>$avg_rating): ?>
														<i class="fa fa-star-o"></i>
													<?php else: ?>
														<i class="fa fa-star"></i>
													<?php endif; ?>
													<?php
												}
											}
											?>
										</div>
										<?php if($tot_rating > 0): ?>
											<span class="review-count">(<?php echo $tot_rating; ?>)</span>
										<?php endif; ?>
									</div>
									<div class="product-price">
										<?php if($row['p_old_price'] != ''): ?>
											<span class="old-price">₹<?php echo $row['p_old_price']; ?></span>
										<?php endif; ?>
										<span class="current-price">₹<?php echo $row['p_current_price']; ?></span>
									</div>
									<?php if($row['p_qty'] > 0): ?>
										<div class="product-actions">
											<button type="button" class="btn btn-primary btn-sm add-to-cart-btn" data-product-id="<?php echo $row['p_id']; ?>">
												<i class="fa fa-shopping-cart"></i> Add to Cart
											</button>
											<button type="button" class="btn btn-success btn-sm buy-now-btn" data-product-id="<?php echo $row['p_id']; ?>">
												<i class="fa fa-bolt"></i> Buy Now
											</button>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<!-- Categories Sidebar 
<div class="category-sidebar">
	<div class="categories-header">
		<h3><i class="fa fa-list"></i> Categories</h3>
	</div>
	<div class="section">
		<button class="section-toggle">
			<span class="title"><i class="fa fa-tshirt"></i> Clothing</span>
			<i class="fa fa-chevron-down chevron"></i>
		</button>
		<div class="section-children">
			<div class="subsection">
				<button class="sub-toggle">
					<span class="title">Men's Clothing</span>
					<i class="fa fa-chevron-down sub-chevron"></i>
				</button>
				<div class="end-list">
					<a href="#">T-Shirts</a>
					<a href="#">Shirts</a>
					<a href="#">Pants</a>
					<a href="#">Shorts</a>
				</div>
			</div>
			<div class="subsection">
				<button class="sub-toggle">
					<span class="title">Women's Clothing</span>
					<i class="fa fa-chevron-down sub-chevron"></i>
				</button>
				<div class="end-list">
					<a href="#">Tops</a>
					<a href="#">Dresses</a>
					<a href="#">Pants</a>
					<a href="#">Skirts</a>
				</div>
			</div>
		</div>
	</div>
	<div class="section">
		<button class="section-toggle">
			<span class="title"><i class="fa fa-mobile"></i> Electronics</span>
			<i class="fa fa-chevron-down chevron"></i>
		</button>
		<div class="section-children">
			<div class="subsection">
				<button class="sub-toggle">
					<span class="title">Mobiles</span>
					<i class="fa fa-chevron-down sub-chevron"></i>
				</button>
				<div class="end-list">
					<a href="#">Smartphones</a>
					<a href="#">Basic Phones</a>
					<a href="#">Tablets</a>
				</div>
			</div>
			<div class="subsection">
				<button class="sub-toggle">
					<span class="title">Laptops</span>
					<i class="fa fa-chevron-down sub-chevron"></i>
				</button>
				<div class="end-list">
					<a href="#">Gaming Laptops</a>
					<a href="#">Business Laptops</a>
					<a href="#">Budget Laptops</a>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="top-brands-sidebar">
	<div class="brands-header">
		<h3><i class="fa fa-certificate"></i> Top Brands</h3>
	</div>
	<div class="brands-list">
		<div class="brand-item">
			<a href="#" class="brand-link">
				<div class="brand-avatar">A</div>
				<div class="brand-info">
					<div class="brand-name">Apple</div>
					<div class="brand-seller">By Apple Inc.</div>
				</div>
				<i class="fa fa-chevron-right brand-arrow"></i>
			</a>
		</div>
		<div class="brand-item">
			<a href="#" class="brand-link">
				<div class="brand-avatar">S</div>
				<div class="brand-info">
					<div class="brand-name">Samsung</div>
					<div class="brand-seller">By Samsung Electronics</div>
				</div>
				<i class="fa fa-chevron-right brand-arrow"></i>
			</a>
		</div>
		<div class="brand-item">
			<a href="#" class="brand-link">
				<div class="brand-avatar">G</div>
				<div class="brand-info">
					<div class="brand-name">Google</div>
					<div class="brand-seller">By Google LLC</div>
				</div>
				<i class="fa fa-chevron-right brand-arrow"></i>
			</a>
		</div>
	</div>
</div>
                  -->
<?php require_once('footer.php'); ?>

<div id="toast-container" style="position:fixed;top:30px;right:30px;z-index:9999;"></div>

<style>
/* Product Grid Fixes */
.products-grid .row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
}

.products-grid .col-md-4,
.products-grid .col-sm-6 {
    display: flex;
    padding: 0 15px;
    margin-bottom: 30px;
}

.product-card {
    display: flex;
    flex-direction: column;
    width: 100%;
    min-height: 450px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.product-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.product-content {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-content h3 {
    margin: 0 0 10px 0;
    font-size: 16px;
    font-weight: 600;
    line-height: 1.4;
    height: 44px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-content h3 a {
    color: var(--color-neutral-900);
    text-decoration: none;
}

.product-content h3 a:hover {
    color: var(--color-primary);
}

.product-rating {
    margin-bottom: 12px;
}

.product-rating .rating {
    color: #ffc107;
    font-size: 14px;
}

.product-rating .review-count {
    color: var(--color-neutral-600);
    font-size: 12px;
    margin-left: 5px;
}

.product-price {
    margin-bottom: 15px;
}

.product-price .old-price {
    color: var(--color-neutral-500);
    text-decoration: line-through;
    font-size: 14px;
    margin-right: 8px;
}

.product-price .current-price {
    color: var(--color-primary);
    font-weight: 700;
    font-size: 18px;
}

.product-actions {
    margin-top: auto;
    display: flex;
    gap: 8px;
}

.product-actions .btn {
    flex: 1;
    padding: 8px 12px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.product-actions .btn:hover {
    transform: translateY(-1px);
}

.product-image { position: relative; }
.product-image.oos img { filter: grayscale(30%) brightness(0.85); }
.oos-badge {
  position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
  background: linear-gradient(135deg,#ff416c 0%, #ff4b2b 100%);
  color:#fff; padding:10px 16px; border-radius:24px; font-weight:700;
  letter-spacing:.4px; box-shadow:0 10px 25px rgba(255,65,108,.35);
  text-transform: uppercase; font-size:13px; z-index: 2; pointer-events: none;
}

/* Categories Sidebar Styles */
.category-sidebar * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.categories-header h3 {
    color: var(--color-neutral-900);
    font-size: 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.categories-header i {
    color: var(--color-primary);
    margin-right: 10px;
}

.category-sidebar {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
}

.section {
    border-bottom: 1px solid #f0f2f5;
}

.section:last-child {
    border-bottom: none;
}

.section-toggle {
    width: 100%;
    padding: 14px 20px;
    background: #fff;
    border: none;
    text-align: left;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.2s ease;
    font-size: 15px;
    font-weight: 600;
    color: var(--color-neutral-800);
}

.section-toggle:hover {
    background: #f8fafc;
    color: var(--color-primary);
}

.section-toggle .title {
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-toggle .title i {
    color: var(--color-primary);
    width: 20px;
    text-align: center;
}

.section-children {
    padding: 0 0 0 40px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.section.open .section-children {
    max-height: 5000px;
    padding: 8px 0 8px 40px;
}

.subsection {
    margin: 6px 0;
}

.sub-toggle {
    width: 100%;
    padding: 10px 15px;
    background: #f8fafc;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    text-align: left;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    font-weight: 500;
    color: var(--color-neutral-700);
    transition: all 0.2s ease;
}

.sub-toggle:hover {
    background: #f1f5ff;
    border-color: #d0e3ff;
    color: var(--color-primary);
}

.end-list {
    padding: 0 0 0 20px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.subsection.open .end-list {
    max-height: 5000px;
    padding: 8px 0 8px 20px;
}

.end-list a {
    display: block;
    padding: 8px 15px;
    margin: 4px 0;
    color: var(--color-neutral-600);
    text-decoration: none;
    font-size: 14px;
    border-radius: 4px;
    transition: all 0.2s ease;
    position: relative;
    padding-left: 25px;
}

.end-list a::before {
    content: '•';
    position: absolute;
    left: 10px;
    color: var(--color-primary);
    font-size: 16px;
    line-height: 1;
}

.end-list a:hover {
    background: #f8fafc;
    color: var(--color-primary);
    transform: translateX(4px);
}

.chevron, .sub-chevron {
    transition: transform 0.2s ease;
    color: var(--color-neutral-500);
    font-size: 12px;
}

.section.open .chevron,
.subsection.open .sub-chevron {
    transform: rotate(90deg);
    color: var(--color-primary);
}

/* Top Brands Sidebar Styles */
.brands-header h3 {
    color: var(--color-neutral-900);
    font-size: 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.brands-header i {
    color: var(--color-primary);
    margin-right: 10px;
}

.brands-list {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
}

.brand-item {
    border-bottom: 1px solid #f0f2f5;
}

.brand-item:last-child {
    border-bottom: none;
}

.brand-link {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
    gap: 12px;
}

.brand-link:hover {
    background: #f8fafc;
    color: inherit;
    text-decoration: none;
    transform: translateX(2px);
}

.brand-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    flex-shrink: 0;
}

.brand-info {
    flex: 1;
    min-width: 0;
}

.brand-name {
    font-weight: 600;
    font-size: 14px;
    color: var(--color-neutral-900);
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.brand-seller {
    font-size: 12px;
    color: var(--color-neutral-600);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.brand-arrow {
    color: var(--color-neutral-400);
    font-size: 12px;
    transition: all 0.2s ease;
}

.brand-link:hover .brand-arrow {
    color: var(--color-primary);
    transform: translateX(2px);
}

/* Responsive Design */
@media (max-width: 991px) {
    .products-grid .col-md-4 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media (max-width: 767px) {
    .products-grid .col-sm-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .product-card {
        min-height: 400px;
    }
    
    .product-image {
        height: 200px;
    }
    
    .category-sidebar {
        border-radius: 0;
    }
    
    .section-toggle {
        padding: 12px 16px;
    }
    
    .section-children {
        padding-left: 30px;
    }
    
    .end-list {
        padding-left: 15px;
    }
    
    .top-brands-sidebar {
        margin-top: 20px;
    }
    
    .brand-link {
        padding: 12px 16px;
    }
    
    .brand-avatar {
        width: 36px;
        height: 36px;
        font-size: 14px;
    }
}
</style>

<script>
window.isLoggedIn = <?php echo isset($_SESSION['customer']['cust_id']) ? 'true' : 'false'; ?>;

function toggleWishlist(productId, el) {
  if (!window.isLoggedIn) {
    showToast('Please login to add items to wishlist', 'error');
    return;
  }
  
  var action = el.classList.contains('active') ? 'remove' : 'add';
  fetch('wishlist-action.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'action=' + action + '&product_id=' + productId
  })
  .then(res => res.json())
  .then(data => {
    if(data.success) {
      el.classList.toggle('active', action === 'add');
      showToast(action === 'add' ? 'Added to wishlist' : 'Removed from wishlist');
    } else {
      showToast('Error updating wishlist', 'error');
    }
  })
  .catch(err => {
    showToast('Error updating wishlist', 'error');
  });
}

function checkWishlist(productId, el) {
  if (!window.isLoggedIn) return;
  
  fetch('wishlist-action.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'action=check&product_id=' + productId
  })
  .then(res => res.json())
  .then(data => {
    if(data.success && data.wishlisted) el.classList.add('active');
  });
}

function showToast(msg, type = 'success') {
  var toast = document.createElement('div');
  toast.textContent = msg;
  toast.style.background = type === 'success' ? '#28a745' : '#dc3545';
  toast.style.color = '#fff';
  toast.style.padding = '12px 24px';
  toast.style.marginTop = '10px';
  toast.style.borderRadius = '4px';
  toast.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)';
  toast.style.opacity = '0';
  toast.style.transition = 'opacity 0.3s';
  
  document.getElementById('toast-container').appendChild(toast);
  
  setTimeout(() => toast.style.opacity = '1', 100);
  setTimeout(() => {
    toast.style.opacity = '0';
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

function addToCart(productId, button) {
  if (!window.isLoggedIn) {
    showToast('Please login to add items to cart', 'error');
    return;
  }
  
  const originalText = button.innerHTML;
  button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding...';
  button.disabled = true;
  
  fetch('cart-action.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'product_id=' + productId + '&p_qty=1&action=add_to_cart'
  })
  .then(res => res.json())
  .then(data => {
    if(data.success) {
      showToast('Product added to cart successfully!');
      // Update cart count if element exists
      const cartCount = document.querySelector('.cart-count');
      if (cartCount && data.cart_count) {
        cartCount.textContent = data.cart_count;
      }
    } else {
      showToast(data.error || data.message || 'Error adding to cart', 'error');
    }
  })
  .catch(err => {
    console.error('Cart error:', err);
    showToast('Error adding to cart', 'error');
  })
  .finally(() => {
    button.innerHTML = originalText;
    button.disabled = false;
  });
}

function buyNow(productId) {
  if (!window.isLoggedIn) {
    showToast('Please login to purchase', 'error');
    return;
  }
  
  // Add to cart first, then redirect to checkout
  fetch('cart-action.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'product_id=' + productId + '&p_qty=1&action=buy_now'
  })
  .then(res => res.json())
  .then(data => {
    if(data.success) {
      if(data.redirect) {
        window.location.href = data.redirect;
      } else {
        window.location.href = 'checkout.php';
      }
    } else {
      showToast(data.error || data.message || 'Error adding to cart', 'error');
    }
  })
  .catch(err => {
    console.error('Buy now error:', err);
    showToast('Error processing request', 'error');
  });
}

// Initialize page functionality
document.addEventListener('DOMContentLoaded', function() {
  // Check wishlist status for logged in users
  if (window.isLoggedIn) {
    document.querySelectorAll('.wishlist-heart').forEach(heart => {
      const productId = heart.getAttribute('data-product');
      checkWishlist(productId, heart);
    });
  }
  
  // Add to cart button handling
  document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function() {
      const productId = this.getAttribute('data-product-id');
      addToCart(productId, this);
    });
  });
  
  // Buy now button handling
  document.querySelectorAll('.buy-now-btn').forEach(button => {
    button.addEventListener('click', function() {
      const productId = this.getAttribute('data-product-id');
      buyNow(productId);
    });
  });

  // Categories sidebar functionality
  document.querySelectorAll('.section-toggle').forEach(toggle => {
    toggle.addEventListener('click', function() {
      const parent = this.parentElement;
      parent.classList.toggle('open');
    });
  });

  // Toggle subsections
  document.querySelectorAll('.sub-toggle').forEach(toggle => {
    toggle.addEventListener('click', function(e) {
      e.stopPropagation();
      const parent = this.parentElement;
      parent.classList.toggle('open');
    });
  });
});
</script>