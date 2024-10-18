<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // If logged in, redirect to the index page
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
    <link href="./src/css/gmaillogin.css" rel="stylesheet">
</head>

<body>
    <div>
        <?php if (!empty($errors)) : ?>
            <div>
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="loginmaincontainer">
            <div class="logincontainer">   
                <div class="loginimage">
                    <img src="/uploads/gmail_logo.png" alt="Login Image">
                </div>

                <form method="POST" action="/model/gmaillogin.php" onsubmit="return validateForm()">
                    <div class="loginform_container">
                        <div class="loginform">
                            <h2 class="loginheader">Login</h2>
                            <label for="email"><strong>Email</strong></label><br>
                            <input class="loginemail" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br>
                            <span id="emailError" style="color:red;"></span>
                        </div>
                        <div>
                            <label for="password"><strong>Password</strong></label><br>
                            <input type="password" class="loginpassword" id="password" name="password">
                            <span id="passwordError" style="color:red;"></span>
                        </div>
                              <!-- Error Message Area -->
                        <?php if (isset($_SESSION['error_message'])): ?>
                            <div style="color:red;">
                        <?php
                            echo $_SESSION['error_message'];
                            // Clear error message after displaying
                            unset($_SESSION['error_message']);
                        ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <input class="loginbutton" type="submit" value="Login">
                        </div>
                        <div class="loginlink">
                            Already have an acount?<a href="/view/view_gmailsignup.php">Signup</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./src/script/gmaillogin.js"></script>
</body>

</html>

