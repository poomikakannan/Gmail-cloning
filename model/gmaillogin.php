<?php
session_start(); // Start a session
//database connection
require '../config/config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // SQL query 
    $sql = "SELECT * FROM tbl_user WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    // Fetch user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the password

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
    
        header("Location: ../index.php");
        exit;
    } 
    else {
        // Set error message in session
        $_SESSION['error_message'] = 'Incorrect Password.';
        
        // Redirect back to login page
        header("Location:../view/view_gmaillogin.php");
        exit;
    }
    
}

