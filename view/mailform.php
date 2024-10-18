<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../view/src/css/mailform.css">
    <title>Compose Email</title>
</head>
<body>
    <div class="compose-container">
        <h2>Compose Email</h2>
        <form class="compose-form" action="/model/mailform.php" method="POST">
            <div class="form-group">
                <label for="to">To:</label>
                <input type="email" id="to" name="to" required>
            </div>

            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="6" required></textarea>
            </div>

            <div class="button-group">
                <button type="submit">Send</button>
            </div>
        </form>

        <div class="email-signature">
            <p>Thank you,</p>
            <p class="name"><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'User'; ?>,</p>
            <p>Intern - QA Touch.</p>
            <p><a href="https://www.linkedin.com/in/your-linkedin" target="_blank">LinkedIn</a> | <a href="tel:+919787390982">+91 9787390982</a></p>
        </div>
    </div>
</body>
</html>









