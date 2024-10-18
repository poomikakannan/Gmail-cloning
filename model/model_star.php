<?php
require '../config/config.php'; // Ensure this path points to your DB config file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emailId = intval($_POST['id']); // Securely cast ID to integer
    $isStar = intval($_POST['isstar']); // Securely cast isstar to integer

    // Update the isstar column in the database
    $stmt = $pdo->prepare("UPDATE tbl_email SET isstar = :isstar WHERE id = :id");
    $stmt->bindParam(':isstar', $isStar, PDO::PARAM_INT);
    $stmt->bindParam(':id', $emailId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error";
    }
}
?>