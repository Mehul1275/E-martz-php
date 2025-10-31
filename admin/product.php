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
    padding: 1.2rem 1rem;
    text-transform: uppercase;
    font-size: 0.95rem;
    letter-spacing: 0.5px;
}

.modern-table-container tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #e3e6f0;
}

.modern-table-container tbody td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.modern-table-container tbody tr:hover {
    background-color: #f8f9fc;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.product-status-badge {
    padding: 0.4rem 0.7rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    display: inline-block;
    margin-bottom: 0.3rem;
}

.status-active {
    background: linear-gradient(135deg, #1cc88a, #17a673);
    color: white;
}

.status-inactive {
    background: linear-gradient(135deg, #e74a3b, #c0392b);
    color: white;
}

.status-featured {
    background: linear-gradient(135deg, #f6c23e, #dda20a);
    color: white;
}

.status-not-featured {
    background: linear-gradient(135deg, #6c757d, #545b62);
    color: white;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.modern-btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-edit {
    background: linear-gradient(135deg, #36b9cc, #258391);
    color: white;
}

.btn-edit:hover {
    background: linear-gradient(135deg, #258391, #1e6b73);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(54, 185, 204, 0.3);
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

.btn-add-product {
    background: linear-gradient(135deg, #1cc88a, #17a673);
    color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-add-product:hover {
    background: linear-gradient(135deg, #17a673, #138f5f);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(28, 200, 138, 0.3);
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

.product-info {
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.product-image {
    width: 65px;
    height: 65px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid #e3e6f0;
    flex-shrink: 0;
}

.product-details {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
    min-width: 0;
    flex: 1;
}

.product-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 1rem;
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-company {
    font-size: 0.9rem;
    color: #7f8c8d;
}

.price-info {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
    font-size: 1rem;
}

.current-price {
    font-weight: 600;
    color: #1cc88a;
    font-size: 1.1rem;
}

.old-price {
    text-decoration: line-through;
    color: #6c757d;
    font-size: 0.9rem;
}

.category-info {
    font-size: 0.9rem;
    line-height: 1.4;
}

.category-top {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.1rem;
}

.category-mid {
    color: #7f8c8d;
    margin-bottom: 0.1rem;
}

.category-end {
    color: #95a5a6;
}

.action-buttons {
    display: flex;
    gap: 0.3rem;
    flex-direction: column;
}

.action-buttons .modern-btn {
    padding: 0.3rem 0.6rem;
    font-size: 0.75rem;
    white-space: nowrap;
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

.stats-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stats-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.5rem;
    font-weight: 600;
}

.stats-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #667eea;
}

.stats-row {
    margin-bottom: 2rem;
}
</style>

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-shopping-bag"></i>
        Product Management
    </h1>
    <div class="subtitle">Manage your product inventory and listings</div>
    <div style="margin-top: 1rem;">
        <a href="product-add.php" class="btn-add-product">
            <i class="fa fa-plus"></i> Add Product
        </a>
    </div>
</div>

<?php
// Get product statistics
$stmt = $pdo->query("SELECT COUNT(*) as total_products FROM tbl_product");
$total_products = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'];

$stmt = $pdo->query("SELECT COUNT(*) as active_products FROM tbl_product WHERE p_is_active = 1");
$active_products = $stmt->fetch(PDO::FETCH_ASSOC)['active_products'];

$stmt = $pdo->query("SELECT COUNT(*) as featured_products FROM tbl_product WHERE p_is_featured = 1");
$featured_products = $stmt->fetch(PDO::FETCH_ASSOC)['featured_products'];

$stmt = $pdo->query("SELECT COUNT(*) as low_stock FROM tbl_product WHERE p_qty <= 10");
$low_stock = $stmt->fetch(PDO::FETCH_ASSOC)['low_stock'];

$stmt = $pdo->query("SELECT COUNT(DISTINCT t4.tcat_id) as total_categories FROM tbl_product t1 
    JOIN tbl_end_category t2 ON t1.ecat_id = t2.ecat_id
    JOIN tbl_mid_category t3 ON t2.mcat_id = t3.mcat_id
    JOIN tbl_top_category t4 ON t3.tcat_id = t4.tcat_id");
$total_categories = $stmt->fetch(PDO::FETCH_ASSOC)['total_categories'];

$stmt = $pdo->query("SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM tbl_rating");
$rating_data = $stmt->fetch(PDO::FETCH_ASSOC);
$avg_rating = $rating_data['avg_rating'] ? round($rating_data['avg_rating'], 1) : 0;
$total_reviews = $rating_data['total_reviews'];
?>

<div class="stats-row fade-in">
    <div class="row">
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fa fa-shopping-bag"></i>
                </div>
                <div class="stats-number"><?php echo $total_products; ?></div>
                <div class="stats-label">Total Products</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fa fa-check-circle" style="color: #1cc88a;"></i>
                </div>
                <div class="stats-number" style="background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo $active_products; ?></div>
                <div class="stats-label">Active Products</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fa fa-star" style="color: #f6c23e;"></i>
                </div>
                <div class="stats-number" style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo $featured_products; ?></div>
                <div class="stats-label">Featured Products</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fa fa-exclamation-triangle" style="color: #e74a3b;"></i>
                </div>
                <div class="stats-number" style="background: linear-gradient(135deg, #e74a3b 0%, #c0392b 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo $low_stock; ?></div>
                <div class="stats-label">Low Stock</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fa fa-tags" style="color: #6f42c1;"></i>
                </div>
                <div class="stats-number" style="background: linear-gradient(135deg, #6f42c1 0%, #5a2d91 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo $total_categories; ?></div>
                <div class="stats-label">Categories</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fa fa-star-half-o" style="color: #fd7e14;"></i>
                </div>
                <div class="stats-number" style="background: linear-gradient(135deg, #fd7e14 0%, #e55a00 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo $avg_rating; ?></div>
                <div class="stats-label">Average Rating</div>
            </div>
        </div>
    </div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-4">
            <input type="text" id="productSearch" class="search-box" placeholder="🔍 Search products by name, company...">
        </div>
        <div class="col-md-3">
            <select id="categoryFilter" class="search-box">
                <option value="">All Categories</option>
                <?php
                $statement = $pdo->prepare("SELECT DISTINCT t4.tcat_name FROM tbl_product t1 
                    JOIN tbl_end_category t2 ON t1.ecat_id = t2.ecat_id
                    JOIN tbl_mid_category t3 ON t2.mcat_id = t3.mcat_id
                    JOIN tbl_top_category t4 ON t3.tcat_id = t4.tcat_id
                    ORDER BY t4.tcat_name");
                $statement->execute();
                $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($categories as $cat) {
                    echo '<option value="'.htmlspecialchars($cat['tcat_name']).'">'.htmlspecialchars($cat['tcat_name']).'</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <select id="statusFilter" class="search-box">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="col-md-2">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Total: <span id="totalCount">0</span>
            </div>
        </div>
    </div>
</div>

<section class="content">
	<div class="modern-table-container slide-in">
		<div class="table-responsive">
		
		<table id="productsTable" class="table">
					<thead>
						<tr>
							<th width="3%">#</th>
							<th width="25%">Product Info</th>
							<th width="12%">Company</th>
							<th width="10%">Pricing</th>
							<th width="8%">Stock</th>
							<th width="15%">Status</th>
							<th width="15%">Category</th>
							<th width="12%">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						$statement = $pdo->prepare("SELECT
							t1.p_id,
							t1.p_name,
							t1.p_old_price,
							t1.p_current_price,
							t1.p_qty,
							t1.p_featured_photo,
							t1.p_is_featured,
							t1.p_is_active,
							t1.ecat_id,
							t1.seller_id,
							t1.created_at,
							t2.ecat_id,
							t2.ecat_name,
							t3.mcat_id,
							t3.mcat_name,
							t4.tcat_id,
							t4.tcat_name,
							s.company_name
						FROM tbl_product t1
						JOIN tbl_end_category t2 ON t1.ecat_id = t2.ecat_id
						JOIN tbl_mid_category t3 ON t2.mcat_id = t3.mcat_id
						JOIN tbl_top_category t4 ON t3.tcat_id = t4.tcat_id
						LEFT JOIN sellers s ON t1.seller_id = s.id
						ORDER BY t1.p_id DESC");
						$statement->execute();
						$result = $statement->fetchAll(PDO::FETCH_ASSOC);
						foreach ($result as $row) {
							$i++;
							?>
							<tr data-status="<?php echo $row['p_is_active']==1 ? 'active' : 'inactive'; ?>">
								<td><?php echo $i; ?></td>
								<td>
									<div class="product-info">
										<img src="../assets/uploads/<?php echo htmlspecialchars($row['p_featured_photo']); ?>" 
											 alt="<?php echo htmlspecialchars($row['p_name']); ?>" 
											 class="product-image">
										<div class="product-details">
											<div class="product-name"><?php echo htmlspecialchars($row['p_name']); ?></div>
											<div class="product-company">
												<i class="fa fa-calendar"></i> 
												<?php echo isset($row['created_at']) ? date('M d, Y', strtotime($row['created_at'])) : 'N/A'; ?>
											</div>
										</div>
									</div>
								</td>
								<td>
									<div style="font-size: 1rem; font-weight: 500;">
										<i class="fa fa-building"></i> 
										<?php echo isset($row['company_name']) ? htmlspecialchars($row['company_name']) : 'N/A'; ?>
									</div>
								</td>
								<td>
									<div class="price-info">
										<div class="current-price">₹<?php echo number_format((float)str_replace(',', '', $row['p_current_price']), 2); ?></div>
										<?php if((float)str_replace(',', '', $row['p_old_price']) > (float)str_replace(',', '', $row['p_current_price'])): ?>
										<div class="old-price">₹<?php echo number_format((float)str_replace(',', '', $row['p_old_price']), 2); ?></div>
										<?php endif; ?>
									</div>
								</td>
								<td>
									<div style="font-weight: 600; font-size: 1rem; color: <?php echo $row['p_qty'] > 10 ? '#1cc88a' : ($row['p_qty'] > 0 ? '#f6c23e' : '#e74a3b'); ?>;">
										<i class="fa fa-cube"></i> <?php echo $row['p_qty']; ?>
									</div>
								</td>
								<td>
									<div>
										<span class="product-status-badge <?php echo $row['p_is_active']==1 ? 'status-active' : 'status-inactive'; ?>">
											<i class="fa fa-<?php echo $row['p_is_active']==1 ? 'check-circle' : 'times-circle'; ?>"></i>
											<?php echo $row['p_is_active']==1 ? 'Active' : 'Inactive'; ?>
										</span>
									</div>
									<div style="margin-top: 0.3rem;">
										<span class="product-status-badge <?php echo $row['p_is_featured']==1 ? 'status-featured' : 'status-not-featured'; ?>">
											<i class="fa fa-<?php echo $row['p_is_featured']==1 ? 'star' : 'star-o'; ?>"></i>
											<?php echo $row['p_is_featured']==1 ? 'Featured' : 'Regular'; ?>
										</span>
									</div>
								</td>
								<td>
									<div class="category-info">
										<div class="category-top"><?php echo htmlspecialchars($row['tcat_name']); ?></div>
										<div class="category-mid"><?php echo htmlspecialchars($row['mcat_name']); ?></div>
										<div class="category-end"><?php echo htmlspecialchars($row['ecat_name']); ?></div>
									</div>
								</td>
								<td>
									<div class="action-buttons">
										<a href="product-edit.php?id=<?php echo $row['p_id']; ?>" class="modern-btn btn-edit">
											<i class="fa fa-edit"></i> Edit
										</a>
										<a href="#" class="modern-btn btn-delete" data-href="product-delete.php?id=<?php echo $row['p_id']; ?>" data-toggle="modal" data-target="#confirm-delete">
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
</section>

<div class="modal fade modern-modal" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <i class="fa fa-exclamation-triangle"></i> Delete Product Confirmation
                </h4>
            </div>
            <div class="modal-body">
                <p><strong>Warning:</strong> This action will permanently delete the product and all associated data.</p>
                <p style="color: #e74a3b; font-weight: 600;">Be careful! This product will be deleted from the order table, payment table, size table, color table and rating table also.</p>
                <p>Are you sure you want to proceed? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <a class="btn btn-danger btn-ok">
                    <i class="fa fa-trash"></i> Delete Product
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('productSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    const table = document.getElementById('productsTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    const totalCountSpan = document.getElementById('totalCount');
    
    // Update total count initially
    updateTotalCount();
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const categoryTerm = categoryFilter.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent.toLowerCase();
            const status = row.getAttribute('data-status');
            
            const matchesSearch = text.includes(searchTerm);
            const matchesCategory = categoryTerm === '' || text.includes(categoryTerm);
            const matchesStatus = statusValue === '' || status === statusValue;
            
            if (matchesSearch && matchesCategory && matchesStatus) {
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
    categoryFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);
});
</script>

<?php require_once('footer.php'); ?>