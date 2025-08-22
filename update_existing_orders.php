<?php
/**
 * Script to update existing orders with tracking IDs
 * Run this script once after adding the tracking_id column to the database
 */

// Include configuration
require_once("admin/inc/config.php");
require_once("admin/inc/functions.php");
require_once("admin/inc/tracking_functions.php");

echo "<h2>Updating Existing Orders with Tracking IDs</h2>";

try {
    // Check if tracking_id column exists
    $statement = $pdo->prepare("SHOW COLUMNS FROM tbl_payment LIKE 'tracking_id'");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    if(count($result) == 0) {
        echo "<p style='color: red;'>Error: tracking_id column does not exist in tbl_payment table.</p>";
        echo "<p>Please run the database update script first:</p>";
        echo "<pre>ALTER TABLE `tbl_payment` ADD COLUMN `tracking_id` VARCHAR(50) DEFAULT NULL AFTER `invoice_number`;</pre>";
        exit;
    }
    
    // Get orders without tracking IDs
    $statement = $pdo->prepare("SELECT COUNT(*) as count FROM tbl_payment WHERE tracking_id IS NULL OR tracking_id = ''");
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $total_orders = $result['count'];
    
    if($total_orders == 0) {
        echo "<p style='color: green;'>All orders already have tracking IDs assigned.</p>";
        exit;
    }
    
    echo "<p>Found {$total_orders} orders without tracking IDs.</p>";
    
    // Update orders with tracking IDs
    $statement = $pdo->prepare("SELECT id FROM tbl_payment WHERE tracking_id IS NULL OR tracking_id = ''");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    $updated_count = 0;
    foreach ($result as $row) {
        $tracking_id = generateUniqueTrackingId($pdo);
        $update_statement = $pdo->prepare("UPDATE tbl_payment SET tracking_id = ? WHERE id = ?");
        $update_statement->execute(array($tracking_id, $row['id']));
        $updated_count++;
        
        echo "<p>Updated order ID {$row['id']} with tracking ID: {$tracking_id}</p>";
    }
    
    echo "<p style='color: green;'>Successfully updated {$updated_count} orders with tracking IDs.</p>";
    
} catch(Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?> 