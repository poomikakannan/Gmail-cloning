<?php
// session_start(); // Start a session

// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require './config/config.php'; 

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: /view/view_gmaillogin.php");
    exit(); 
}

// Query to retrieve sent emails from the database
$sql = 'SELECT * FROM tbl_email WHERE sender_id = ' . $_SESSION['user_id'] . ' ORDER BY created_at DESC';

try {
    $stmt = $pdo->query($sql); // Execute the query
    $emails = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results
} catch (PDOException $e) {
    echo "Error fetching emails: " . $e->getMessage();
    exit();
}

$pdo = null;

?>