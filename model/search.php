<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

require '../config/config.php';

$searchQuery = isset($_POST['search']) ? trim($_POST['search']) : '';

if ($searchQuery !== '') {
    $sql = "SELECT * FROM tbl_email WHERE subject LIKE :searchQuery OR body LIKE :searchQuery";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['searchQuery' => '%' . $searchQuery . '%']);
        $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['emails' => $emails]);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error fetching emails: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['emails' => []]);
}
?>
