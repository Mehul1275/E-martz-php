<?php
require_once('admin/inc/config.php');
require_once('admin/inc/functions.php');

if (!isset($_GET['payment_id'])) {
    die('No invoice specified.');
}
$payment_id = $_GET['payment_id'];

// Fetch payment info
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
$statement->execute([$payment_id]);
$payment = $statement->fetch(PDO::FETCH_ASSOC);
if (!$payment) {
    die('Invoice not found.');
}

// Fetch order items
$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
$statement->execute([$payment_id]);
$order_items = $statement->fetchAll(PDO::FETCH_ASSOC);

// Calculate total
$total = 0;
foreach ($order_items as $item) {
    $total += $item['unit_price'] * $item['quantity'];
}

$invoice_number = $payment['invoice_number'];

// Get company settings
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$settings = $statement->fetch(PDO::FETCH_ASSOC);

// Get seller information for the first product
$seller_info = null;
if (!empty($order_items)) {
    $first_product_id = $order_items[0]['product_id'];
    $statement = $pdo->prepare("SELECT s.* FROM sellers s 
                                INNER JOIN tbl_product p ON s.id = p.seller_id 
                                WHERE p.p_id = ?");
    $statement->execute([$first_product_id]);
    $seller_info = $statement->fetch(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?php echo htmlspecialchars($invoice_number); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .invoice-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .company-logo {
            max-width: 150px;
            max-height: 60px;
            margin-bottom: 15px;
        }
        
        .company-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .company-tagline {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .invoice-details {
            display: flex;
            justify-content: space-between;
            padding: 30px;
            border-bottom: 2px solid #eee;
        }
        
        .invoice-info {
            flex: 1;
        }
        
        .invoice-number {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .invoice-date {
            color: #666;
            font-size: 14px;
        }
        
        .parties-info {
            display: flex;
            justify-content: space-between;
            padding: 30px;
            border-bottom: 2px solid #eee;
        }
        
        .seller-info, .customer-info {
            flex: 1;
            margin: 0 15px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #667eea;
        }
        
        .info-item {
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        
        .products-table th {
            background: #f8f9fa;
            padding: 15px 10px;
            text-align: left;
            font-weight: bold;
            color: #333;
            border-bottom: 2px solid #dee2e6;
        }
        
        .products-table td {
            padding: 15px 10px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: top;
        }
        
        .products-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .product-name {
            font-weight: bold;
            color: #333;
        }
        
        .product-details {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        
        .total-section {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: right;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
        }
        
        .footer {
            background: #333;
            color: white;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .contact-info {
            text-align: left;
        }
        
        .website-info {
            text-align: right;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        @media print {
            body { background: white; }
            .invoice-container { box-shadow: none; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <?php if (!empty($settings['logo'])): ?>
                <img src="assets/uploads/<?php echo htmlspecialchars($settings['logo']); ?>" alt="Company Logo" class="company-logo">
            <?php endif; ?>
            <div class="company-name"><?php echo htmlspecialchars($settings['meta_title_home'] ?? 'E-Martz'); ?></div>
            <div class="company-tagline">Your Trusted Online Shopping Destination</div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="invoice-info">
                <div class="invoice-number">INVOICE #<?php echo htmlspecialchars($invoice_number); ?></div>
                <div class="invoice-date">Date: <?php echo date('F j, Y', strtotime($payment['payment_date'])); ?></div>
                <div class="invoice-date">Time: <?php echo date('g:i A', strtotime($payment['payment_date'])); ?></div>
            </div>
            <div class="status-badge status-<?php echo strtolower($payment['payment_status']); ?>">
                <?php echo htmlspecialchars($payment['payment_status']); ?>
            </div>
        </div>

        <!-- Parties Information -->
        <div class="parties-info">
            <!-- Seller Information -->
            <div class="seller-info">
                <div class="section-title">From</div>
                <?php if ($seller_info): ?>
                    <div class="info-item">
                        <span class="info-label">Company:</span> <?php echo htmlspecialchars($seller_info['company_name']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Contact:</span> <?php echo htmlspecialchars($seller_info['fullname']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span> <?php echo htmlspecialchars($seller_info['email']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone:</span> <?php echo htmlspecialchars($seller_info['phone']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Address:</span> <?php echo htmlspecialchars($seller_info['company_address']); ?>
                    </div>
                    <?php if (!empty($seller_info['gstno'])): ?>
                    <div class="info-item">
                        <span class="info-label">GST No:</span> <?php echo htmlspecialchars($seller_info['gstno']); ?>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="info-item">
                        <span class="info-label">Company:</span> <?php echo htmlspecialchars($settings['meta_title_home'] ?? 'E-Martz'); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span> <?php echo htmlspecialchars($settings['contact_email']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone:</span> <?php echo htmlspecialchars($settings['contact_phone']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Address:</span> <?php echo htmlspecialchars($settings['contact_address']); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Customer Information -->
            <div class="customer-info">
                <div class="section-title">Bill To</div>
                <div class="info-item">
                    <span class="info-label">Name:</span> <?php echo htmlspecialchars($payment['customer_name']); ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span> <?php echo htmlspecialchars($payment['customer_email']); ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Transaction ID:</span> <?php echo htmlspecialchars($payment['txnid']); ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Payment Method:</span> <?php echo htmlspecialchars($payment['payment_method']); ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Shipping Status:</span> <?php echo htmlspecialchars($payment['shipping_status']); ?>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div style="padding: 0 30px;">
            <table class="products-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 40%;">Product Details</th>
                        <th style="width: 10%;">Size</th>
                        <th style="width: 10%;">Color</th>
                        <th style="width: 10%;">Qty</th>
                        <th style="width: 12%;">Unit Price</th>
                        <th style="width: 13%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach ($order_items as $item): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                            <div class="product-name"><?php echo htmlspecialchars($item['product_name']); ?></div>
                            <div class="product-details">
                                Product ID: <?php echo htmlspecialchars($item['product_id']); ?>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($item['size'] ?: 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($item['color'] ?: 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>₹<?php echo number_format($item['unit_price'], 2); ?></td>
                        <td>₹<?php echo number_format($item['unit_price'] * $item['quantity'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>₹<?php echo number_format($total, 2); ?></span>
            </div>
            <div class="total-row">
                <span>Tax (0%):</span>
                <span>₹0.00</span>
            </div>
            <div class="total-row">
                <span>Shipping:</span>
                <span>₹0.00</span>
            </div>
            <div class="total-row total-amount">
                <span>Total Amount:</span>
                <span>₹<?php echo number_format($total, 2); ?></span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                <div class="contact-info">
                    <div>Contact: <?php echo htmlspecialchars($settings['contact_email']); ?></div>
                    <div>Phone: <?php echo htmlspecialchars($settings['contact_phone']); ?></div>
                    <div>Address: <?php echo htmlspecialchars($settings['contact_address']); ?></div>
                </div>
                <div class="website-info">
                    <div>Website: www.e-martz.com</div>
                    <div>Thank you for your business!</div>
                    <div style="margin-top: 10px; font-size: 10px; opacity: 0.8;">
                        This is a computer generated invoice. No signature required.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 