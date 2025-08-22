<?php
session_start();
require_once('admin/inc/config.php');
header('Content-Type: application/json');

if (!isset($_SESSION['customer']['cust_id'])) {
    echo json_encode(['success' => false, 'error' => 'not_logged_in']);
    exit;
}

$customer_id = $_SESSION['customer']['cust_id'];
$action = isset($_POST['action']) ? $_POST['action'] : '';
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

if (!$product_id) {
    echo json_encode(['success' => false, 'error' => 'no_product_id']);
    exit;
}

switch ($action) {
    case 'add':
        try {
            $stmt = $pdo->prepare('INSERT IGNORE INTO tbl_wishlist (customer_id, product_id) VALUES (?, ?)');
            $stmt->execute([$customer_id, $product_id]);
            echo json_encode(['success' => true, 'status' => 'added']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        break;
    case 'remove':
        try {
            $stmt = $pdo->prepare('DELETE FROM tbl_wishlist WHERE customer_id = ? AND product_id = ?');
            $stmt->execute([$customer_id, $product_id]);
            echo json_encode(['success' => true, 'status' => 'removed']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        break;
    case 'check':
        $stmt = $pdo->prepare('SELECT 1 FROM tbl_wishlist WHERE customer_id = ? AND product_id = ?');
        $stmt->execute([$customer_id, $product_id]);
        $exists = $stmt->fetchColumn();
        echo json_encode(['success' => true, 'wishlisted' => (bool)$exists]);
        break;
    case 'guest_fetch':
        $ids = isset($_POST['ids']) ? json_decode($_POST['ids'], true) : [];
        if (!$ids || !is_array($ids)) {
            echo json_encode(['success' => true, 'products' => []]);
            exit;
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare('SELECT p_id as product_id, p_name, p_featured_photo, p_current_price, p_old_price FROM tbl_product WHERE p_id IN (' . $placeholders . ')');
        $stmt->execute($ids);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'products' => $products]);
        exit;
    default:
        echo json_encode(['success' => false, 'error' => 'invalid_action']);
} 