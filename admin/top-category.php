<?php require_once('header.php'); ?>

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-tags"></i>
        Top Level Categories
    </h1>
    <div class="subtitle">Manage top-level product categories and menu visibility</div>
    <div style="margin-top: 1rem;">
        <a href="top-category-add.php" class="btn-add-new">
            <i class="fa fa-plus"></i> Add New Category
        </a>
        <button class="btn-add-secondary" onclick="location.reload()" style="margin-left: 0.5rem;">
            <i class="fa fa-refresh"></i> Refresh
        </button>
    </div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-4">
            <input type="text" id="categorySearch" class="search-box" placeholder="🔍 Search categories...">
        </div>
        <div class="col-md-3">
            <select class="search-box" id="menuFilter">
                <option value="">All Categories</option>
                <option value="yes">Show on Menu</option>
                <option value="no">Hidden from Menu</option>
            </select>
        </div>
        <div class="col-md-2">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Total: <span id="totalCount">0</span>
            </div>
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; text-align: right;">
                <button class="modern-btn btn-add-secondary" onclick="document.querySelector('table').scrollIntoView({behavior: 'smooth'})">
                    <i class="fa fa-list"></i> View All
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modern-table-container slide-in">
    <div class="table-responsive">
		
        <table id="example1" class="table">
            <thead>
                <tr>
                    <th width="10">#</th>
                    <th width="300">Category Information</th>
                    <th width="150">Menu Visibility</th>
                    <th width="100">Sub Categories</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
				<?php
				$i=0;
				$statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_id DESC");
				$statement->execute();
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
				foreach ($result as $row) {
					$i++;
					
					// Count sub-categories
					$stmt_count = $pdo->prepare("SELECT COUNT(*) as count FROM tbl_mid_category WHERE tcat_id = ?");
					$stmt_count->execute(array($row['tcat_id']));
					$sub_count = $stmt_count->fetch(PDO::FETCH_ASSOC)['count'];
					?>
                    <tr>
                        <td><span class="row-number"><?php echo $i; ?></span></td>
                        <td>
                            <div class="category-info">
                                <div class="category-icon">
                                    <i class="fa fa-folder" style="font-size: 1.5rem; color: #667eea;"></i>
                                </div>
                                <div class="category-details">
                                    <strong class="category-name"><?php echo htmlspecialchars($row['tcat_name']); ?></strong>
                                    <small class="category-id">ID: #<?php echo $row['tcat_id']; ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if($row['show_on_menu'] == 1): ?>
                                <span class="status-badge status-active">
                                    <i class="fa fa-eye"></i> Visible
                                </span>
                            <?php else: ?>
                                <span class="status-badge status-inactive">
                                    <i class="fa fa-eye-slash"></i> Hidden
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="sub-category-count">
                                <span class="count-badge"><?php echo $sub_count; ?></span>
                                <small>Sub Categories</small>
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="top-category-edit.php?id=<?php echo $row['tcat_id']; ?>" class="modern-btn modern-btn-primary modern-btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#" class="modern-btn modern-btn-danger modern-btn-sm" data-href="top-category-delete.php?id=<?php echo $row['tcat_id']; ?>" data-toggle="modal" data-target="#confirm-delete">
                                    <i class="fa fa-trash"></i>
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

<script>
// Modern table search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('categorySearch');
    const menuFilter = document.getElementById('menuFilter');
    const table = document.getElementById('example1');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    function updateTotalCount() {
        const visibleRows = table.querySelectorAll('tbody tr:not([style*="display: none"])');
        document.getElementById('totalCount').textContent = visibleRows.length;
    }
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const menuTerm = menuFilter.value.toLowerCase();

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let showRow = true;

            // Search filter
            if (searchTerm) {
                let found = false;
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].textContent.toLowerCase().includes(searchTerm)) {
                        found = true;
                        break;
                    }
                }
                if (!found) showRow = false;
            }

            // Menu visibility filter
            if (menuTerm && showRow) {
                const menuCell = cells[2]; // Menu Visibility column
                if (menuCell) {
                    const isVisible = menuCell.textContent.toLowerCase().includes('visible');
                    if ((menuTerm === 'yes' && !isVisible) || (menuTerm === 'no' && isVisible)) {
                        showRow = false;
                    }
                }
            }

            row.style.display = showRow ? '' : 'none';
        }
        
        updateTotalCount();
    }
    
    // Initial count
    updateTotalCount();

    searchInput.addEventListener('keyup', filterTable);
    menuFilter.addEventListener('change', filterTable);
});
</script>

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

.btn-add-new {
    background: linear-gradient(135deg, #1cc88a, #17a673);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(28, 200, 138, 0.3);
    cursor: pointer;
    text-decoration: none;
}

.btn-add-new:hover {
    background: linear-gradient(135deg, #17a673, #138d5a);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(28, 200, 138, 0.4);
    color: white;
    text-decoration: none;
}

.btn-add-secondary {
    background: linear-gradient(135deg, #36b9cc, #258391);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-add-secondary:hover {
    background: linear-gradient(135deg, #258391, #1e6b73);
    transform: translateY(-1px);
    color: white;
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

.modern-table-container .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
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

.search-box:hover {
    border-color: #a78bfa;
    box-shadow: 0 2px 8px rgba(167, 139, 250, 0.1);
}

.row-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    font-weight: 600;
    color: white;
    font-size: 0.85rem;
}

.category-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.category-details {
    display: flex;
    flex-direction: column;
}

.category-name {
    font-size: 1rem;
    color: #495057;
    margin-bottom: 0.25rem;
}

.category-id {
    color: #64748b;
    font-size: 0.8rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.375rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-active {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.status-inactive {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.sub-category-count {
    text-align: center;
}

.count-badge {
    display: inline-block;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.sub-category-count small {
    display: block;
    color: #64748b;
    font-size: 0.75rem;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.modern-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.modern-btn i {
    margin-right: 0.5rem;
}

.modern-btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.modern-btn-sm i {
    margin-right: 0.25rem;
}

.modern-btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
}

.modern-btn-primary:hover {
    background: linear-gradient(135deg, #0056b3, #004085);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    color: white;
    text-decoration: none;
}

.modern-btn-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.modern-btn-danger:hover {
    background: linear-gradient(135deg, #c82333, #bd2130);
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
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


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
                <p style="color:red;">Be careful! All products, mid level categories and end level categories under this top lelvel category will be deleted from all the tables like order table, payment table, size table, color table, rating table etc.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>