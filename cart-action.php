<?php
// declare(strict_types=1); // Temporarily disabled for debugging

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('admin/inc/config.php');
require_once('admin/inc/functions.php');
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log the incoming data for debugging
error_log("Cart action received: " . json_encode($_POST));

try {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $p_qty = isset($_POST['p_qty']) ? (int)$_POST['p_qty'] : 1;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    error_log("Parsed data - product_id: $product_id, p_qty: $p_qty, action: $action");

    if (!$product_id || !$action) {
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
        exit();
    }

    // Get product info
    $stmt = $pdo->prepare('SELECT * FROM tbl_product WHERE p_id=?');
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        echo json_encode(['success' => false, 'error' => 'Product not found']);
        exit();
    }

    error_log("Product found: " . $product['p_name']);

    // Add to cart logic (no size/color for quick add)
    if (!isset($_SESSION['cart_p_id'])) {
        $_SESSION['cart_p_id'] = [];
        $_SESSION['cart_size_id'] = [];
        $_SESSION['cart_size_name'] = [];
        $_SESSION['cart_color_id'] = [];
        $_SESSION['cart_color_name'] = [];
        $_SESSION['cart_p_qty'] = [];
        $_SESSION['cart_p_current_price'] = [];
        $_SESSION['cart_p_name'] = [];
        $_SESSION['cart_p_featured_photo'] = [];
    }

    // Check if already in cart
    $found = false;
    foreach ($_SESSION['cart_p_id'] as $key => $pid) {
        if ($pid == $product_id) {
            $_SESSION['cart_p_qty'][$key] += $p_qty;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $i = count($_SESSION['cart_p_id']) + 1;
        $_SESSION['cart_p_id'][$i] = $product_id;
        $_SESSION['cart_size_id'][$i] = 0;
        $_SESSION['cart_size_name'][$i] = '';
        $_SESSION['cart_color_id'][$i] = 0;
        $_SESSION['cart_color_name'][$i] = '';
        $_SESSION['cart_p_qty'][$i] = $p_qty;
        $_SESSION['cart_p_current_price'][$i] = $product['p_current_price'];
        $_SESSION['cart_p_name'][$i] = $product['p_name'];
        $_SESSION['cart_p_featured_photo'][$i] = $product['p_featured_photo'];
    }

    error_log("Cart updated successfully");

    if ($action === 'buy_now') {
        echo json_encode(['success' => true, 'redirect' => 'checkout.php']);
    } else {
        echo json_encode(['success' => true]);
    }
    
} catch (Exception $e) {
    error_log("Cart action error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Server error: ' . $e->getMessage()]);
} 