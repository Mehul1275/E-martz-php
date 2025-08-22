<?php
/**
 * Tracking Functions for E-martz
 * Functions to generate and manage order tracking IDs
 */

/**
 * Generate a unique tracking ID
 * Format: TRK + YYYYMMDD + 6 digit random number
 * Example: TRK20250730123456
 */
function generateTrackingId() {
    $date = date('Ymd');
    $random = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    return 'TRK' . $date . $random;
}

/**
 * Check if tracking ID already exists
 */
function isTrackingIdExists($pdo, $tracking_id) {
    $statement = $pdo->prepare("SELECT COUNT(*) as count FROM tbl_payment WHERE tracking_id = ?");
    $statement->execute(array($tracking_id));
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}

/**
 * Generate a unique tracking ID that doesn't exist in database
 */
function generateUniqueTrackingId($pdo) {
    do {
        $tracking_id = generateTrackingId();
    } while (isTrackingIdExists($pdo, $tracking_id));
    
    return $tracking_id;
}

/**
 * Update existing orders with tracking IDs (for migration)
 */
function updateExistingOrdersWithTrackingId($pdo) {
    $statement = $pdo->prepare("SELECT id FROM tbl_payment WHERE tracking_id IS NULL OR tracking_id = ''");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($result as $row) {
        $tracking_id = generateUniqueTrackingId($pdo);
        $update_statement = $pdo->prepare("UPDATE tbl_payment SET tracking_id = ? WHERE id = ?");
        $update_statement->execute(array($tracking_id, $row['id']));
    }
}
?> 