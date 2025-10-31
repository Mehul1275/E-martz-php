<?php
include 'inc/config.php';

// Accept both the new key (tcat_id) and the legacy key (id) for compatibility
$tcatId = null;
if (isset($_POST['tcat_id']) && $_POST['tcat_id'] !== '') {
	$tcatId = (int)$_POST['tcat_id'];
} elseif (isset($_POST['id']) && $_POST['id'] !== '') { // legacy
	$tcatId = (int)$_POST['id'];
}

if ($tcatId !== null) {
	$statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id = ? ORDER BY mcat_name ASC");
	$statement->execute([$tcatId]);
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	?>
	<option value="">Select Mid Category</option>
	<?php foreach ($result as $row): ?>
		<option value="<?php echo $row['mcat_id']; ?>"><?php echo $row['mcat_name']; ?></option>
	<?php endforeach; ?>
<?php }