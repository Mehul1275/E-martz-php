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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My Products - Seller Panel</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="admin/css/_all-skins.min.css">
    <link rel="stylesheet" href="assets/css/seller-modern.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed seller-products-page">
<div class="wrapper">
<?php include('seller-sidebar.php'); ?>
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="seller-page-header fade-in" style="margin-top: 20px;">
            <h1 class="seller-page-title">
                <i class="fa fa-cube"></i>
                My Products
            </h1>
            <p class="seller-page-subtitle">Manage your product listings and inventory</p>
        </div>

        <section class="content" style="padding: 0 40px;">
            <!-- Quick Statistics -->
            <div class="row fade-in" style="margin-bottom: 30px;">
                <?php
                // Get product statistics
                try {
                    $stats = $pdo->prepare("SELECT 
                        COUNT(*) as total_products,
                        SUM(CASE WHEN p_is_active = 1 THEN 1 ELSE 0 END) as active_products,
                        SUM(CASE WHEN p_is_featured = 1 THEN 1 ELSE 0 END) as featured_products,
                        SUM(CASE WHEN p_qty = 0 THEN 1 ELSE 0 END) as out_of_stock
                        FROM tbl_product WHERE seller_id = ?");
                    $stats->execute([$seller_id]);
                    $product_stats = $stats->fetch(PDO::FETCH_ASSOC);
                } catch (Exception $e) {
                    $product_stats = ['total_products' => 0, 'active_products' => 0, 'featured_products' => 0, 'out_of_stock' => 0];
                }
                ?>
                <div class="col-md-3 col-sm-6">
                    <div class="seller-stat-card card-products">
                        <div class="card-content">
                            <h3 class="card-number"><?php echo $product_stats['total_products']; ?></h3>
                            <p class="card-label">Total Products</p>
                            <div class="card-change positive">
                                <i class="fa fa-shopping-bag"></i>
                                <span>All Products</span>
                            </div>
                        </div>
                        <i class="fa fa-cube card-icon"></i>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="seller-stat-card card-completed">
                        <div class="card-content">
                            <h3 class="card-number"><?php echo $product_stats['active_products']; ?></h3>
                            <p class="card-label">Active Products</p>
                            <div class="card-change positive">
                                <i class="fa fa-check-circle"></i>
                                <span>Live & Selling</span>
                            </div>
                        </div>
                        <i class="fa fa-check-circle card-icon"></i>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="seller-stat-card card-shipping">
                        <div class="card-content">
                            <h3 class="card-number"><?php echo $product_stats['featured_products']; ?></h3>
                            <p class="card-label">Featured</p>
                            <div class="card-change positive">
                                <i class="fa fa-star"></i>
                                <span>Highlighted</span>
                            </div>
                        </div>
                        <i class="fa fa-star card-icon"></i>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="seller-stat-card card-orders">
                        <div class="card-content">
                            <h3 class="card-number"><?php echo $product_stats['out_of_stock']; ?></h3>
                            <p class="card-label">Out of Stock</p>
                            <div class="card-change negative">
                                <i class="fa fa-exclamation-triangle"></i>
                                <span>Need Restock</span>
                            </div>
                        </div>
                        <i class="fa fa-exclamation-triangle card-icon"></i>
                    </div>
                </div>
            </div>
            
            <!-- Filter & Search Bar -->
            <div class="seller-filter-bar slide-in">
                <div class="filter-header">
                    <h3><i class="fa fa-filter"></i> Filter & Search Products</h3>
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
                                <i class="fa fa-search"></i> Search Products
                            </label>
                            <div class="seller-search-box">
                                <i class="fa fa-search"></i>
                                <input type="text" id="productSearch" 
                                       placeholder="Search by product name..." 
                                       class="seller-form-control">
                            </div>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-toggle-on"></i> Status
                            </label>
                            <select id="statusFilter" class="seller-form-control seller-filter-select">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-star"></i> Featured
                            </label>
                            <select id="featuredFilter" class="seller-form-control seller-filter-select">
                                <option value="">All Products</option>
                                <option value="featured">Featured</option>
                                <option value="regular">Regular</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fa fa-cubes"></i> Stock
                            </label>
                            <select id="stockFilter" class="seller-form-control seller-filter-select">
                                <option value="">All Stock Levels</option>
                                <option value="in-stock">In Stock</option>
                                <option value="low-stock">Low Stock</option>
                                <option value="out-of-stock">Out of Stock</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="filter-summary">
                        <div class="results-info">
                            <span class="results-count">
                                <i class="fa fa-list"></i>
                                Showing <span id="currentCount">0</span> of <span id="totalCount"><?php echo $product_stats['total_products']; ?></span> products
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Products Table -->
            <div class="seller-table-container slide-in">
                <div class="table-header">
                    <h3><i class="fa fa-table"></i> Product Inventory</h3>
                    <div class="table-actions">
                        <button class="seller-btn-sm seller-modern-btn-primary" onclick="refreshTable()">
                            <i class="fa fa-refresh"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="seller-modern-table" id="productsTable">
                        <thead>
                            <tr>
                                <th><i class="fa fa-hashtag"></i> #</th>
                                <th><i class="fa fa-image"></i> Product</th>
                                <th><i class="fa fa-rupee"></i> Price</th>
                                <th><i class="fa fa-cubes"></i> Stock</th>
                                <th><i class="fa fa-toggle-on"></i> Status</th>
                                <th><i class="fa fa-cogs"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE seller_id=? ORDER BY p_id DESC");
                            $statement->execute(array($seller_id));
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            
                            if(empty($result)) {
                                echo '<tr><td colspan="6" class="text-center" style="padding: 3rem; color: #7f8c8d;">'
                                    .'<div class="empty-state">'
                                    .'<i class="fa fa-cube"></i><br>'
                                    .'No products found. <a href="seller-product-add.php" class="seller-modern-btn seller-modern-btn-primary">Add your first product</a> to get started!'
                                    .'</div></td></tr>';
                            } else {
                                foreach ($result as $row) {
                                    $i++;
                                    // Determine stock status
                                    $stock_class = 'in-stock';
                                    $stock_label = 'In Stock';
                                    if($row['p_qty'] == 0) {
                                        $stock_class = 'out-of-stock';
                                        $stock_label = 'Out of Stock';
                                    } elseif($row['p_qty'] <= 10) {
                                        $stock_class = 'low-stock';
                                        $stock_label = 'Low Stock';
                                    }
                                    ?>
                                    <tr class="product-row" 
                                        data-status="<?php echo $row['p_is_active'] ? 'active' : 'inactive'; ?>" 
                                        data-featured="<?php echo $row['p_is_featured'] ? 'featured' : 'regular'; ?>"
                                        data-stock="<?php echo $stock_class; ?>">
                                        
                                        <td class="text-center">
                                            <div class="product-serial"><?php echo $i; ?></div>
                                        </td>
                                        
                                        <td>
                                            <div class="product-info-compact">
                                                <div class="product-image-container">
                                                    <img src="assets/uploads/<?php echo htmlspecialchars($row['p_featured_photo']); ?>" 
                                                         alt="<?php echo htmlspecialchars($row['p_name']); ?>" 
                                                         class="product-thumb">
                                                    <?php if($row['p_is_featured']): ?>
                                                        <div class="featured-badge"><i class="fa fa-star"></i></div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="product-details-compact">
                                                    <h4 class="product-name-compact"><?php echo htmlspecialchars($row['p_name']); ?></h4>
                                                    <div class="product-meta">
                                                        <span class="product-id">#<?php echo $row['p_id']; ?></span>
                                                        <?php if(isset($row['p_date'])): ?>
                                                            <span class="product-date">Added: <?php echo date('M j, Y', strtotime($row['p_date'])); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="price-info-compact">
                                                <div class="current-price">₹<?php echo number_format($row['p_current_price'], 2); ?></div>
                                                <?php if($row['p_old_price'] > 0 && $row['p_old_price'] > $row['p_current_price']): ?>
                                                    <div class="old-price">₹<?php echo number_format($row['p_old_price'], 2); ?></div>
                                                    <div class="discount-percent">
                                                        <?php echo round((($row['p_old_price'] - $row['p_current_price']) / $row['p_old_price']) * 100); ?>% OFF
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="stock-info-compact <?php echo $stock_class; ?>">
                                                <div class="stock-number"><?php echo $row['p_qty']; ?></div>
                                                <div class="stock-label"><?php echo $stock_label; ?></div>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="status-badges-compact">
                                                <div class="status-badge <?php echo $row['p_is_active'] ? 'status-active' : 'status-inactive'; ?>">
                                                    <i class="fa <?php echo $row['p_is_active'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                                    <?php echo $row['p_is_active'] ? 'Active' : 'Inactive'; ?>
                                                </div>
                                                <?php if($row['p_is_featured']): ?>
                                                    <div class="status-badge status-featured">
                                                        <i class="fa fa-star"></i> Featured
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="action-buttons-compact">
                                                <a href="seller-product-edit.php?id=<?php echo $row['p_id']; ?>" 
                                                   class="seller-modern-btn seller-modern-btn-sm seller-modern-btn-primary" 
                                                   title="Edit Product">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="#" 
                                                   class="seller-modern-btn seller-modern-btn-sm seller-modern-btn-danger" 
                                                   data-href="seller-product-delete.php?id=<?php echo $row['p_id']; ?>" 
                                                   data-toggle="modal" data-target="#confirm-delete" 
                                                   title="Delete Product">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
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
<!-- Enhanced Delete Confirmation Modal -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content seller-modal">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteModalLabel">
                    <i class="fa fa-exclamation-triangle text-danger"></i>
                    Delete Product Confirmation
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="seller-alert seller-alert-danger">
                    <i class="fa fa-warning"></i>
                    <div class="alert-content">
                        <strong>Warning!</strong>
                        <p>This action cannot be undone. The product will be permanently removed from your inventory.</p>
                    </div>
                </div>
                <p>Are you sure you want to delete this product?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="seller-modern-btn seller-modern-btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <a class="seller-modern-btn seller-modern-btn-danger btn-ok">
                    <i class="fa fa-trash"></i> Delete Product
                </a>
            </div>
        </div>
    </div>
</div>
<script src="admin/js/jquery-2.2.3.min.js"></script>
<script src="admin/js/bootstrap.min.js"></script>
<script src="admin/js/app.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize counters
    updateProductCount();
    
    // Add animations
    setTimeout(function() {
        $('.fade-in').addClass('visible');
        $('.slide-in').each(function(i) {
            var $this = $(this);
            setTimeout(function() {
                $this.addClass('visible');
            }, i * 100);
        });
    }, 100);
    
    // Search functionality
    $('#productSearch').on('keyup', function() {
        filterProducts();
    });
    
    // Filter functionality
    $('#statusFilter, #featuredFilter, #stockFilter').on('change', function() {
        filterProducts();
    });
    
    // Clear filters
    $('#clearFilters').on('click', function() {
        $('#productSearch').val('');
        $('#statusFilter').val('');
        $('#featuredFilter').val('');
        $('#stockFilter').val('');
        filterProducts();
    });
    
    function filterProducts() {
        var searchTerm = $('#productSearch').val().toLowerCase();
        var statusFilter = $('#statusFilter').val();
        var featuredFilter = $('#featuredFilter').val();
        var stockFilter = $('#stockFilter').val();
        var visibleCount = 0;
        
        $('.product-row').each(function() {
            var $row = $(this);
            var productName = $row.find('.product-name-compact').text().toLowerCase();
            var productStatus = $row.data('status');
            var productFeatured = $row.data('featured');
            var productStock = $row.data('stock');
            
            var showRow = true;
            
            // Search filter
            if (searchTerm && !productName.includes(searchTerm)) {
                showRow = false;
            }
            
            // Status filter
            if (statusFilter && statusFilter !== productStatus) {
                showRow = false;
            }
            
            // Featured filter
            if (featuredFilter && featuredFilter !== productFeatured) {
                showRow = false;
            }
            
            // Stock filter
            if (stockFilter && stockFilter !== productStock) {
                showRow = false;
            }
            
            if (showRow) {
                $row.show();
                visibleCount++;
            } else {
                $row.hide();
            }
        });
        
        $('#currentCount').text(visibleCount);
    }
    
    function updateProductCount() {
        var totalCount = $('.product-row').length;
        $('#totalCount').text(totalCount);
        $('#currentCount').text(totalCount);
    }
    
    // Delete confirmation modal
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
});

// Helper functions
function refreshTable() {
    location.reload();
}
</script>
</body>
</html>