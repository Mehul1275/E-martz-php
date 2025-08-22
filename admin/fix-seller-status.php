<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Fix Seller Status Issues</h1>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body">
					<?php
					// Check for sellers with status=1 but email_verified=0
					$statement = $pdo->prepare("SELECT * FROM sellers WHERE status=1 AND email_verified=0");
					$statement->execute();
					$problematic_sellers = $statement->fetchAll(PDO::FETCH_ASSOC);
					
					if(empty($problematic_sellers)) {
						echo '<div class="alert alert-success">No problematic sellers found. All active sellers have proper email verification status.</div>';
					} else {
						echo '<div class="alert alert-warning">Found ' . count($problematic_sellers) . ' seller(s) with status=1 but email_verified=0. These sellers cannot login.</div>';
						
						echo '<table class="table table-bordered">';
						echo '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Email Verified</th></tr></thead>';
						echo '<tbody>';
						
						foreach($problematic_sellers as $seller) {
							echo '<tr>';
							echo '<td>' . $seller['id'] . '</td>';
							echo '<td>' . htmlspecialchars($seller['fullname']) . '</td>';
							echo '<td>' . htmlspecialchars($seller['email']) . '</td>';
							echo '<td>' . ($seller['status'] == 1 ? 'Active' : 'Inactive') . '</td>';
							echo '<td>' . ($seller['email_verified'] == 1 ? 'Yes' : 'No') . '</td>';
							echo '</tr>';
						}
						
						echo '</tbody></table>';
						
						if(isset($_POST['fix_sellers'])) {
							// Fix the problematic sellers
							$statement = $pdo->prepare("UPDATE sellers SET email_verified=1 WHERE status=1 AND email_verified=0");
							$statement->execute();
							
							echo '<div class="alert alert-success">Fixed ' . count($problematic_sellers) . ' seller(s). They can now login successfully.</div>';
							echo '<script>setTimeout(function(){ window.location.reload(); }, 2000);</script>';
						} else {
							echo '<form method="post">';
							echo '<button type="submit" name="fix_sellers" class="btn btn-success">Fix All Problematic Sellers</button>';
							echo '</form>';
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php require_once('footer.php'); ?> 