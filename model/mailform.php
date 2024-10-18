<?php
session_start();

ini_set('display_errors',1);
error_reporting(E_ALL);

require "../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../config/config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Fetching form data and sanitizing input
    $to = filter_var(trim($_POST["to"]), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    $user_id = $_SESSION['user_id'] ?? 1; 
    $receiver_email = $to; 

    // Check if the sender (user_id) exists in tbl_user
    $stmt = $pdo->prepare("SELECT id FROM tbl_user WHERE id = :user_id");
    
    $stmt->execute([':user_id' => $user_id]);
    $sender_exists = $stmt->fetchAll();

    // Check if the receiver (email) exists in tbl_user
    $stmt = $pdo->prepare("SELECT id FROM tbl_user WHERE email = :email");
    $stmt->execute([':email' => $receiver_email]);
    $receiver_id = $stmt->fetchAll();

    // Validate both sender and receiver
    if ($sender_exists && $receiver_id) {

        // PHPMailer setup
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                   
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'poomikakdckap@gmail.com';            
            $mail->Password   = 'tocd pzba pdyx uwbf'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       
            $mail->Port       = 587;                     

            // Recipients
            $mail->setFrom('poomikakdckap@gmail.com', $_SESSION['user_name']);
            $mail->addAddress($to);                                   

            // Content
            $mail->isHTML(true);                                    
            $mail->Subject = $subject;
            $mail->Body    = $message;

            // Send email
            if ($mail->send()) {
                header('location: ../index.php');
        

                // // Insert email details into the database
                $sql = 'INSERT INTO tbl_email (user_id, sender_id, receiver_id, subject, body, created_at, updated_at)
                        VALUES (:user_id, :sender_id, :receiver_id, :subject, :body, NOW(), NOW())';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':user_id' => $user_id,       
                    ':sender_id' => $user_id,     
                    ':receiver_id' => $receiver_id[0]['id'], 
                    ':subject' => $subject,        
                    ':body' => $message           
                ]);

                // echo 'Email details saved to database.';
            } else {
                echo 'Message could not be sent.';
            }

        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }

    
    } else {
        echo 'Sender or receiver not found in the system.';
    }

}
?>
