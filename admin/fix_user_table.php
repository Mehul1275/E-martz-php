<?php
session_start();
include("inc/config.php");
if(!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}

echo "<h2>Fixing tbl_user table structure...</h2>";

try {
    // Check current table structure
    $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_user'");
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    
    echo "<p>Current Auto_increment value: " . ($result['Auto_increment'] ?? 'NULL') . "</p>";
    
    // Show current data
    $statement = $pdo->prepare("SELECT * FROM tbl_user ORDER BY id");
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>Current users in table:</p>";
    echo "<ul>";
    foreach($users as $user) {
        echo "<li>ID: " . $user['id'] . " - " . $user['full_name'] . " (" . $user['email'] . ")</li>";
    }
    echo "</ul>";
    
    // Create new table with correct structure
    $pdo->exec("CREATE TABLE tbl_user_new (
        id int(10) NOT NULL AUTO_INCREMENT,
        full_name varchar(100) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(100) NOT NULL,
        password varchar(255) NOT NULL,
        photo varchar(255) NOT NULL,
        role varchar(30) NOT NULL,
        status varchar(10) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci");
    
    // Copy data to new table
    $pdo->exec("INSERT INTO tbl_user_new (full_name, email, phone, password, photo, role, status)
                SELECT full_name, email, phone, password, photo, role, status FROM tbl_user");
    
    // Drop old table and rename new one
    $pdo->exec("DROP TABLE tbl_user");
    $pdo->exec("RENAME TABLE tbl_user_new TO tbl_user");
    
    // Check new structure
    $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_user'");
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    
    echo "<p>New Auto_increment value: " . ($result['Auto_increment'] ?? 'NULL') . "</p>";
    
    echo "<p style='color: green;'>Table structure fixed successfully!</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<p><a href='user-add.php'>Go back to Add User</a></p>";
?> 