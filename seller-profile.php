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

// Fetch seller info
$stmt = $pdo->prepare('SELECT * FROM sellers WHERE id = ?');
$stmt->execute([$seller_id]);
$seller = $stmt->fetch(PDO::FETCH_ASSOC);

// Safety check for seller data
if (!$seller) {
    header('Location: seller-login.php');
    exit;
}

// Get seller statistics - simplified version
$seller_stats = [
    'total_products' => 0,
    'active_products' => 0, 
    'featured_products' => 0,
    'avg_rating' => 0,
    'total_reviews' => 0
];

// Try to get basic product count
try {
    $stats_stmt = $pdo->prepare("SELECT COUNT(*) as total_products FROM tbl_product WHERE seller_id = ?");
    $stats_stmt->execute([$seller_id]);
    $result = $stats_stmt->fetch(PDO::FETCH_ASSOC);
    $seller_stats['total_products'] = $result['total_products'] ?? 0;
    $seller_stats['active_products'] = $result['total_products'] ?? 0;
} catch (PDOException $e) {
    // Keep default values if query fails - no error display for better UX
    error_log("Seller profile stats query failed: " . $e->getMessage());
}

// Set default order count
$order_count = ['total_orders' => 0];

$info_success = '';
$info_error = '';
$pass_success = '';
$pass_error = '';

// Update info
if(isset($_POST['update_info'])) {
    $fullname = trim($_POST['fullname']);
    $company_name = trim($_POST['company_name']);
    $company_address = trim($_POST['company_address']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gstno = trim($_POST['gstno']);
    if($fullname == '' || $email == '') {
        $info_error = 'Full Name and Email are required.';
    } else {
        $stmt = $pdo->prepare('UPDATE sellers SET fullname=?, company_name=?, company_address=?, email=?, phone=?, gstno=? WHERE id=?');
        $stmt->execute([$fullname, $company_name, $company_address, $email, $phone, $gstno, $seller_id]);
        $info_success = 'Profile updated successfully.';
        // Update session
        $_SESSION['seller']['fullname'] = $fullname;
        $_SESSION['seller']['company_name'] = $company_name;
        $_SESSION['seller']['company_address'] = $company_address;
        $_SESSION['seller']['email'] = $email;
        $_SESSION['seller']['phone'] = $phone;
        $_SESSION['seller']['gstno'] = $gstno;
        // Refresh seller info
        $stmt = $pdo->prepare('SELECT * FROM sellers WHERE id = ?');
        $stmt->execute([$seller_id]);
        $seller = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Update password
if(isset($_POST['update_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    if($old_password == '' || $new_password == '' || $confirm_password == '') {
        $pass_error = 'All password fields are required.';
    } else if($new_password != $confirm_password) {
        $pass_error = 'New password and confirm password do not match.';
    } else if(!password_verify($old_password, $seller['password'])) {
        $pass_error = 'Old password is incorrect.';
    } else {
        $hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('UPDATE sellers SET password=? WHERE id=?');
        $stmt->execute([$hashed, $seller_id]);
        $pass_success = 'Password updated successfully.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller Panel - Profile</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="admin/css/_all-skins.min.css">
    <link rel="stylesheet" href="assets/css/seller-modern.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
<?php include('seller-sidebar.php'); ?>
    <div class="content-wrapper" style="min-height:100vh;">
        <!-- Page Header -->
        <div class="seller-page-header fade-in" style="margin-top: 20px;">
            <h1 class="seller-page-title">
                <i class="fa fa-user"></i>
                My Profile
            </h1>
            <p class="seller-page-subtitle">Manage your seller account information and settings</p>
        </div>

        <section class="content" style="padding: 0 40px;">
            <!-- Seller Statistics Dashboard 
            <div class="row fade-in" style="margin-bottom: 30px;">
                <div class="col-md-3 col-sm-6">
                    <div class="seller-stat-card card-products">
                        <div class="card-content">
                            <h3 class="card-number"><?php echo $seller_stats['total_products'] ?? 0; ?></h3>
                            <p class="card-label">Total Products</p>
                            <div class="card-change positive">
                                <i class="fa fa-cube"></i>
                                <span><?php echo $seller_stats['active_products'] ?? 0; ?> Active</span>
                            </div>
                        </div>
                        <i class="fa fa-shopping-bag card-icon"></i>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="seller-stat-card card-orders">
                        <div class="card-content">
                            <h3 class="card-number"><?php echo $order_count['total_orders'] ?? 0; ?></h3>
                            <p class="card-label">Total Orders</p>
                            <div class="card-change positive">
                                <i class="fa fa-shopping-cart"></i>
                                <span>All Time</span>
                            </div>
                        </div>
                        <i class="fa fa-shopping-cart card-icon"></i>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="seller-stat-card card-completed">
                        <div class="card-content">
                            <h3 class="card-number"><?php echo number_format($seller_stats['avg_rating'], 1); ?></h3>
                            <p class="card-label">Average Rating</p>
                            <div class="card-change positive">
                                <i class="fa fa-star"></i>
                                <span><?php echo $seller_stats['total_reviews']; ?> Reviews</span>
                            </div>
                        </div>
                        <i class="fa fa-star card-icon"></i>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="seller-stat-card card-shipping">
                        <div class="card-content">
                            <h3 class="card-number"><?php echo $seller_stats['featured_products'] ?? 0; ?></h3>
                            <p class="card-label">Featured Products</p>
                            <div class="card-change positive">
                                <i class="fa fa-star-o"></i>
                                <span>Highlighted Items</span>
                            </div>
                        </div>
                        <i class="fa fa-star-o card-icon"></i>
                    </div>
                </div>
            </div>
            -->
            <div class="row">
                <div class="col-md-6">
                    <div class="seller-form-container fade-in">
                        <div class="form-header">
                            <div class="form-icon">
                                <i class="fa fa-info-circle"></i>
                            </div>
                            <h3>Profile Information</h3>
                            <p>Update your personal and business details</p>
                        </div>
                        <div class="form-body">
                            <?php if($info_success): ?>
                                <div class="seller-alert alert-success">
                                    <i class="fa fa-check-circle"></i>
                                    <?= htmlspecialchars($info_success) ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($info_error): ?>
                                <div class="seller-alert alert-danger">
                                    <i class="fa fa-exclamation-circle"></i>
                                    <?= htmlspecialchars($info_error) ?>
                                </div>
                            <?php endif; ?>
                            
                            <form method="post" class="seller-form" id="profileForm">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="seller-label">
                                            <i class="fa fa-user"></i>
                                            Full Name <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="fullname" class="seller-form-control" 
                                                   value="<?= htmlspecialchars($seller['fullname'] ?? '') ?>" 
                                                   placeholder="Enter your full name" required>
                                            <div class="input-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="seller-label">
                                            <i class="fa fa-building"></i>
                                            Company Name
                                        </label>
                                        <input type="text" name="company_name" class="seller-form-control" 
                                               value="<?= htmlspecialchars($seller['company_name'] ?? '') ?>" 
                                               placeholder="Enter your company name">
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="seller-label">
                                            <i class="fa fa-map-marker"></i>
                                            Company Address
                                        </label>
                                        <textarea name="company_address" class="seller-form-control" rows="3" 
                                                  placeholder="Enter complete company address"><?= htmlspecialchars($seller['company_address'] ?? '') ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="seller-label">
                                            <i class="fa fa-envelope"></i>
                                            Email Address <span class="required">*</span>
                                        </label>
                                        <input type="email" name="email" class="seller-form-control" 
                                               value="<?= htmlspecialchars($seller['email'] ?? '') ?>" 
                                               placeholder="Enter your email address" required>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="seller-label">
                                            <i class="fa fa-phone"></i>
                                            Phone Number
                                        </label>
                                        <input type="text" name="phone" class="seller-form-control" 
                                               value="<?= htmlspecialchars($seller['phone'] ?? '') ?>" 
                                               placeholder="Enter your phone number">
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="seller-label">
                                            <i class="fa fa-file-text"></i>
                                            GST Number
                                        </label>
                                        <input type="text" name="gstno" class="seller-form-control" 
                                               value="<?= htmlspecialchars($seller['gstno'] ?? '') ?>" 
                                               placeholder="Enter your GST number">
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" name="update_info" class="seller-btn seller-btn-primary">
                                        <i class="fa fa-save"></i> Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="seller-form-container slide-in">
                        <div class="form-header">
                            <div class="form-icon">
                                <i class="fa fa-lock"></i>
                            </div>
                            <h3>Change Password</h3>
                            <p>Update your account password for security</p>
                        </div>
                        <div class="form-body">
                            <?php if($pass_success): ?>
                                <div class="seller-alert alert-success">
                                    <i class="fa fa-check-circle"></i>
                                    <?= htmlspecialchars($pass_success) ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($pass_error): ?>
                                <div class="seller-alert alert-danger">
                                    <i class="fa fa-exclamation-circle"></i>
                                    <?= htmlspecialchars($pass_error) ?>
                                </div>
                            <?php endif; ?>
                            
                            <form method="post" class="seller-form">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="seller-label">
                                            <i class="fa fa-key"></i>
                                            Current Password <span class="required">*</span>
                                        </label>
                                        <input type="password" name="old_password" class="seller-form-control" 
                                               placeholder="Enter your current password" required>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="seller-label">
                                            <i class="fa fa-lock"></i>
                                            New Password <span class="required">*</span>
                                        </label>
                                        <input type="password" name="new_password" class="seller-form-control" 
                                               placeholder="Enter new password" required>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="seller-label">
                                            <i class="fa fa-check"></i>
                                            Confirm New Password <span class="required">*</span>
                                        </label>
                                        <input type="password" name="confirm_password" class="seller-form-control" 
                                               placeholder="Confirm new password" required>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" name="update_password" class="seller-btn seller-btn-warning">
                                        <i class="fa fa-shield"></i> Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="admin/js/jquery-2.2.3.min.js"></script>
<script src="admin/js/bootstrap.min.js"></script>
<script src="admin/js/app.min.js"></script>

<script>
$(document).ready(function() {
    // Add animations
    setTimeout(function() {
        $('.fade-in').addClass('visible');
        $('.slide-in').addClass('visible');
    }, 100);
    
    // Form validation
    $('form').on('submit', function(e) {
        const form = $(this);
        const requiredFields = form.find('[required]');
        let isValid = true;
        
        requiredFields.each(function() {
            const field = $(this);
            if (!field.val().trim()) {
                field.addClass('error');
                isValid = false;
            } else {
                field.removeClass('error');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
    
    // Remove error class on input
    $('.seller-form-control').on('input', function() {
        $(this).removeClass('error');
    });
});
</script>

<style>
/* Additional styles for profile page */
.seller-form-container {
    background: white;
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-md);
    margin-bottom: var(--spacing-lg);
    overflow: hidden;
}

.form-header {
    background: var(--seller-gradient-primary);
    color: white;
    padding: var(--spacing-lg);
    text-align: center;
}

.form-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto var(--spacing-md);
    font-size: 1.5rem;
}

.form-header h3 {
    margin: 0 0 var(--spacing-xs);
    font-size: 1.5rem;
    font-weight: 600;
}

.form-header p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

.form-body {
    padding: var(--spacing-lg);
}

.seller-form {
    margin: 0;
}

.form-row {
    margin-bottom: var(--spacing-lg);
}

.seller-label {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-weight: 600;
    color: var(--seller-dark);
    margin-bottom: var(--spacing-sm);
    font-size: 0.9rem;
}

.seller-label i {
    color: var(--seller-primary);
    width: 16px;
}

.required {
    color: var(--seller-danger);
}

.seller-form-control {
    width: 100%;
    padding: var(--spacing-md);
    border: 2px solid var(--seller-light);
    border-radius: var(--border-radius-md);
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: white;
}

.seller-form-control:focus {
    outline: none;
    border-color: var(--seller-primary);
    box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
}

.seller-form-control.error {
    border-color: var(--seller-danger);
    box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
}

.seller-form-control::placeholder {
    color: var(--seller-secondary);
}

.form-actions {
    margin-top: var(--spacing-xl);
    text-align: center;
}

.seller-btn-warning {
    background: var(--seller-gradient-warning);
    color: white;
}

.seller-btn-warning:hover {
    background: var(--seller-gradient-accent);
    transform: translateY(-2px);
    color: white;
}

/* Animation keyframes */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.fade-in {
    opacity: 0;
    animation: fadeIn 0.6s ease-out forwards;
}

.slide-in {
    opacity: 0;
    transform: translateY(20px);
    animation: slideIn 0.8s ease-out forwards;
}

.fade-in.visible,
.slide-in.visible {
    opacity: 1;
    transform: translateY(0);
}
</style>
</body>
</html>