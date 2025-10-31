<?php require_once('header.php'); ?>

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-palette"></i>
        Product Colors
    </h1>
    <div class="subtitle">Manage color options for your products</div>
    <div style="margin-top: 1rem;">
        <a href="color-add.php" class="btn-add-new">
            <i class="fa fa-plus"></i> Add New Color
        </a>
    </div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-6">
            <input type="text" id="colorSearch" class="search-box" placeholder="🔍 Search colors by name...">
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Total Colors: <span id="totalCount">0</span>
            </div>
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; text-align: right;">
                <a href="color-add.php" class="modern-btn btn-add-secondary">
                    <i class="fa fa-plus"></i> Quick Add
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="modern-table-container slide-in">
                <div class="table-responsive">
                    <table id="colorTable" class="table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">#</th>
                        <th><i class="fa fa-palette"></i> Color Name</th>
                        <th class="text-center" style="width: 100px;">Preview</th>
                        <th class="text-center" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=0;
                    $statement = $pdo->prepare("SELECT * FROM tbl_color ORDER BY color_id ASC");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $i++;
                        // Generate a color based on the color name
                        $colorCode = '#' . substr(md5($row['color_name']), 0, 6);
                        ?>
                        <tr>
                            <td class="text-center">
                                <span class="row-number"><?php echo $i; ?></span>
                            </td>
                            <td>
                                <div class="color-info">
                                    <span class="color-name"><?php echo htmlspecialchars($row['color_name']); ?></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="color-preview-container">
                                    <div class="color-preview" style="background-color: <?php echo $colorCode; ?>" title="<?php echo htmlspecialchars($row['color_name']); ?>"></div>
                                    <span class="color-code"><?php echo $colorCode; ?></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="color-edit.php?id=<?php echo $row['color_id']; ?>" class="modern-btn modern-btn-sm modern-btn-info" title="Edit Color">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" class="modern-btn modern-btn-sm modern-btn-danger" 
                                       data-href="color-delete.php?id=<?php echo $row['color_id']; ?>" 
                                       data-toggle="modal" data-target="#confirm-delete" title="Delete Color">
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
        </div>
    </div>
</section>


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
                <p>Are you sure you want to delete this color? This action cannot be undone.</p>
                <div class="alert alert-warning">
                    <i class="fa fa-info-circle"></i>
                    <strong>Warning:</strong> Deleting this color may affect products that use it.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modern-btn modern-btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <a class="modern-btn modern-btn-danger btn-ok">
                    <i class="fa fa-trash"></i> Delete
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
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(28, 200, 138, 0.3);
}

.btn-add-new:hover {
    background: linear-gradient(135deg, #17a673, #138d5a);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(28, 200, 138, 0.4);
    color: white;
    text-decoration: none;
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

.color-info {
    display: flex;
    align-items: center;
}

.color-name {
    font-weight: 600;
    color: #495057;
    font-size: 1rem;
}

.color-preview-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.color-preview {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.color-code {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6c757d;
    background: #f8f9fc;
    padding: 0.2rem 0.5rem;
    border-radius: 12px;
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

.alert-warning {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
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
    const searchInput = document.getElementById('colorSearch');
    const table = document.getElementById('colorTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    const totalCountSpan = document.getElementById('totalCount');
    
    // Update total count initially
    updateTotalCount();
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const colorName = rows[i].getElementsByClassName('color-name')[0].textContent.toLowerCase();
            
            if (colorName.includes(searchTerm)) {
                rows[i].style.display = '';
                visibleCount++;
            } else {
                rows[i].style.display = 'none';
            }
        }
        
        totalCountSpan.textContent = visibleCount;
    }
    
    function updateTotalCount() {
        totalCountSpan.textContent = rows.length;
    }
    
    searchInput.addEventListener('input', filterTable);
    
    // Modal functionality
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
});
</script>


<?php require_once('footer.php'); ?>