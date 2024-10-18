<?php
session_start(); // Start a session

// Include the database configuration
require '../config/config.php'; 

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: /view/view_gmaillogin.php");
    exit(); 
}
// $sql = 'SELECT * FROM tbl_email';

try {
    $stmt = $pdo->query($sql); // Execute the query
} catch (PDOException $e) {
    echo "Error fetching emails: " . $e->getMessage();
    exit();
}

$pdo = null; 

?>