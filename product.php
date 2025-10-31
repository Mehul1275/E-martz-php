<?php require_once('header.php'); ?>

<style>
.company-info-section {
    padding: 20px 0;
}

.company-details h4 {
    color: #333;
    margin-bottom: 20px;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}

.company-details .table th {
    font-weight: 600;
    color: #495057;
}

.company-details .table td {
    vertical-align: middle;
}



.company-details .fa {
    margin-right: 8px;
    color: #007bff;
}
</style>

<?php
if(!isset($_REQUEST['id'])) {
    header('location: index.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT p.*, s.fullname as seller_name, s.company_name, s.company_address, s.email as seller_email, s.phone as seller_phone FROM tbl_product p LEFT JOIN sellers s ON p.seller_id = s.id WHERE p.p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if( $total == 0 ) {
        header('location: index.php');
        exit;
    }
}

foreach($result as $row) {
    $p_name = $row['p_name'];
    $p_old_price = $row['p_old_price'];
    $p_current_price = $row['p_current_price'];
    $p_qty = $row['p_qty'];
    $p_featured_photo = $row['p_featured_photo'];
    $p_description = $row['p_description'];
    $p_short_description = $row['p_short_description'];
    $p_feature = $row['p_feature'];
    $p_condition = $row['p_condition'];
    $p_return_policy = $row['p_return_policy'];
    $p_total_view = $row['p_total_view'];
    $p_is_featured = $row['p_is_featured'];
    $p_is_active = $row['p_is_active'];
    $ecat_id = $row['ecat_id'];
    $seller_name = $row['seller_name'];
    $company_name = $row['company_name'];
    $company_address = $row['company_address'];
    $seller_email = $row['seller_email'];
    $seller_phone = $row['seller_phone'];
}

// Getting all categories name for breadcrumb
$statement = $pdo->prepare("SELECT
                        t1.ecat_id,
                        t1.ecat_name,
                        t1.mcat_id,

                        t2.mcat_id,
                        t2.mcat_name,
                        t2.tcat_id,

                        t3.tcat_id,
                        t3.tcat_name

                        FROM tbl_end_category t1
                        JOIN tbl_mid_category t2
                        ON t1.mcat_id = t2.mcat_id
                        JOIN tbl_top_category t3
                        ON t2.tcat_id = t3.tcat_id
                        WHERE t1.ecat_id=?");
$statement->execute(array($ecat_id));
$total = $statement->rowCount();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $ecat_name = $row['ecat_name'];
    $mcat_id = $row['mcat_id'];
    $mcat_name = $row['mcat_name'];
    $tcat_id = $row['tcat_id'];
    $tcat_name = $row['tcat_name'];
}


$p_total_view = $p_total_view + 1;

$statement = $pdo->prepare("UPDATE tbl_product SET p_total_view=? WHERE p_id=?");
$statement->execute(array($p_total_view,$_REQUEST['id']));


$statement = $pdo->prepare("SELECT * FROM tbl_product_size WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $size[] = $row['size_id'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_product_color WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $color[] = $row['color_id'];
}


// Remove old inline review logic (form_review, review display, etc.)
// Add new review tab using submit-review.php

// Show success/error messages at the top
if (isset($_GET['success'])): ?>
  <div style="color:green; margin:10px 0;"> <?= htmlspecialchars($_GET['success']) ?> </div>
<?php elseif (isset($_GET['error'])): ?>
  <div style="color:red; margin:10px 0;"> <?= htmlspecialchars($_GET['error']) ?> </div>
<?php endif; ?>

<?php if(isset($_POST['form_add_to_cart'])) {

	// getting the currect stock of this product
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$current_p_qty = $row['p_qty'];
	}
	if($_POST['p_qty'] > $current_p_qty):
		$temp_msg = 'Sorry! There are only '.$current_p_qty.' item(s) in stock';
		?>
		<script type="text/javascript">alert('<?php echo $temp_msg; ?>');</script>
		<?php
	else:
    if(isset($_SESSION['cart_p_id']))
    {
        $arr_cart_p_id = array();
        $arr_cart_size_id = array();
        $arr_cart_color_id = array();
        $arr_cart_p_qty = array();
        $arr_cart_p_current_price = array();

        $i=0;
        foreach($_SESSION['cart_p_id'] as $key => $value) 
        {
            $i++;
            $arr_cart_p_id[$i] = $value;
        }

        $i=0;
        foreach($_SESSION['cart_size_id'] as $key => $value) 
        {
            $i++;
            $arr_cart_size_id[$i] = $value;
        }

        $i=0;
        foreach($_SESSION['cart_color_id'] as $key => $value) 
        {
            $i++;
            $arr_cart_color_id[$i] = $value;
        }


        $added = 0;
        if(!isset($_POST['size_id'])) {
            $size_id = 0;
        } else {
            $size_id = $_POST['size_id'];
        }
        if(!isset($_POST['color_id'])) {
            $color_id = 0;
        } else {
            $color_id = $_POST['color_id'];
        }
        for($i=1;$i<=count($arr_cart_p_id);$i++) {
            if( ($arr_cart_p_id[$i]==$_REQUEST['id']) && ($arr_cart_size_id[$i]==$size_id) && ($arr_cart_color_id[$i]==$color_id) ) {
                $added = 1;
                break;
            }
        }
        if($added == 1) {
           $error_message1 = 'This product is already added to the shopping cart.';
        } else {

            $i=0;
            foreach($_SESSION['cart_p_id'] as $key => $res) 
            {
                $i++;
            }
            $new_key = $i+1;

            if(isset($_POST['size_id'])) {

                $size_id = $_POST['size_id'];

                $statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_id=?");
                $statement->execute(array($size_id));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                foreach ($result as $row) {
                    $size_name = $row['size_name'];
                }
            } else {
                $size_id = 0;
                $size_name = '';
            }
            
            if(isset($_POST['color_id'])) {
                $color_id = $_POST['color_id'];
                $statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
                $statement->execute(array($color_id));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                foreach ($result as $row) {
                    $color_name = $row['color_name'];
                }
            } else {
                $color_id = 0;
                $color_name = '';
            }
          

            $_SESSION['cart_p_id'][$new_key] = $_REQUEST['id'];
            $_SESSION['cart_size_id'][$new_key] = $size_id;
            $_SESSION['cart_size_name'][$new_key] = $size_name;
            $_SESSION['cart_color_id'][$new_key] = $color_id;
            $_SESSION['cart_color_name'][$new_key] = $color_name;
            $_SESSION['cart_p_qty'][$new_key] = $_POST['p_qty'];
            $_SESSION['cart_p_current_price'][$new_key] = $_POST['p_current_price'];
            $_SESSION['cart_p_name'][$new_key] = $_POST['p_name'];
            $_SESSION['cart_p_featured_photo'][$new_key] = $_POST['p_featured_photo'];

            $success_message1 = 'Product is added to the cart successfully!';
        }
        
    }
    else
    {

        if(isset($_POST['size_id'])) {

            $size_id = $_POST['size_id'];

            $statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_id=?");
            $statement->execute(array($size_id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
            foreach ($result as $row) {
                $size_name = $row['size_name'];
            }
        } else {
            $size_id = 0;
            $size_name = '';
        }
        
        if(isset($_POST['color_id'])) {
            $color_id = $_POST['color_id'];
            $statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
            $statement->execute(array($color_id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
            foreach ($result as $row) {
                $color_name = $row['color_name'];
            }
        } else {
            $color_id = 0;
            $color_name = '';
        }
        

        $_SESSION['cart_p_id'][1] = $_REQUEST['id'];
        $_SESSION['cart_size_id'][1] = $size_id;
        $_SESSION['cart_size_name'][1] = $size_name;
        $_SESSION['cart_color_id'][1] = $color_id;
        $_SESSION['cart_color_name'][1] = $color_name;
        $_SESSION['cart_p_qty'][1] = $_POST['p_qty'];
        $_SESSION['cart_p_current_price'][1] = $_POST['p_current_price'];
        $_SESSION['cart_p_name'][1] = $_POST['p_name'];
        $_SESSION['cart_p_featured_photo'][1] = $_POST['p_featured_photo'];

        $success_message1 = 'Product is added to the cart successfully!';
    }
	endif;
}
?>

<?php
if($error_message1 != '') {
    echo "<script>alert('".$error_message1."')</script>";
}
if($success_message1 != '') {
    echo "<script>alert('".$success_message1."')</script>";
    header('location: product.php?id='.$_REQUEST['id']);
}
?>

<?php if(isset($_SESSION['customer']['cust_id'])): ?>
<script>
function toggleWishlist(productId, el) {
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
      if(action === 'add') el.classList.add('active');
      else el.classList.remove('active');
    }
  });
}
function checkWishlist(productId, el) {
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
  toast.style.fontSize = '16px';
  document.body.appendChild(toast);
  setTimeout(function(){ toast.remove(); }, 2500);
}
document.addEventListener('DOMContentLoaded', function() {
  var el = document.querySelector('.wishlist-heart[data-product]');
  if(el) {
    <?php if(isset($_SESSION['customer']['cust_id'])): ?>
      checkWishlist(el.getAttribute('data-product'), el);
      el.addEventListener('click', function() {
        toggleWishlist(el.getAttribute('data-product'), el);
      });
    <?php else: ?>
      el.addEventListener('click', function() {
        showToast('Please login to add to wishlist.', 'error');
      });
    <?php endif; ?>
  }
});
</script>
<?php endif; ?>

<div class="page" style="padding: 40px 0; background: #f8fafc;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
                <nav class="breadcrumb-nav" style="margin-bottom: 30px;">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo BASE_URL; ?>"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="<?php echo BASE_URL.'product-category.php?id='.$tcat_id.'&type=top-category' ?>"><?php echo $tcat_name; ?></a></li>
                        <li><a href="<?php echo BASE_URL.'product-category.php?id='.$mcat_id.'&type=mid-category' ?>"><?php echo $mcat_name; ?></a></li>
                        <li><a href="<?php echo BASE_URL.'product-category.php?id='.$ecat_id.'&type=end-category' ?>"><?php echo $ecat_name; ?></a></li>
                        <li class="active"><?php echo $p_name; ?></li>
                    </ol>
                </nav>

				<div class="product-detail-card">
					<div class="row">
						<div class="col-md-6">
							<div class="product-gallery" style="position: relative;">
								<?php if($p_old_price!='' && $p_old_price > $p_current_price): ?>
									<div class="discount-badge">
										<?php echo round((($p_old_price - $p_current_price) / $p_old_price) * 100); ?>% OFF
									</div>
								<?php endif; ?>
								<ul class="prod-slider">
									<li style="background-image: url(assets/uploads/<?php echo $p_featured_photo; ?>); position: relative;">
										<a class="popup" href="assets/uploads/<?php echo $p_featured_photo; ?>"></a>
										<?php if($p_qty <= 0): ?>
										<div class="oos-badge" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:linear-gradient(135deg,#ff416c,#ff4b2b);color:#fff;padding:12px 18px;border-radius:26px;font-weight:700;letter-spacing:.4px;box-shadow:0 10px 25px rgba(255,65,108,.35);text-transform:uppercase;font-size:14px;z-index:2;"> 
											<i class="fa fa-ban"></i> Out of Stock
										</div>
										<?php endif; ?>
									</li>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
									$statement->execute(array($_REQUEST['id']));
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
										?>
										<li style="background-image: url(assets/uploads/product_photos/<?php echo $row['photo']; ?>);">
											<a class="popup" href="assets/uploads/product_photos/<?php echo $row['photo']; ?>"></a>
										</li>
										<?php
									}
									?>
								</ul>
								<div id="prod-pager">
									<a data-slide-index="0" href=""><div class="prod-pager-thumb" style="background-image: url(assets/uploads/<?php echo $p_featured_photo; ?>"></div></a>
									<?php
									$i=1;
									$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
									$statement->execute(array($_REQUEST['id']));
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
										?>
										<a data-slide-index="<?php echo $i; ?>" href=""><div class="prod-pager-thumb" style="background-image: url(assets/uploads/product_photos/<?php echo $row['photo']; ?>"></div></a>
										<?php
										$i++;
									}
									?>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="product-info">
								<h1 class="product-title"><?php echo $p_name; ?></h1>
								
								<div class="product-rating">
									<div class="rating">
										<?php
										// Getting the average rating for this product
										$t_rating = 0;
										$statement = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
										$statement->execute(array($_REQUEST['id']));
										$tot_rating = $statement->rowCount();
										if($tot_rating == 0) {
											$avg_rating = 0;
										} else {
											$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
											foreach ($result as $row) {
												$t_rating = $t_rating + $row['rating'];
											}
											$avg_rating = $t_rating / $tot_rating;
										}
										?>
										<?php
										if($avg_rating == 0) {
											echo '<span class="text-muted">No reviews yet</span>';
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
										<span class="review-count">(<?php echo $tot_rating; ?> reviews)</span>
									<?php endif; ?>
								</div>
								
								<div class="product-description">
									<p><?php echo $p_short_description; ?></p>
								</div>
								
								<div class="product-price">
									<div class="price-label">Price:</div>
									<div class="price-display">
										<?php if($p_old_price!=''): ?>
											<span class="old-price">₹<?php echo $p_old_price; ?></span>
										<?php endif; ?> 
										<span class="current-price">₹<?php echo $p_current_price; ?></span>
									</div>
								</div>
								
								<form action="" method="post" class="product-form">
									<?php if(isset($size)): ?>
									<div class="form-group">
										<label><?php echo LANG_VALUE_52; ?>:</label>
										<select name="size_id" class="form-control select2">
											<?php
											$statement = $pdo->prepare("SELECT * FROM tbl_size");
											$statement->execute();
											$result = $statement->fetchAll(PDO::FETCH_ASSOC);
											foreach ($result as $row) {
												if(in_array($row['size_id'],$size)) {
													?>
													<option value="<?php echo $row['size_id']; ?>"><?php echo $row['size_name']; ?></option>
													<?php
												}
											}
											?>
										</select>
									</div>
									<?php endif; ?>

									<?php if(isset($color)): ?>
									<div class="form-group">
										<label><?php echo LANG_VALUE_53; ?>:</label>
										<select name="color_id" class="form-control select2">
											<?php
											$statement = $pdo->prepare("SELECT * FROM tbl_color");
											$statement->execute();
											$result = $statement->fetchAll(PDO::FETCH_ASSOC);
											foreach ($result as $row) {
												if(in_array($row['color_id'],$color)) {
													?>
													<option value="<?php echo $row['color_id']; ?>"><?php echo $row['color_name']; ?></option>
													<?php
												}
											}
											?>
										</select>
									</div>
									<?php endif; ?>
									
									<div class="form-group">
										<label><?php echo LANG_VALUE_55; ?>:</label>
										<div class="quantity-input">
											<input type="number" class="form-control" step="1" min="1" max="" name="p_qty" value="1" title="Qty" pattern="[0-9]*" inputmode="numeric">
										</div>
									</div>
									
									<?php if($p_qty > 0): ?>
									<div class="product-actions">
										<button type="button" class="btn btn-primary btn-lg add-to-cart-btn">
											<i class="fa fa-shopping-cart"></i> <?php echo LANG_VALUE_154; ?>
										</button>
										<button type="button" class="btn btn-success btn-lg buy-now-btn">
											<i class="fa fa-bolt"></i> Buy Now
										</button>
										<?php if(isset($_SESSION['customer']['cust_id'])): ?>
											<!-- Replace wishlist-btn with wishlist-heart icon -->
											<i class="fa fa-heart wishlist-heart" data-product="<?php echo $_REQUEST['id']; ?>" style="font-size: 24px; cursor: pointer; margin-left: 15px;"></i>
										<?php endif; ?>
									</div>
									<?php else: ?>
									<div class="product-actions">
										<div class="alert alert-warning">
											<i class="fa fa-exclamation-triangle"></i> Out of Stock
										</div>
									</div>
									<?php endif; ?>
									
									<input type="hidden" name="product_id" value="<?php echo $_REQUEST['id']; ?>">
									<input type="hidden" name="p_name" value="<?php echo htmlspecialchars($p_name, ENT_QUOTES, 'UTF-8'); ?>">
									<input type="hidden" name="p_featured_photo" value="<?php echo htmlspecialchars($p_featured_photo, ENT_QUOTES, 'UTF-8'); ?>">
									<input type="hidden" name="p_current_price" value="<?php echo $p_current_price; ?>">
								</form>
								
								<div class="trust-indicators">
									<div class="trust-item">
										<i class="fa fa-shield"></i>
										<span>Secure Payment</span>
									</div>
									<div class="trust-item">
										<i class="fa fa-truck"></i>
										<span>Fast Delivery</span>
									</div>
									<div class="trust-item">
										<i class="fa fa-undo"></i>
										<span>Easy Returns</span>
									</div>
								</div>
								
								<div class="social-share-section">
									<h4><i class="fa fa-share-alt"></i> Share This Product</h4>
									<div class="social-share-buttons">
										<a href="#" class="share-btn facebook" onclick="shareOnFacebook()" title="Share on Facebook">
											<i class="fa fa-facebook"></i>
										</a>
										<a href="#" class="share-btn twitter" onclick="shareOnTwitter()" title="Share on Twitter">
											<i class="fa fa-twitter"></i>
										</a>
										<a href="#" class="share-btn whatsapp" onclick="shareOnWhatsApp()" title="Share on WhatsApp">
											<i class="fa fa-whatsapp"></i>
										</a>
										<a href="#" class="share-btn telegram" onclick="shareOnTelegram()" title="Share on Telegram">
											<i class="fa fa-telegram"></i>
										</a>
										<a href="#" class="share-btn copy-link" onclick="copyProductLink()" title="Copy Link">
											<i class="fa fa-link"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row" style="margin-top: 40px;">
						<div class="col-md-12">
							<div class="product-tabs">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#description" aria-controls="description" role="tab" data-toggle="tab"><i class="fa fa-info-circle"></i> <?php echo LANG_VALUE_59; ?></a></li>
									<li role="presentation"><a href="#feature" aria-controls="feature" role="tab" data-toggle="tab"><i class="fa fa-star"></i> <?php echo LANG_VALUE_60; ?></a></li>
									<li role="presentation"><a href="#condition" aria-controls="condition" role="tab" data-toggle="tab"><i class="fa fa-check-circle"></i> <?php echo LANG_VALUE_61; ?></a></li>
									<li role="presentation"><a href="#return_policy" aria-controls="return_policy" role="tab" data-toggle="tab"><i class="fa fa-undo"></i> <?php echo LANG_VALUE_62; ?></a></li>
									<li role="presentation"><a href="#company_info" aria-controls="company_info" role="tab" data-toggle="tab"><i class="fa fa-building"></i> Company Info</a></li>
									<li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab"><i class="fa fa-comments"></i> Reviews</a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="description">
									<div class="tab-content-wrapper">
										<?php
										if($p_description == '') {
											echo '<p class="text-muted">' . LANG_VALUE_70 . '</p>';
										} else {
											echo '<div class="content">' . $p_description . '</div>';
										}
										?>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="feature">
									<div class="tab-content-wrapper">
										<?php
										if($p_feature == '') {
											echo '<p class="text-muted">' . LANG_VALUE_71 . '</p>';
										} else {
											echo '<div class="content">' . $p_feature . '</div>';
										}
										?>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="condition">
									<div class="tab-content-wrapper">
										<?php
										if($p_condition == '') {
											echo '<p class="text-muted">' . LANG_VALUE_72 . '</p>';
										} else {
											echo '<div class="content">' . $p_condition . '</div>';
										}
										?>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="return_policy">
									<div class="tab-content-wrapper">
										<?php
										if($p_return_policy == '') {
											echo '<p class="text-muted">' . LANG_VALUE_73 . '</p>';
										} else {
											echo '<div class="content">' . $p_return_policy . '</div>';
										}
										?>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="company_info">
									<div class="tab-content-wrapper">
										<?php if($company_name && $seller_name): ?>
											<div class="company-details">
												<h4><i class="fa fa-building"></i> Company Information</h4>
												<div class="company-info-grid">
													<div class="info-item">
														<strong><i class="fa fa-user"></i> Seller Name:</strong>
														<span><?php echo htmlspecialchars($seller_name); ?></span>
													</div>
													<div class="info-item">
														<strong><i class="fa fa-building"></i> Company Name:</strong>
														<span><?php echo htmlspecialchars($company_name); ?></span>
													</div>
													<?php if($company_address): ?>
													<div class="info-item">
														<strong><i class="fa fa-map-marker"></i> Company Address:</strong>
														<span><?php echo nl2br(htmlspecialchars($company_address)); ?></span>
													</div>
													<?php endif; ?>
													<?php if($seller_email): ?>
													<div class="info-item">
														<strong><i class="fa fa-envelope"></i> Email Address:</strong>
														<span><a href="mailto:<?php echo htmlspecialchars($seller_email); ?>"><?php echo htmlspecialchars($seller_email); ?></a></span>
													</div>
													<?php endif; ?>
													<?php if($seller_phone): ?>
													<div class="info-item">
														<strong><i class="fa fa-phone"></i> Phone Number:</strong>
														<span><a href="tel:<?php echo htmlspecialchars($seller_phone); ?>"><?php echo htmlspecialchars($seller_phone); ?></a></span>
													</div>
													<?php endif; ?>
												</div>
											</div>
										<?php else: ?>
											<div class="alert alert-info">
												<i class="fa fa-info-circle"></i> Company information is not available for this product.
											</div>
										<?php endif; ?>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="reviews">
									<div class="tab-content-wrapper">
										<?php
										// Fetch reviews for this product
										$statement = $pdo->prepare("SELECT t1.*, t2.cust_name FROM tbl_rating t1 JOIN tbl_customer t2 ON t1.cust_id = t2.cust_id WHERE t1.p_id=? ORDER BY t1.rt_id DESC");
										$statement->execute([$_REQUEST['id']]);
										$reviews = $statement->fetchAll(PDO::FETCH_ASSOC);
										$total = count($reviews);
										?>
										<div class="reviews-header">
											<h3>Customer Reviews (<?= $total ?>)</h3>
										</div>
										
										<?php if ($total): ?>
											<div class="reviews-list">
												<?php foreach ($reviews as $row): ?>
													<div class="review-item">
														<div class="review-header">
															<div class="reviewer-name"><?= htmlspecialchars($row['cust_name']) ?></div>
															<div class="review-rating">
																<?php for($i=1;$i<=5;$i++): ?>
																	<?php if($i <= $row['rating']): ?><i class="fa fa-star"></i><?php else: ?><i class="fa fa-star-o"></i><?php endif; ?>
																<?php endfor; ?>
															</div>
															<div class="review-date"><?= isset($row['created_at']) ? date('M d, Y', strtotime($row['created_at'])) : 'N/A' ?></div>
														</div>
														<?php if(isset($row['subject']) && $row['subject']): ?>
															<h5 class="review-subject"><?= htmlspecialchars($row['subject']) ?></h5>
														<?php endif; ?>
														<p class="review-comment"><?= nl2br(htmlspecialchars($row['comment'])) ?></p>
													</div>
												<?php endforeach; ?>
											</div>
										<?php else: ?>
											<div class="no-reviews">
												<i class="fa fa-comments-o"></i>
												<p>No reviews yet. Be the first to review this product!</p>
											</div>
										<?php endif; ?>

										<div class="write-review-section">
											<h3>Write a Review</h3>
											<?php if(isset($_SESSION['customer'])): ?>
												<?php
												// Check if this customer already reviewed this product
												$statement = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=? AND cust_id=?");
												$statement->execute([$_REQUEST['id'], $_SESSION['customer']['cust_id']]);
												$alreadyReviewed = $statement->rowCount();
												?>
												<?php if(!$alreadyReviewed): ?>
													<form action="submit-review.php" method="POST" class="review-form">
														<input type="hidden" name="p_id" value="<?= htmlspecialchars($_REQUEST['id']) ?>">
														<div class="form-group">
															<label>Rating:</label>
															<div class="star-rating">
																<input type="radio" id="star5" name="rating" value="5" required><label for="star5">★</label>
																<input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
																<input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
																<input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
																<input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
															</div>
														</div>
														<div class="form-group">
															<label>Subject:</label>
															<input type="text" name="subject" class="form-control" maxlength="255" required placeholder="Review subject">
														</div>
														<div class="form-group">
															<label>Review Description:</label>
															<textarea name="comment" class="form-control" rows="4" placeholder="Write your review" required></textarea>
														</div>
														<button type="submit" class="btn btn-primary">Submit Review</button>
													</form>
												<?php else: ?>
													<div class="alert alert-info">
														<i class="fa fa-check-circle"></i> You have already reviewed this product.
													</div>
												<?php endif; ?>
											<?php else: ?>
												<div class="alert alert-warning">
													<i class="fa fa-sign-in"></i> Please <a href="login.php">login</a> to write a review.
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
							</div>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
</div>

<div class="product bg-gray pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="headline">
                    <h2><?php echo LANG_VALUE_155; ?></h2>
                    <h3><?php echo LANG_VALUE_156; ?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="product-carousel">

                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE ecat_id=? AND p_id!=?");
                    $statement->execute(array($ecat_id,$_REQUEST['id']));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        ?>
                        <div class="item">
                            <div class="product-card">
                                <div class="product-image">
                                    <a href="product.php?id=<?php echo $row['p_id']; ?>">
                                        <img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="<?php echo htmlspecialchars($row['p_name']); ?>">
                                    </a>
                                    <?php if($row['p_old_price'] != '' && $row['p_old_price'] > $row['p_current_price']): ?>
                                        <div class="discount-badge">
                                            <?php echo round((($row['p_old_price'] - $row['p_current_price']) / $row['p_old_price']) * 100); ?>% OFF
                                        </div>
                                    <?php endif; ?>
                                    <?php if(isset($_SESSION['customer']['cust_id'])): ?>
                                        <div class="wishlist-icon">
                                            <i class="fa fa-heart wishlist-heart" data-product="<?php echo $row['p_id']; ?>"></i>
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
                                            <span class="old-price"><?php echo LANG_VALUE_1; ?><?php echo $row['p_old_price']; ?></span>
                                        <?php endif; ?>
                                        <span class="current-price"><?php echo LANG_VALUE_1; ?><?php echo $row['p_current_price']; ?></span>
                                    </div>
                                    <?php if($row['p_qty'] > 0): ?>
                                        <div class="product-actions">
                                            <form class="product-action-form" data-product-id="<?php echo $row['p_id']; ?>">
                                                <input type="hidden" name="product_id" value="<?php echo $row['p_id']; ?>">
                                                <input type="hidden" name="p_qty" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm add-to-cart-btn">
                                                    <i class="fa fa-shopping-cart"></i> Add to Cart
                                                </button>
                                                <button type="button" class="btn btn-success btn-sm buy-now-btn">
                                                    <i class="fa fa-bolt"></i> Buy Now
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Toast container -->
<div id="toast-container" style="position:fixed;top:30px;right:30px;z-index:9999;"></div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  console.log('Product page JavaScript loaded');
  
  var addToCartBtn = document.querySelector('.add-to-cart-btn');
  var buyNowBtn = document.querySelector('.buy-now-btn');
  var heart = document.querySelector('.wishlist-heart[data-product]');

  console.log('Add to Cart button:', addToCartBtn);
  console.log('Buy Now button:', buyNowBtn);

  function showToast(msg, type = 'success') {
    var toast = document.createElement('div');
    toast.textContent = msg;
    toast.style.background = type === 'success' ? '#28a745' : '#dc3545';
    toast.style.color = '#fff';
    toast.style.padding = '12px 24px';
    toast.style.marginTop = '10px';
    toast.style.borderRadius = '4px';
    toast.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)';
    toast.style.fontSize = '16px';
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(function(){ toast.remove(); }, 2500);
  }

  function addToCart() {
    console.log('Add to Cart clicked');
    
    var productIdInput = document.querySelector('input[name="product_id"]');
    var qtyInput = document.querySelector('input[name="p_qty"]');
    
    console.log('Product ID input:', productIdInput);
    console.log('Quantity input:', qtyInput);
    
    if (!productIdInput || !qtyInput) {
      console.error('Required inputs not found');
      showToast('Error: Product information not found', 'error');
      return;
    }
    
    var formData = new FormData();
    formData.append('product_id', productIdInput.value);
    formData.append('p_qty', qtyInput.value);
    formData.append('action', 'add_to_cart');
    
    console.log('Sending data:', {
      product_id: productIdInput.value,
      p_qty: qtyInput.value,
      action: 'add_to_cart'
    });
    
    fetch('cart-action.php', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      console.log('Response status:', response.status);
      return response.json();
    })
    .then(data => {
      console.log('Response data:', data);
      if(data.success) {
        showToast('Product added to cart!');
      } else {
        showToast(data.error || 'Error adding to cart', 'error');
      }
    })
    .catch(error => {
      console.error('Fetch error:', error);
      showToast('Error adding to cart', 'error');
    });
  }

  function buyNow() {
    console.log('Buy Now clicked');
    
    <?php if(!isset($_SESSION['customer']['cust_id'])): ?>
      showToast('Please login to purchase', 'error');
      setTimeout(function(){ window.location = 'login.php'; }, 1200);
      return;
    <?php endif; ?>
    
    var productIdInput = document.querySelector('input[name="product_id"]');
    var qtyInput = document.querySelector('input[name="p_qty"]');
    
    if (!productIdInput || !qtyInput) {
      console.error('Required inputs not found');
      showToast('Error: Product information not found', 'error');
      return;
    }
    
    var formData = new FormData();
    formData.append('product_id', productIdInput.value);
    formData.append('p_qty', qtyInput.value);
    formData.append('action', 'buy_now');
    
    console.log('Sending data:', {
      product_id: productIdInput.value,
      p_qty: qtyInput.value,
      action: 'buy_now'
    });
    
    fetch('cart-action.php', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      console.log('Response status:', response.status);
      return response.json();
    })
    .then(data => {
      console.log('Response data:', data);
      if(data.success && data.redirect) {
        window.location = data.redirect;
      } else {
        showToast(data.error || 'Error processing purchase', 'error');
      }
    })
    .catch(error => {
      console.error('Fetch error:', error);
      showToast('Error processing purchase', 'error');
    });
  }

  if(addToCartBtn) {
    addToCartBtn.addEventListener('click', function(e) {
      e.preventDefault();
      addToCart();
    });
  } else {
    console.error('Add to Cart button not found');
  }
  
  if(buyNowBtn) {
    buyNowBtn.addEventListener('click', function(e) {
      e.preventDefault();
      buyNow();
    });
  } else {
    console.error('Buy Now button not found');
  }
  
  if(heart) {
    function toggleWishlist(productId, el) {
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
          if(action === 'add') el.classList.add('active');
          else el.classList.remove('active');
        }
      });
    }
    function checkWishlist(productId, el) {
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
    <?php if(isset($_SESSION['customer']['cust_id'])): ?>
      checkWishlist(heart.getAttribute('data-product'), heart);
      heart.addEventListener('click', function() {
        toggleWishlist(heart.getAttribute('data-product'), heart);
      });
    <?php else: ?>
      heart.addEventListener('click', function() {
        showToast('Please login to add to wishlist.', 'error');
      });
    <?php endif; ?>
  }
});
</script>

<?php require_once('footer.php'); ?>
