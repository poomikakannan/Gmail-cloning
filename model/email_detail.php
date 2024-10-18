<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();
require '../config/config.php';
echo "hiiiiiiiiiiiiiii";
// Check if ID is provided
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id !== null) {
    // Debug: Print the values to confirm if they are being passed correctly
    // Remove these once confirmed
    error_log("Email ID: $id");
    error_log("User ID: " . $_SESSION['user_id']);
    
    // Prepare the query to fetch email details for inbox only
    $query = "SELECT subject, body, created_at FROM tbl_email WHERE id = :id AND receiver_id = :user_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT); // Assuming you store the logged-in user's ID in session
    $stmt->execute();

    // Fetch email details
    $email = $stmt->fetch(PDO::FETCH_ASSOC);
    print_r($email);
    if ($email) {
        // Store email details in session to pass to HTML
        $_SESSION['email'] = $email;
        
    } else {
        $_SESSION['error'] = "Email not founfffds.";
    }
} else {
    $_SESSION['error'] = "Invalid email ID.";
}

// Redirect to the HTML page
header("Location: /view/showpage.php");
exit;
