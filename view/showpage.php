<?php
session_start();
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Details</title>
    <link rel="stylesheet" href="../view/src/css/showpage.css">
</head>
<body>

<?php if ($error): ?>
    <p><?= htmlspecialchars($error); ?></p>
<?php elseif ($email): ?>
    <a href="/index.php"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="showemail-subject"><?= htmlspecialchars($email['subject']);?></div>
    <div class="showemail-body"><?= nl2br(htmlspecialchars($email['body'])); ?></div>
    <div class="showemail-time"><?= htmlspecialchars($email['created_at']); ?></div>
<?php endif; ?>

<div class="emails-signature">
    <p>Thank you,</p>
    <p class="name"><?= isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'User'; ?>,</p>
    <p>Intern - QA Touch.</p>
    <p><a href="https://www.linkedin.com/in/your-linkedin" target="_blank">LinkedIn</a> | 
    <a href="tel:+919787390982">+91 9787390982</a></p>
</div>

</body>
</html>

<?php
// Clear session variables to avoid reuse
unset($_SESSION['email']);
unset($_SESSION['error']);
?>
