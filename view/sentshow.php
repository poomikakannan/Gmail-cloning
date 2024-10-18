<?php
// Start session
session_start();

// Check if email and error are set in the session
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

<div id="emailDetails">
    <?php if ($error): ?>
        <!-- Display error message if any -->
        <p><?= htmlspecialchars($error); ?></p>
    <?php elseif ($email): ?>
        <!-- Back arrow -->
        <a href="" id="backArrow"><i class="fa-solid fa-arrow-left"></i></a>

        <!-- Display email details -->
        <div class="showemail-subject"><?= htmlspecialchars($email['subject']); ?></div>
        <div class="showemail-body"><?= nl2br(htmlspecialchars($email['body'])); ?></div>
        <div class="showemail-time"><?= htmlspecialchars($email['created_at']); ?></div>
    <?php endif; ?>
</div>

<div class="emails-signature">
    <p>Thank you,</p>
    <p class="name">User</p>
    <p>Intern - QA Touch.</p>
    <p><a href="https://www.linkedin.com/in/your-linkedin" target="_blank">LinkedIn</a> | 
    <a href="tel:+919787390982">+91 9787390982</a></p>
</div>

<script>
    document.getElementById('backArrow').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior

        // Use AJAX to load the sent page content dynamically
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/index.php?type=sent', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Replace email details section with the content from the sent page
                document.getElementById('emailDetails').innerHTML = xhr.responseText;

                // Change the URL in the browser without reloading the page
                history.pushState(null, '', '/index.php?type=sent');
            }
        };
        xhr.send();
    });

    // Add an event listener to handle the back button behavior (optional)
    window.onpopstate = function () {
        // Handle back navigation via history API (if needed)
        // You can re-fetch content here or update the state.
    };
</script>

</body>
</html>

<?php
// Clear session variables to avoid reuse
unset($_SESSION['email']);
unset($_SESSION['error']);
?>
