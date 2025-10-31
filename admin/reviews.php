<?php
require_once 'header.php';

// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $pdo->prepare('DELETE FROM tbl_rating WHERE rt_id = ?');
    $stmt->execute([$delete_id]);
    echo '<div class="alert alert-success">Review deleted successfully.</div>';
}

// Fetch all reviews
$stmt = $pdo->query('SELECT r.rt_id, r.p_id, r.cust_id, r.subject, r.comment, r.rating, p.p_name, p.p_featured_photo, c.cust_name, r.created_at FROM tbl_rating r JOIN tbl_product p ON r.p_id = p.p_id JOIN tbl_customer c ON r.cust_id = c.cust_id ORDER BY r.rt_id DESC');
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

.review-product {
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.product-image {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid #e3e6f0;
}

.product-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
}

.customer-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    color: #34495e;
}

.rating-stars {
    display: flex;
    gap: 0.2rem;
    align-items: center;
}

.rating-stars i {
    font-size: 1rem;
}

.star-filled {
    color: #f39c12;
}

.star-empty {
    color: #bdc3c7;
}

.rating-badge {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    padding: 0.3rem 0.6rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-left: 0.5rem;
}

.review-comment {
    max-width: 300px;
    font-size: 0.9rem;
    line-height: 1.4;
    color: #2c3e50;
}

.review-subject {
    font-weight: 600;
    color: #8e44ad;
    margin-bottom: 0.3rem;
}

.review-date {
    font-size: 0.85rem;
    color: #7f8c8d;
    font-weight: 500;
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
        <i class="fa fa-star"></i>
        Customer Reviews Management
    </h1>
    <div class="subtitle">Monitor and manage customer product reviews and ratings</div>
</div>

<div class="row" style="margin-bottom: 1.5rem;">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number"><?php echo count($reviews); ?></div>
            <div class="stats-label">Total Reviews</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number">
                <?php 
                $avg_rating = 0;
                if(count($reviews) > 0) {
                    $total_rating = array_sum(array_column($reviews, 'rating'));
                    $avg_rating = round($total_rating / count($reviews), 1);
                }
                echo $avg_rating;
                ?>
            </div>
            <div class="stats-label">Average Rating</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number">
                <?php echo count(array_filter($reviews, function($r) { return $r['rating'] >= 4; })); ?>
            </div>
            <div class="stats-label">Positive Reviews</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number">
                <?php echo count(array_filter($reviews, function($r) { return $r['rating'] <= 2; })); ?>
            </div>
            <div class="stats-label">Negative Reviews</div>
        </div>
    </div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-6">
            <input type="text" id="reviewSearch" class="search-box" placeholder="🔍 Search reviews by product, customer, or comment...">
        </div>
        <div class="col-md-3">
            <select id="ratingFilter" class="search-box">
                <option value="">All Ratings</option>
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
            </select>
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Showing: <span id="visibleCount">0</span> reviews
            </div>
        </div>
    </div>
</div>

<section class="content">
  <div class="modern-table-container slide-in">
    <div class="table-responsive">
      <table id="reviews-table" class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Product</th>
            <th>Customer</th>
            <th>Review Details</th>
            <th>Rating</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=0; foreach($reviews as $review): $i++; ?>
          <tr data-rating="<?= $review['rating'] ?>">
            <td><?= $i ?></td>
            <td>
              <div class="review-product">
                <img src="../assets/uploads/<?= htmlspecialchars($review['p_featured_photo']) ?>" alt="" class="product-image">
                <div class="product-name"><?= htmlspecialchars($review['p_name']) ?></div>
              </div>
            </td>
            <td>
              <div class="customer-info">
                <i class="fa fa-user"></i>
                <?= htmlspecialchars($review['cust_name']) ?>
              </div>
            </td>
            <td>
              <div class="review-comment">
                <?php if(isset($review['subject']) && !empty($review['subject'])): ?>
                  <div class="review-subject"><?= htmlspecialchars($review['subject']) ?></div>
                <?php endif; ?>
                <?= nl2br(htmlspecialchars($review['comment'])) ?>
              </div>
            </td>
            <td>
              <div class="rating-stars">
                <?php for($j=1;$j<=5;$j++): ?>
                  <i class="fa fa-star <?= $j <= $review['rating'] ? 'star-filled' : 'star-empty' ?>"></i>
                <?php endfor; ?>
                <span class="rating-badge"><?= $review['rating'] ?>/5</span>
              </div>
            </td>
            <td>
              <div class="review-date">
                <i class="fa fa-calendar"></i>
                <?= isset($review['created_at']) ? date('M d, Y', strtotime($review['created_at'])) : 'N/A' ?>
              </div>
            </td>
            <td>
              <a href="reviews.php?delete=<?= $review['rt_id'] ?>" class="action-btn btn-delete" onclick="return confirm('Are you sure you want to delete this review?');">
                <i class="fa fa-trash"></i> Delete
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<script>
// Search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('reviewSearch');
    const ratingFilter = document.getElementById('ratingFilter');
    const table = document.getElementById('reviews-table');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    const visibleCountSpan = document.getElementById('visibleCount');
    
    // Update visible count initially
    updateVisibleCount();
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const ratingValue = ratingFilter.value;
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent.toLowerCase();
            const rating = row.getAttribute('data-rating');
            
            const matchesSearch = text.includes(searchTerm);
            const matchesRating = ratingValue === '' || rating === ratingValue;
            
            if (matchesSearch && matchesRating) {
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
    ratingFilter.addEventListener('change', filterTable);
});
</script>

<?php require_once 'footer.php'; ?> 