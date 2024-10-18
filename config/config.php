<?php
$servername = "localhost";
$username = "dckap";
$password = "Dckap2023Ecommerce"; 
$dbname = "gmail"; 

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

