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
	}
}
$statement = $pdo->prepare("DELETE FROM sellers WHERE id=?");
$statement->execute(array($_REQUEST['id']));
header('location: seller.php');
exit;
?> 