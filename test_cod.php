<?php
// Test file to verify COD order processing
session_start();
include("admin/inc/config.php");

echo "<h2>COD Order Processing Test</h2>";

// Check if there are any existing COD orders
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_method = 'Cash on Delivery' ORDER BY id DESC LIMIT 5");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "<h3>Recent COD Orders:</h3>";
if(count($result) > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Customer</th><th>Order ID</th><th>Amount</th><th>Status</th><th>Date</th></tr>";
    foreach($result as $row) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['customer_name'] . "</td>";
        echo "<td>" . $row['txnid'] . "</td>";
        echo "<td>₹" . $row['paid_amount'] . "</td>";
        echo "<td>" . $row['payment_status'] . "</td>";
        echo "<td>" . $row['payment_date'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check order details for the first COD order
    if(count($result) > 0) {
        $first_order = $result[0];
        echo "<h3>Order Details for Order ID: " . $first_order['txnid'] . "</h3>";
        
        $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id = ?");
        $statement1->execute(array($first_order['payment_id']));
        $order_details = $statement1->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($order_details) > 0) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Product ID</th><th>Product Name</th><th>Size</th><th>Color</th><th>Quantity</th><th>Unit Price</th></tr>";
            foreach($order_details as $detail) {
                echo "<tr>";
                echo "<td>" . $detail['product_id'] . "</td>";
                echo "<td>" . $detail['product_name'] . "</td>";
                echo "<td>" . $detail['size'] . "</td>";
                echo "<td>" . $detail['color'] . "</td>";
                echo "<td>" . $detail['quantity'] . "</td>";
                echo "<td>₹" . $detail['unit_price'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: red;'>No order details found for this payment ID!</p>";
        }
    }
} else {
    echo "<p>No COD orders found in the database.</p>";
}

echo "<hr>";
echo "<h3>Database Table Structure Check:</h3>";

// Check tbl_order structure
$statement = $pdo->prepare("DESCRIBE tbl_order");
$statement->execute();
$columns = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "<h4>tbl_order columns:</h4>";
echo "<ul>";
foreach($columns as $column) {
    echo "<li>" . $column['Field'] . " - " . $column['Type'] . "</li>";
}
echo "</ul>";

// Check tbl_payment structure
$statement = $pdo->prepare("DESCRIBE tbl_payment");
$statement->execute();
$columns = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "<h4>tbl_payment columns:</h4>";
echo "<ul>";
foreach($columns as $column) {
    echo "<li>" . $column['Field'] . " - " . $column['Type'] . "</li>";
}
echo "</ul>";

echo "<hr>";
echo "<p><strong>Test completed.</strong></p>";
?> 