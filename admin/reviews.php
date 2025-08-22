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

<link rel="stylesheet" href="css/dataTables.bootstrap.css">
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>

<section class="content-header">
  <div class="content-header-left">
    <h1>Customer Reviews</h1>
  </div>
</section>

<section class="content">
  <div class="box box-info">
    <div class="box-body table-responsive">
      <table id="reviews-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Product</th>
            <th>Customer</th>
            <th>Subject</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=0; foreach($reviews as $review): $i++; ?>
          <tr>
            <td><?= $i ?></td>
            <td>
              <img src="../assets/uploads/<?= htmlspecialchars($review['p_featured_photo']) ?>" alt="" style="width:50px;height:50px;object-fit:cover;margin-right:8px;vertical-align:middle;">
              <?= htmlspecialchars($review['p_name']) ?>
            </td>
            <td><?= htmlspecialchars($review['cust_name']) ?></td>
            <td><?= isset($review['subject']) ? htmlspecialchars($review['subject']) : 'N/A' ?></td>
            <td>
              <?php for($j=1;$j<=5;$j++): ?>
                <?php if($j <= $review['rating']): ?><i class="fa fa-star" style="color:#f5b301;"></i><?php else: ?><i class="fa fa-star-o"></i><?php endif; ?>
              <?php endfor; ?>
            </td>
            <td><?= nl2br(htmlspecialchars($review['comment'])) ?></td>
            <td><?= isset($review['created_at']) ? date('Y-m-d H:i', strtotime($review['created_at'])) : 'N/A' ?></td>
            <td>
              <a href="reviews.php?delete=<?= $review['rt_id'] ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this review?');"><i class="fa fa-trash"></i> Delete</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  $('#reviews-table').DataTable();
});
</script>

<?php require_once 'footer.php'; ?> 