<?php
session_start();
include("admin/inc/config.php");

echo "<h2>Cart Data Debug</h2>";

if(!isset($_SESSION['cart_p_id']) || empty($_SESSION['cart_p_id'])) {
    echo "<p style='color: red;'>No cart items found!</p>";
    echo "<p><a href='index.php'>Go to Home</a></p>";
    exit();
}

echo "<h3>Cart Session Data:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h3>Cart Arrays:</h3>";

// Initialize arrays
$i = 0;
foreach($_SESSION['cart_p_id'] as $key => $value) {
    $i++;
    $arr_cart_p_id[$i] = $value;
}

$i = 0;
foreach($_SESSION['cart_p_name'] as $key => $value) {
    $i++;
    $arr_cart_p_name[$i] = $value;
}

$i = 0;
foreach($_SESSION['cart_p_current_price'] as $key => $value) {
    $i++;
    $arr_cart_p_current_price[$i] = $value;
}

$i = 0;
foreach($_SESSION['cart_p_qty'] as $key => $value) {
    $i++;
    $arr_cart_p_qty[$i] = $value;
}

echo "<h4>Product IDs:</h4>";
print_r($arr_cart_p_id);

echo "<h4>Product Names:</h4>";
print_r($arr_cart_p_name);

echo "<h4>Product Prices:</h4>";
print_r($arr_cart_p_current_price);

echo "<h4>Product Quantities:</h4>";
print_r($arr_cart_p_qty);

echo "<h3>Calculations:</h3>";
$table_total_price = 0;

for($i=1;$i<=count($arr_cart_p_id);$i++) {
    echo "<p>Item $i:</p>";
    echo "<ul>";
    echo "<li>Price: " . $arr_cart_p_current_price[$i] . " (Type: " . gettype($arr_cart_p_current_price[$i]) . ")</li>";
    echo "<li>Quantity: " . $arr_cart_p_qty[$i] . " (Type: " . gettype($arr_cart_p_qty[$i]) . ")</li>";
    
    $current_price = floatval($arr_cart_p_current_price[$i]);
    $quantity = intval($arr_cart_p_qty[$i]);
    $row_total = $current_price * $quantity;
    
    echo "<li>Converted Price: $current_price</li>";
    echo "<li>Converted Quantity: $quantity</li>";
    echo "<li>Row Total: $row_total</li>";
    echo "</ul>";
    
    $table_total_price += $row_total;
}

echo "<h3>Final Total: ₹" . number_format($table_total_price, 2) . "</h3>";

echo "<p><a href='checkout.php'>Go to Checkout</a></p>";
echo "<p><a href='cart.php'>Go to Cart</a></p>";
?> 