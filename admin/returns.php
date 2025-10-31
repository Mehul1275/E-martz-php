<?php require_once('header.php'); ?>
<?php require_once('inc/tracking_functions.php'); ?>

<?php
// PHPMailer includes and namespace imports
require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
?>

<style>
.modern-page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.modern-page-header h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.modern-page-header .subtitle {
    margin-top: 0.5rem;
    opacity: 0.9;
    font-size: 1.1rem;
}

.modern-filter-bar {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
}

.modern-table-container {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
}

.modern-table-container table {
    margin-bottom: 0;
}

.modern-table-container thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    border: none;
    font-weight: 600;
    color: #5a5c69;
    padding: 1rem 0.75rem;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.modern-table-container tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #e3e6f0;
}

.modern-table-container tbody tr:hover {
    background-color: #f8f9fc;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.search-box {
    width: 100%;
    padding: 0.8rem 1rem;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-box:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.modern-btn {
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-approve {
    background: linear-gradient(135deg, #1cc88a, #17a673);
    color: white;
}

.btn-approve:hover {
    background: linear-gradient(135deg, #17a673, #138f5f);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(28, 200, 138, 0.3);
    color: white;
    text-decoration: none;
}

.btn-reject {
    background: linear-gradient(135deg, #e74a3b, #c0392b);
    color: white;
}

.btn-reject:hover {
    background: linear-gradient(135deg, #c82333, #bd2130);
    transform: translateY(-1px);
    color: white;
}

.return-status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active {
    background: linear-gradient(135deg, #1cc88a, #17a673);
    color: white;
}

.status-inactive {
    background: linear-gradient(135deg, #e74a3b, #c0392b);
    color: white;
}

.status-warning {
    background: linear-gradient(135deg, #f6c23e, #dda20a);
    color: white;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}
</style>
<?php
// Approve return
if(isset($_GET['approve'])) {
    $id = (int)$_GET['approve'];
    // Only approve if order_status is 'Returned' (not 'Return Rejected')
    $statement = $pdo->prepare("UPDATE tbl_payment SET return_approved_by_admin=1 WHERE id=? AND order_status='Returned'");
    $statement->execute(array($id));

    // Send email to customer about return approval
    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
    $statement->execute(array($id));
    $order = $statement->fetch(PDO::FETCH_ASSOC);

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

            $mail->setFrom('emartz6976@gmail.com', 'E-martz Admin');
            $mail->addAddress($order['customer_email']);

            $mail->isHTML(true);
            $mail->Subject = 'Return Request Approved - Order #' . $order['payment_id'];
            $mail->Body    = 'Dear ' . $order['customer_name'] . ',<br><br>Your return request for order #' . $order['payment_id'] . ' has been approved. The return process will be initiated shortly.<br><br>Thank you for shopping with us.<br><br>Best regards,<br>E-martz Team';

            $mail->send();
        } catch (Exception $e) {
            // Log error but don't stop execution
            error_log("Return approval email failed: " . $mail->ErrorInfo);
        }
    }

    header('Location: returns.php');
    exit;
}
// Reject return (set to Return Rejected)
if(isset($_GET['reject'])) {
    $id = (int)$_GET['reject'];
    $statement = $pdo->prepare("UPDATE tbl_payment SET order_status='Return Rejected', return_approved_by_admin=0 WHERE id=? AND order_status='Returned'");
    $statement->execute(array($id));

    // Send email to customer about return rejection
    $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
    $statement->execute(array($id));
    $order = $statement->fetch(PDO::FETCH_ASSOC);

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

            $mail->setFrom('emartz6976@gmail.com', 'E-martz Admin');
            $mail->addAddress($order['customer_email']);

            $mail->isHTML(true);
            $mail->Subject = 'Return Request Rejected - Order #' . $order['payment_id'];
            $mail->Body    = 'Dear ' . $order['customer_name'] . ',<br><br>We regret to inform you that your return request for order #' . $order['payment_id'] . ' has been rejected. If you have any questions, please contact our customer support.<br><br>Thank you for shopping with us.<br><br>Best regards,<br>E-martz Team';

            $mail->send();
        } catch (Exception $e) {
            // Log error but don't stop execution
            error_log("Return rejection email failed: " . $mail->ErrorInfo);
        }
    }

    header('Location: returns.php');
    exit;
}
?>
<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-undo"></i>
        Return Orders Management
    </h1>
    <div class="subtitle">Review and manage customer return requests</div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-6">
            <input type="text" id="returnSearch" class="search-box" placeholder="🔍 Search returns by customer, product, payment ID...">
        </div>
        <div class="col-md-3">
            <select id="statusFilter" class="search-box">
                <option value="">All Status</option>
                <option value="returned">Pending Returns</option>
                <option value="return rejected">Rejected Returns</option>
                <option value="approved">Approved Returns</option>
            </select>
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Total Returns: <span id="totalCount">0</span>
            </div>
        </div>
    </div>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="modern-table-container slide-in">
				<div class="table-responsive">
					<table id="returnsTable" class="table">
			<thead>
				<tr>
					<th width="10">#</th>
					<th width="200">Customer Information</th>
					<th width="250">Product Details</th>
					<th width="180">Payment Information</th>
					<th width="100">Paid Amount</th>
					<th width="120">Order Status</th>
					<th width="200">Return Reason</th>
					<th width="150">Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$i=0;
			$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE order_status IN ('Returned', 'Return Rejected') ORDER BY id DESC");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $row) {
				$i++;
				?>
				<tr data-status="<?php echo strtolower(str_replace(' ', '-', $row['order_status'])); ?>">
					<td><?php echo $i; ?></td>
					<td>
						<div class="return-customer-info">
							<div class="customer-name"><?php echo htmlspecialchars($row['customer_name']); ?></div>
							<div class="customer-details">
								<i class="fa fa-id-card"></i> ID: <?php echo $row['customer_id']; ?>
							</div>
							<div class="customer-details">
								<i class="fa fa-envelope"></i> <?php echo htmlspecialchars($row['customer_email']); ?>
							</div>
						</div>
					</td>
					<td>
						<div class="product-details">
							<?php
							$statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
							$statement1->execute(array($row['payment_id']));
							$items = $statement1->fetchAll(PDO::FETCH_ASSOC);
							foreach ($items as $it) {
								echo '<div class="product-item">';
								echo '<strong>' . htmlspecialchars($it['product_name']) . '</strong><br>';
								echo '<small>Size: ' . htmlspecialchars($it['size']) . ' | Color: ' . htmlspecialchars($it['color']) . '</small><br>';
								echo '<small>Qty: ' . $it['quantity'] . ' | Price: ₹' . $it['unit_price'] . '</small>';
								echo '</div>';
							}
							?>
						</div>
					</td>
					<td>
						<div class="payment-info">
							<strong>Method:</strong> <?php echo htmlspecialchars($row['payment_method']); ?><br>
							<strong>Date:</strong> <?php echo date('d M Y', strtotime($row['payment_date'])); ?><br>
							<strong>Txn ID:</strong> <?php echo htmlspecialchars($row['txnid']); ?>
						</div>
					</td>
					<td>
						<span class="amount-display">₹<?php echo number_format($row['paid_amount'], 2); ?></span>
					</td>
					<td>
						<?php if($row['order_status'] == 'Return Rejected'): ?>
							<span class="return-status-badge status-inactive">
								<i class="fa fa-times-circle"></i> Return Rejected
							</span>
						<?php else: ?>
							<span class="return-status-badge status-warning">
								<i class="fa fa-clock-o"></i> Returned
							</span>
						<?php endif; ?>
					</td>
					<td>
						<div class="return-reason">
							<?php echo htmlspecialchars($row['return_reason']); ?>
						</div>
					</td>
					<td>
						<div class="action-buttons">
							<?php if($row['order_status'] == 'Return Rejected'): ?>
								<span class="return-status-badge status-inactive">
									<i class="fa fa-ban"></i> Rejected
								</span>
							<?php elseif($row['return_approved_by_admin']): ?>
								<span class="return-status-badge status-active">
									<i class="fa fa-check-circle"></i> Approved
								</span>
							<?php elseif($row['order_status'] == 'Returned'): ?>
								<a href="returns.php?approve=<?php echo $row['id']; ?>" class="modern-btn btn-approve" onclick="return confirm('Are you sure you want to approve this return?')">
									<i class="fa fa-check"></i> Approve
								</a>
								<a href="returns.php?reject=<?php echo $row['id']; ?>" class="modern-btn btn-reject" onclick="return confirm('Are you sure you want to reject this return?')">
									<i class="fa fa-times"></i> Reject
								</a>
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
		</div>
	</div>
</section>

<script>
// Search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('returnSearch');
    const statusFilter = document.getElementById('statusFilter');
    const table = document.getElementById('returnsTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    const totalCountSpan = document.getElementById('totalCount');
    
    // Update total count initially
    updateTotalCount();
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent.toLowerCase();
            const status = row.getAttribute('data-status');
            
            const matchesSearch = text.includes(searchTerm);
            let matchesStatus = true;
            
            if (statusValue) {
                if (statusValue === 'approved') {
                    matchesStatus = text.includes('approved');
                } else {
                    matchesStatus = status === statusValue;
                }
            }
            
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
        
        totalCountSpan.textContent = visibleCount;
    }
    
    function updateTotalCount() {
        totalCountSpan.textContent = rows.length;
    }
    
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
});
</script>

<style>
.return-customer-info {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.customer-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 1rem;
}

.customer-details {
    font-size: 0.9rem;
    color: #7f8c8d;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.product-details, .payment-info {
    font-size: 0.9rem;
    line-height: 1.4;
}

.product-item {
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e5e7eb;
    background: #f8f9fc;
    padding: 0.5rem;
    border-radius: 4px;
}

.product-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.amount-display {
    font-weight: 700;
    font-size: 1.2rem;
    color: #1cc88a;
    background: linear-gradient(135deg, #e8f5e8, #d4edda);
    padding: 0.5rem;
    border-radius: 6px;
    text-align: center;
}

.return-reason {
    font-size: 0.9rem;
    line-height: 1.4;
    max-width: 200px;
    word-wrap: break-word;
    background: #fff3cd;
    padding: 0.5rem;
    border-radius: 4px;
    border-left: 4px solid #ffc107;
}

.payment-info {
    background: #f8f9fc;
    padding: 0.5rem;
    border-radius: 4px;
    border-left: 4px solid #667eea;
}

.fade-in {
    animation: fadeIn 0.6s ease-out;
}

.slide-in {
    animation: slideIn 0.8s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
<?php require_once('footer.php'); ?>


