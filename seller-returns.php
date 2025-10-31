<?php
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("seller-header.php");

// PHPMailer includes and namespace imports
require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(!isset($_SESSION['seller'])) {
    header('Location: seller-login.php');
    exit;
}
$seller_id = $_SESSION['seller']['id'];

// Approve/Reject for this seller's orders only (admin approval flag reused for visibility)
if(isset($_GET['approve'])) {
    $id = (int)$_GET['approve'];
    $stmt = $pdo->prepare("UPDATE tbl_payment SET return_approved_by_admin=1 WHERE id=?");
    $stmt->execute(array($id));

    // Send email to customer about return approval
    $stmt = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
    $stmt->execute(array($id));
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if($order && !empty($order['customer_email'])) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'emartz6976@gmail.com';
            $mail->Password   = 'saeq xbcv bhuh tgby';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('emartz6976@gmail.com', 'E-martz Seller');
            $mail->addAddress($order['customer_email']);

            $mail->isHTML(true);
            $mail->Subject = 'Return Request Approved - Order #' . $order['payment_id'];
            $mail->Body    = 'Dear ' . $order['customer_name'] . ',<br><br>Your return request for order #' . $order['payment_id'] . ' has been approved by the seller. The return process will be initiated shortly.<br><br>Thank you for shopping with us.<br><br>Best regards,<br>E-martz Team';

            $mail->send();
        } catch (Exception $e) {
            // Log error but don't stop execution
            error_log("Return approval email failed: " . $mail->ErrorInfo);
        }
    }

    header('Location: seller-returns.php');
    exit;
}
if(isset($_GET['reject'])) {
    $id = (int)$_GET['reject'];
    $stmt = $pdo->prepare("UPDATE tbl_payment SET order_status='Return Rejected', return_approved_by_admin=0 WHERE id=?");
    $stmt->execute(array($id));

    // Send email to customer about return rejection
    $stmt = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
    $stmt->execute(array($id));
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if($order && !empty($order['customer_email'])) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'emartz6976@gmail.com';
            $mail->Password   = 'saeq xbcv bhuh tgby';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('emartz6976@gmail.com', 'E-martz Seller');
            $mail->addAddress($order['customer_email']);

            $mail->isHTML(true);
            $mail->Subject = 'Return Request Rejected - Order #' . $order['payment_id'];
            $mail->Body    = 'Dear ' . $order['customer_name'] . ',<br><br>We regret to inform you that your return request for order #' . $order['payment_id'] . ' has been rejected by the seller. If you have any questions, please contact our customer support.<br><br>Thank you for shopping with us.<br><br>Best regards,<br>E-martz Team';

            $mail->send();
        } catch (Exception $e) {
            // Log error but don't stop execution
            error_log("Return rejection email failed: " . $mail->ErrorInfo);
        }
    }

    header('Location: seller-returns.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller Panel - Return Orders</title>
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
                <i class="fa fa-undo"></i>
                Return Orders
            </h1>
            <p class="seller-page-subtitle">Manage customer return requests and approvals</p>
        </div>

        <section class="content">
            <!-- Filter & Search Bar -->
            <div class="seller-filter-bar slide-in">
                <div class="filter-header">
                    <h3><i class="fa fa-filter"></i> Filter & Search Returns</h3>
                    <div class="filter-actions">
                        <button id="clearFilters" class="seller-btn-sm seller-modern-btn-secondary">
                            <i class="fa fa-refresh"></i> Clear
                        </button>
                    </div>
                </div>
                <div class="filter-content">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-search"></i> Search Returns
                            </label>
                            <div class="seller-search-box">
                                <i class="fa fa-search"></i>
                                <input type="text" id="searchReturns" 
                                       placeholder="Search by customer name, payment ID..." 
                                       class="seller-form-control">
                            </div>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-list-alt"></i> Return Status
                            </label>
                            <select id="statusFilter" class="seller-form-control seller-filter-select">
                                <option value="">All Status</option>
                                <option value="Returned">Returned</option>
                                <option value="Return Rejected">Return Rejected</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-check-circle"></i> Approval Status
                            </label>
                            <select id="approvalFilter" class="seller-form-control seller-filter-select">
                                <option value="">All Approvals</option>
                                <option value="approved">Approved</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-calendar"></i> Date Range
                            </label>
                            <select id="dateFilter" class="seller-form-control seller-filter-select">
                                <option value="">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="filter-summary">
                        <div class="results-info">
                            <span class="results-count">
                                <i class="fa fa-list"></i>
                                Showing <span id="returnCount">0</span> returns
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Returns Table -->
            <div class="seller-table-container slide-in">
                <div class="table-responsive">
                    <table class="seller-modern-table">
                                <thead>
                                    <tr>
                                        <th>Return Info</th>
                                        <th>Customer Details</th>
                                        <th>Products</th>
                                        <th>Payment & Amount</th>
                                        <th>Return Reason</th>
                                        <th>Status & Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i=0;
                                $statement = $pdo->prepare("SELECT DISTINCT p.* FROM tbl_payment p JOIN tbl_order o ON p.payment_id=o.payment_id JOIN tbl_product pr ON o.product_id=pr.p_id WHERE p.order_status IN ('Returned', 'Return Rejected') AND pr.seller_id=? ORDER BY p.id DESC");
                                $statement->execute(array($seller_id));
                                $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($rows as $row) {
                                    $i++;
                                    ?>
                                    <tr class="return-row" data-status="<?php echo htmlspecialchars($row['order_status']); ?>" data-approval="<?php echo $row['return_approved_by_admin'] ? 'approved' : ($row['order_status'] == 'Return Rejected' ? 'rejected' : 'pending'); ?>">
                                        <td class="seller-return-info">
                                            <div class="return-id">Return #<?php echo $i; ?></div>
                                            <div class="order-id">Order: <?php echo htmlspecialchars($row['payment_id']); ?></div>
                                            <div class="return-date">Date: <?php echo date('M d, Y', strtotime($row['payment_date'])); ?></div>
                                        </td>
                                        <td class="seller-customer-info">
                                            <div class="customer-name"><?php echo htmlspecialchars($row['customer_name']); ?></div>
                                            <div class="customer-email"><?php echo htmlspecialchars($row['customer_email']); ?></div>
                                            <div class="customer-id">ID: <?php echo $row['customer_id']; ?></div>
                                        </td>
                                        <td class="seller-products-list">
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT o.* FROM tbl_order o JOIN tbl_product pr ON o.product_id=pr.p_id WHERE o.payment_id=? AND pr.seller_id=?");
                                            $statement1->execute(array($row['payment_id'], $seller_id));
                                            $items = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($items as $it) {
                                                ?>
                                                <div class="product-item">
                                                    <div class="product-name"><?php echo htmlspecialchars($it['product_name']); ?></div>
                                                    <div class="product-details">
                                                        <span class="product-variant">Size: <?php echo htmlspecialchars($it['size']); ?></span>
                                                        <span class="product-variant">Color: <?php echo htmlspecialchars($it['color']); ?></span>
                                                        <span class="product-quantity">Qty: <?php echo $it['quantity']; ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="seller-payment-info">
                                            <div class="payment-method"><?php echo htmlspecialchars($row['payment_method']); ?></div>
                                            <div class="order-amount">₹<?php echo number_format($row['paid_amount'], 2); ?></div>
                                            <div class="transaction-id">Txn: <?php echo htmlspecialchars($row['txnid']); ?></div>
                                        </td>
                                        <td class="return-reason">
                                            <div class="reason-text"><?php echo htmlspecialchars($row['return_reason']); ?></div>
                                        </td>
                                        <td class="seller-status-group">
                                            <div class="status-item">
                                                <span class="status-label">Order Status</span>
                                                <?php if($row['order_status'] == 'Return Rejected'): ?>
                                                    <span class="seller-badge seller-badge-danger">
                                                        <i class="fa fa-times"></i> Return Rejected
                                                    </span>
                                                <?php else: ?>
                                                    <span class="seller-badge seller-badge-warning">
                                                        <i class="fa fa-undo"></i> Returned
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="status-item">
                                                <span class="status-label">Approval Status</span>
                                                <?php if($row['order_status'] == 'Return Rejected'): ?>
                                                    <span class="seller-badge seller-badge-danger">
                                                        <i class="fa fa-ban"></i> Rejected
                                                    </span>
                                                <?php elseif($row['return_approved_by_admin']): ?>
                                                    <span class="seller-badge seller-badge-success">
                                                        <i class="fa fa-check"></i> Approved
                                                    </span>
                                                <?php else: ?>
                                                    <div class="action-buttons">
                                                        <a href="seller-returns.php?approve=<?php echo $row['id']; ?>" 
                                                           class="seller-btn seller-btn-sm btn-complete"
                                                           onclick="return confirm('Are you sure you want to approve this return request?')">
                                                            <i class="fa fa-check"></i> Approve
                                                        </a>
                                                        <a href="seller-returns.php?reject=<?php echo $row['id']; ?>" 
                                                           class="seller-btn seller-btn-sm seller-btn-danger"
                                                           onclick="return confirm('Are you sure you want to reject this return request?')">
                                                            <i class="fa fa-times"></i> Reject
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
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
    // Search functionality
    $('#searchReturns').on('keyup', function() {
        filterReturns();
    });
    
    // Filter functionality
    $('#statusFilter, #approvalFilter, #dateFilter').on('change', function() {
        filterReturns();
    });
    
    function filterReturns() {
        const searchTerm = $('#searchReturns').val().toLowerCase();
        const statusFilter = $('#statusFilter').val();
        const approvalFilter = $('#approvalFilter').val();
        const dateFilter = $('#dateFilter').val();
        let visibleCount = 0;
        
        $('.return-row').each(function() {
            const row = $(this);
            const customerName = row.find('.customer-name').text().toLowerCase();
            const customerEmail = row.find('.customer-email').text().toLowerCase();
            const orderId = row.find('.order-id').text().toLowerCase();
            const productNames = row.find('.product-name').map(function() {
                return $(this).text().toLowerCase();
            }).get().join(' ');
            const returnReason = row.find('.reason-text').text().toLowerCase();
            
            const matchesSearch = !searchTerm || 
                customerName.includes(searchTerm) || 
                customerEmail.includes(searchTerm) || 
                orderId.includes(searchTerm) || 
                productNames.includes(searchTerm) ||
                returnReason.includes(searchTerm);
            
            const matchesStatus = !statusFilter || row.data('status') === statusFilter;
            const matchesApproval = !approvalFilter || row.data('approval') === approvalFilter;
            const matchesDate = !dateFilter || 
                (dateFilter === 'today' && moment(row.find('.return-date').text(), 'MMM D, YYYY').isSame(moment(), 'day')) ||
                (dateFilter === 'week' && moment(row.find('.return-date').text(), 'MMM D, YYYY').isSame(moment(), 'week')) ||
                (dateFilter === 'month' && moment(row.find('.return-date').text(), 'MMM D, YYYY').isSame(moment(), 'month'));
            
            if (matchesSearch && matchesStatus && matchesApproval && matchesDate) {
                row.show();
                visibleCount++;
            } else {
                row.hide();
            }
        });
        
        $('#returnCount').text(visibleCount);
    }
    
    // Add animations
    setTimeout(function() {
        $('.fade-in').addClass('visible');
        $('.slide-in').addClass('visible');
    }, 100);
    
    // Auto-focus search on page load
    $('#searchReturns').focus();
});
</script>

<style>
/* Additional styles for returns page */
.seller-return-info {
    text-align: left;
}

.return-id {
    font-weight: 700;
    color: var(--seller-primary);
    font-size: 1rem;
    margin-bottom: var(--spacing-xs);
}

.return-date {
    font-size: 0.8rem;
    color: var(--seller-secondary);
}

.return-reason {
    max-width: 200px;
}

.reason-text {
    font-size: 0.9rem;
    color: var(--seller-dark);
    line-height: 1.4;
    padding: var(--spacing-sm);
    background: rgba(44, 90, 160, 0.05);
    border-radius: var(--border-radius-sm);
    border-left: 3px solid var(--seller-warning);
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-xs);
}

.seller-btn-danger {
    background: var(--seller-gradient-danger);
    color: white;
}

.seller-btn-danger:hover {
    background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
    transform: translateY(-1px);
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
