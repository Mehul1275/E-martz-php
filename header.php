<?php
declare(strict_types=1);
// This is main configuration File

// Start output buffering and session
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include configuration files
require_once("admin/inc/config.php");
require_once("admin/inc/functions.php");
require_once("admin/inc/CSRF_Protect.php");

// Initialize CSRF protection
$csrf = new CSRF_Protect();

// Initialize message variables
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Getting all language variables into array as global variable
$i = 1;
$statement = $pdo->prepare("SELECT * FROM tbl_language");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	define('LANG_VALUE_'.$i, $row['lang_value']);
	$i++;
}

// Get settings
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$logo = $row['logo'];
	$favicon = $row['favicon'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
	$meta_title_home = $row['meta_title_home'];
    $meta_keyword_home = $row['meta_keyword_home'];
    $meta_description_home = $row['meta_description_home'];
    $before_head = $row['before_head'];
    $after_body = $row['after_body'];
}

// Checking the order table and removing the pending transaction that are 24 hours+ old. Very important
$current_date_time = date('Y-m-d H:i:s');
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(['Pending']);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$ts1 = strtotime($row['payment_date']);
	$ts2 = strtotime($current_date_time);     
	$diff = $ts2 - $ts1;
	$time = $diff/(3600);
	if($time > 24) {

		// Return back the stock amount
		$statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
		$statement1->execute([$row['payment_id']]);
		$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result1 as $row1) {
			$statement2 = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
			$statement2->execute([$row1['product_id']]);
			$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result2 as $row2) {
				$p_qty = $row2['p_qty'];
			}
			$final = $p_qty + $row1['quantity'];

			$statement = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
			$statement->execute([$final, $row1['product_id']]);
		}
		
		// Deleting data from table
		$statement1 = $pdo->prepare("DELETE FROM tbl_order WHERE payment_id=?");
		$statement1->execute([$row['payment_id']]);

		$statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE id=?");
		$statement1->execute([$row['id']]);
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Meta Tags -->
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="assets/uploads/<?php echo htmlspecialchars($favicon, ENT_QUOTES, 'UTF-8'); ?>">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
	<link rel="stylesheet" href="assets/css/jquery.bxslider.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/rating.css">
	<link rel="stylesheet" href="assets/css/spacing.css">
	<link rel="stylesheet" href="assets/css/bootstrap-touch-slider.css">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/tree-menu.css">
	<link rel="stylesheet" href="assets/css/select2.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/responsive.css">

	<!-- Corporate theme fonts and overrides -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/corporate.css">

	<?php

	$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$about_meta_title = $row['about_meta_title'];
		$about_meta_keyword = $row['about_meta_keyword'];
		$about_meta_description = $row['about_meta_description'];
		$faq_meta_title = $row['faq_meta_title'];
		$faq_meta_keyword = $row['faq_meta_keyword'];
		$faq_meta_description = $row['faq_meta_description'];
		$blog_meta_title = $row['blog_meta_title'];
		$blog_meta_keyword = $row['blog_meta_keyword'];
		$blog_meta_description = $row['blog_meta_description'];
		$contact_meta_title = $row['contact_meta_title'];
		$contact_meta_keyword = $row['contact_meta_keyword'];
		$contact_meta_description = $row['contact_meta_description'];
		$pgallery_meta_title = $row['pgallery_meta_title'];
		$pgallery_meta_keyword = $row['pgallery_meta_keyword'];
		$pgallery_meta_description = $row['pgallery_meta_description'];
		$vgallery_meta_title = $row['vgallery_meta_title'];
		$vgallery_meta_keyword = $row['vgallery_meta_keyword'];
		$vgallery_meta_description = $row['vgallery_meta_description'];
	}

	$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	
	if($cur_page == 'index.php' || $cur_page == 'login.php' || $cur_page == 'registration.php' || $cur_page == 'cart.php' || $cur_page == 'checkout.php' || $cur_page == 'forget-password.php' || $cur_page == 'reset-password.php' || $cur_page == 'product-category.php' || $cur_page == 'product.php') {
		?>
		<title><?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}

	if($cur_page == 'about.php') {
		?>
		<title><?php echo $about_meta_title; ?></title>
		<meta name="keywords" content="<?php echo $about_meta_keyword; ?>">
		<meta name="description" content="<?php echo $about_meta_description; ?>">
		<?php
	}
	if($cur_page == 'faq.php') {
		?>
		<title><?php echo $faq_meta_title; ?></title>
		<meta name="keywords" content="<?php echo $faq_meta_keyword; ?>">
		<meta name="description" content="<?php echo $faq_meta_description; ?>">
		<?php
	}
	if($cur_page == 'contact.php') {
		?>
		<title><?php echo $contact_meta_title; ?></title>
		<meta name="keywords" content="<?php echo $contact_meta_keyword; ?>">
		<meta name="description" content="<?php echo $contact_meta_description; ?>">
		<?php
	}
	if($cur_page == 'product.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) 
		{
		    $og_photo = $row['p_featured_photo'];
		    $og_title = $row['p_name'];
		    $og_slug = 'product.php?id='.$_REQUEST['id'];
			$og_description = substr(strip_tags($row['p_description']),0,200).'...';
		}
	}

	if($cur_page == 'dashboard.php') {
		?>
		<title>Dashboard - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'customer-profile-update.php') {
		?>
		<title>Update Profile - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'customer-billing-shipping-update.php') {
		?>
		<title>Update Billing and Shipping Info - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'customer-password-update.php') {
		?>
		<title>Update Password - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'customer-order.php') {
		?>
		<title>Orders - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	?>
	
	<?php if($cur_page == 'blog-single.php'): ?>
		<meta property="og:title" content="<?php echo $og_title; ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo BASE_URL.$og_slug; ?>">
		<meta property="og:description" content="<?php echo $og_description; ?>">
		<meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
	<?php endif; ?>

	<?php if($cur_page == 'product.php'): ?>
		<meta property="og:title" content="<?php echo $og_title; ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo BASE_URL.$og_slug; ?>">
		<meta property="og:description" content="<?php echo $og_description; ?>">
		<meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
	<?php endif; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Select2 JS -->
    <script src="assets/js/select2.min.js"></script>

    <!-- <script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5993ef01e2587a001253a261&product=inline-share-buttons"></script> -->

<?php echo $before_head; ?>

</head>
<body>

<?php echo $after_body; ?>

<div id="preloader">
	<div id="status"></div>
</div>

<!-- top bar -->

<style>
/* Enhanced Account Dropdown */
.header-actions { position: relative; }
.header-actions > div { position: relative; }
.header-actions #accountDropdown { cursor: pointer; font-weight: 500; }

/* Reset and scope dropdown so header/menu styles don't leak in */
.header-actions .account-dropdown {
  display: none;
  position: absolute;
  right: 0;
  top: calc(100% + 8px);
  background: #fff;
  border: 1px solid #e0e0e0;
  box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  min-width: 230px;
  z-index: 3001; /* above header and nav */
  padding: 10px 0;
  list-style: none;
  border-radius: 8px;
}
.header-actions .account-dropdown li { padding: 0; float: none; }
.header-actions .account-dropdown li a {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  color: #222;
  text-decoration: none;
  font-size: 15px;
  white-space: nowrap;
}
.header-actions .account-dropdown li a:hover { background: #f5f5f5; color: #007bff; }
.header-actions .account-dropdown li:not(:last-child) a { border-bottom: 1px solid #f0f0f0; }

/* Make logo bigger but keep header slim */
.header-logo {
  display: flex;
  align-items: center;
  height: 64px;
  min-width: 120px;
}
.header-logo img {
  max-height: 60px !important;
  max-width: 180px;
  width: auto;
  height: 60px;
  object-fit: contain;
  display: block;
}
@media (max-width: 600px) {
  .header-logo img { max-height: 40px !important; height: 40px; max-width: 120px; }
  .header-logo { height: 44px; }
}
.header-row {
  min-height: 64px;
  height: 64px;
  align-items: center;
}

/* Sticky header */
.header {
  position: sticky;
  top: 0;
  z-index: 1020;
  background: #fff;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  overflow: visible; /* allow dropdowns to escape */
}
@supports not (position: sticky) {
  .header {
    position: fixed;
    width: 100%;
    left: 0;
    right: 0;
  }
}
</style>
<style>
/* --- Category Menu: vertical mid-level dropdowns & tidy submenu --- */
.menu ul { list-style: none; margin: 0; padding: 0; }
.menu > ul > li { position: relative; }

/* Level-2 (mid category) dropdown */
.menu > ul > li > ul {
  position: absolute;
  top: 100%;
  left: 0;
  display: none;
  background: #0f1d3a; /* dark to match theme */
  min-width: 240px;
  padding: 8px 0;
  border-radius: 6px;
  box-shadow: 0 10px 24px rgba(0,0,0,.25);
  z-index: 1500; /* below account dropdown but above content */
}
.menu > ul > li:hover > ul { display: block; }
.menu > ul > li > ul > li { position: relative; display: block; white-space: nowrap; }
.menu > ul > li > ul > li > a { display: block; padding: 10px 16px; color: #fff; text-decoration: none; }
.menu > ul > li > ul > li > a:hover { background: rgba(255,255,255,.08); }

/* Level-3 (end category) dropdown opens to the right */
.menu > ul > li > ul > li > ul {
  position: absolute;
  top: 0;
  left: 100%;
  display: none;
  background: #0f1d3a;
  min-width: 240px;
  padding: 8px 0;
  border-radius: 6px;
  box-shadow: 0 10px 24px rgba(0,0,0,.25);
  z-index: 1500;
}
.menu > ul > li > ul > li:hover > ul { display: block; }

/* Ensure no accidental multi-column layout from inherited styles */
.menu > ul > li > ul > li,
.menu > ul > li > ul > li > ul > li { float: none; }

/* Sidebar category tree cleanup */
.nav.menu > li > a { display: flex; align-items: center; gap: 8px; padding: 8px 10px; text-decoration: none; }
.nav.menu .lbl { font-weight: 600; }
.nav.menu .lbl1 { font-weight: 500; }
.nav.menu .children { margin-left: 14px; border-left: 1px solid #eee; padding-left: 10px; }
.nav.menu .sign { width: 18px; display: inline-block; text-align: center; color: #777; }
</style>

<div class="header" style="background:#fff;">
	<div class="container">
		<div class="header-row" style="display:flex;align-items:center;justify-content:space-between;gap:24px;padding:10px 0;">
			<!-- Logo -->
			<div class="header-logo" style="flex:0 0 auto;">
				<a href="index.php"><img src="assets/uploads/<?php echo $logo; ?>" alt="logo image"></a>
			</div>

			<!-- Search Bar -->
			<div class="header-search" style="flex:1 1 0;max-width:600px;">
				<form class="navbar-form navbar-left" role="search" action="search-result.php" method="get" style="display:flex;width:100%;">
					<?php $csrf->echoInputField(); ?>
					<input type="text" class="form-control search-top" placeholder="<?php echo LANG_VALUE_2; ?>" name="search_text" style="flex:1 1 0;width:1%;min-width:0;">
					<button type="submit" class="btn btn-primary" style="margin-left:5px;">Search</button>
				</form>
			</div>

			<!-- Right Side: Wishlist, Cart, Account -->
			<div class="header-actions" style="flex:0 0 auto;display:flex;align-items:center;gap:24px;">
				<a href="wishlist.php" style="display:flex;align-items:center;gap:4px;text-decoration:none;color:inherit;"><i class="fa fa-heart"></i> <span style="display:none;display:inline;">Wishlist</span></a>
				<a href="cart.php" style="display:flex;align-items:center;gap:4px;text-decoration:none;color:inherit;"><i class="fa fa-shopping-cart"></i> <span style="display:none;display:inline;">Cart</span></a>
				<div style="position:relative;">
					<?php if(isset($_SESSION['customer'])): ?>
						<a href="dashboard.php" id="accountDropdown" style="display:flex;align-items:center;gap:4px;text-decoration:none;color:inherit;">
							<i class="fa fa-user"></i> Account <i class="fa fa-caret-down"></i>
						</a>
                        <ul class="account-dropdown">
							<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
							<li><a href="customer-order.php"><i class="fa fa-list"></i> Orders</a></li>
							<li><a href="track-order.php"><i class="fa fa-truck"></i> Track Order</a></li>
							<li><a href="cart.php"><i class="fa fa-shopping-cart"></i> Cart</a></li>
							<li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
						</ul>
					<?php elseif(isset($_SESSION['seller'])): ?>
						<a href="#" id="accountDropdown" style="display:flex;align-items:center;gap:4px;text-decoration:none;color:inherit;">
							<i class="fa fa-user"></i> Seller <i class="fa fa-caret-down"></i>
						</a>
                        <ul class="account-dropdown">
							<li><a href="seller-dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
							<li><a href="seller-profile.php"><i class="fa fa-user"></i> Profile</a></li>
							<li><a href="seller-logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
						</ul>
					<?php else: ?>
						<a href="login.php" style="display:flex;align-items:center;gap:4px;text-decoration:none;color:inherit;"><i class="fa fa-user"></i> Customer Login</a>
						<!-- Seller Login button removed -->
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
// Account dropdown: hover + click toggle, closes on outside click
(function(){
    var accDrop = document.getElementById('accountDropdown');
    if (!accDrop) return;
    var parent = accDrop.parentElement;
    var dropdown = accDrop.nextElementSibling;
    var hideTimer = null;

    function openMenu(){
        if (hideTimer) { clearTimeout(hideTimer); hideTimer = null; }
        dropdown.style.display = 'block';
    }
    function closeMenu(){
        dropdown.style.display = 'none';
    }
    function scheduleHide(){
        if (hideTimer) { clearTimeout(hideTimer); }
        hideTimer = setTimeout(closeMenu, 150);
    }

    // Hover behavior (desktop-like)
    parent.addEventListener('mouseenter', openMenu);
    parent.addEventListener('mouseleave', scheduleHide);
    dropdown.addEventListener('mouseenter', openMenu);
    dropdown.addEventListener('mouseleave', scheduleHide);

    // Click toggle (mobile/keyboard)
    accDrop.addEventListener('click', function(e){
        e.preventDefault();
        if (dropdown.style.display === 'block') { closeMenu(); }
        else { openMenu(); }
    });

    // Close on outside click
    document.addEventListener('click', function(e){
        if (!parent.contains(e.target)) { closeMenu(); }
    });
})();
</script>

<!-- Mobile Navigation Toggle -->
<button class="mobile-nav-toggle" onclick="toggleMobileNav()">
    <i class="fa fa-bars"></i> Categories
</button>

<div class="nav" id="mainNav" style="overflow: visible;">
	<div class="container">
		<div class="row">
			<div class="col-md-12 pl_0 pr_0">
                <div class="menu-container" style="overflow: visible;">
                    <div class="menu" style="overflow: visible;">
						<ul>
							<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
							
							<?php
							$statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							
							// Category icons mapping
							$category_icons = [
								'Men' => 'fa-male',
								'Women' => 'fa-female', 
								'Kids' => 'fa-child',
								'Electronics' => 'fa-laptop',
								'Health and Household' => 'fa-medkit',
								'Sports' => 'fa-futbol-o',
								'Books' => 'fa-book',
								'Fashion' => 'fa-shopping-bag',
								'Home' => 'fa-home',
								'Beauty' => 'fa-heart'
							];
							
							foreach ($result as $row) {
								$icon_class = isset($category_icons[$row['tcat_name']]) ? $category_icons[$row['tcat_name']] : 'fa-tag';
								?>
								<li><a href="product-category.php?id=<?php echo $row['tcat_id']; ?>&type=top-category">
									<i class="fa <?php echo $icon_class; ?>"></i> <?php echo $row['tcat_name']; ?>
								</a>
									<ul>
										<?php
										$statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
										$statement1->execute(array($row['tcat_id']));
										$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
										foreach ($result1 as $row1) {
											?>
											<li><a href="product-category.php?id=<?php echo $row1['mcat_id']; ?>&type=mid-category"><?php echo $row1['mcat_name']; ?></a>
												<ul>
													<?php
													$statement2 = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=?");
													$statement2->execute(array($row1['mcat_id']));
													$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
													foreach ($result2 as $row2) {
														?>
														<li><a href="product-category.php?id=<?php echo $row2['ecat_id']; ?>&type=end-category"><?php echo $row2['ecat_name']; ?></a></li>
														<?php
													}
													?>
												</ul>
											</li>
											<?php
										}
										?>
									</ul>
								</li>
								<?php
								// Insert Top Brands dropdown immediately after "Health and Household"
								if ($row['tcat_name'] === 'Health and Household') {
									?>
									<li><a href="#"><i class="fa fa-certificate"></i> Top Brands</a>
										<ul>
											<?php
											try {
												$brandStmtMenu = $pdo->prepare("SELECT id, company_name FROM sellers WHERE status = 1 AND email_verified = 1 ORDER BY company_name ASC LIMIT 20");
												$brandStmtMenu->execute();
												$menuBrands = $brandStmtMenu->fetchAll(PDO::FETCH_ASSOC);
												foreach ($menuBrands as $b) {
													?>
													<li><a href="seller-store.php?id=<?php echo (int)$b['id']; ?>"><?php echo htmlspecialchars($b['company_name'], ENT_QUOTES, 'UTF-8'); ?></a></li>
													<?php
												}
											} catch (Exception $e) {
												?>
												<li><a href="#">No brands available</a></li>
												<?php
											}
											?>
										</ul>
									</li>
									<?php
								}
								?>
							<?php
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
function toggleMobileNav() {
    const nav = document.getElementById('mainNav');
    if (nav.style.display === 'none' || nav.style.display === '') {
        nav.style.display = 'block';
    } else {
        nav.style.display = 'none';
    }
}

// Close mobile nav when clicking outside
document.addEventListener('click', function(event) {
    const nav = document.getElementById('mainNav');
    const toggle = document.querySelector('.mobile-nav-toggle');
    
    if (!nav.contains(event.target) && !toggle.contains(event.target)) {
        if (window.innerWidth <= 768) {
            nav.style.display = 'none';
        }
    }
});

// Handle window resize
window.addEventListener('resize', function() {
    const nav = document.getElementById('mainNav');
    if (window.innerWidth > 768) {
        nav.style.display = 'block';
    } else {
        nav.style.display = 'none';
    }
});
</script>