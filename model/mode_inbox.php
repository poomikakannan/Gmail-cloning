<?php

// Start the session
// session_start();

// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Require database configuration
require './config/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: /view/view_gmaillogin.php");
    exit();
}

// Query to retrieve emails from the database
$sql = 'SELECT tbl_email.*, tbl_user.name AS sender_name 
        FROM tbl_email 
        JOIN tbl_user ON tbl_user.id = tbl_email.sender_id 
        WHERE tbl_email.receiver_id = :receiver_id 
        ORDER BY tbl_email.created_at DESC';

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':receiver_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any emails were retrieved
    if (empty($emails)) {
        echo "No emails found.";
    } else {
        foreach ($emails as $email) {
        }
    }

} catch (PDOException $e) {
    echo "Error fetching emails: " . $e->getMessage();
    exit();
}

$pdo = null;

?>
