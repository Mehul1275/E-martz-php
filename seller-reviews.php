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

$success_message = '';
$error_message = '';

// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $pdo->prepare('DELETE FROM tbl_rating WHERE rt_id = ?');
    if($stmt->execute([$delete_id])) {
        $success_message = 'Review deleted successfully.';
    } else {
        $error_message = 'Error deleting review.';
    }
}

// Fetch only reviews for this seller's products
$stmt = $pdo->prepare('SELECT r.rt_id, r.p_id, r.cust_id, r.subject, r.comment, r.rating, p.p_name, p.p_featured_photo, c.cust_name, r.created_at FROM tbl_rating r JOIN tbl_product p ON r.p_id = p.p_id JOIN tbl_customer c ON r.cust_id = c.cust_id WHERE p.seller_id = ? ORDER BY r.rt_id DESC');
$stmt->execute([$seller_id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="admin/css/dataTables.bootstrap.css">
<script src="admin/js/jquery-2.2.3.min.js"></script>
<script src="admin/js/bootstrap.min.js"></script>
<script src="admin/js/app.min.js"></script>
<script src="admin/js/jquery.dataTables.min.js"></script>
<script src="admin/js/dataTables.bootstrap.min.js"></script>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Seller Panel - Product Reviews</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="admin/css/_all-skins.min.css">
    <link rel="stylesheet" href="assets/css/seller-modern.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
<?php include('seller-sidebar.php'); ?>
    <div class="content-wrapper" style="min-height:100vh;">
        <!-- Page Header -->
        <div class="seller-page-header fade-in" style="margin-top: 20px;">
            <h1 class="seller-page-title">
                <i class="fa fa-star"></i>
                Product Reviews
            </h1>
            <p class="seller-page-subtitle">Monitor customer feedback and ratings for your products</p>
        </div>

        <!-- Filter & Search Bar -->
        <div class="seller-filter-bar slide-in">
            <div class="filter-header">
                <h3><i class="fa fa-filter"></i> Filter & Search Reviews</h3>
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
                            <i class="fa fa-search"></i> Search Reviews
                        </label>
                        <div class="seller-search-box">
                            <i class="fa fa-search"></i>
                            <input type="text" id="searchReviews" 
                                   placeholder="Search by product name, customer name..." 
                                   class="seller-form-control">
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fa fa-star"></i> Rating
                        </label>
                        <select id="ratingFilter" class="seller-form-control seller-filter-select">
                            <option value="">All Ratings</option>
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fa fa-cube"></i> Product
                        </label>
                        <select id="productFilter" class="seller-form-control seller-filter-select">
                            <option value="">All Products</option>
                            <?php
                            $product_stmt = $pdo->prepare('SELECT DISTINCT p.p_id, p.p_name FROM tbl_product p JOIN tbl_rating r ON p.p_id = r.p_id WHERE p.seller_id = ? ORDER BY p.p_name');
                            $product_stmt->execute([$seller_id]);
                            $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($products as $product) {
                                echo '<option value="'.$product['p_id'].'">'.htmlspecialchars($product['p_name']).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fa fa-calendar"></i> Date Range
                        </label>
                        <select id="dateFilter" class="seller-form-control seller-filter-select">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>
                </div>
                
                <div class="filter-summary">
                    <div class="results-info">
                        <span class="results-count">
                            <i class="fa fa-list"></i>
                            Showing <span id="reviewCount"><?php echo count($reviews); ?></span> reviews
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <!-- Alert Messages -->
            <?php if($success_message): ?>
                <div class="seller-alert alert-success fade-in">
                    <i class="fa fa-check-circle"></i>
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>
            
            <?php if($error_message): ?>
                <div class="seller-alert alert-danger fade-in">
                    <i class="fa fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <!-- Reviews Table -->
            <div class="seller-table-container slide-in">
                <div class="table-responsive">
                    <table class="seller-modern-table">
                                <thead>
                                    <tr>
                                        <th>Product Info</th>
                                        <th>Customer</th>
                                        <th>Review Details</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Date & Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach($reviews as $review): $i++; ?>
                                    <tr class="review-row" data-rating="<?= $review['rating'] ?>">
                                        <td class="seller-product-info">
                                            <div class="product-image-container">
                                                <img src="assets/uploads/<?= htmlspecialchars($review['p_featured_photo']) ?>" 
                                                     alt="Product Image" class="product-image">
                                            </div>
                                            <div class="product-details">
                                                <div class="product-name"><?= htmlspecialchars($review['p_name']) ?></div>
                                                <div class="product-id">ID: <?= $review['p_id'] ?></div>
                                            </div>
                                        </td>
                                        <td class="seller-customer-info">
                                            <div class="customer-name"><?= htmlspecialchars($review['cust_name']) ?></div>
                                            <div class="customer-id">Customer ID: <?= $review['cust_id'] ?></div>
                                        </td>
                                        <td class="review-details">
                                            <div class="review-subject">
                                                <?= isset($review['subject']) && !empty($review['subject']) ? htmlspecialchars($review['subject']) : 'General Review' ?>
                                            </div>
                                            <div class="review-id">Review #<?= $i ?></div>
                                        </td>
                                        <td class="rating-display">
                                            <div class="star-rating">
                                                <?php for($j=1;$j<=5;$j++): ?>
                                                    <?php if($j <= $review['rating']): ?>
                                                        <i class="fa fa-star star-filled"></i>
                                                    <?php else: ?>
                                                        <i class="fa fa-star-o star-empty"></i>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                            <div class="rating-text"><?= $review['rating'] ?>/5 Stars</div>
                                        </td>
                                        <td class="review-comment">
                                            <div class="comment-text"><?= nl2br(htmlspecialchars($review['comment'])) ?></div>
                                        </td>
                                        <td class="review-actions">
                                            <div class="review-date">
                                                <?= isset($review['created_at']) ? date('M d, Y', strtotime($review['created_at'])) : 'N/A' ?>
                                            </div>
                                            <div class="review-time">
                                                <?= isset($review['created_at']) ? date('H:i', strtotime($review['created_at'])) : '' ?>
                                            </div>
                                            <div class="action-buttons">
                                                <a href="seller-reviews.php?delete=<?= $review['rt_id'] ?>" 
                                                   class="seller-btn seller-btn-sm seller-btn-danger"
                                                   onclick="return confirm('Are you sure you want to delete this review? This action cannot be undone.')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
        </section>
    </div>
</div>

<script>
$(document).ready(function() {
    // Search functionality
    $('#searchReviews').on('keyup', function() {
        filterReviews();
    });
    
    // Rating filter functionality
    $('#ratingFilter').on('change', function() {
        filterReviews();
    });
    
    // Product filter functionality
    $('#productFilter').on('change', function() {
        filterReviews();
    });
    
    // Date filter functionality
    $('#dateFilter').on('change', function() {
        filterReviews();
    });
    
    function filterReviews() {
        const searchTerm = $('#searchReviews').val().toLowerCase();
        const ratingFilter = $('#ratingFilter').val();
        const productFilter = $('#productFilter').val();
        const dateFilter = $('#dateFilter').val();
        let visibleCount = 0;
        
        $('.review-row').each(function() {
            const row = $(this);
            const productName = row.find('.product-name').text().toLowerCase();
            const customerName = row.find('.customer-name').text().toLowerCase();
            const reviewSubject = row.find('.review-subject').text().toLowerCase();
            const commentText = row.find('.comment-text').text().toLowerCase();
            const rating = row.data('rating').toString();
            const productId = row.find('.product-id').text().split(': ')[1];
            const reviewDate = row.find('.review-date').text();
            
            const matchesSearch = !searchTerm || 
                productName.includes(searchTerm) || 
                customerName.includes(searchTerm) || 
                reviewSubject.includes(searchTerm) ||
                commentText.includes(searchTerm);
            
            const matchesRating = !ratingFilter || rating === ratingFilter;
            
            const matchesProduct = !productFilter || productId === productFilter;
            
            const matchesDate = !dateFilter || 
                (dateFilter === 'today' && reviewDate === date('M d, Y')) || 
                (dateFilter === 'week' && getWeekNumber(reviewDate) === getWeekNumber(date('M d, Y'))) || 
                (dateFilter === 'month' && reviewDate.split(' ')[0] === date('M'));
            
            if (matchesSearch && matchesRating && matchesProduct && matchesDate) {
                row.show();
                visibleCount++;
            } else {
                row.hide();
            }
        });
        
        $('#reviewCount').text(visibleCount);
    }
    
    function getWeekNumber(dateString) {
        const date = new Date(dateString);
        const firstDayOfYear = new Date(date.getFullYear(), 0, 1);
        const pastDaysOfYear = (date - firstDayOfYear) / 24 / 60 / 60 / 1000;
        return Math.ceil((pastDaysOfYear + firstDayOfYear.getDay() + 1) / 7);
    }
    
    // Add animations
    setTimeout(function() {
        $('.fade-in').addClass('visible');
        $('.slide-in').addClass('visible');
    }, 100);
    
    // Auto-focus search on page load
    $('#searchReviews').focus();
});
</script>

<style>
/* Additional styles for reviews page */
.seller-product-info {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.product-image-container {
    flex-shrink: 0;
}

.product-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: var(--border-radius-sm);
    border: 2px solid var(--seller-light);
}

.product-details {
    flex: 1;
}

.product-id {
    font-size: 0.8rem;
    color: var(--seller-secondary);
}

.review-details {
    text-align: left;
}

.review-subject {
    font-weight: 600;
    color: var(--seller-dark);
    margin-bottom: var(--spacing-xs);
}

.review-id {
    font-size: 0.8rem;
    color: var(--seller-secondary);
}

.rating-display {
    text-align: center;
}

.star-rating {
    margin-bottom: var(--spacing-xs);
}

.star-filled {
    color: #f5b301;
    font-size: 1.1rem;
}

.star-empty {
    color: #ddd;
    font-size: 1.1rem;
}

.rating-text {
    font-size: 0.85rem;
    color: var(--seller-secondary);
    font-weight: 500;
}

.review-comment {
    max-width: 250px;
}

.comment-text {
    font-size: 0.9rem;
    color: var(--seller-dark);
    line-height: 1.4;
    max-height: 100px;
    overflow-y: auto;
    padding: var(--spacing-sm);
    background: rgba(44, 90, 160, 0.05);
    border-radius: var(--border-radius-sm);
    border-left: 3px solid var(--seller-info);
}

.review-actions {
    text-align: center;
}

.review-date {
    font-weight: 600;
    color: var(--seller-dark);
    margin-bottom: var(--spacing-xs);
}

.review-time {
    font-size: 0.8rem;
    color: var(--seller-secondary);
    margin-bottom: var(--spacing-sm);
}

.action-buttons {
    display: flex;
    justify-content: center;
}

/* Animation keyframes */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.fade-in {
    opacity: 0;
    animation: fadeIn 0.6s ease-out forwards;
}

.slide-in {
    opacity: 0;
    transform: translateY(20px);
    animation: slideIn 0.8s ease-out forwards;
}

.fade-in.visible,
.slide-in.visible {
    opacity: 1;
    transform: translateY(0);
}
</style>
</body>
</html>