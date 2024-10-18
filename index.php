<?php
session_start();
require "./view/pratials/header.php";
// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: /view/view_gmaillogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/view/src/css/homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Emails - Gmail Clone</title>
</head>
<body>
    <div class="sidebar">
        <a href="#" id="composeBtn">
            <button class="compose-btn">
                <i class="fa-solid fa-pencil"></i>Compose
            </button>
        </a>
        <div class="menu">
            <div class="menu-item" id="menus">
                <i class="fa-solid fa-inbox"></i>Inbox
            </div>
            <div class="menu-item" id="menus1">
                <i class="fa-solid fa-play"></i>Sent
            </div>
            <button class="menu-item" id="menustar">
                <i class="fa-regular fa-star"></i>Starred
            </button>
            <button class="menu-item" onclick="location.href='snoozed.php'">
                <i class="fa-regular fa-clock"></i>Snoozed
            </button>
            <button class="menu-item" onclick="location.href='drafts.php'">
                <i class="fa-regular fa-file"></i>Drafts
            </button>
        </div>
    </div>

    <div class="main">
        <!-- Email List (Inbox) -->
        <div class="div_in" id="in">
            <?php require "./view/inbox.php"; ?>
        </div>

        <!-- Email Details View -->
        <div class="email_detail" id="emailDetail" style="display: none;">
            <?php require "./view/showpage.php"; ?>
        </div>

        <!-- Sent Emails -->
        <div class="div_send" id="send" style="display: none;">
            <?php require "./view/send.php"; ?>
        </div>

        <div class="sentshow" id="showSentshow" style="display: none;">
            <?php require "./view/sentshow.php"; ?>
        </div>

        <!-- Starred Emails -->
        <div class="div_star" id="star" style="display: none;">
            <?php require "./view/starred.php"; ?>
        </div>

        <!-- Email Compose Modal -->
        <div id="composeModal" class="modal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <div id="modal-body"></div>
            </div>
        </div>
    </div>

    <script>
        // Function to change view and update URL
        function changeView(type) {
            // Update the URL without reloading the page
            history.pushState(null, '', `?type=${type}`);

            // Show or hide the relevant sections based on the type
            if (type === 'sent') {
                document.getElementById('send').style.display = 'block';
                document.getElementById('in').style.display = 'none';
                document.getElementById('star').style.display = 'none';
            } else if (type === 'starred') {
                document.getElementById('send').style.display = 'none';
                document.getElementById('in').style.display = 'none';
                document.getElementById('star').style.display = 'block';
            } else {
                document.getElementById('send').style.display = 'none';
                document.getElementById('in').style.display = 'block';
                document.getElementById('star').style.display = 'none';
            }
            document.getElementById("emailDetail").style.display = "none"; // Hide email details
            setActive(type === 'sent' ? document.getElementById("menus1") : document.getElementById(type === 'starred' ? "menustar" : "menus"));
            document.getElementById("showSentshow").style.display = "none";
        }

        // Event listeners for menu items
        document.getElementById("composeBtn").addEventListener("click", function(e) {
            e.preventDefault();
            document.getElementById("composeModal").style.display = "block";
            fetch('/view/mailform.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById("modal-body").innerHTML = data;
                })
                .catch(error => console.error('Error loading mailform:', error));
        });

        // Close the modal when the close button is clicked
        document.querySelector('.close-btn').addEventListener('click', function() {
            document.getElementById("composeModal").style.display = "none";
        });

        // Close the modal when clicking outside the modal content
        window.onclick = function(event) {
            const modal = document.getElementById("composeModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        // Show Inbox and set active by default when the page loads
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const type = urlParams.get('type') || 'inbox'; // Default to 'inbox'
            changeView(type); // Change view based on URL parameters
        };

        // Handle Inbox menu item click
        document.getElementById("menus").addEventListener("click", function(e) {
            e.preventDefault();
            changeView('inbox'); // Change view to Inbox
        });

        // Handle Sent menu item click
        document.getElementById("menus1").addEventListener("click", function(e) {
            e.preventDefault();
            changeView('sent'); // Change view to Sent
        });

        // Handle Starred menu item click
        document.getElementById("menustar").addEventListener("click", function(e) {
            e.preventDefault();
            changeView('starred'); // Change view to Starred
        });

        // Function to set active class
        function setActive(activeElement) {
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
            });
            activeElement.classList.add('active');
        }

        // Event listener for email divs (show email details for Inbox)
        document.querySelectorAll('.email').forEach(emailDiv => {
            emailDiv.addEventListener('click', function() {
                const emailId = this.getAttribute('data-id');

                // Hide inbox and sent, and show email details
                document.getElementById("in").style.display = "none";
                document.getElementById("send").style.display = "none";
                document.getElementById("emailDetail").style.display = "block";
                document.getElementById("showSentshow").style.display = "none";
                document.getElementById("star").style.display = "none";

                // Fetch the email content
                fetch(`/model/email_detail.php?id=${emailId}`)
                    .then(response => response.text())    
                    .then(data => {
                        console.log(data);  // Display content in console for debugging purposes
                        document.getElementById("emailDetail").innerHTML = data; // Display content
                    })
                    .catch(error => console.error('Error fetching email content:', error));
            });
        });

        // Event listener for sent email divs (show email details for sent emails)
        document.querySelectorAll('.sendemail').forEach(emailDiv => {
            emailDiv.addEventListener('click', function(event) {
                const emailId = this.getAttribute('data-id');

                // Hide inbox and sent, and show sent email details
                document.getElementById("in").style.display = "none";
                document.getElementById("send").style.display = "none";
                document.getElementById("emailDetail").style.display = "none";
                document.getElementById("showSentshow").style.display = "block";
                document.getElementById("star").style.display = "none";

                // Fetch the sent email content
                fetch(`/model/emailsend_detail.php?id=${emailId}`)
                    .then(response => response.text())
                    .then(data => {
                        console.log("Sent email data: ", data); // Debugging purpose
                        document.getElementById("showSentshow").innerHTML = data; // Display sent email content
                    })
                    .catch(error => console.error('Error fetching sent email content:', error));
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
    // Select all star icons
    const starIcons = document.querySelectorAll('.iconstar');

    // Add click event listener to each star icon
    starIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            console.log("hiii");
            
            const emailId = this.getAttribute('data-id');
            const isStarred = this.getAttribute('data-isstar') === '1'; // true if isstar is 1, false if 0
            const starIcon = this.querySelector('.fa-star');

            // Toggle the star status visually and update the isstar attribute
            if (isStarred) {
                starIcon.classList.remove('fa-solid');
                starIcon.classList.add('fa-regular');
                this.setAttribute('data-isstar', '0');
                starIcon.style.color = "gray"; // Reset to default color
            } else {
                starIcon.classList.remove('fa-regular');
                starIcon.classList.add('fa-solid');
                this.setAttribute('data-isstar', '1');
                starIcon.style.color = "yellow"; // Change to yellow when starred
            }

            // Send AJAX request to update the isstar column in the database
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'model/model_star.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Star status updated successfully!');
                } else {
                    console.log('Failed to update star status.');
                }
            };
            xhr.send('id=' + encodeURIComponent(emailId) + '&isstar=' + (isStarred ? 0 : 1));
        });
    });
});

    </script>
</body>
</html>
