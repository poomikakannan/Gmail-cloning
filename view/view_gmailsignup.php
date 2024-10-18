<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gmail Signup</title>
    <link rel="stylesheet" href="./src/css/gmailsignup.css">
    <script src="./src/script/gmailsignup.js"></script> 
</head>

<body>
    <div class="gmailsignup_container">
        <div class="signup_container">
            <div class="signup_image_container">
                <img src="/uploads/gmail_logo.png" alt="Signup Image">
            </div>

            <div class="signup_form_container">
                <h2 class="header">Signup</h2>

                <?php
                
                if (!empty($errors)) {
                    echo '<div class="error-messages">';
                    foreach ($errors as $error) {
                        echo '<p>' . htmlspecialchars($error) . '</p>';
                    }
                    echo '</div>';
                }
                ?>

                <!-- Signup form -->
                <form id="signupForm" action="/model/gmailsignup.php" method="post" onsubmit="return validateForm()">
                <div class="formcontainer">
    <div class="formlabel">
        <label for="name"><strong>Name</strong></label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>"><br>
        <div id="error-name" class="error-message"></div> 
    </div>

    <div class="formlabel">
        <label for="email"><strong>Email</strong></label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br>
        <div id="error-email" class="error-message"></div> 
    </div>
    <div class="formlabel">
    <div class="formlabel tooltip">
        <label for="password"><strong>Password</strong></label><br>
        <input type="password" id="password" name="password" oninput="validatePassword()"><br>
        <div class="tooltiptext" id="password-tooltip">
            <p>Password must contain:</p>
            <ul>
                <li id="characters" class="invalid">At least 8 characters</li>
                <li id="upper" class="invalid">One uppercase letter</li>
                <li id="lower" class="invalid">One lowercase letter</li>
                <li id="number" class="invalid">One number</li>
                <li id="special" class="invalid">One special character</li>
            </ul>
        </div>
        <div id="error-password" class="error-message"></div> 
    <!-- </div> -->
    </div>

    <div class="formlabel">
        <label for="confirm-password"><strong>Confirm Password</strong></label><br>
        <input type="password" id="confirm-password" name="confirm-password"><br>
        <div id="error-confirm-password" class="error-message"></div> 
    </div>

    <button class="signupbutton" type="submit">Signup</button>
</div>

                </form>
                <div class="signuplink">
                Already have been?<a href="/view/view_gmaillogin.php">Login</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
