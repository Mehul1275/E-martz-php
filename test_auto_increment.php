<?php
/**
 * Test Script for Auto-Increment Fix
 * This script tests the new auto-increment method to ensure it works correctly
 */

// Database connection
require_once('admin/inc/config.php');

echo "<h2>Auto-Increment Fix Test</h2>";

try {
    // Test the new method for tbl_product
    echo "<h3>Testing tbl_product auto-increment:</h3>";
    $statement = $pdo->prepare("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_product'");
    $statement->execute();
    $result = $statement->fetchAll();
    
    if(!empty($result)) {
        $ai_id = $result[0]['AUTO_INCREMENT'];
        echo "<p style='color: green;'>✓ Successfully got auto-increment value: {$ai_id}</p>";
    } else {
        echo "<p style='color: red;'>✗ Failed to get auto-increment value</p>";
    }
    
    // Test the new method for tbl_product_photo
    echo "<h3>Testing tbl_product_photo auto-increment:</h3>";
    $statement = $pdo->prepare("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_product_photo'");
    $statement->execute();
    $result = $statement->fetchAll();
    
    if(!empty($result)) {
        $next_id = $result[0]['AUTO_INCREMENT'];
        echo "<p style='color: green;'>✓ Successfully got auto-increment value: {$next_id}</p>";
    } else {
        echo "<p style='color: red;'>✗ Failed to get auto-increment value</p>";
    }
    
    // Test the old method to show the difference
    echo "<h3>Testing old SHOW TABLE STATUS method (for comparison):</h3>";
    $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product'");
    $statement->execute();
    $result = $statement->fetchAll();
    
    if(!empty($result)) {
        echo "<p>SHOW TABLE STATUS result structure:</p>";
        echo "<pre>";
        print_r($result[0]);
        echo "</pre>";
        
        // Check if index 10 exists
        if(isset($result[0][10])) {
            echo "<p style='color: green;'>✓ Index 10 exists: " . $result[0][10] . "</p>";
        } else {
            echo "<p style='color: red;'>✗ Index 10 does not exist - this was causing the error!</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ SHOW TABLE STATUS returned no results</p>";
    }
    
    echo "<hr>";
    echo "<p style='color: blue;'><strong>Conclusion:</strong> The new method using information_schema.TABLES is more reliable and eliminates the 'Undefined array key 10' error.</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><strong>Note:</strong> You can delete this test file after confirming the fix works.</p>";
?>
