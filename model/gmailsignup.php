<?php
session_start();

ini_set('display_errors',1);
error_reporting(E_ALL);


require '../config/config.php'; 

if (!isset($_SESSION['user_name'])) {
    header("Location: /view/view_gmaillogin.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash(password: $password,algo: PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO tbl_user (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();

        echo "Signup successful!";
        header('Location: ../view/view_gmaillogin.php'); 
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $pdo = null;
}



