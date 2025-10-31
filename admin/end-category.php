<?php require_once('header.php'); ?>

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-tags"></i>
        End-Level Categories
    </h1>
    <div class="subtitle">Manage final product categories and their hierarchical relationships</div>
    <div style="margin-top: 1rem;">
        <a href="end-category-add.php" class="btn-add-new">
            <i class="fa fa-plus"></i> Add New Category
        </a>
    </div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-6">
            <input type="text" id="categorySearch" class="search-box" placeholder="🔍 Search categories, mid-level, or top-level...">
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Total: <span id="totalCount">0</span>
            </div>
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; text-align: right;">
                <button class="modern-btn btn-add-secondary" onclick="document.querySelector('table').scrollIntoView({behavior: 'smooth'})">
                    <i class="fa fa-sitemap"></i> View Hierarchy
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modern-table-container slide-in">
    <div class="table-responsive">
        <table id="categoryTable" class="table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 60px;">#</th>
                    <th><i class="fa fa-tag"></i> End-Level Category</th>
                    <th><i class="fa fa-sitemap"></i> Mid-Level Category</th>
                    <th><i class="fa fa-folder-open"></i> Top-Level Category</th>
                    <th class="text-center" style="width: 120px;">Level</th>
                    <th class="text-center" style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                    $i=0;
                    $statement = $pdo->prepare("SELECT * 
                                        FROM tbl_end_category t1
                                        JOIN tbl_mid_category t2
                                        ON t1.mcat_id = t2.mcat_id
                                        JOIN tbl_top_category t3
                                        ON t2.tcat_id = t3.tcat_id
                                        ORDER BY t3.tcat_name ASC, t2.mcat_name ASC, t1.ecat_name ASC
                                        ");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $i++;
                        ?>
                    <tr>
                        <td class="text-center">
                            <span class="row-number"><?php echo $i; ?></span>
                        </td>
                        <td>
                            <div class="category-info">
                                <span class="category-name"><?php echo htmlspecialchars($row['ecat_name']); ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="mid-category">
                                <span class="mid-name"><?php echo htmlspecialchars($row['mcat_name']); ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="top-category">
                                <span class="top-name"><?php echo htmlspecialchars($row['tcat_name']); ?></span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="level-badge level-end">End-Level</span>
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <a href="end-category-edit.php?id=<?php echo $row['ecat_id']; ?>" class="modern-btn modern-btn-sm modern-btn-info" title="Edit Category">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#" class="modern-btn modern-btn-sm modern-btn-danger" 
                                   data-href="end-category-delete.php?id=<?php echo $row['ecat_id']; ?>" 
                                   data-toggle="modal" data-target="#confirm-delete" title="Delete Category">
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


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fa fa-exclamation-triangle text-warning"></i>
                    Delete Confirmation
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this end-level category? This action cannot be undone.</p>
                <div class="alert alert-danger">
                    <i class="fa fa-warning"></i>
                    <strong>Critical Warning:</strong> All products under this end-level category will be permanently deleted from all tables including orders, payments, sizes, colors, ratings, etc.
                </div>
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    <strong>Impact:</strong> This will affect your entire product catalog, sales history, and customer data.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modern-btn modern-btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <a class="modern-btn modern-btn-danger btn-ok">
                    <i class="fa fa-trash"></i> Delete Permanently
                </a>
            </div>
        </div>
    </div>
</div>

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
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-size: 0.875rem;
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

.page-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.page-title h1 {
    margin: 0;
    font-size: 2.5rem;
    font-weight: 600;
}

.page-subtitle {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

.page-icon {
    font-size: 2rem;
    margin-right: 1rem;
    vertical-align: middle;
}

.modern-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.modern-table-container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.table-header h3 {
    margin: 0;
    color: #495057;
    font-size: 1.25rem;
}

.table-header h3 i {
    margin-right: 0.5rem;
    color: #007bff;
}

.search-box {
    position: relative;
    width: 300px;
}

.modern-search-input {
    width: 100%;
    padding: 0.75rem 2.5rem 0.75rem 1rem;
    border: 1px solid #ced4da;
    border-radius: 25px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.modern-search-input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.search-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}

.modern-table th {
    background: #f8f9fa;
    padding: 1rem;
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
    text-align: left;
}

.modern-table td {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.modern-table tbody tr:hover {
    background: #f8f9fa;
    transition: background-color 0.3s ease;
}

.row-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    background: #e9ecef;
    border-radius: 50%;
    font-weight: 600;
    color: #495057;
}

.category-info {
    display: flex;
    align-items: center;
}

.category-name {
    font-weight: 600;
    color: #495057;
    font-size: 1rem;
}

.mid-category {
    display: flex;
    align-items: center;
}

.mid-name {
    font-weight: 500;
    color: #6c757d;
    font-size: 0.9rem;
    background: #fff3cd;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    border: 1px solid #ffeaa7;
}

.top-category {
    display: flex;
    align-items: center;
}

.top-name {
    font-weight: 500;
    color: #6c757d;
    font-size: 0.9rem;
    background: #d1ecf1;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    border: 1px solid #bee5eb;
}

.level-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.level-end {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
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

.modern-btn-info {
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: white;
}

.modern-btn-info:hover {
    background: linear-gradient(135deg, #138496, #117a8b);
    transform: translateY(-1px);
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

.modern-btn-secondary {
    background: #6c757d;
    color: white;
}

.modern-btn-secondary:hover {
    background: #5a6268;
    color: white;
    text-decoration: none;
}

.modern-modal .modal-header {
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 1.5rem;
}

.modern-modal .modal-title {
    font-weight: 600;
    color: #495057;
}

.modern-modal .modal-body {
    padding: 2rem;
}

.modern-modal .modal-footer {
    padding: 1.5rem;
    border-top: 1px solid #dee2e6;
    background: #f8f9fa;
}

.alert {
    padding: 0.75rem 1rem;
    border-radius: 6px;
    margin-top: 1rem;
}

.alert-danger {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.alert-info {
    background: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
}

.text-center {
    text-align: center;
}

.text-warning {
    color: #ffc107;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('categorySearch');
    const table = document.getElementById('categoryTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    const totalCountSpan = document.getElementById('totalCount');
    
    function updateTotalCount() {
        const visibleRows = table.querySelectorAll('tbody tr:not([style*="display: none"])');
        totalCountSpan.textContent = visibleRows.length;
    }
    
    // Initial count
    updateTotalCount();
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        
        for (let i = 0; i < rows.length; i++) {
            const categoryName = rows[i].getElementsByClassName('category-name')[0].textContent.toLowerCase();
            const midName = rows[i].getElementsByClassName('mid-name')[0].textContent.toLowerCase();
            const topName = rows[i].getElementsByClassName('top-name')[0].textContent.toLowerCase();
            
            if (categoryName.includes(searchTerm) || midName.includes(searchTerm) || topName.includes(searchTerm)) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
        
        updateTotalCount();
    });
    
    // Modal functionality
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
});
</script>


<?php require_once('footer.php'); ?>