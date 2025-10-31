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
        Customer Management
    </h1>
    <div class="subtitle">Manage and monitor all registered customers on your platform</div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-6">
            <input type="text" id="customerSearch" class="search-box" placeholder="🔍 Search customers by name, email, phone...">
        </div>
        <div class="col-md-3">
            <select id="statusFilter" class="search-box">
                <option value="">All Status</option>
                <option value="active">Active Customers</option>
                <option value="inactive">Inactive Customers</option>
            </select>
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Total Customers: <span id="totalCount">0</span>
            </div>
        </div>
    </div>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="modern-table-container slide-in">
				<div class="table-responsive">
					<table id="customersTable" class="table">
						<thead>
							<tr>
								<th width="10">#</th>
								<th width="200">Customer Information</th>
								<th width="180">Contact Details</th>
								<th width="200">Location</th>
								<th width="120">Registration Date</th>
								<th width="100">Status</th>
								<th width="150">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT t1.*, t2.country_name 
														FROM tbl_customer t1
														JOIN tbl_country t2
														ON t1.cust_country = t2.country_id
														ORDER BY t1.cust_id DESC
													");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);						
							foreach ($result as $row) {
								$i++;
								?>
								<tr data-status="<?php echo $row['cust_status']==1 ? 'active' : 'inactive'; ?>">
									<td><?php echo $i; ?></td>
									<td>
										<div class="customer-info">
											<div class="customer-name"><?php echo htmlspecialchars($row['cust_name']); ?></div>
											<div class="customer-id">
												<i class="fa fa-id-card"></i> ID: #<?php echo $row['cust_id']; ?>
											</div>
										</div>
									</td>
									<td>
										<div class="contact-info">
											<div class="email-info">
												<i class="fa fa-envelope" style="color: #667eea;"></i>
												<span><?php echo htmlspecialchars($row['cust_email']); ?></span>
											</div>
											<?php if(!empty($row['cust_phone'])): ?>
											<div class="phone-info">
												<i class="fa fa-phone" style="color: #10b981;"></i>
												<span><?php echo htmlspecialchars($row['cust_phone']); ?></span>
											</div>
											<?php endif; ?>
										</div>
									</td>
									<td>
										<div class="location-info">
											<div class="country">
												<i class="fa fa-globe" style="color: #f59e0b;"></i>
												<strong><?php echo htmlspecialchars($row['country_name']); ?></strong>
											</div>
											<div class="city-state">
												<i class="fa fa-map-marker" style="color: #ef4444;"></i>
												<?php echo htmlspecialchars($row['cust_city']); ?>, <?php echo htmlspecialchars($row['cust_state']); ?>
											</div>
										</div>
									</td>
									<td>
										<div class="registration-date">
									<?php 
									// Prefer Unix timestamp if present; fallback to MySQL datetime string
									$timestampRaw = $row['cust_timestamp'] ?? '';
									$datetimeRaw  = $row['cust_datetime'] ?? '';

									$display = '';
									if ($timestampRaw !== '' && ctype_digit((string)$timestampRaw)) {
										$display = date('d M Y', (int)$timestampRaw);
									} elseif ($datetimeRaw !== '') {
										$ts = strtotime($datetimeRaw);
										if ($ts !== false) {
											$display = date('d M Y', $ts);
										}
									}

									if ($display !== '') {
										echo '<i class="fa fa-calendar" style="color: #8b5cf6;"></i><br>' . $display;
									} else {
										echo '<span class="text-muted">N/A</span>';
									}
									?>
										</div>
									</td>
									<td>
										<span class="customer-status-badge <?php echo $row['cust_status']==1 ? 'status-active' : 'status-inactive'; ?>">
											<i class="fa fa-<?php echo $row['cust_status']==1 ? 'check-circle' : 'times-circle'; ?>"></i>
											<?php echo $row['cust_status']==1 ? 'Active' : 'Inactive'; ?>
										</span>
									</td>
									<td>
										<div class="action-buttons">
											<a href="customer-change-status.php?id=<?php echo $row['cust_id']; ?>" class="modern-btn btn-change-status">
												<i class="fa fa-toggle-on"></i> Change Status
											</a>
											<a href="#" class="modern-btn btn-delete" data-href="customer-delete.php?id=<?php echo $row['cust_id']; ?>" data-toggle="modal" data-target="#confirm-delete">
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

<script>
// Search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('customerSearch');
    const statusFilter = document.getElementById('statusFilter');
    const table = document.getElementById('customersTable');
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

<style>
.customer-status-badge {
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

.customer-info {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.customer-name {
    font-weight: 600;
    color: #2c3e50;
}

.customer-id {
    font-size: 0.9rem;
    color: #7f8c8d;
}

.contact-info, .location-info {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
    font-size: 0.9rem;
}

.email-info, .phone-info, .country, .city-state {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.registration-date {
    text-align: center;
    font-size: 0.9rem;
}

.text-muted {
    color: #9ca3af;
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
.customer-info:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.contact-info:hover, .location-info:hover {
    transform: scale(1.02);
    transition: all 0.3s ease;
}

.customer-status-badge {
    transition: all 0.3s ease;
}

.customer-status-badge:hover {
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
</style>

<div class="modal fade modern-modal" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <i class="fa fa-exclamation-triangle"></i> Delete Customer Confirmation
                </h4>
            </div>
            <div class="modal-body">
                <p><strong>Warning:</strong> This action will permanently delete the customer and all associated data.</p>
                <p>Are you sure you want to proceed? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <a class="btn btn-danger btn-ok">
                    <i class="fa fa-trash"></i> Delete Customer
                </a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>