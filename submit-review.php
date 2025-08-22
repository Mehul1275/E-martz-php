<?php
session_start();
require_once 'admin/inc/config.php';

if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cust_id = $_SESSION['customer']['cust_id'];
    $p_id = intval($_POST['p_id']);
    $rating = intval($_POST['rating']);
    $subject = trim($_POST['subject']);
    $comment = trim($_POST['comment']);

    // Basic validation
    if ($rating < 1 || $rating > 5 || empty($subject) || empty($comment)) {
        header("Location: product.php?id=$p_id&error=Invalid input");
        exit;
    }

    // Prevent duplicate review
    $stmt = $pdo->prepare("SELECT rt_id FROM tbl_rating WHERE p_id=? AND cust_id=?");
    $stmt->execute([$p_id, $cust_id]);
    if ($stmt->rowCount() > 0) {
        header("Location: product.php?id=$p_id&error=You have already reviewed this product");
        exit;
    }

    // Insert review
    $stmt = $pdo->prepare("INSERT INTO tbl_rating (p_id, cust_id, subject, comment, rating) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$p_id, $cust_id, $subject, $comment, $rating])) {
        header("Location: product.php?id=$p_id&success=Review submitted");
    } else {
        header("Location: product.php?id=$p_id&error=Could not submit review");
    }
}
?> 