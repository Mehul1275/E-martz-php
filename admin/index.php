<?php require_once('header.php'); ?>

<style>
.simple-dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem 2rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}

.simple-dashboard-header h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 15px;
}

.simple-dashboard-header .welcome-text {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1rem;
    font-weight: 400;
}

.modern-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

/* Responsive behavior for sidebar toggle */
.sidebar-collapse .modern-stats-grid {
    gap: 1rem;
}

@media (max-width: 1200px) {
    .modern-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .modern-stats-grid {
        grid-template-columns: 1fr;
    }
}

.modern-stat-card {
    background: var(--card-gradient);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    border: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    color: white;
}

.modern-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18);
}

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: rgba(255, 255, 255, 0.9);
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 6px 10px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.2);
    color: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

.stat-number {
    font-size: 2.8rem;
    font-weight: 800;
    color: white;
    margin-bottom: 0.5rem;
    line-height: 1;
}

.stat-label {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.3rem;
    letter-spacing: 0.5px;
}

.stat-description {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.85rem;
    line-height: 1.4;
    font-weight: 400;
}

.card-primary { --card-gradient: linear-gradient(135deg, #4c63d2 0%, #5a4fcf 100%); }
.card-success { --card-gradient: linear-gradient(135deg, #0d7377 0%, #14a085 100%); }
.card-warning { --card-gradient: linear-gradient(135deg, #d946ef 0%, #ec4899 100%); }
.card-danger { --card-gradient: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); }
.card-info { --card-gradient: linear-gradient(135deg, #059669 0%, #047857 100%); }
.card-purple { --card-gradient: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); }
.card-teal { --card-gradient: linear-gradient(135deg, #0891b2 0%, #0e7490 100%); }
.card-orange { --card-gradient: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); }

.modern-charts-section {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

/* Responsive behavior for sidebar toggle */
.sidebar-collapse .modern-charts-section {
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.modern-chart-container {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid #f1f5f9;
    min-height: 400px;
    display: flex;
    flex-direction: column;
}

.modern-chart-container canvas {
    flex: 1;
    max-height: 300px;
}

.chart-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f5f9;
}

.chart-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
}

.chart-subtitle {
    color: #64748b;
    font-size: 0.9rem;
    margin-top: 0.3rem;
}

/* Top Products Section */
.top-products-list {
    padding: 1rem 0;
}

.product-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.3s ease;
}

.product-item:last-child {
    border-bottom: none;
}

.product-item:hover {
    background-color: #f8f9fc;
    border-radius: 8px;
    margin: 0 -0.5rem;
    padding: 1rem 0.5rem;
}

.product-rank {
    font-size: 1.2rem;
    font-weight: 700;
    color: #667eea;
    min-width: 30px;
}

.product-image {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
}

.product-info {
    flex: 1;
}

.product-name {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.3rem;
    font-size: 0.95rem;
}

.product-stats {
    display: flex;
    gap: 1rem;
    font-size: 0.8rem;
}

.sold-count {
    color: #10b981;
    font-weight: 600;
}

.revenue {
    color: #667eea;
    font-weight: 600;
}


/* No Data Messages */
.no-data-message {
    text-align: center;
    padding: 2rem;
    color: #64748b;
}

.no-data-message.success {
    color: #10b981;
}

.no-data-message i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
}

.no-data-message p {
    margin: 0;
    font-weight: 500;
}

.fade-in {
    animation: fadeIn 0.6s ease-out;
}

.slide-in {
    animation: slideIn 0.8s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

@media (max-width: 1200px) {
    .modern-charts-section {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .simple-dashboard-header {
        padding: 1.2rem 1.5rem;
        text-align: center;
    }
    
    .simple-dashboard-header h1 {
        font-size: 1.8rem;
        justify-content: center;
    }
    
    .modern-stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-number {
        font-size: 2rem;
    }
}

/* Dashboard Grid Layout */
.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

/* Responsive behavior for sidebar toggle */
.sidebar-collapse .dashboard-grid {
    gap: 1.5rem;
}

.chart-section {
    min-height: 400px;
}

.quick-actions-section {
    min-height: 400px;
}

.compact-chart-wrapper {
    height: 300px;
    position: relative;
}

/* Quick Actions Grid */
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    padding: 1rem 0;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    color: inherit;
    border-color: #d1d5db;
}

.action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
}

.action-icon i {
    font-size: 1.25rem;
    color: white;
}

.action-content {
    flex: 1;
}

.action-title {
    font-weight: 600;
    font-size: 0.95rem;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.action-desc {
    font-size: 0.8rem;
    color: #6b7280;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .chart-section,
    .quick-actions-section {
        min-height: auto;
    }
    
    .compact-chart-wrapper {
        height: 250px;
    }
}

@media (max-width: 768px) {
    .quick-actions-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    
    .quick-action-btn {
        padding: 0.75rem;
    }
    
    .action-icon {
        width: 40px;
        height: 40px;
        margin-right: 0.75rem;
    }
    
    .action-icon i {
        font-size: 1.1rem;
    }
    
    .compact-chart-wrapper {
        height: 200px;
    }
}
</style>

<div class="simple-dashboard-header fade-in" style="margin-top: -40px; margin-bottom: 2rem;">
    <h1>
        <i class="fa fa-tachometer"></i>
        Dashboard
    </h1>
    <p class="welcome-text">Welcome back! Here's what's happening with your E-Martz store today.</p>
</div>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_top_category");
$statement->execute();
$total_top_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
$statement->execute();
$total_mid_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_end_category");
$statement->execute();
$total_end_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_product");
$statement->execute();
$total_product = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_status='1'");
$statement->execute();
$total_customers = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_active='1'");
$statement->execute();
$total_subscriber = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost");
$statement->execute();
$available_shipping = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Completed'));
$total_order_completed = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE shipping_status=?");
$statement->execute(array('Completed'));
$total_shipping_completed = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM sellers WHERE status='1'");
$statement->execute();
$total_active_sellers = $statement->rowCount();

$statement = $pdo->prepare("SELECT COUNT(*) as seller_products FROM tbl_product p LEFT JOIN sellers s ON p.seller_id = s.id WHERE s.status='1'");
$statement->execute();
$seller_products_result = $statement->fetch(PDO::FETCH_ASSOC);
$total_seller_products = $seller_products_result['seller_products'] ? $seller_products_result['seller_products'] : 0;

$statement = $pdo->prepare("SELECT SUM(paid_amount) as total_earning FROM tbl_payment WHERE payment_status='Completed'");
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);
$total_earning = $row['total_earning'] ? $row['total_earning'] : 0;

// Get data for charts
$statement = $pdo->prepare("SELECT DATE(payment_date) as date, SUM(paid_amount) as daily_sales FROM tbl_payment WHERE payment_status='Completed' AND payment_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY DATE(payment_date) ORDER BY date");
$statement->execute();
$daily_sales = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT payment_status, COUNT(*) as count FROM tbl_payment GROUP BY payment_status");
$statement->execute();
$order_status_data = $statement->fetchAll(PDO::FETCH_ASSOC);

// Get top selling products
$statement = $pdo->prepare("SELECT p.p_name, p.p_featured_photo, SUM(CAST(o.quantity AS UNSIGNED)) as total_sold, SUM(CAST(o.unit_price AS DECIMAL(10,2)) * CAST(o.quantity AS UNSIGNED)) as revenue FROM tbl_order o LEFT JOIN tbl_product p ON o.product_id = p.p_id GROUP BY o.product_id ORDER BY total_sold DESC LIMIT 5");
$statement->execute();
$top_products = $statement->fetchAll(PDO::FETCH_ASSOC);


// Get customer insights
$statement = $pdo->prepare("SELECT COUNT(*) as new_customers FROM tbl_customer WHERE cust_status='1' AND DATE(cust_datetime) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
$statement->execute();
$weekly_customers = $statement->fetch(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT COUNT(*) as total_reviews FROM tbl_rating WHERE DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
$statement->execute();
$monthly_reviews = $statement->fetch(PDO::FETCH_ASSOC);

?>

<section class="content">
<!-- Stats Cards -->
<div class="modern-stats-grid slide-in">
    <div class="modern-stat-card card-primary">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fa fa-shopping-bag"></i>
            </div>
            <div class="stat-trend">
                <i class="fa fa-arrow-up"></i> +12%
            </div>
        </div>
        <div class="stat-number"><?php echo $total_product; ?></div>
        <div class="stat-label">Total Products</div>
        <div class="stat-description">Active products in your inventory</div>
    </div>
    
    <div class="modern-stat-card card-warning">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fa fa-cube"></i>
            </div>
            <div class="stat-trend">
                <i class="fa fa-arrow-up"></i> +18%
            </div>
        </div>
        <div class="stat-number"><?php echo $total_seller_products; ?></div>
        <div class="stat-label">Seller's Products</div>
        <div class="stat-description">Products from active sellers</div>
    </div>
    
    <div class="modern-stat-card card-success">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="stat-trend">
                <i class="fa fa-arrow-up"></i> +8%
            </div>
        </div>
        <div class="stat-number"><?php echo $total_order_completed; ?></div>
        <div class="stat-label">Completed Orders</div>
        <div class="stat-description">Successfully processed orders</div>
    </div>
    
    <div class="modern-stat-card card-info">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fa fa-truck"></i>
            </div>
            <div class="stat-trend">
                <i class="fa fa-arrow-up"></i> +15%
            </div>
        </div>
        <div class="stat-number"><?php echo $total_shipping_completed; ?></div>
        <div class="stat-label">Completed Shipping</div>
        <div class="stat-description">Orders delivered to customers</div>
    </div>
    
    <div class="modern-stat-card card-orange">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fa fa-building"></i>
            </div>
            <div class="stat-trend">
                <i class="fa fa-arrow-up"></i> +12%
            </div>
        </div>
        <div class="stat-number"><?php echo $total_active_sellers; ?></div>
        <div class="stat-label">Active Sellers</div>
        <div class="stat-description">Verified and active sellers</div>
    </div>
    
    <div class="modern-stat-card card-danger">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="stat-trend">
                <i class="fa fa-arrow-up"></i> +5%
            </div>
        </div>
        <div class="stat-number"><?php echo $total_customers; ?></div>
        <div class="stat-label">Active Customers</div>
        <div class="stat-description">Registered and verified customers</div>
    </div>
    
    <div class="modern-stat-card card-teal">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fa fa-envelope"></i>
            </div>
            <div class="stat-trend">
                <i class="fa fa-arrow-up"></i> +20%
            </div>
        </div>
        <div class="stat-number"><?php echo $total_subscriber; ?></div>
        <div class="stat-label">Newsletter Subscribers</div>
        <div class="stat-description">Active email subscribers</div>
    </div>
    
    <div class="modern-stat-card card-purple">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fa fa-money"></i>
            </div>
            <div class="stat-trend">
                <i class="fa fa-arrow-up"></i> +25%
            </div>
        </div>
        <div class="stat-number">₹<?php echo $row['total_earning'] == '' ? '0.00' : number_format($row['total_earning'], 2); ?></div>
        <div class="stat-label">Total Revenue</div>
        <div class="stat-description">Lifetime earnings from sales</div>
    </div>
</div>

<!-- E-commerce Admin Sections -->
<div class="modern-charts-section fade-in">
    <!-- Sales Chart -->
    <div class="modern-chart-container">
        <div class="chart-header">
            <div>
                <h3 class="chart-title">
                    <i class="fa fa-line-chart"></i> 
                    Sales Analytics
                </h3>
                <p class="chart-subtitle">Revenue trends over the last 7 days</p>
            </div>
        </div>
        <canvas id="salesChart" height="100"></canvas>
    </div>
    
    <!-- Top Selling Products -->
    <div class="modern-chart-container">
        <div class="chart-header">
            <h3 class="chart-title">
                <i class="fa fa-trophy"></i> 
                Top Selling Products
            </h3>
        </div>
        
        <div class="top-products-list">
            <?php 
            if(empty($top_products)) {
                echo '<div class="no-data-message">';
                echo '<i class="fa fa-info-circle"></i>';
                echo '<p>No sales data available yet</p>';
                echo '</div>';
            } else {
                foreach($top_products as $index => $product) {
                    $rank = $index + 1;
                    echo '<div class="product-item">';
                    echo '<div class="product-rank">#' . $rank . '</div>';
                    echo '<div class="product-image">';
                    if($product['p_featured_photo']) {
                        echo '<img src="../assets/uploads/' . htmlspecialchars($product['p_featured_photo']) . '" alt="Product">';
                    } else {
                        echo '<div class="no-image"><i class="fa fa-image"></i></div>';
                    }
                    echo '</div>';
                    echo '<div class="product-info">';
                    echo '<div class="product-name">' . htmlspecialchars($product['p_name']) . '</div>';
                    echo '<div class="product-stats">';
                    echo '<span class="sold-count">' . $product['total_sold'] . ' sold</span>';
                    echo '<span class="revenue">₹' . number_format($product['revenue'], 2) . '</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</div>


<!-- Charts and Quick Actions Grid -->
<div class="dashboard-grid slide-in" style="margin-bottom: 2rem;">
    <!-- Order Status Chart -->
    <div class="chart-section">
        <div class="modern-chart-container">
            <div class="chart-header">
                <div>
                    <h3 class="chart-title">
                        <i class="fa fa-pie-chart"></i> 
                        Order Status
                    </h3>
                    <p class="chart-subtitle">Distribution overview</p>
                </div>
            </div>
            <div class="compact-chart-wrapper">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions Section -->
    <div class="quick-actions-section">
        <div class="modern-chart-container">
            <div class="chart-header">
                <div>
                    <h3 class="chart-title">
                        <i class="fa fa-bolt"></i> 
                        Quick Actions
                    </h3>
                    <p class="chart-subtitle">Common e-commerce tasks</p>
                </div>
            </div>
            <div class="quick-actions-grid">
                <a href="product-add.php" class="quick-action-btn">
                    <div class="action-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fa fa-plus"></i>
                    </div>
                    <div class="action-content">
                        <div class="action-title">Add Product</div>
                        <div class="action-desc">New item</div>
                    </div>
                </a>
                
                <a href="order.php" class="quick-action-btn">
                    <div class="action-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="action-content">
                        <div class="action-title">View Orders</div>
                        <div class="action-desc">Manage orders</div>
                    </div>
                </a>
                
                <a href="customer.php" class="quick-action-btn">
                    <div class="action-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="action-content">
                        <div class="action-title">Customers</div>
                        <div class="action-desc">User management</div>
                    </div>
                </a>
                
                <a href="slider-add.php" class="quick-action-btn">
                    <div class="action-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fa fa-image"></i>
                    </div>
                    <div class="action-content">
                        <div class="action-title">Add Slider</div>
                        <div class="action-desc">Homepage banner</div>
                    </div>
                </a>
                
                <a href="settings.php" class="quick-action-btn">
                    <div class="action-icon" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);">
                        <i class="fa fa-cog"></i>
                    </div>
                    <div class="action-content">
                        <div class="action-title">Settings</div>
                        <div class="action-desc">Site config</div>
                    </div>
                </a>
                
                <a href="returns.php" class="quick-action-btn">
                    <div class="action-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                        <i class="fa fa-undo"></i>
                    </div>
                    <div class="action-content">
                        <div class="action-title">Returns</div>
                        <div class="action-desc">Handle returns</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesData = <?php echo json_encode($daily_sales); ?>;
const salesLabels = salesData.map(item => {
    const date = new Date(item.date);
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
});
const salesValues = salesData.map(item => parseFloat(item.daily_sales || 0));

const salesChart = new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: salesLabels,
        datasets: [{
            label: 'Daily Sales (₹)',
            data: salesValues,
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '₹' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Order Status Chart
const orderCtx = document.getElementById('orderStatusChart').getContext('2d');
const orderData = <?php echo json_encode($order_status_data); ?>;
const orderLabels = orderData.map(item => item.payment_status);
const orderValues = orderData.map(item => parseInt(item.count));
const orderColors = ['#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6'];

const orderChart = new Chart(orderCtx, {
    type: 'doughnut',
    data: {
        labels: orderLabels,
        datasets: [{
            data: orderValues,
            backgroundColor: orderColors,
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    usePointStyle: true,
                    font: {
                        size: 12
                    }
                }
            }
        }
    }
});

// Handle sidebar toggle and resize charts
$(document).ready(function() {
    // Listen for sidebar toggle events
    $('.modern-sidebar-toggle').on('click', function() {
        setTimeout(function() {
            // Resize charts after sidebar animation completes
            if (salesChart) {
                salesChart.resize();
            }
            if (orderChart) {
                orderChart.resize();
            }
        }, 300); // Wait for CSS transition to complete
    });
    
    // Also listen for window resize events
    $(window).on('resize', function() {
        if (salesChart) {
            salesChart.resize();
        }
        if (orderChart) {
            orderChart.resize();
        }
    });
});
</script>
		  
</section>

<?php require_once('footer.php'); ?>