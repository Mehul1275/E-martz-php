<?php require_once('header.php'); ?>
<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	$statement = $pdo->prepare("SELECT * FROM sellers WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	} else {
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			$status = $row['status'];
		}
	}
}
if($status == 0) {
	$final = 1;
	// When activating a seller, also set email_verified to 1
	$statement = $pdo->prepare("UPDATE sellers SET status=?, email_verified=1 WHERE id=?");
	$statement->execute(array($final,$_REQUEST['id']));
} else {
	$final = 0;
	$statement = $pdo->prepare("UPDATE sellers SET status=? WHERE id=?");
	$statement->execute(array($final,$_REQUEST['id']));
}
header('location: seller.php');
exit;
?> 