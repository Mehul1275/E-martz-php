<?php require_once('header.php'); ?>

<?php
// Check if the customer is logged in or not
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
?>

<?php
// Get customer statistics
$customer_id = $_SESSION['customer']['cust_id'];

// Get total orders
$statement = $pdo->prepare("SELECT COUNT(*) as total_orders FROM tbl_payment WHERE customer_id=?");
$statement->execute(array($customer_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$total_orders = $result[0]['total_orders'];

// Get total spent
$statement = $pdo->prepare("SELECT SUM(paid_amount) as total_spent FROM tbl_payment WHERE customer_id=? AND payment_status='Completed'");
$statement->execute(array($customer_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$total_spent = $result[0]['total_spent'] ? $result[0]['total_spent'] : 0;

// Get pending orders (exclude cancelled/returned)
$statement = $pdo->prepare("SELECT COUNT(*) as pending_orders FROM tbl_payment WHERE customer_id=? AND shipping_status='Pending' AND (order_status IS NULL OR order_status NOT IN ('Cancelled','Returned'))");
$statement->execute(array($customer_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$pending_orders = $result[0]['pending_orders'];
?>

<!-- Enhanced Dashboard Styles -->
<style>
/* Page Header Styling - Match Cart and Checkout pages */
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

/* Enhanced Dashboard Content */
.dashboard-content {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 30px;
}

/* Welcome Card */
.welcome-card {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border: 2px solid var(--color-primary);
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 20px;
}

.welcome-avatar {
    width: 60px;
    height: 60px;
    background: var(--color-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

.welcome-info h3 {
    color: var(--color-neutral-900);
    margin-bottom: 5px;
    font-weight: 600;
}

.welcome-info p {
    color: var(--color-neutral-700);
    margin: 0;
    font-size: 16px;
}

/* Statistics Cards */
.stats-cards {
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border: 1px solid var(--color-neutral-200);
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.stat-icon.blue {
    background: var(--color-primary);
}

.stat-icon.green {
    background: var(--color-success);
}

.stat-icon.orange {
    background: var(--color-warning);
}

.stat-content h3 {
    color: var(--color-neutral-900);
    margin-bottom: 5px;
    font-weight: 700;
    font-size: 24px;
}

.stat-content p {
    color: var(--color-neutral-600);
    margin: 0;
    font-size: 14px;
    font-weight: 600;
}

/* Recent Orders Section */
.recent-orders {
    background: white;
    border: 1px solid var(--color-neutral-200);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.orders-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 20px 25px;
    border-bottom: 2px solid var(--color-primary);
}

.orders-header h3 {
    color: var(--color-neutral-900);
    margin: 0;
    font-weight: 600;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.orders-header h3 i {
    color: var(--color-primary);
}

.orders-table {
    padding: 0;
}

.orders-table table {
    margin: 0;
    background: white;
}

.orders-table th {
    background: var(--color-neutral-100);
    color: var(--color-neutral-900);
    font-weight: 700;
    padding: 15px;
    border: none;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.orders-table td {
    padding: 15px;
    border-bottom: 1px solid #f1f3f4;
    vertical-align: middle;
}

.orders-table tbody tr:hover {
    background: #f8f9fa;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-completed {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.status-pending {
    background: #fffbeb;
    color: #92400e;
    border: 1px solid #fde68a;
}

.status-shipped {
    background: #eff6ff;
    color: #1e40af;
    border: 1px solid #bfdbfe;
}

.status-cancelled {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.view-details {
    color: var(--color-primary);
    text-decoration: none;
    font-weight: 600;
    padding: 6px 12px;
    border: 1px solid var(--color-primary);
    border-radius: 6px;
    transition: all 0.3s ease;
}

.view-details:hover {
    background: var(--color-primary);
    color: white;
    text-decoration: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        padding: 25px 20px;
    }
    
    .page-header h1 {
        font-size: 24px;
    }
    
    .dashboard-content {
        padding: 20px;
    }
    
    .welcome-card {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }
    
    .stat-card {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }
    
    .orders-header {
        padding: 15px 20px;
    }
    
    .orders-table th,
    .orders-table td {
        padding: 10px 8px;
        font-size: 14px;
    }
}
</style>

<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Customer Dashboard</h1>
                    <p class="text-muted">Manage your account and track your orders</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class="col-md-9">
                <div class="dashboard-content">
                    <!-- Welcome Card -->
                    <div class="welcome-card">
                        <div class="welcome-avatar">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="welcome-info">
                            <h3>Welcome Back!</h3>
                            <p><?php echo $_SESSION['customer']['cust_name']; ?></p>
                        </div>
                    </div>
                    
                    <!-- Statistics Cards -->
                    <div class="row stats-cards">
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="stat-icon blue">
                                    <i class="fa fa-shopping-bag"></i>
                                </div>
                                <div class="stat-content">
                                    <h3><?php echo $total_orders; ?></h3>
                                    <p>Total Orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="stat-icon green">
                                    <i class="fa fa-rupee"></i>
                                </div>
                                <div class="stat-content">
                                    <h3>₹<?php echo number_format($total_spent, 0); ?></h3>
                                    <p>Total Spent</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="stat-icon orange">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <div class="stat-content">
                                    <h3><?php echo $pending_orders; ?></h3>
                                    <p>Pending Orders</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Orders -->
                    <div class="recent-orders">
                        <div class="orders-header">
                            <h3><i class="fa fa-refresh"></i> Recent Orders</h3>
                        </div>
                        <div class="orders-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_id=? ORDER BY id DESC LIMIT 5");
                                    $statement->execute(array($customer_id));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    if(count($result) > 0) {
                                        foreach ($result as $row) {
                                            // Determine status badge (prioritize Cancelled / Returned)
                                            $order_status = isset($row['order_status']) ? $row['order_status'] : 'Pending';
                                            $display_status = $order_status === 'Cancelled' ? 'Cancelled' : ($order_status === 'Returned' ? 'Returned' : $row['shipping_status']);
                                            $status_class = '';
                                            if($display_status === 'Cancelled') {
                                                $status_class = 'status-cancelled';
                                            } elseif($display_status === 'Returned') {
                                                $status_class = 'status-pending';
                                            } else {
                                                switch($display_status) {
                                                    case 'Completed': $status_class = 'status-completed'; break;
                                                    case 'Pending': $status_class = 'status-pending'; break;
                                                    case 'Shipped': $status_class = 'status-shipped'; break;
                                                    default: $status_class = 'status-pending';
                                                }
                                            }

                                            // Fetch product list for this payment
                                            $statementP = $pdo->prepare("SELECT product_name FROM tbl_order WHERE payment_id=?");
                                            $statementP->execute(array($row['payment_id']));
                                            $products = $statementP->fetchAll(PDO::FETCH_ASSOC);
                                            $product_names = array_map(function($p){ return $p['product_name']; }, $products);
                                            $product_list_text = implode(', ', $product_names);
                                            ?>
                                            <tr>
                                                <td><strong><?php echo $row['invoice_number']; ?></strong></td>
                                                <td><?php echo date('M d, Y', strtotime($row['payment_date'])); ?></td>
                                                <td><strong>₹<?php echo number_format($row['paid_amount'], 2); ?></strong></td>
                                                <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $display_status; ?></span></td>
                                                <td>
                                                    <?php if($display_status === 'Cancelled') { ?>
                                                        <span style="color:#991b1b; font-weight:600;">Cancelled:</span>
                                                        <span class="text-muted"><?php echo htmlspecialchars($product_list_text); ?></span>
                                                    <?php } else { ?>
                                                        <a href="customer-order.php" class="view-details">View Details</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="5" class="text-center">No orders found</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>