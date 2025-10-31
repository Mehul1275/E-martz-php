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

// Calculate payment statistics
$stmt = $pdo->prepare("
    SELECT 
        COUNT(DISTINCT p.payment_id) as total_payments,
        SUM(CASE WHEN p.payment_status = 'Completed' THEN 1 ELSE 0 END) as completed_payments,
        SUM(CASE WHEN p.payment_status = 'Pending' THEN 1 ELSE 0 END) as pending_payments,
        SUM(CASE WHEN p.payment_status = 'Completed' THEN p.paid_amount ELSE 0 END) as total_earnings
    FROM tbl_payment p
    JOIN tbl_order o ON p.payment_id = o.payment_id
    JOIN tbl_product pr ON o.product_id = pr.p_id
    WHERE pr.seller_id = ?
");
$stmt->execute([$seller_id]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller Panel - Payments</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="admin/css/_all-skins.min.css">
    <link rel="stylesheet" href="admin/css/dataTables.bootstrap.css">
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
                <i class="fa fa-credit-card"></i>
                Payment Management
            </h1>
            <p class="seller-page-subtitle">Track and monitor all your payment transactions and earnings</p>
        </div>

        <!-- Payment Statistics Dashboard -->
        <div class="row fade-in">
            <div class="col-md-3 col-sm-6">
                <div class="seller-stat-card card-earnings">
                    <div class="card-content">
                        <h3 class="card-number">₹<?php echo number_format($stats['total_earnings'] ?? 0, 2); ?></h3>
                        <p class="card-label">Total Earnings</p>
                        <div class="card-change positive">
                            <i class="fa fa-arrow-up"></i>
                            <span>All Time Revenue</span>
                        </div>
                    </div>
                    <i class="fa fa-rupee card-icon"></i>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="seller-stat-card card-orders">
                    <div class="card-content">
                        <h3 class="card-number"><?php echo $stats['total_payments'] ?? 0; ?></h3>
                        <p class="card-label">Total Payments</p>
                        <div class="card-change positive">
                            <i class="fa fa-credit-card"></i>
                            <span>All Transactions</span>
                        </div>
                    </div>
                    <i class="fa fa-credit-card card-icon"></i>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="seller-stat-card card-completed">
                    <div class="card-content">
                        <h3 class="card-number"><?php echo $stats['completed_payments'] ?? 0; ?></h3>
                        <p class="card-label">Completed</p>
                        <div class="card-change positive">
                            <i class="fa fa-check-circle"></i>
                            <span>Successfully Processed</span>
                        </div>
                    </div>
                    <i class="fa fa-check-circle card-icon"></i>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="seller-stat-card card-shipping">
                    <div class="card-content">
                        <h3 class="card-number"><?php echo $stats['pending_payments'] ?? 0; ?></h3>
                        <p class="card-label">Pending</p>
                        <div class="card-change negative">
                            <i class="fa fa-clock-o"></i>
                            <span>Awaiting Processing</span>
                        </div>
                    </div>
                    <i class="fa fa-clock-o card-icon"></i>
                </div>
            </div>
        </div>

        <section class="content">
            <!-- Filter & Search Bar -->
            <div class="seller-filter-bar slide-in">
                <div class="filter-header">
                    <h3><i class="fa fa-filter"></i> Filter & Search Payments</h3>
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
                                <i class="fa fa-search"></i> Search Payments
                            </label>
                            <div class="seller-search-box">
                                <i class="fa fa-search"></i>
                                <input type="text" id="searchPayments" 
                                       placeholder="Search by payment ID, customer name..." 
                                       class="seller-form-control">
                            </div>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-credit-card"></i> Payment Method
                            </label>
                            <select id="paymentMethodFilter" class="seller-form-control seller-filter-select">
                                <option value="">All Payment Methods</option>
                                <option value="PayPal">PayPal</option>
                                <option value="Stripe">Stripe</option>
                                <option value="Bank Deposit">Bank Deposit</option>
                                <option value="Cash on Delivery">Cash on Delivery</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-check-circle"></i> Payment Status
                            </label>
                            <select id="paymentStatusFilter" class="seller-form-control seller-filter-select">
                                <option value="">All Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
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
                                <option value="year">This Year</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="filter-summary">
                        <div class="results-info">
                            <span class="results-count">
                                <i class="fa fa-list"></i>
                                Showing <span id="paymentCount">0</span> payments
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="seller-table-container slide-in">
                        <div class="table-header">
                            <h3><i class="fa fa-table"></i> Payment Transactions</h3>
                            <div class="table-actions">
                                <button class="seller-btn-sm seller-modern-btn-primary" onclick="refreshTable()">
                                    <i class="fa fa-refresh"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="seller-modern-table">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-hashtag"></i> #</th>
                                        <th><i class="fa fa-user"></i> Customer Info</th>
                                        <th><i class="fa fa-shopping-bag"></i> Products</th>
                                        <th><i class="fa fa-credit-card"></i> Payment Details</th>
                                        <th><i class="fa fa-rupee"></i> Amount</th>
                                        <th><i class="fa fa-check-circle"></i> Payment Status</th>
                                        <th><i class="fa fa-truck"></i> Shipping</th>
                                        <th><i class="fa fa-calendar"></i> Date</th>
                                        <th><i class="fa fa-file-text"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i=0;
                                // Get all payments
                                $statement = $pdo->prepare("SELECT * FROM tbl_payment ORDER BY id DESC");
                                $statement->execute();
                                $payments = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($payments as $row) {
                                    // For each payment, get orders for this payment that belong to this seller
                                    $statement1 = $pdo->prepare(
                                        "SELECT o.* FROM tbl_order o
                                         JOIN tbl_product p ON o.product_id = p.p_id
                                         WHERE o.payment_id = ? AND p.seller_id = ?"
                                    );
                                    $statement1->execute(array($row['payment_id'], $seller_id));
                                    $orders = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                    if(count($orders) == 0) continue; // skip if no orders for this seller in this payment
                                    $i++;
                                    ?>
                                    <tr class="payment-row <?php echo $row['payment_status'] == 'Pending' ? 'seller-order-row-pending' : 'seller-order-row-completed'; ?>">
                                        <td class="text-center">
                                            <div class="payment-number"><?php echo $i; ?></div>
                                        </td>
                                        
                                        <td>
                                            <div class="seller-customer-info-box">
                                                <div class="customer-header">
                                                    <i class="fa fa-user"></i> Customer #<?php echo $row['customer_id']; ?>
                                                </div>
                                                <div class="customer-name"><?php echo htmlspecialchars($row['customer_name']); ?></div>
                                                <div class="customer-email">
                                                    <i class="fa fa-envelope"></i> <?php echo htmlspecialchars($row['customer_email']); ?>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="seller-products-list">
                                                <?php foreach ($orders as $row1): ?>
                                                <div class="product-item">
                                                    <div class="product-name">
                                                        <i class="fa fa-shopping-bag"></i> <?php echo htmlspecialchars($row1['product_name']); ?>
                                                    </div>
                                                    <div class="product-details">
                                                        <?php if($row1['size']): ?>
                                                        <span class="product-variant">
                                                            <i class="fa fa-arrows-alt"></i> <?php echo $row1['size']; ?>
                                                        </span>
                                                        <?php endif; ?>
                                                        <?php if($row1['color']): ?>
                                                        <span class="product-variant">
                                                            <i class="fa fa-paint-brush"></i> <?php echo $row1['color']; ?>
                                                        </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="product-quantity">
                                                        <i class="fa fa-cube"></i> Qty: <?php echo $row1['quantity']; ?> × ₹<?php echo number_format($row1['unit_price'], 2); ?>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="seller-payment-info-box">
                                                <div class="payment-header">
                                                    <i class="fa fa-credit-card"></i> <?php echo $row['payment_method']; ?>
                                                </div>
                                                <div class="transaction-info">
                                                    <strong>Payment ID:</strong><br>
                                                    <span class="seller-tracking-id"><?php echo $row['payment_id']; ?></span>
                                                </div>
                                                <?php if($row['txnid']): ?>
                                                <div class="transaction-id">
                                                    <strong>Transaction:</strong><br>
                                                    <small><?php echo $row['txnid']; ?></small>
                                                </div>
                                                <?php endif; ?>
                                                <?php if($row['payment_method'] == 'Bank Deposit' && $row['bank_transaction_info']): ?>
                                                <div class="bank-info">
                                                    <strong>Bank Info:</strong><br>
                                                    <small><?php echo nl2br(htmlspecialchars($row['bank_transaction_info'])); ?></small>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="seller-amount-display">
                                                ₹<?php echo number_format($row['paid_amount'], 2); ?>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="seller-status-badge <?php echo $row['payment_status'] == 'Completed' ? 'seller-status-completed' : 'seller-status-pending'; ?>">
                                                <?php if($row['payment_status'] == 'Completed'): ?>
                                                    <i class="fa fa-check-circle"></i> Completed
                                                <?php else: ?>
                                                    <i class="fa fa-clock-o"></i> Pending
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="seller-status-badge <?php 
                                                echo $row['shipping_status'] == 'Delivered' ? 'seller-status-delivered' : 
                                                    ($row['shipping_status'] == 'Shipped' ? 'seller-status-completed' : 'seller-status-pending'); 
                                            ?>">
                                                <?php if($row['shipping_status'] == 'Delivered'): ?>
                                                    <i class="fa fa-check-circle"></i> Delivered
                                                <?php elseif($row['shipping_status'] == 'Shipped'): ?>
                                                    <i class="fa fa-truck"></i> Shipped
                                                <?php else: ?>
                                                    <i class="fa fa-clock-o"></i> Pending
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="payment-date">
                                                <i class="fa fa-calendar"></i> <?php echo date('M j, Y', strtotime($row['payment_date'])); ?>
                                                <small><?php echo date('g:i A', strtotime($row['payment_date'])); ?></small>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="seller-action-buttons">
                                                <?php if($row['invoice_number']): ?>
                                                <div class="seller-invoice-number" title="Invoice Number">
                                                    <?php echo $row['invoice_number']; ?>
                                                </div>
                                                <a href="#" class="seller-modern-btn seller-modern-btn-sm seller-modern-btn-primary" 
                                                   onclick="viewInvoice('<?php echo $row['invoice_number']; ?>')" 
                                                   title="View Invoice">
                                                    <i class="fa fa-file-text"></i> Invoice
                                                </a>
                                                <?php else: ?>
                                                <small class="text-muted">No Invoice</small>
                                                <?php endif; ?>
                                                <a href="#" class="seller-modern-btn seller-modern-btn-sm seller-modern-btn-info" 
                                                   onclick="trackOrder('<?php echo $row['payment_id']; ?>')" 
                                                   title="Track Order">
                                                    <i class="fa fa-search"></i> Track
                                                </a>
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
                </div>
            </div>
        </section>
    </div>
</div>
<script src="admin/js/jquery-2.2.3.min.js"></script>
<script src="admin/js/bootstrap.min.js"></script>
<script src="admin/js/app.min.js"></script>
<script src="admin/js/jquery.dataTables.min.js"></script>
<script src="admin/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize DataTable with enhanced configuration
    var table = $('.seller-modern-table').DataTable({
        "pageLength": 15,
        "responsive": true,
        "order": [[7, 'desc']], // Sort by date column (descending)
        "dom": 'rt<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>', // Hide default search
        "columnDefs": [
            { "orderable": false, "targets": [2, 8] }, // Disable sorting for products and actions columns
            { "className": "text-center", "targets": [0, 4, 5, 6] }
        ],
        "language": {
            "emptyTable": "<div class='empty-state'><i class='fa fa-credit-card'></i><br>No payment transactions found</div>",
            "info": "Showing _START_ to _END_ of _TOTAL_ payments",
            "infoEmpty": "No payments to show",
            "infoFiltered": "(filtered from _MAX_ total payments)"
        }
    });
    
    // Update counts
    var totalPayments = <?php echo $i; ?>;
    $('#paymentCount').text(totalPayments);
    
    // Enhanced search functionality
    $('#searchPayments').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // Payment method filter
    $('#paymentMethodFilter').on('change', function() {
        var filterValue = this.value;
        if (filterValue === '') {
            table.column(3).search('').draw();
        } else {
            table.column(3).search(filterValue).draw();
        }
    });
    
    // Payment status filter
    $('#paymentStatusFilter').on('change', function() {
        var filterValue = this.value;
        if (filterValue === '') {
            table.column(5).search('').draw();
        } else {
            table.column(5).search(filterValue).draw();
        }
    });
    
    // Date filter
    $('#dateFilter').on('change', function() {
        var filterValue = this.value;
        if (filterValue === '') {
            table.column(7).search('').draw();
        } else {
            var dateRange = getDateRange(filterValue);
            table.column(7).search(dateRange).draw();
        }
    });
    
    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#searchPayments').val('');
        $('#paymentMethodFilter').val('');
        $('#paymentStatusFilter').val('');
        $('#dateFilter').val('');
        table.search('').columns().search('').draw();
    });
    
    // Add animations with stagger effect
    setTimeout(function() {
        $('.fade-in').addClass('visible');
        $('.slide-in').each(function(i) {
            var $this = $(this);
            setTimeout(function() {
                $this.addClass('visible');
            }, i * 100);
        });
    }, 100);
});

// Helper functions
function refreshTable() {
    location.reload();
}

function viewInvoice(invoiceNumber) {
    // Open invoice in new window/tab
    window.open('invoice.php?id=' + invoiceNumber, '_blank');
}

function trackOrder(paymentId) {
    // Open order tracking page
    window.open('track-order.php?payment_id=' + paymentId, '_blank');
}

function getDateRange(filterValue) {
    var today = new Date();
    var dateRange = '';
    switch (filterValue) {
        case 'today':
            dateRange = moment(today).format('MMM D, YYYY');
            break;
        case 'week':
            var startOfWeek = moment(today).startOf('week').format('MMM D, YYYY');
            var endOfWeek = moment(today).endOf('week').format('MMM D, YYYY');
            dateRange = startOfWeek + ' - ' + endOfWeek;
            break;
        case 'month':
            var startOfMonth = moment(today).startOf('month').format('MMM D, YYYY');
            var endOfMonth = moment(today).endOf('month').format('MMM D, YYYY');
            dateRange = startOfMonth + ' - ' + endOfMonth;
            break;
        case 'year':
            var startOfYear = moment(today).startOf('year').format('MMM D, YYYY');
            var endOfYear = moment(today).endOf('year').format('MMM D, YYYY');
            dateRange = startOfYear + ' - ' + endOfYear;
            break;
    }
    return dateRange;
}
</script>
</body>
</html>