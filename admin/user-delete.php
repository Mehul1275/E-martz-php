<?php
session_start();
include("inc/config.php");
if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}
require_once('header.php');
if (!isset($_GET['id'])) {
    header('Location: users.php');
    exit;
}
$id = (int)$_GET['id'];

if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $id) {
    header('Location: users.php?error=cannot_delete_self');
    exit;
}

// Get photo name to delete from folder
$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id = ?");
$statement->execute([$id]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if($user) {
    $photo = $user['photo'];
    if($photo && file_exists('../assets/uploads/'.$photo)) {
        unlink('../assets/uploads/'.$photo);
    }
}

$statement = $pdo->prepare("DELETE FROM tbl_user WHERE id = ?");
$statement->execute([$id]);
header('Location: users.php?success=1');
exit; 