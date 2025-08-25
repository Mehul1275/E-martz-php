<?php
/**
 * Product Image Fix Script
 * This script fixes existing product image conflicts by updating image names
 * to include timestamps and ensuring unique naming.
 * 
 * Run this script once to fix existing issues, then delete it.
 */

// Database connection
require_once('admin/inc/config.php');

echo "<h2>Product Image Fix Script</h2>";
echo "<p>Starting to fix product image conflicts...</p>";

try {
    // Get all products with their current image names
    $statement = $pdo->prepare("SELECT p_id, p_featured_photo FROM tbl_product ORDER BY p_id");
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    $fixed_count = 0;
    $errors = array();
    
    foreach($products as $product) {
        $p_id = $product['p_id'];
        $current_image = $product['p_featured_photo'];
        
        // Skip if no image or already has timestamp
        if(empty($current_image) || strpos($current_image, '-') !== false) {
            continue;
        }
        
        // Check if image file exists
        $image_path = 'assets/uploads/' . $current_image;
        if(!file_exists($image_path)) {
            $errors[] = "Product ID {$p_id}: Image file not found: {$current_image}";
            continue;
        }
        
        // Generate new image name with timestamp
        $ext = pathinfo($current_image, PATHINFO_EXTENSION);
        $timestamp = time() + $p_id; // Use product ID to ensure uniqueness
        $new_image_name = 'product-featured-' . $p_id . '-' . $timestamp . '.' . $ext;
        $new_image_path = 'assets/uploads/' . $new_image_name;
        
        // Rename the file
        if(rename($image_path, $new_image_path)) {
            // Update database
            $update_statement = $pdo->prepare("UPDATE tbl_product SET p_featured_photo = ? WHERE p_id = ?");
            $update_statement->execute(array($new_image_name, $p_id));
            
            echo "<p>✓ Fixed Product ID {$p_id}: {$current_image} → {$new_image_name}</p>";
            $fixed_count++;
        } else {
            $errors[] = "Product ID {$p_id}: Failed to rename image file";
        }
    }
    
    echo "<h3>Summary</h3>";
    echo "<p>Total products processed: " . count($products) . "</p>";
    echo "<p>Images fixed: {$fixed_count}</p>";
    
    if(!empty($errors)) {
        echo "<h3>Errors encountered:</h3>";
        foreach($errors as $error) {
            echo "<p style='color: red;'>✗ {$error}</p>";
        }
    }
    
    if($fixed_count > 0) {
        echo "<p style='color: green; font-weight: bold;'>✅ Image conflicts have been resolved!</p>";
        echo "<p>You can now safely delete this script.</p>";
    } else {
        echo "<p style='color: blue;'>ℹ️ No image conflicts found. All products are using the new naming convention.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><strong>Note:</strong> This script should only be run once. After running, delete this file for security.</p>";
?>
