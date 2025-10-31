<?php require_once('header.php'); ?>

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

.seller-status-badge {
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

.seller-stats-badge {
    padding: 0.3rem 0.6rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    margin: 0.2rem;
    display: inline-block;
}

.stats-products {
    background: linear-gradient(135deg, #36b9cc, #258391);
    color: white;
}

.stats-orders {
    background: linear-gradient(135deg, #1cc88a, #17a673);
    color: white;
}

.stats-earnings {
    background: linear-gradient(135deg, #f6c23e, #dda20a);
    color: white;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

/* Animation keyframes */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Animation classes */
.fade-in {
    animation: fadeIn 0.6s ease-out;
}

.slide-in {
    animation: slideIn 0.8s ease-out;
}

/* Enhanced hover effects */
.seller-info:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.contact-info:hover {
    transform: scale(1.02);
    transition: all 0.3s ease;
}

.seller-stats-badge {
    transition: all 0.3s ease;
}

.seller-stats-badge:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.seller-status-badge {
    transition: all 0.3s ease;
}

.seller-status-badge:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.search-box {
    transition: all 0.3s ease;
}

.search-box:hover {
    border-color: #a78bfa;
    box-shadow: 0 2px 8px rgba(167, 139, 250, 0.1);
}

.btn-fix-status {
    transition: all 0.3s ease;
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

.btn-change-status {
    background: linear-gradient(135deg, #1cc88a, #17a673);
    color: white;
}

.btn-change-status:hover {
    background: linear-gradient(135deg, #17a673, #138f5f);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(28, 200, 138, 0.3);
    color: white;
    text-decoration: none;
}

.btn-delete {
    background: linear-gradient(135deg, #e74a3b, #c0392b);
    color: white;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #c0392b, #a93226);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(231, 74, 59, 0.3);
    color: white;
    text-decoration: none;
}

.btn-fix-status {
    background: linear-gradient(135deg, #f6c23e, #dda20a);
    color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-fix-status:hover {
    background: linear-gradient(135deg, #dda20a, #b7950b);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(246, 194, 62, 0.3);
    color: white;
    text-decoration: none;
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

.seller-info {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.seller-name {
    font-weight: 600;
    color: #2c3e50;
}

.seller-company {
    font-size: 0.9rem;
    color: #7f8c8d;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
    font-size: 0.9rem;
}

.modern-modal .modal-content {
    border-radius: 10px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.modern-modal .modal-header {
    background: linear-gradient(135deg, #e74a3b, #c0392b);
    color: white;
    border-radius: 10px 10px 0 0;
    border-bottom: none;
}

.modern-modal .modal-title {
    font-weight: 600;
}

.modern-modal .modal-body {
    padding: 2rem;
    font-size: 1.1rem;
}
</style>

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-users"></i>
        Seller Management
    </h1>
    <div class="subtitle">Manage and monitor all registered sellers on your platform</div>
    <div style="margin-top: 1rem;">
        <a href="fix-seller-status.php" class="btn-fix-status">
            <i class="fa fa-wrench"></i> Fix Seller Status Issues
        </a>
    </div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-6">
            <input type="text" id="sellerSearch" class="search-box" placeholder="🔍 Search sellers by name, company, email...">
        </div>
        <div class="col-md-3">
            <select id="statusFilter" class="search-box">
                <option value="">All Status</option>
                <option value="active">Active Sellers</option>
                <option value="inactive">Inactive Sellers</option>
            </select>
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Total Sellers: <span id="totalCount">0</span>
            </div>
        </div>
    </div>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="modern-table-container slide-in">
				<div class="table-responsive">
					<table id="sellersTable" class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Seller Info</th>
								<th>Contact Details</th>
								<th>Business Info</th>
								<th>Performance Stats</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$i=0;
						$statement = $pdo->prepare("SELECT * FROM sellers ORDER BY fullname ASC");
						$statement->execute();
						$result = $statement->fetchAll(PDO::FETCH_ASSOC);
						foreach ($result as $row) {
							$i++;
							
							// Get total products for this seller
							$stmt_products = $pdo->prepare("SELECT COUNT(*) as total_products FROM tbl_product WHERE seller_id = ? AND p_is_active = 1");
							$stmt_products->execute(array($row['id']));
							$product_result = $stmt_products->fetch(PDO::FETCH_ASSOC);
							$total_products = $product_result['total_products'];
							
							// Get total orders for this seller
							$stmt_orders = $pdo->prepare("SELECT COUNT(DISTINCT o.payment_id) as total_orders FROM tbl_order o 
														  INNER JOIN tbl_product p ON o.product_id = p.p_id 
														  WHERE p.seller_id = ?");
							$stmt_orders->execute(array($row['id']));
							$order_result = $stmt_orders->fetch(PDO::FETCH_ASSOC);
							$total_orders = $order_result['total_orders'];
							
							// Get total earnings for this seller
							$stmt_earnings = $pdo->prepare("SELECT SUM(o.unit_price * o.quantity) as total_earnings FROM tbl_order o 
														   INNER JOIN tbl_product p ON o.product_id = p.p_id 
														   INNER JOIN tbl_payment pay ON o.payment_id = pay.payment_id
														   WHERE p.seller_id = ? AND pay.payment_status = 'Completed'");
							$stmt_earnings->execute(array($row['id']));
							$earnings_result = $stmt_earnings->fetch(PDO::FETCH_ASSOC);
							$total_earnings = $earnings_result['total_earnings'] ? $earnings_result['total_earnings'] : 0;
							?>
							<tr data-status="<?php echo $row['status']==1 ? 'active' : 'inactive'; ?>">
								<td><?php echo $i; ?></td>
								<td>
									<div class="seller-info">
										<div class="seller-name"><?php echo htmlspecialchars($row['fullname']); ?></div>
										<div class="seller-company">
											<i class="fa fa-building"></i> <?php echo htmlspecialchars($row['company_name']); ?>
										</div>
									</div>
								</td>
								<td>
									<div class="contact-info">
										<div><i class="fa fa-envelope"></i> <?php echo htmlspecialchars($row['email']); ?></div>
										<div><i class="fa fa-phone"></i> <?php echo htmlspecialchars($row['phone']); ?></div>
									</div>
								</td>
								<td>
									<div style="font-size: 0.9rem;">
										<div><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($row['company_address']); ?></div>
										<?php if(!empty($row['gstno'])): ?>
										<div style="margin-top: 0.3rem;"><strong>GST:</strong> <?php echo htmlspecialchars($row['gstno']); ?></div>
										<?php endif; ?>
									</div>
								</td>
								<td>
									<div>
										<span class="seller-stats-badge stats-products">
											<i class="fa fa-cube"></i> <?php echo $total_products; ?> Products
										</span>
									</div>
									<div>
										<span class="seller-stats-badge stats-orders">
											<i class="fa fa-shopping-cart"></i> <?php echo $total_orders; ?> Orders
										</span>
									</div>
									<div>
										<span class="seller-stats-badge stats-earnings">
											<i class="fa fa-rupee"></i> ₹<?php echo number_format($total_earnings, 2); ?>
										</span>
									</div>
								</td>
								<td>
									<span class="seller-status-badge <?php echo $row['status']==1 ? 'status-active' : 'status-inactive'; ?>">
										<i class="fa fa-<?php echo $row['status']==1 ? 'check-circle' : 'times-circle'; ?>"></i>
										<?php echo $row['status']==1 ? 'Active' : 'Inactive'; ?>
									</span>
								</td>
								<td>
									<div class="action-buttons">
										<a href="seller-change-status.php?id=<?php echo $row['id']; ?>" class="modern-btn btn-change-status">
											<i class="fa fa-toggle-on"></i> Change Status
										</a>
										<a href="#" class="modern-btn btn-delete" data-href="seller-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">
											<i class="fa fa-trash"></i> Delete
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

<div class="modal fade modern-modal" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <i class="fa fa-exclamation-triangle"></i> Delete Seller Confirmation
                </h4>
            </div>
            <div class="modal-body">
                <p><strong>Warning:</strong> This action will permanently delete the seller and all associated data.</p>
                <p>Are you sure you want to proceed? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <a class="btn btn-danger btn-ok">
                    <i class="fa fa-trash"></i> Delete Seller
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('sellerSearch');
    const statusFilter = document.getElementById('statusFilter');
    const table = document.getElementById('sellersTable');
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
            const matchesStatus = statusValue === '' || status === statusValue;
            
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

<?php require_once('footer.php'); ?> 