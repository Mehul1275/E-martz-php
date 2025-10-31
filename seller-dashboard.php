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

// Dashboard stats queries
$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_product WHERE seller_id=?");
$statement->execute([$seller_id]);
$total_product = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_order o JOIN tbl_product p ON o.product_id = p.p_id JOIN tbl_payment pay ON o.payment_id = pay.payment_id WHERE p.seller_id=? AND pay.payment_status='Pending'");
$statement->execute([$seller_id]);
$total_order_pending = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_order o JOIN tbl_product p ON o.product_id = p.p_id JOIN tbl_payment pay ON o.payment_id = pay.payment_id WHERE p.seller_id=? AND pay.payment_status='Completed'");
$statement->execute([$seller_id]);
$total_order_completed = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_order o JOIN tbl_product p ON o.product_id = p.p_id JOIN tbl_payment pay ON o.payment_id = pay.payment_id WHERE p.seller_id=? AND pay.shipping_status='Pending'");
$statement->execute([$seller_id]);
$total_shipping_pending = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_order o JOIN tbl_product p ON o.product_id = p.p_id JOIN tbl_payment pay ON o.payment_id = pay.payment_id WHERE p.seller_id=? AND pay.shipping_status='Completed'");
$statement->execute([$seller_id]);
$total_shipping_completed = $statement->fetchColumn();

$statement = $pdo->prepare("SELECT SUM(o.unit_price * o.quantity) FROM tbl_order o JOIN tbl_product p ON o.product_id = p.p_id JOIN tbl_payment pay ON o.payment_id = pay.payment_id WHERE p.seller_id=? AND pay.payment_status='Completed'");
$statement->execute([$seller_id]);
$total_earning = $statement->fetchColumn();
if(!$total_earning) $total_earning = 0;

// Get sales data for charts (last 7 days)
$sales_data = [];
$labels = [];
for($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('M j', strtotime($date));
    
    $statement = $pdo->prepare("SELECT COALESCE(SUM(o.unit_price * o.quantity), 0) FROM tbl_order o JOIN tbl_product p ON o.product_id = p.p_id JOIN tbl_payment pay ON o.payment_id = pay.payment_id WHERE p.seller_id=? AND pay.payment_status='Completed' AND DATE(pay.payment_date) = ?");
    $statement->execute([$seller_id, $date]);
    $sales_data[] = (float)$statement->fetchColumn();
}

// Get top products
$statement = $pdo->prepare("SELECT p.p_name, p.p_featured_photo, COUNT(o.id) as order_count, SUM(o.unit_price * o.quantity) as total_sales FROM tbl_product p LEFT JOIN tbl_order o ON p.p_id = o.product_id LEFT JOIN tbl_payment pay ON o.payment_id = pay.payment_id WHERE p.seller_id=? AND (pay.payment_status='Completed' OR pay.payment_status IS NULL) GROUP BY p.p_id ORDER BY order_count DESC, total_sales DESC LIMIT 5");
$statement->execute([$seller_id]);
$top_products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller Dashboard - E-martz</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Favicon -->
    <link rel="icon" type="image/ico" href="favicon.ico">
    <link rel="shortcut icon" type="image/ico" href="favicon.ico">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="admin/css/_all-skins.min.css">
    <link rel="stylesheet" href="assets/css/seller-modern.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
<?php include('seller-sidebar.php'); ?>
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="seller-page-header fade-in" style=" margin-top: 20px;">
            <h1 class="seller-page-title">
                <i class="fa fa-dashboard" ></i>
                Seller Dashboard
            </h1>
            <p class="seller-page-subtitle">Welcome back, <?php echo htmlspecialchars($_SESSION['seller']['fullname']); ?>! Here's your business overview.</p>
        </div>

        <section class="content">
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="seller-stat-card card-products fade-in">
                        <div class="card-icon">
                            <i class="fa fa-cube"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-number" style="--card-color: #2c5aa0;"><?php echo $total_product; ?></h3>
                            <p class="card-label">Total Products</p>
                            <div class="card-change positive">
                                <i class="fa fa-arrow-up"></i>
                                <span>Active listings</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="seller-stat-card card-orders fade-in">
                        <div class="card-icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-number" style="--card-color: #e74c3c;"><?php echo $total_order_pending; ?></h3>
                            <p class="card-label">Pending Orders</p>
                            <div class="card-change">
                                <i class="fa fa-exclamation-circle"></i>
                                <span>Needs attention</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="seller-stat-card card-completed fade-in">
                        <div class="card-icon">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-number" style="--card-color: #27ae60;"><?php echo $total_order_completed; ?></h3>
                            <p class="card-label">Completed Orders</p>
                            <div class="card-change positive">
                                <i class="fa fa-arrow-up"></i>
                                <span>Successfully delivered</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="seller-stat-card card-shipping fade-in">
                        <div class="card-icon">
                            <i class="fa fa-truck"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-number" style="--card-color: #f39c12;"><?php echo $total_shipping_pending; ?></h3>
                            <p class="card-label">Pending Shipping</p>
                            <div class="card-change">
                                <i class="fa fa-clock-o"></i>
                                <span>Ready to ship</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="seller-stat-card card-shipping fade-in">
                        <div class="card-icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-number" style="--card-color: #3498db;"><?php echo $total_shipping_completed; ?></h3>
                            <p class="card-label">Shipped Orders</p>
                            <div class="card-change positive">
                                <i class="fa fa-arrow-up"></i>
                                <span>In transit</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="seller-stat-card card-earnings fade-in">
                        <div class="card-icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-number" style="--card-color: #e67e22;">₹<?php echo number_format($total_earning); ?></h3>
                            <p class="card-label">Total Earnings</p>
                            <div class="card-change positive">
                                <i class="fa fa-arrow-up"></i>
                                <span>Revenue generated</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Quick Actions Row -->
            <div class="row">
                <!-- Sales Chart -->
                <div class="col-lg-8">
                    <div class="seller-chart-container slide-in">
                        <div class="seller-chart-header">
                            <div>
                                <h3 class="seller-chart-title">Sales Trend</h3>
                                <p class="seller-chart-subtitle">Last 7 days performance</p>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-lg-4">
                    <div class="seller-quick-actions slide-in">
                        <h3>Quick Actions</h3>
                        <div class="seller-action-grid">
                            <a href="seller-product-add.php" class="seller-action-btn btn-add-product">
                                <i class="fa fa-plus"></i>
                                <span>Add Product</span>
                            </a>
                            <a href="seller-orders.php" class="seller-action-btn btn-view-orders">
                                <i class="fa fa-list"></i>
                                <span>View Orders</span>
                            </a>
                            <a href="seller-returns.php" class="seller-action-btn btn-view-returns">
                                <i class="fa fa-undo"></i>
                                <span>View Returns</span>
                            </a>
                            <a href="seller-profile.php" class="seller-action-btn btn-view-profile">
                                <i class="fa fa-user"></i>
                                <span>Edit Profile</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="seller-top-products slide-in">
                        <h3>Top Performing Products</h3>
                        <?php if(empty($top_products)): ?>
                            <p style="text-align: center; color: #7f8c8d; padding: 2rem;">No products found. <a href="seller-product-add.php">Add your first product</a> to get started!</p>
                        <?php else: ?>
                            <?php foreach($top_products as $product): ?>
                                <div class="seller-product-item">
                                    <img src="assets/uploads/<?php echo htmlspecialchars($product['p_featured_photo']); ?>" alt="Product" class="seller-product-image">
                                    <div class="seller-product-info">
                                        <h4 class="seller-product-name"><?php echo htmlspecialchars($product['p_name']); ?></h4>
                                        <p class="seller-product-sales"><?php echo $product['order_count']; ?> orders</p>
                                    </div>
                                    <div class="seller-product-price">₹<?php echo number_format($product['total_sales'] ?: 0); ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
// Sales Chart
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Daily Sales (₹)',
            data: <?php echo json_encode($sales_data); ?>,
            borderColor: '#2c5aa0',
            backgroundColor: 'rgba(44, 90, 160, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#2c5aa0',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2.5,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                },
                ticks: {
                    callback: function(value) {
                        return '₹' + value.toLocaleString();
                    }
                }
            },
            x: {
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            }
        },
        elements: {
            point: {
                hoverBackgroundColor: '#e67e22'
            }
        }
    }
});

// Ensure content visibility and add animations
document.addEventListener('DOMContentLoaded', function() {
    // Immediately show all content
    const fadeElements = document.querySelectorAll('.fade-in, .slide-in');
    fadeElements.forEach(element => {
        element.style.opacity = '1';
        element.style.transform = 'translateY(0) translateX(0)';
        element.style.visibility = 'visible';
    });
    
    // Show content sections
    const contentSections = document.querySelectorAll('.content, section.content, .seller-stat-card, .seller-chart-container, .seller-quick-actions, .seller-top-products');
    contentSections.forEach(section => {
        section.style.opacity = '1';
        section.style.visibility = 'visible';
        section.style.display = 'block';
    });
    
    // Add subtle entrance animation for cards
    const cards = document.querySelectorAll('.seller-stat-card');
    cards.forEach((card, index) => {
        card.style.opacity = '1';
        card.style.visibility = 'visible';
        setTimeout(() => {
            card.style.transform = 'translateY(0)';
            card.classList.add('animate-in');
        }, index * 50);
    });
});
</script>

<style>
/* Fix chart container dimensions */
.chart-wrapper {
    position: relative;
    height: 300px;
    width: 100%;
    max-height: 300px;
    overflow: hidden;
}

.seller-chart-container {
    padding: var(--spacing-lg);
    background: white;
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-md);
    margin-bottom: var(--spacing-lg);
}

.seller-chart-container canvas {
    max-height: 300px !important;
    height: 300px !important;
}

/* Ensure chart responsiveness */
@media (max-width: 768px) {
    .chart-wrapper {
        height: 250px;
        max-height: 250px;
    }
    
    .seller-chart-container canvas {
        max-height: 250px !important;
        height: 250px !important;
    }
}
</style>

</body>
</html> 