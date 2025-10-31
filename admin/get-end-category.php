<?php
include 'inc/config.php';

// Accept both the new key (mcat_id) and the legacy key (id) for compatibility
$mcatId = null;
if (isset($_POST['mcat_id']) && $_POST['mcat_id'] !== '') {
	$mcatId = (int)$_POST['mcat_id'];
} elseif (isset($_POST['id']) && $_POST['id'] !== '') { // legacy
	$mcatId = (int)$_POST['id'];
}

if ($mcatId !== null) {
	$statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id = ? ORDER BY ecat_name ASC");
	$statement->execute([$mcatId]);
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	?>
	<option value="">Select End Category</option>
	<?php foreach ($result as $row): ?>
		<option value="<?php echo $row['ecat_id']; ?>"><?php echo $row['ecat_name']; ?></option>
	<?php endforeach; ?>
<?php }