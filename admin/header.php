<?php
declare(strict_types=1);

// Start output buffering and session
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include configuration files
require_once("inc/config.php");
require_once("inc/functions.php");
require_once("inc/CSRF_Protect.php");

// Initialize CSRF protection
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Check if the user is logged in or not
if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Panel</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<!-- Favicon -->
	<link rel="icon" type="image/ico" href="../assets/img/favicon.ico">
	<link rel="shortcut icon" type="image/ico" href="../assets/img/favicon.ico">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	
	<!-- Core CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/on-off-switch.css"/>
	<link rel="stylesheet" href="css/summernote.css">
	<link rel="stylesheet" href="style.css">
	
	<!-- Modern Admin CSS -->
	<link rel="stylesheet" href="css/modern-admin.css">
	
	<!-- Chart.js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<style>
	.modern-main-header {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		border-bottom: none;
		box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
		height: 70px;
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		width: 100%;
		display: flex;
		align-items: center;
		z-index: 1030;
	}

	/* Sidebar adjustments */
	.main-sidebar {
		position: fixed;
		top: 20px;
		left: 0;
		height: calc(100vh - 70px);
		z-index: 1020;
	}

	/* Content wrapper adjustments */
	.content-wrapper {
		margin-left: 230px;
		margin-top: 70px;
		min-height: calc(100vh - 70px);
	}

	/* Logo behavior when sidebar is collapsed */
	.sidebar-collapse .modern-logo {
		margin: 0;
		width: 50px;
		justify-content: center;
	}

	.sidebar-collapse .modern-logo .modern-logo-text {
		font-size: 0;
	}

	.sidebar-collapse .modern-logo .modern-logo-text i {
		font-size: 1.2rem;
	}

	/* Adjust header layout when sidebar is collapsed */
	.sidebar-collapse .modern-main-header {
		padding-left: 0;
	}

	.sidebar-collapse .modern-navbar {
		margin-left: 50px;
	}

	/* Adjust content wrapper when sidebar is collapsed */
	.sidebar-collapse .content-wrapper {
		margin-left: 50px;
	}

	.modern-logo {
		background: rgba(255, 255, 255, 0.1);
		border-right: 1px solid rgba(255, 255, 255, 0.2);
		height: 70px;
		display: flex;
		align-items: center;
		justify-content: center;
		width: 230px;
		transition: all 0.3s ease;
	}

	.modern-logo:hover {
		background: rgba(255, 255, 255, 0.15);
	}

	.modern-logo-text {
		color: white;
		font-size: 1.8rem;
		font-weight: 700;
		text-decoration: none;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.modern-navbar {
		background: transparent;
		border: none;
		height: 70px;
		flex: 1;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 0 20px;
	}

	.modern-sidebar-toggle {
		color: white;
		font-size: 1.2rem;
		padding: 10px;
		border-radius: 8px;
		transition: all 0.3s ease;
		background: rgba(255, 255, 255, 0.1);
		border: 1px solid rgba(255, 255, 255, 0.2);
		text-decoration: none;
	}

	.modern-sidebar-toggle:hover {
		background: rgba(255, 255, 255, 0.2);
		color: white;
		text-decoration: none;
	}

	.modern-header-title {
		color: white;
		font-size: 1.3rem;
		font-weight: 600;
		margin: 0;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.modern-user-menu {
		position: relative;
	}

	.modern-user-dropdown {
		display: flex;
		align-items: center;
		gap: 12px;
		color: white;
		text-decoration: none;
		padding: 8px 15px;
		border-radius: 25px;
		background: rgba(255, 255, 255, 0.1);
		border: 1px solid rgba(255, 255, 255, 0.2);
		transition: all 0.3s ease;
		backdrop-filter: blur(10px);
	}

	.modern-user-dropdown:hover {
		background: rgba(255, 255, 255, 0.2);
		color: white;
		text-decoration: none;
		transform: translateY(-1px);
		box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
	}

	.modern-user-avatar {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		border: 2px solid rgba(255, 255, 255, 0.3);
		object-fit: cover;
	}

	.modern-user-info {
		display: flex;
		flex-direction: column;
		align-items: flex-start;
	}

	.modern-user-name {
		font-weight: 600;
		font-size: 0.95rem;
		line-height: 1.2;
	}

	.modern-user-role {
		font-size: 0.8rem;
		opacity: 0.8;
		line-height: 1;
	}

	.modern-dropdown-arrow {
		font-size: 0.8rem;
		opacity: 0.7;
		transition: transform 0.3s ease;
	}

	.modern-user-dropdown.open .modern-dropdown-arrow {
		transform: rotate(180deg);
	}

	.modern-dropdown-menu {
		position: absolute;
		top: 100%;
		right: 0;
		background: white;
		border-radius: 12px;
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
		border: 1px solid #e3e6f0;
		min-width: 200px;
		margin-top: 8px;
		opacity: 0;
		visibility: hidden;
		transform: translateY(-10px);
		transition: all 0.3s ease;
		z-index: 1000;
	}

	.modern-dropdown-menu.show {
		opacity: 1;
		visibility: visible;
		transform: translateY(0);
	}

	.modern-dropdown-header {
		padding: 15px 20px;
		border-bottom: 1px solid #f1f5f9;
		text-align: center;
	}

	.modern-dropdown-avatar {
		width: 50px;
		height: 50px;
		border-radius: 50%;
		margin: 0 auto 8px;
		display: block;
		border: 3px solid #667eea;
	}

	.modern-dropdown-name {
		font-weight: 600;
		color: #1e293b;
		margin-bottom: 2px;
	}

	.modern-dropdown-email {
		font-size: 0.85rem;
		color: #64748b;
	}

	.modern-dropdown-item {
		display: block;
		padding: 12px 20px;
		color: #475569;
		text-decoration: none;
		transition: all 0.3s ease;
		display: flex;
		align-items: center;
		gap: 10px;
		font-weight: 500;
	}

	.modern-dropdown-item:hover {
		background: #f8fafc;
		color: #667eea;
		text-decoration: none;
	}

	.modern-dropdown-item i {
		width: 16px;
		text-align: center;
	}

	.modern-dropdown-divider {
		height: 1px;
		background: #f1f5f9;
		margin: 8px 0;
	}

	@media (max-width: 768px) {
		.modern-logo {
			width: 60px;
		}
		
		.modern-logo-text {
			font-size: 1.2rem;
		}
		
		.modern-header-title {
			display: none;
		}
		
		.modern-user-info {
			display: none;
		}
	}
	</style>

</head>

<body class="hold-transition fixed skin-blue sidebar-mini">

	<div class="wrapper">

		<header class="modern-main-header">
			<div class="modern-logo">
				<a href="index.php" class="modern-logo-text">
					<i class="fa fa-shopping-bag" style="margin-left: 15px;"></i>
					E-martz
				</a>
			</div>

			<nav class="modern-navbar">
				<div style="display: flex; align-items: center; gap: 20px;">
					<a href="#" class="modern-sidebar-toggle" data-toggle="offcanvas" role="button">
						<i class="fa fa-bars"></i>
					</a>
					<h1 class="modern-header-title">
						<i class="fa fa-tachometer"></i>
						Admin Panel
					</h1>
				</div>

				<div class="modern-user-menu">
					<a href="#" class="modern-user-dropdown" onclick="toggleUserDropdown(event)">
						<img src="../assets/uploads/<?php echo htmlspecialchars(isset($_SESSION['user']['photo']) && $_SESSION['user']['photo'] ? $_SESSION['user']['photo'] : 'user-1.png', ENT_QUOTES, 'UTF-8'); ?>" class="modern-user-avatar" alt="User Avatar">
						<div class="modern-user-info">
							<div class="modern-user-name">
								<?php echo htmlspecialchars(isset($_SESSION['user']['full_name']) ? $_SESSION['user']['full_name'] : 'Administrator', ENT_QUOTES, 'UTF-8'); ?>
							</div>
							<div class="modern-user-role">Administrator</div>
						</div>
						<i class="fa fa-chevron-down modern-dropdown-arrow"></i>
					</a>
					
					<div class="modern-dropdown-menu" id="userDropdownMenu">
						<div class="modern-dropdown-header">
							<img src="../assets/uploads/<?php echo htmlspecialchars(isset($_SESSION['user']['photo']) && $_SESSION['user']['photo'] ? $_SESSION['user']['photo'] : 'user-1.png', ENT_QUOTES, 'UTF-8'); ?>" class="modern-dropdown-avatar" alt="User Avatar">
							<div class="modern-dropdown-name">
								<?php echo htmlspecialchars(isset($_SESSION['user']['full_name']) ? $_SESSION['user']['full_name'] : 'Administrator', ENT_QUOTES, 'UTF-8'); ?>
							</div>
							<div class="modern-dropdown-email">
								<?php echo htmlspecialchars($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8'); ?>
							</div>
						</div>
						<a href="profile-edit.php" class="modern-dropdown-item">
							<i class="fa fa-user"></i>
							Edit Profile
						</a>
						<a href="settings.php" class="modern-dropdown-item">
							<i class="fa fa-cog"></i>
							Settings
						</a>
						<div class="modern-dropdown-divider"></div>
						<a href="logout.php" class="modern-dropdown-item">
							<i class="fa fa-sign-out"></i>
							Log Out
						</a>
					</div>
				</div>
			</nav>
		</header>

		<script>
		function toggleUserDropdown(event) {
			event.preventDefault();
			const dropdown = document.getElementById('userDropdownMenu');
			const toggle = event.currentTarget;
			
			dropdown.classList.toggle('show');
			toggle.classList.toggle('open');
		}

		// Close dropdown when clicking outside
		document.addEventListener('click', function(event) {
			const dropdown = document.getElementById('userDropdownMenu');
			const toggle = document.querySelector('.modern-user-dropdown');
			
			if (!toggle.contains(event.target)) {
				dropdown.classList.remove('show');
				toggle.classList.remove('open');
			}
		});
		</script>

  		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); ?>
<!-- Side Bar to Manage Shop Activities -->
  		<aside class="main-sidebar">
    		<section class="sidebar">
      
      			<ul class="sidebar-menu">

    <!-- 1. Dashboard -->
    <li class="treeview <?php if($cur_page == 'index.php') {echo 'active';} ?>">
      <a href="index.php">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
    </li>

    <!-- 2. Website Settings -->
    <li class="treeview <?php if( ($cur_page == 'settings.php') ) {echo 'active';} ?>">
      <a href="settings.php">
        <i class="fa fa-sliders"></i> <span>Website Settings</span>
      </a>
    </li>

    <!-- 3. Shop Settings -->
    <li class="treeview <?php if( ($cur_page == 'size.php') || ($cur_page == 'size-add.php') || ($cur_page == 'size-edit.php') || ($cur_page == 'color.php') || ($cur_page == 'color-add.php') || ($cur_page == 'color-edit.php') || ($cur_page == 'country.php') || ($cur_page == 'country-add.php') || ($cur_page == 'country-edit.php') || ($cur_page == 'shipping-cost.php') || ($cur_page == 'shipping-cost-edit.php') || ($cur_page == 'top-category.php') || ($cur_page == 'top-category-add.php') || ($cur_page == 'top-category-edit.php') || ($cur_page == 'mid-category.php') || ($cur_page == 'mid-category-add.php') || ($cur_page == 'mid-category-edit.php') || ($cur_page == 'end-category.php') || ($cur_page == 'end-category-add.php') || ($cur_page == 'end-category-edit.php') ) {echo 'active';} ?>">
        <a href="#">
            <i class="fa fa-cogs"></i>
            <span>Shop Settings</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="size.php"><i class="fa fa-circle-o"></i> Size</a></li>
            <li><a href="color.php"><i class="fa fa-circle-o"></i> Color</a></li>
            <li><a href="country.php"><i class="fa fa-circle-o"></i> Country</a></li>
            <li><a href="shipping-cost.php"><i class="fa fa-circle-o"></i> Shipping Cost</a></li>
            <li><a href="top-category.php"><i class="fa fa-circle-o"></i> Top Level Category</a></li>
            <li><a href="mid-category.php"><i class="fa fa-circle-o"></i> Mid Level Category</a></li>
            <li><a href="end-category.php"><i class="fa fa-circle-o"></i> End Level Category</a></li>
        </ul>
    </li>

    <!-- 4. Product Management -->
    <li class="treeview <?php if( ($cur_page == 'product.php') || ($cur_page == 'product-add.php') || ($cur_page == 'product-edit.php') ) {echo 'active';} ?>">
        <a href="product.php">
            <i class="fa fa-shopping-bag"></i> <span>Product Management</span>
        </a>
    </li>

    <!-- 5. Order Management -->
    <li class="treeview <?php if( ($cur_page == 'order.php') ) {echo 'active';} ?>">
        <a href="order.php">
            <i class="fa fa-sticky-note"></i> <span>Order Management</span>
        </a>
    </li>

    <!-- 5.1 Return Orders -->
    <li class="treeview <?php if( ($cur_page == 'returns.php') ) {echo 'active';} ?>">
        <a href="returns.php">
            <i class="fa fa-undo"></i> <span>Return Orders</span>
        </a>
    </li>



    <!-- 7. Registered Customer -->
    <li class="treeview <?php if( (
        $cur_page == 'customer.php') || ($cur_page == 'customer-add.php') || ($cur_page == 'customer-edit.php') ) {echo 'active';} ?>">
      <a href="customer.php">
        <i class="fa fa-user-plus"></i> <span>Registered Customer</span>
      </a>
    </li>

    <!-- 7.2. Seller Management -->
    <li class="treeview <?php if($cur_page == 'seller.php') {echo 'active';} ?>">
      <a href="seller.php">
        <i class="fa fa-user"></i> <span>Seller Management</span>
      </a>
    </li>

    <!-- 7.1. Customer Reviews -->
    <li class="treeview <?php if($cur_page == 'reviews.php') {echo 'active';} ?>">
      <a href="reviews.php">
        <i class="fa fa-star"></i> <span>Customer Reviews</span>
      </a>
    </li>

    <!-- 8. Messages -->
    <?php
    // Count unread messages
    $unread_count = 0;
    try {
      $stmt = $pdo->query("SELECT COUNT(*) FROM tbl_contact_messages WHERE is_read=0");
      $unread_count = $stmt->fetchColumn();
    } catch(Exception $e) {}
    ?>
    <li class="treeview <?php if($cur_page == 'messages.php') {echo 'active';} ?>">
      <a href="messages.php">
        <i class="fa fa-envelope"></i> <span>Messages</span>
        <?php if($unread_count > 0): ?>
          <span class="label label-danger pull-right" style="margin-top:3px;"><?php echo $unread_count; ?></span>
        <?php endif; ?>
      </a>
    </li>

    <!-- 9. Subscriber -->
    <li class="treeview <?php if( ($cur_page == 'subscriber.php')||($cur_page == 'subscriber.php') ) {echo 'active';} ?>">
      <a href="subscriber.php">
        <i class="fa fa-hand-o-right"></i> <span>Subscriber</span>
      </a>
    </li>


    <!-- 11. Manage Sliders -->
    <li class="treeview <?php if( ($cur_page == 'slider.php') ) {echo 'active';} ?>">
      <a href="slider.php">
        <i class="fa fa-picture-o"></i> <span>Manage Sliders</span>
      </a>
    </li>

    <!-- 12. FAQ -->
    <li class="treeview <?php if( ($cur_page == 'faq.php') ) {echo 'active';} ?>">
      <a href="faq.php">
        <i class="fa fa-question-circle"></i> <span>FAQ</span>
      </a>
    </li>

    <!-- 13. Page Settings -->
    <li class="treeview <?php if( ($cur_page == 'page.php') ) {echo 'active';} ?>">
      <a href="page.php">
        <i class="fa fa-tasks"></i> <span>Page Settings</span>
      </a>
    </li>

    <!-- 14. Social Media -->
    <li class="treeview <?php if( ($cur_page == 'social-media.php') ) {echo 'active';} ?>">
      <a href="social-media.php">
        <i class="fa fa-globe"></i> <span>Social Media</span>
      </a>
    </li>

    <!-- 15. Users -->
    <li><a href="users.php"><i class="fa fa-users"></i> <span>Users</span></a></li>

      			</ul>
    		</section>
  		</aside>

  		<div class="content-wrapper">

<!-- JS dependencies: jQuery first, then Bootstrap JS -->
<script src="js/jquery-2.2.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>