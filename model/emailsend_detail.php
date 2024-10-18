<?php
session_start();
require '../config/config.php';

// Check if ID is provided
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id !== null) {
    // Log the incoming ID and user ID for debugging
    error_log("Sent Email ID: $id");
    error_log("User ID: " . $_SESSION['user_id']);
    
    // Query to fetch sent emails based on sender_id
    $query = "SELECT subject, body, created_at FROM tbl_email WHERE id = :id AND sender_id = :user_id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();

    // Fetch email details
    $email = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($email) {
        // Log the fetched email data
        error_log("Fetched Sent Email: " . print_r($email, true));
        
        // Store email details in session to pass to HTML
        $_SESSION['email'] = $email;
    } else {
        $_SESSION['error'] = "Sent email not found.";
    }
} else {
    $_SESSION['error'] = "Invalid email ID.";
}

// Redirect to the HTML page for sent emails
header("Location: /view/sentshow.php");
exit;
?>
