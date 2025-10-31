<?php 
declare(strict_types=1);
require_once('header.php'); 
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $cta_title = $row['cta_title'];
    $cta_content = $row['cta_content'];
    $cta_read_more_text = $row['cta_read_more_text'];
    $cta_read_more_url = $row['cta_read_more_url'];
    $cta_photo = $row['cta_photo'];
    $featured_product_title = $row['featured_product_title'];
    $featured_product_subtitle = $row['featured_product_subtitle'];
    $latest_product_title = $row['latest_product_title'];
    $latest_product_subtitle = $row['latest_product_subtitle'];
    $popular_product_title = $row['popular_product_title'];
    $popular_product_subtitle = $row['popular_product_subtitle'];
    $total_featured_product_home = $row['total_featured_product_home'];
    $total_latest_product_home = $row['total_latest_product_home'];
    $total_popular_product_home = $row['total_popular_product_home'];
    $home_service_on_off = $row['home_service_on_off'];
    $home_welcome_on_off = $row['home_welcome_on_off'];
    $home_featured_product_on_off = $row['home_featured_product_on_off'];
    $home_latest_product_on_off = $row['home_latest_product_on_off'];
    $home_popular_product_on_off = $row['home_popular_product_on_off'];
}
?>

<div id="bootstrap-touch-slider" class="carousel bs-slider fade control-round indicators-line" data-ride="carousel" data-pause="hover" data-interval="false" >

    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php
        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_slider");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {            
            ?>
            <li data-target="#bootstrap-touch-slider" data-slide-to="<?php echo $i; ?>" <?php if($i==0) {echo 'class="active"';} ?>></li>
            <?php
            $i++;
        }
        ?>
    </ol>

    <!-- Wrapper For Slides -->
    <div class="carousel-inner" role="listbox">

        <?php
        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_slider");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {            
            ?>
            <div class="item <?php if($i==0) {echo 'active';} ?>" style="background-image:url(assets/uploads/<?php echo htmlspecialchars($row['photo'], ENT_QUOTES, 'UTF-8'); ?>);">
                <div class="bs-slider-overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="slide-text <?php if($row['position'] == 'Left') {echo 'slide_style_left';} elseif($row['position'] == 'Center') {echo 'slide_style_center';} elseif($row['position'] == 'Right') {echo 'slide_style_right';} ?>">
                            <h1 data-animation="animated <?php if($row['position'] == 'Left') {echo 'zoomInLeft';} elseif($row['position'] == 'Center') {echo 'flipInX';} elseif($row['position'] == 'Right') {echo 'zoomInRight';} ?>"><?php echo htmlspecialchars($row['heading'], ENT_QUOTES, 'UTF-8'); ?></h1>
                            <p data-animation="animated <?php if($row['position'] == 'Left') {echo 'fadeInLeft';} elseif($row['position'] == 'Center') {echo 'fadeInDown';} elseif($row['position'] == 'Right') {echo 'fadeInRight';} ?>"><?php echo nl2br(htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8')); ?></p>
                            <a href="<?php echo htmlspecialchars($row['button_url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank"  class="btn btn-primary" data-animation="animated <?php if($row['position'] == 'Left') {echo 'fadeInLeft';} elseif($row['position'] == 'Center') {echo 'fadeInDown';} elseif($row['position'] == 'Right') {echo 'fadeInRight';} ?>"><?php echo htmlspecialchars($row['button_text'], ENT_QUOTES, 'UTF-8'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }
        ?>
    </div>

    <!-- Slider Left Control -->
    <a class="left carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="prev">
        <span class="fa fa-angle-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>

    <!-- Slider Right Control -->
    <a class="right carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="next">
        <span class="fa fa-angle-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>

</div>

<div id="toast-container" style="position:fixed;top:30px;right:30px;z-index:9999;"></div>

<!-- Corporate hero section 
<section class="trust-section" aria-label="E-martz hero">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="hero">
          <div class="hero-inner">
            <div class="hero-text">
              <h1>Your Trusted Online Marketplace</h1>
              <p>Shop confidently with verified sellers, secure payments, and hassle-free returns. Quality products delivered to your doorstep.</p>
              <div style="margin-top:20px;">
                <a href="product-category.php?id=1&type=top-category" class="btn btn-primary btn-lg">Start Shopping</a>
                <a href="faq.php" class="btn btn-outline" style="margin-left:12px;">Learn More</a>
              </div>
              <div class="security-indicators" style="margin-top:20px;">
                <div class="icon"><i class="fa fa-shield"></i></div>
                <div class="text">SSL Secured • Safe Payments • Verified Sellers</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
-->
<!-- Why Choose E-martz Section -->
<section class="why-choose-section pt_70 pb_70" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden;">
  <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.95);"></div>
  <div class="container" style="position: relative; z-index: 2;">
    <div class="row">
      <div class="col-md-12">
        <div class="headline" style="text-align:center;margin-bottom:50px;">
          <h2 style="font-size:32px;font-weight:700;color:#2c3e50;margin-bottom:15px;text-transform:uppercase;">Why Choose E-martz</h2>
          <p style="font-size:18px;color:#7f8c8d;max-width:600px;margin:0 auto;line-height:1.6;">Your satisfaction and security are our top priorities. Experience shopping like never before.</p>
        </div>
      </div>
    </div>
    
    <div class="row" style="margin: 0 -15px;">
      <div class="col-md-4 col-sm-6" style="padding: 0 15px; margin-bottom: 30px;">
        <a href="secure-checkout.php" class="trust-feature-card" style="display:block;text-decoration:none;color:inherit;">
          <div class="trust-feature-inner" style="background:#fff;padding:30px 20px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);text-align:center;transition:all 0.3s ease;border:2px solid transparent;height:100%;margin:10px;">
            <div class="icon-wrapper" style="width:70px;height:70px;margin:0 auto 20px;background:linear-gradient(135deg,#3498db,#2980b9);border-radius:50%;display:flex;align-items:center;justify-content:center;">
              <i class="fa fa-shield" style="font-size:28px;color:#fff;"></i>
            </div>
            <h3 style="font-size:20px;font-weight:600;color:#2c3e50;margin-bottom:15px;">Secure Checkout</h3>
            <p style="color:#7f8c8d;line-height:1.6;margin:0;">256-bit SSL encryption and PCI-compliant payment processing for complete security</p>
          </div>
        </a>
      </div>
      
      <div class="col-md-4 col-sm-6" style="padding: 0 15px; margin-bottom: 30px;">
        <a href="shipping-returns.php" class="trust-feature-card" style="display:block;text-decoration:none;color:inherit;">
          <div class="trust-feature-inner" style="background:#fff;padding:30px 20px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);text-align:center;transition:all 0.3s ease;border:2px solid transparent;height:100%;margin:10px;">
            <div class="icon-wrapper" style="width:70px;height:70px;margin:0 auto 20px;background:linear-gradient(135deg,#e74c3c,#c0392b);border-radius:50%;display:flex;align-items:center;justify-content:center;">
              <i class="fa fa-undo" style="font-size:28px;color:#fff;"></i>
            </div>
            <h3 style="font-size:20px;font-weight:600;color:#2c3e50;margin-bottom:15px;">Easy Returns</h3>
            <p style="color:#7f8c8d;line-height:1.6;margin:0;">Hassle-free 30-day return policy with free return shipping on eligible items</p>
          </div>
        </a>
      </div>
      
      <div class="col-md-4 col-sm-6" style="padding: 0 15px; margin-bottom: 30px;">
        <a href="contact.php" class="trust-feature-card" style="display:block;text-decoration:none;color:inherit;">
          <div class="trust-feature-inner" style="background:#fff;padding:30px 20px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);text-align:center;transition:all 0.3s ease;border:2px solid transparent;height:100%;margin:10px;">
            <div class="icon-wrapper" style="width:70px;height:70px;margin:0 auto 20px;background:linear-gradient(135deg,#f39c12,#e67e22);border-radius:50%;display:flex;align-items:center;justify-content:center;">
              <i class="fa fa-headphones" style="font-size:28px;color:#fff;"></i>
            </div>
            <h3 style="font-size:20px;font-weight:600;color:#2c3e50;margin-bottom:15px;">24/7 Support</h3>
            <p style="color:#7f8c8d;line-height:1.6;margin:0;">Dedicated customer service team available round the clock to assist you</p>
          </div>
        </a>
      </div>
      
      <div class="col-md-4 col-sm-6" style="padding: 0 15px; margin-bottom: 30px;">
        <a href="fast-delivery.php" class="trust-feature-card" style="display:block;text-decoration:none;color:inherit;">
          <div class="trust-feature-inner" style="background:#fff;padding:30px 20px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);text-align:center;transition:all 0.3s ease;border:2px solid transparent;height:100%;margin:10px;">
            <div class="icon-wrapper" style="width:70px;height:70px;margin:0 auto 20px;background:linear-gradient(135deg,#27ae60,#229954);border-radius:50%;display:flex;align-items:center;justify-content:center;">
              <i class="fa fa-truck" style="font-size:28px;color:#fff;"></i>
            </div>
            <h3 style="font-size:20px;font-weight:600;color:#2c3e50;margin-bottom:15px;">Fast Delivery</h3>
            <p style="color:#7f8c8d;line-height:1.6;margin:0;">Quick and reliable shipping with real-time tracking for all orders</p>
          </div>
        </a>
      </div>
      
      <div class="col-md-4 col-sm-6" style="padding: 0 15px; margin-bottom: 30px;">
        <a href="payment-options.php" class="trust-feature-card" style="display:block;text-decoration:none;color:inherit;">
          <div class="trust-feature-inner" style="background:#fff;padding:30px 20px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);text-align:center;transition:all 0.3s ease;border:2px solid transparent;height:100%;margin:10px;">
            <div class="icon-wrapper" style="width:70px;height:70px;margin:0 auto 20px;background:linear-gradient(135deg,#9b59b6,#8e44ad);border-radius:50%;display:flex;align-items:center;justify-content:center;">
              <i class="fa fa-credit-card" style="font-size:28px;color:#fff;"></i>
            </div>
            <h3 style="font-size:20px;font-weight:600;color:#2c3e50;margin-bottom:15px;">Multiple Payment Options</h3>
            <p style="color:#7f8c8d;line-height:1.6;margin:0;">Accept all major credit cards, debit cards, net banking, and digital wallets</p>
          </div>
        </a>
      </div>
      
      <div class="col-md-4 col-sm-6" style="padding: 0 15px; margin-bottom: 30px;">
        <a href="about.php" class="trust-feature-card" style="display:block;text-decoration:none;color:inherit;">
          <div class="trust-feature-inner" style="background:#fff;padding:30px 20px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);text-align:center;transition:all 0.3s ease;border:2px solid transparent;height:100%;margin:10px;">
            <div class="icon-wrapper" style="width:70px;height:70px;margin:0 auto 20px;background:linear-gradient(135deg,#1abc9c,#16a085);border-radius:50%;display:flex;align-items:center;justify-content:center;">
              <i class="fa fa-star" style="font-size:28px;color:#fff;"></i>
            </div>
            <h3 style="font-size:20px;font-weight:600;color:#2c3e50;margin-bottom:15px;">Quality Assurance</h3>
            <p style="color:#7f8c8d;line-height:1.6;margin:0;">Rigorous quality checks and verified products from trusted sellers only</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<style>
.trust-feature-card:hover .trust-feature-inner {
  transform: translateY(-8px);
  box-shadow: 0 15px 35px rgba(0,0,0,0.15);
  border-color: #3498db;
}

.trust-feature-card:hover .icon-wrapper {
  transform: scale(1.1);
}

.trust-feature-card:hover h3 {
  color: #3498db;
}

@media (max-width: 768px) {
  .why-choose-section .headline h2 {
    font-size: 24px;
  }
  
  .trust-feature-inner {
    padding: 25px 15px !important;
  }
  
  .icon-wrapper {
    width: 60px !important;
    height: 60px !important;
  }
  
  .icon-wrapper i {
    font-size: 24px !important;
  }
}
</style>

<?php if($home_featured_product_on_off == 1): ?>
<div class="product pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="headline">
                    <h2><?php echo $featured_product_title; ?></h2>
                    <h3><?php echo $featured_product_subtitle; ?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="product-carousel">
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_featured=? AND p_is_active=? LIMIT ".$total_featured_product_home);
                    $statement->execute(array(1,1));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                    foreach ($result as $row) {
                        ?>
                        <div class="item">
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
                                            <span class="old-price">₹<?php echo $row['p_old_price']; ?></span>
                                        <?php endif; ?>
                                        <span class="current-price">₹<?php echo $row['p_current_price']; ?></span>
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
<?php endif; ?>


<?php if($home_latest_product_on_off == 1): ?>
<div class="product bg-gray pt_70 pb_30">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="headline">
                    <h2><?php echo $latest_product_title; ?></h2>
                    <h3><?php echo $latest_product_subtitle; ?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="product-carousel">
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=? ORDER BY p_id DESC LIMIT ".$total_latest_product_home);
                    $statement->execute(array(1));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                    foreach ($result as $row) {
                        ?>
                        <div class="item">
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
                                            <span class="old-price">₹<?php echo $row['p_old_price']; ?></span>
                                        <?php endif; ?>
                                        <span class="current-price">₹<?php echo $row['p_current_price']; ?></span>
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
<?php endif; ?>


<?php if($home_popular_product_on_off == 1): ?>
<div class="product pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="headline">
                    <h2><?php echo $popular_product_title; ?></h2>
                    <h3><?php echo $popular_product_subtitle; ?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="product-carousel">
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=? ORDER BY p_total_view DESC LIMIT ".$total_popular_product_home);
                    $statement->execute(array(1));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                    foreach ($result as $row) {
                        ?>
                        <div class="item">
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
                                            <span class="old-price">₹<?php echo $row['p_old_price']; ?></span>
                                        <?php endif; ?>
                                        <span class="current-price">₹<?php echo $row['p_current_price']; ?></span>
                                    </div>
                                    <?php if($row['p_qty'] > 0): ?>
                                        <div class="product-actions">
                                            <form class="product-action-form" data-product-id="<?php echo $row['p_id']; ?>">
                                                <input type="hidden" name="product_id" value="<?php echo $row['p_id']; ?>">
                                                <input type="hidden" name="p_qty" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm add-to-cart-btn">
<style>
.product-image { position: relative; }
.product-image.oos img { filter: grayscale(30%) brightness(0.85); }
.oos-badge { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); background:linear-gradient(135deg,#ff416c,#ff4b2b); color:#fff; padding:10px 16px; border-radius:24px; font-weight:700; letter-spacing:.4px; box-shadow:0 10px 25px rgba(255,65,108,.35); text-transform:uppercase; font-size:13px; z-index:2; pointer-events:none; }
</style>
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
<?php endif; ?>

    <div class="row" style="margin-top:20px;">
      <div class="col-md-12">
        <div class="headline" style="text-align:center;margin-bottom:20px;">
          <h2 style="margin-bottom:8px;color:var(--color-neutral-900);">CUSTOMER REVIEWS</h2>
          <p style="color:var(--color-neutral-600);">See what our satisfied customers have to say</p>
        </div>
      </div>
    </div>
    
    <section class="testimonials-section" style="padding: 20px 0 40px 0; background: linear-gradient(135deg, #f8fafc 0%, #e3f2fd 100%); position: relative; overflow: hidden;">
      <div style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(255,255,255,0.9);"></div>
      <div class="container" style="position:relative;z-index:2;">
        
        <div class="testimonials-carousel-container" style="position:relative;overflow:hidden;margin:0 -15px;">
          <div class="testimonials-carousel" id="reviewsCarousel" style="display:flex;transition:transform 0.5s ease;will-change:transform;">
            <!-- Review 1 -->
            <div class="testimonial-card" style="flex:0 0 calc(33.333% - 30px);margin:0 15px;background:#fff;padding:30px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);border-left:4px solid #3498db;position:relative;">
              <div class="rating" style="margin-bottom:20px;color:#f39c12;" aria-label="Rated 5 out of 5">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
              </div>
              <div class="quote" style="font-size:16px;line-height:1.6;color:#555;margin-bottom:20px;font-style:italic;">"Excellent product quality and lightning-fast delivery. The packaging was perfect and customer service was very responsive."</div>
              <div class="author" style="font-weight:600;color:#2c3e50;display:flex;align-items:center;">
                <div class="avatar" style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#3498db,#2980b9);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;margin-right:12px;">P</div>
                <div>
                  <div style="font-size:14px;font-weight:600;">Priya Sharma</div>
                  <div style="font-size:12px;color:#7f8c8d;">Mumbai</div>
                </div>
              </div>
            </div>

            <!-- Review 2 -->
            <div class="testimonial-card" style="flex:0 0 calc(33.333% - 30px);margin:0 15px;background:#fff;padding:30px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);border-left:4px solid #e74c3c;position:relative;">
              <div class="rating" style="margin-bottom:20px;color:#f39c12;" aria-label="Rated 5 out of 5">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
              </div>
              <div class="quote" style="font-size:16px;line-height:1.6;color:#555;margin-bottom:20px;font-style:italic;">"Great shopping experience! The checkout process was smooth and secure. Highly recommend E-martz for online shopping."</div>
              <div class="author" style="font-weight:600;color:#2c3e50;display:flex;align-items:center;">
                <div class="avatar" style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#e74c3c,#c0392b);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;margin-right:12px;">A</div>
                <div>
                  <div style="font-size:14px;font-weight:600;">Ankit Rajput</div>
                  <div style="font-size:12px;color:#7f8c8d;">Delhi</div>
                </div>
              </div>
            </div>

            <!-- Review 3 -->
            <div class="testimonial-card" style="flex:0 0 calc(33.333% - 30px);margin:0 15px;background:#fff;padding:30px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);border-left:4px solid #f39c12;position:relative;">
              <div class="rating" style="margin-bottom:20px;color:#f39c12;" aria-label="Rated 4 out of 5">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>
              </div>
              <div class="quote" style="font-size:16px;line-height:1.6;color:#555;margin-bottom:20px;font-style:italic;">"Love the variety of products and competitive prices. The return process was hassle-free when I needed to exchange an item."</div>
              <div class="author" style="font-weight:600;color:#2c3e50;display:flex;align-items:center;">
                <div class="avatar" style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#f39c12,#e67e22);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;margin-right:12px;">K</div>
                <div>
                  <div style="font-size:14px;font-weight:600;">Kavya Tiwari</div>
                  <div style="font-size:12px;color:#7f8c8d;">Bangalore</div>
                </div>
              </div>
            </div>

            <!-- Review 4 -->
            <div class="testimonial-card" style="flex:0 0 calc(33.333% - 30px);margin:0 15px;background:#fff;padding:30px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);border-left:4px solid #27ae60;position:relative;">
              <div class="rating" style="margin-bottom:20px;color:#f39c12;" aria-label="Rated 5 out of 5">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
              </div>
              <div class="quote" style="font-size:16px;line-height:1.6;color:#555;margin-bottom:20px;font-style:italic;">"Amazing customer support and fast resolution of queries. The product arrived exactly as described with excellent packaging."</div>
              <div class="author" style="font-weight:600;color:#2c3e50;display:flex;align-items:center;">
                <div class="avatar" style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#27ae60,#229954);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;margin-right:12px;">R</div>
                <div>
                  <div style="font-size:14px;font-weight:600;">Rahul Mehta</div>
                  <div style="font-size:12px;color:#7f8c8d;">Pune</div>
                </div>
              </div>
            </div>

            <!-- Review 5 -->
            <div class="testimonial-card" style="flex:0 0 calc(33.333% - 30px);margin:0 15px;background:#fff;padding:30px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);border-left:4px solid #9b59b6;position:relative;">
              <div class="rating" style="margin-bottom:20px;color:#f39c12;" aria-label="Rated 4 out of 5">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>
              </div>
              <div class="quote" style="font-size:16px;line-height:1.6;color:#555;margin-bottom:20px;font-style:italic;">"Great deals and discounts! I've been shopping here for months and always find quality products at reasonable prices."</div>
              <div class="author" style="font-weight:600;color:#2c3e50;display:flex;align-items:center;">
                <div class="avatar" style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#9b59b6,#8e44ad);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;margin-right:12px;">S</div>
                <div>
                  <div style="font-size:14px;font-weight:600;">Sneha Gupta</div>
                  <div style="font-size:12px;color:#7f8c8d;">Chennai</div>
                </div>
              </div>
            </div>

            <!-- Review 6 -->
            <div class="testimonial-card" style="flex:0 0 calc(33.333% - 30px);margin:0 15px;background:#fff;padding:30px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);border-left:4px solid #1abc9c;position:relative;">
              <div class="rating" style="margin-bottom:20px;color:#f39c12;" aria-label="Rated 5 out of 5">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
              </div>
              <div class="quote" style="font-size:16px;line-height:1.6;color:#555;margin-bottom:20px;font-style:italic;">"Secure payment options and reliable delivery service. I feel confident shopping here knowing my data is protected."</div>
              <div class="author" style="font-weight:600;color:#2c3e50;display:flex;align-items:center;">
                <div class="avatar" style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#1abc9c,#16a085);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;margin-right:12px;">V</div>
                <div>
                  <div style="font-size:14px;font-weight:600;">Vikram Singh</div>
                  <div style="font-size:12px;color:#7f8c8d;">Jaipur</div>
                </div>
              </div>
            </div>

            <!-- Review 7 -->
            <div class="testimonial-card" style="flex:0 0 calc(33.333% - 30px);margin:0 15px;background:#fff;padding:30px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);border-left:4px solid #e67e22;position:relative;">
              <div class="rating" style="margin-bottom:20px;color:#f39c12;" aria-label="Rated 4 out of 5">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>
              </div>
              <div class="quote" style="font-size:16px;line-height:1.6;color:#555;margin-bottom:20px;font-style:italic;">"User-friendly website with easy navigation. The mobile app works perfectly and makes shopping on-the-go convenient."</div>
              <div class="author" style="font-weight:600;color:#2c3e50;display:flex;align-items:center;">
                <div class="avatar" style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#e67e22,#d35400);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;margin-right:12px;">M</div>
                <div>
                  <div style="font-size:14px;font-weight:600;">Meera Patel</div>
                  <div style="font-size:12px;color:#7f8c8d;">Ahmedabad</div>
                </div>
              </div>
            </div>

            <!-- Duplicate first 3 reviews for seamless loop -->
            <div class="testimonial-card" style="flex:0 0 calc(33.333% - 30px);margin:0 15px;background:#fff;padding:30px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);border-left:4px solid #3498db;position:relative;">
              <div class="rating" style="margin-bottom:20px;color:#f39c12;" aria-label="Rated 5 out of 5">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
              </div>
              <div class="quote" style="font-size:16px;line-height:1.6;color:#555;margin-bottom:20px;font-style:italic;">"Excellent product quality and lightning-fast delivery. The packaging was perfect and customer service was very responsive."</div>
              <div class="author" style="font-weight:600;color:#2c3e50;display:flex;align-items:center;">
                <div class="avatar" style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#3498db,#2980b9);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;margin-right:12px;">P</div>
                <div>
                  <div style="font-size:14px;font-weight:600;">Priya Sharma</div>
                  <div style="font-size:12px;color:#7f8c8d;">Mumbai</div>
                </div>
              </div>
            </div>

            <div class="testimonial-card" style="flex:0 0 calc(33.333% - 30px);margin:0 15px;background:#fff;padding:30px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);border-left:4px solid #e74c3c;position:relative;">
              <div class="rating" style="margin-bottom:20px;color:#f39c12;" aria-label="Rated 5 out of 5">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
              </div>
              <div class="quote" style="font-size:16px;line-height:1.6;color:#555;margin-bottom:20px;font-style:italic;">"Great shopping experience! The checkout process was smooth and secure. Highly recommend E-martz for online shopping."</div>
              <div class="author" style="font-weight:600;color:#2c3e50;display:flex;align-items:center;">
                <div class="avatar" style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#e74c3c,#c0392b);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;margin-right:12px;">A</div>
                <div>
                  <div style="font-size:14px;font-weight:600;">Ankit Rajput</div>
                  <div style="font-size:12px;color:#7f8c8d;">Delhi</div>
                </div>
              </div>
            </div>

            <div class="testimonial-card" style="flex:0 0 calc(33.333% - 30px);margin:0 15px;background:#fff;padding:30px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.1);border-left:4px solid #f39c12;position:relative;">
              <div class="rating" style="margin-bottom:20px;color:#f39c12;" aria-label="Rated 4 out of 5">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>
              </div>
              <div class="quote" style="font-size:16px;line-height:1.6;color:#555;margin-bottom:20px;font-style:italic;">"Love the variety of products and competitive prices. The return process was hassle-free when I needed to exchange an item."</div>
              <div class="author" style="font-weight:600;color:#2c3e50;display:flex;align-items:center;">
                <div class="avatar" style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#f39c12,#e67e22);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;margin-right:12px;">K</div>
                <div>
                  <div style="font-size:14px;font-weight:600;">Kavya Tiwari</div>
                  <div style="font-size:12px;color:#7f8c8d;">Bangalore</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row" style="margin-top:40px;">
          <div class="col-md-12">
            <div class="badge-strip" style="display:flex;align-items:center;justify-content:center;gap:30px;flex-wrap:wrap;padding:20px;background:rgba(255,255,255,0.8);border-radius:8px;backdrop-filter:blur(10px);">
              <div style="font-weight:600;color:var(--color-neutral-700);">Trusted & Secure:</div>
              <div style="display:flex;align-items:center;gap:8px;color:var(--color-success);"><i class="fa fa-lock"></i> SSL Secured</div>
              <div style="display:flex;align-items:center;gap:8px;color:var(--color-success);"><i class="fa fa-shield"></i> PCI Compliant</div>
              <div style="display:flex;align-items:center;gap:8px;color:var(--color-success);"><i class="fa fa-check-circle"></i> Verified Sellers</div>
              <div style="display:flex;align-items:center;gap:8px;color:var(--color-success);"><i class="fa fa-truck"></i> Tracked Delivery</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <style>
    .testimonials-carousel-container:hover .testimonials-carousel {
      animation-play-state: paused !important;
    }

    .testimonials-carousel {
      animation: slideReviews 25s linear infinite;
    }

    @keyframes slideReviews {
      0% { transform: translateX(0); }
      100% { transform: translateX(calc(-33.333% * 7)); }
    }

    .testimonial-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
    }

    .testimonial-card .avatar {
      transition: transform 0.3s ease;
    }

    .testimonial-card:hover .avatar {
      transform: scale(1.1);
    }

    @media (max-width: 768px) {
      .testimonials-carousel {
        animation: slideReviewsMobile 30s linear infinite;
      }
      
      @keyframes slideReviewsMobile {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(-100% * 7)); }
      }
      
      .testimonial-card {
        flex: 0 0 calc(100% - 30px) !important;
        margin: 0 15px !important;
      }
      
      .badge-strip {
        gap: 15px !important;
        font-size: 14px;
      }
    }

    @media (max-width: 992px) and (min-width: 769px) {
      .testimonials-carousel {
        animation: slideReviewsTablet 20s linear infinite;
      }
      
      @keyframes slideReviewsTablet {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(-50% * 7)); }
      }
      
      .testimonial-card {
        flex: 0 0 calc(50% - 30px) !important;
      }
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const carousel = document.getElementById('reviewsCarousel');
      const container = carousel.parentElement;
      
      // Pause animation on hover
      container.addEventListener('mouseenter', function() {
        carousel.style.animationPlayState = 'paused';
      });
      
      container.addEventListener('mouseleave', function() {
        carousel.style.animationPlayState = 'running';
      });
      
      // Reset animation when it completes for seamless loop
      carousel.addEventListener('animationiteration', function() {
        carousel.style.transform = 'translateX(0)';
      });
    });
    </script>

<?php require_once('footer.php'); ?>
<script>
window.isLoggedIn = <?php echo isset($_SESSION['customer']['cust_id']) ? 'true' : 'false'; ?>;
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
  var container = document.getElementById('toast-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toast-container';
    container.style.position = 'fixed';
    container.style.top = '30px';
    container.style.right = '30px';
    container.style.zIndex = '9999';
    document.body.appendChild(container);
  }
  container.appendChild(toast);
  setTimeout(function(){ toast.remove(); }, 2500);
}
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.wishlist-heart[data-product]').forEach(function(el) {
    if(window.isLoggedIn) {
      checkWishlist(el.getAttribute('data-product'), el);
      el.addEventListener('click', function() {
        toggleWishlist(el.getAttribute('data-product'), el);
      });
    } else {
      el.addEventListener('click', function() {
        showToast('Please login to add to wishlist.', 'error');
      });
    }
  });
  // Add to Cart & Buy Now logic
  document.querySelectorAll('.product-action-form').forEach(function(form) {
    var addToCartBtn = form.querySelector('.add-to-cart-btn');
    var buyNowBtn = form.querySelector('.buy-now-btn');
    var productId = form.getAttribute('data-product-id');
    addToCartBtn.addEventListener('click', function(e) {
      e.preventDefault();
      var formData = new FormData(form);
      formData.append('action', 'add_to_cart');
      fetch('cart-action.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if(data.success) showToast('Product added to cart!');
        else showToast(data.error || 'Error', 'error');
      });
    });
    buyNowBtn.addEventListener('click', function(e) {
      e.preventDefault();
      if(!window.isLoggedIn) {
        showToast('Please login to purchase', 'error');
        setTimeout(function(){ window.location = 'login.php'; }, 1200);
        return;
      }
      var formData = new FormData(form);
      formData.append('action', 'buy_now');
      fetch('cart-action.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if(data.success && data.redirect) window.location = data.redirect;
        else showToast(data.error || 'Error', 'error');
      });
    });
  });
});
</script>