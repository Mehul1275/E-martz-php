<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_product_category = $row['banner_product_category'];
}
?>

<?php
if( !isset($_REQUEST['id']) || !isset($_REQUEST['type']) ) {
    header('location: index.php');
    exit;
} else {

    if( ($_REQUEST['type'] != 'top-category') && ($_REQUEST['type'] != 'mid-category') && ($_REQUEST['type'] != 'end-category') ) {
        header('location: index.php');
        exit;
    } else {

        $statement = $pdo->prepare("SELECT * FROM tbl_top_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $top[] = $row['tcat_id'];
            $top1[] = $row['tcat_name'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $mid[] = $row['mcat_id'];
            $mid1[] = $row['mcat_name'];
            $mid2[] = $row['tcat_id'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_end_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $end[] = $row['ecat_id'];
            $end1[] = $row['ecat_name'];
            $end2[] = $row['mcat_id'];
        }

        if($_REQUEST['type'] == 'top-category') {
            if(!in_array($_REQUEST['id'],$top)) {
                header('location: index.php');
                exit;
            } else {

                // Getting Title
                for ($i=0; $i < count($top); $i++) { 
                    if($top[$i] == $_REQUEST['id']) {
                        $title = $top1[$i];
                        break;
                    }
                }
                $arr1 = array();
                $arr2 = array();
                // Find out all ecat ids under this
                for ($i=0; $i < count($mid); $i++) { 
                    if($mid2[$i] == $_REQUEST['id']) {
                        $arr1[] = $mid[$i];
                    }
                }
                for ($j=0; $j < count($arr1); $j++) {
                    for ($i=0; $i < count($end); $i++) { 
                        if($end2[$i] == $arr1[$j]) {
                            $arr2[] = $end[$i];
                        }
                    }   
                }
                $final_ecat_ids = $arr2;
            }   
        }

        if($_REQUEST['type'] == 'mid-category') {
            if(!in_array($_REQUEST['id'],$mid)) {
                header('location: index.php');
                exit;
            } else {
                // Getting Title
                for ($i=0; $i < count($mid); $i++) { 
                    if($mid[$i] == $_REQUEST['id']) {
                        $title = $mid1[$i];
                        break;
                    }
                }
                $arr2 = array();        
                // Find out all ecat ids under this
                for ($i=0; $i < count($end); $i++) { 
                    if($end2[$i] == $_REQUEST['id']) {
                        $arr2[] = $end[$i];
                    }
                }
                $final_ecat_ids = $arr2;
            }
        }

        if($_REQUEST['type'] == 'end-category') {
            if(!in_array($_REQUEST['id'],$end)) {
                header('location: index.php');
                exit;
            } else {
                // Getting Title
                for ($i=0; $i < count($end); $i++) { 
                    if($end[$i] == $_REQUEST['id']) {
                        $title = $end1[$i];
                        break;
                    }
                }
                $final_ecat_ids = array($_REQUEST['id']);
            }
        }
        
    }   
}
?>

<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php require_once('sidebar-category.php'); ?>
            </div>
            <div class="col-md-9">
                <div class="category-header">
                    <h1 style="color: var(--color-neutral-900); margin-bottom: 8px; font-weight: 600;">
                        <?php echo LANG_VALUE_50; ?> <?php echo $title; ?>
                    </h1>
                    
                    <?php
                    $filter_info = [];
                    $min_price = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float)$_GET['min_price'] : null;
                    $max_price = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float)$_GET['max_price'] : null;
                    
                    if ($min_price !== null || $max_price !== null) {
                        if ($min_price !== null && $max_price !== null) {
                            $filter_info[] = "Price: ₹{$min_price} - ₹{$max_price}";
                        } elseif ($min_price !== null) {
                            $filter_info[] = "Price: Above ₹{$min_price}";
                        } elseif ($max_price !== null) {
                            $filter_info[] = "Price: Under ₹{$max_price}";
                        }
                    }
                    
                    if (!empty($filter_info)) {
                        echo '<div class="active-filters" style="margin: 10px 0; padding: 10px; background: #f0f8ff; border: 1px solid #d6e9ff; border-radius: 6px;">';
                        echo '<i class="fa fa-filter" style="color: var(--color-primary); margin-right: 8px;"></i>';
                        echo '<strong>Active Filters:</strong> ' . implode(', ', $filter_info);
                        echo ' <a href="?' . http_build_query(array_diff_key($_GET, array_flip(['min_price', 'max_price']))) . '" style="color: #ff4757; margin-left: 10px; text-decoration: none;"><i class="fa fa-times"></i> Clear Filters</a>';
                        echo '</div>';
                    }
                    ?>
                    
                    <p class="text-muted">Discover our curated selection of quality products</p>
                    
                </div>
                
                <div class="products-grid">
                    <div class="row">
                        <?php
                        // Price filtering
                        $min_price = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float)$_GET['min_price'] : null;
                        $max_price = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float)$_GET['max_price'] : null;
                        
                        // Build price filter SQL
                        $price_filter = '';
                        $price_params = [];
                        
                            if ($min_price !== null || $max_price !== null) {
                                if ($min_price !== null && $max_price !== null) {
                                    $price_filter = ' AND CAST(p_current_price AS DECIMAL(10,2)) BETWEEN ? AND ?';
                                    $price_params = [$min_price, $max_price];
                                } elseif ($min_price !== null) {
                                    $price_filter = ' AND CAST(p_current_price AS DECIMAL(10,2)) >= ?';
                                    $price_params = [$min_price];
                                } elseif ($max_price !== null) {
                                    $price_filter = ' AND CAST(p_current_price AS DECIMAL(10,2)) <= ?';
                                    $price_params = [$max_price];
                                }
                            }
                        
                        // Collect all products that match the criteria
                        $all_products = [];
                        
                        for($ii=0; $ii<count($final_ecat_ids); $ii++) {
                            $sql = "SELECT * FROM tbl_product WHERE ecat_id=? AND p_is_active=?" . $price_filter . " ORDER BY p_current_price ASC";
                            $statement = $pdo->prepare($sql);
                            $params = array_merge([$final_ecat_ids[$ii], 1], $price_params);
                            $statement->execute($params);
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            
                            // Add products to our collection
                            foreach ($result as $row) {
                                $all_products[] = $row;
                            }
                        }
                        
                        // Check if any products found
                        if(count($all_products) == 0) {
                            $no_products_message = LANG_VALUE_153;
                            if ($min_price !== null || $max_price !== null) {
                                $no_products_message = 'No products found in the selected price range.';
                            }
                            echo '<div class="col-md-12"><div class="alert alert-info"><i class="fa fa-info-circle"></i> ' . $no_products_message . '</div></div>';
                        } else {
                            // Display all collected products
                            foreach ($all_products as $row) {
                                    ?>
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
                                } // End foreach ($all_products as $row)
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>

<div id="toast-container" style="position:fixed;top:30px;right:30px;z-index:9999;"></div>

<style>
.product-image { position: relative; }
.product-image.oos img { filter: grayscale(30%) brightness(0.85); }
.oos-badge {
  position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
  background: linear-gradient(135deg,#ff416c 0%, #ff4b2b 100%);
  color:#fff; padding:10px 16px; border-radius:24px; font-weight:700;
  letter-spacing:.4px; box-shadow:0 10px 25px rgba(255,65,108,.35);
  text-transform: uppercase; font-size:13px; z-index: 2; pointer-events: none;
}
</style>

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
    checkWishlist(el.getAttribute('data-product'), el);
    el.addEventListener('click', function() {
      toggleWishlist(el.getAttribute('data-product'), el);
    });
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