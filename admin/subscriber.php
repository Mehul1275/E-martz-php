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

.subscriber-email {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    font-weight: 500;
    color: #2c3e50;
}

.subscriber-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3498db, #2980b9);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.2rem;
}

.subscriber-status {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: linear-gradient(135deg, #1cc88a, #17a673);
    color: white;
}

.action-btn {
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
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

.header-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.btn-action {
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-remove {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
}

.btn-remove:hover {
    background: linear-gradient(135deg, #e67e22, #d35400);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(243, 156, 18, 0.3);
    color: white;
    text-decoration: none;
}

.btn-export {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
}

.btn-export:hover {
    background: linear-gradient(135deg, #229954, #1e8449);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(39, 174, 96, 0.3);
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

.stats-card {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
    text-align: center;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
}

.stats-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.5rem;
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

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-users"></i>
        Newsletter Subscribers
    </h1>
    <div class="subtitle">Manage newsletter subscriptions and email marketing lists</div>
    <div class="header-actions">
        <a href="subscriber-remove.php" class="btn-action btn-remove">
            <i class="fa fa-trash"></i> Remove Pending Subscribers
        </a>
        <a href="subscriber-csv.php" class="btn-action btn-export">
            <i class="fa fa-download"></i> Export as CSV
        </a>
    </div>
</div>

<?php
// Get subscriber statistics
$stmt_active = $pdo->prepare("SELECT COUNT(*) as count FROM tbl_subscriber WHERE subs_active=1");
$stmt_active->execute();
$active_count = $stmt_active->fetch(PDO::FETCH_ASSOC)['count'];

$stmt_total = $pdo->prepare("SELECT COUNT(*) as count FROM tbl_subscriber");
$stmt_total->execute();
$total_count = $stmt_total->fetch(PDO::FETCH_ASSOC)['count'];

$inactive_count = $total_count - $active_count;
?>

<div class="row" style="margin-bottom: 1.5rem;">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number" style="color: #27ae60;"><?php echo $active_count; ?></div>
            <div class="stats-label">Active Subscribers</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number" style="color: #e74a3b;"><?php echo $inactive_count; ?></div>
            <div class="stats-label">Inactive Subscribers</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number"><?php echo $total_count; ?></div>
            <div class="stats-label">Total Subscribers</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number">
                <?php echo $total_count > 0 ? round(($active_count / $total_count) * 100) : 0; ?>%
            </div>
            <div class="stats-label">Active Rate</div>
        </div>
    </div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-8">
            <input type="text" id="subscriberSearch" class="search-box" placeholder="🔍 Search subscribers by email address...">
        </div>
        <div class="col-md-4">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Showing: <span id="visibleCount">0</span> active subscribers
            </div>
        </div>
    </div>
</div>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="modern-table-container slide-in">        
        <div class="table-responsive">
          <table id="subscribersTable" class="table">
			<thead>
			    <tr>
			        <th>#</th>
			        <th>Subscriber Information</th>
			        <th>Status</th>
			        <th>Actions</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_active=1 ORDER BY subs_email ASC");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
            	foreach ($result as $row) {
            		$i++;
            		$first_letter = strtoupper(substr($row['subs_email'], 0, 1));
            		?>
					<tr>
	                    <td><?php echo $i; ?></td>
	                    <td>
	                    	<div class="subscriber-email">
	                    		<div class="subscriber-avatar"><?php echo $first_letter; ?></div>
	                    		<div>
	                    			<div style="font-weight: 600; color: #2c3e50;"><?php echo htmlspecialchars($row['subs_email']); ?></div>
	                    			<div style="font-size: 0.8rem; color: #7f8c8d;">
	                    				<i class="fa fa-calendar"></i> Subscribed: <?php echo date('M d, Y', strtotime($row['subs_date'] ?? 'now')); ?>
	                    			</div>
	                    		</div>
	                    	</div>
	                    </td>
	                    <td>
	                    	<span class="subscriber-status">
	                    		<i class="fa fa-check-circle"></i> Active
	                    	</span>
	                    </td>
	                    <td>
	                    	<a href="#" class="action-btn btn-delete" data-href="subscriber-delete.php?id=<?php echo $row['subs_id']; ?>" data-toggle="modal" data-target="#confirm-delete">
	                    		<i class="fa fa-trash"></i> Remove
	                    	</a>
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
                    <i class="fa fa-exclamation-triangle"></i> Remove Subscriber Confirmation
                </h4>
            </div>
            <div class="modal-body">
                <p><strong>Warning:</strong> This action will permanently remove the subscriber from your newsletter list.</p>
                <p>Are you sure you want to proceed? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <a class="btn btn-danger btn-ok">
                    <i class="fa fa-trash"></i> Remove Subscriber
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('subscriberSearch');
    const table = document.getElementById('subscribersTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    const visibleCountSpan = document.getElementById('visibleCount');
    
    // Update visible count initially
    updateVisibleCount();
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent.toLowerCase();
            
            if (text.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
        
        visibleCountSpan.textContent = visibleCount;
    }
    
    function updateVisibleCount() {
        visibleCountSpan.textContent = rows.length;
    }
    
    searchInput.addEventListener('input', filterTable);
});
</script>

<?php require_once('footer.php'); ?>