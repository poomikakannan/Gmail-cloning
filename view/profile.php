<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Profile Popup</title>
</head>
<body>
    <div class="container">
        <div class="profile-icon" onclick="togglePopup()">
        </div>
        <div class="popup" id="profilePopup">

            <div class="popup-content">
                <p>poomikakdckap@gmail.com</p>
                <div class="staticprofile">
                <img src="/uploads/profile.jpg" alt="Profile" class="popup_avatar">
                </div>
                <h2>Hi, Poomika</h2>

                <div class="storage-info">
                </div>
                <button class="popup-button">Manage your Google Account</button>
                <button class="popup-button">Add account</button>
                <button class="popup-button">Sign out</button>
            </div>
        </div>
    </div>

    <!-- <script src="/view/src/script/profile.js"></script> -->
</body>
</html>

