<?php
session_start();

$isUserLoggedIn = isset($_SESSION['user_name']);
$isUserLogged = isset($_SESSION['user_email']);

function handleLogout() {
  if (isset($_POST['logout'])) {
      echo 'Logged out';
      if (session_destroy()) { 
          header("Location: ./view/view_gmaillogin.php"); 
          exit();
      }
  }
}
handleLogout();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gmail Signup/Login Header</title>
  <link rel="stylesheet" href="/view/src/css/header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <header >
    <div class="head">
    <div class="logo">
      <img src="/uploads/gmail_logo.png" alt="Gmail Logo">
    </div>

    <!-- Search Form with Section Hidden Input -->
    <form id="searchForm" onsubmit="return false;">
      <input type="text" id="searchInput" name="search" placeholder="Search emails" oninput="searchEmails()">
      <input type="hidden" id="currentSection" name="section" value="inbox"> <!-- Default to inbox -->
    </form>

    <div class="auth-buttons" id="authButtons">
      <a href="/view/view_gmailsignup.php"><button id="signup" class="signup-btn">Sign Up</button></a>
      <a href="/view/view_gmaillogin.php"><button class="login-btn" id="login">Login</button></a>

      <div class="profile-icon" id="profileIcon">
        <i class="fa-solid fa-user"></i>
      </div>

      <!-- Profile Popup -->
      <div class="profile-popup" id="profilePopup" style="display:none;">
        <!-- Close icon -->
        <div class="close-icon" id="closeIcon">
          <i class="fas fa-times"></i>
        </div>
        
        <div class="profile-header">
            <p class="useremail">
              <?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : 'email@example.com'; ?>
            </p>
          <img src="/uploads/profile.jpg" alt="User Profile" class="profile-pic">
            <h3 class="username">Hi
              <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'User'; ?>
            </h3>
 
        </div>
        
        <!-- Sign out button -->
        <form method="POST" action="">
          <button class="logout-btn" type="submit" name="logout" id="logout">Sign out</button>
        </form>
      </div>
    </div>
    </div>
  </header>

  <div id="emailList"></div>

  <script>
  // Variables for DOM elements
  var profileIcon = document.getElementById('profileIcon');
  var profilePopup = document.getElementById('profilePopup');
  var closeIcon = document.getElementById('closeIcon');
  var loginButton = document.getElementById('login');
  var signupButton = document.getElementById('signup');
  var currentSection = document.getElementById('currentSection');

  // Toggle the visibility of the profile popup when clicking the profile icon
  profileIcon.addEventListener('click', function() {
    profilePopup.style.display = (profilePopup.style.display === 'none' || profilePopup.style.display === '') ? 'block' : 'none';
  });

  // Close the profile popup when the close icon is clicked
  closeIcon.addEventListener('click', function() {
    profilePopup.style.display = 'none';
  });

  // Check if the user is logged in and toggle buttons accordingly
  var isUserLoggedIn = <?php echo json_encode($isUserLoggedIn); ?>;
  console.log(isUserLoggedIn);

  if (isUserLoggedIn) {
    loginButton.style.display = "none";
    signupButton.style.display = "none";
    profileIcon.style.display = "inline-block";
  } else {
    loginButton.style.display = "inline-block";
    signupButton.style.display = "inline-block";
    profileIcon.style.display = "none";
  }

  // Hide the profile popup when clicking outside
  window.addEventListener('click', function(event) {
    if (!event.target.closest('.profile-popup') && !event.target.closest('.profile-icon')) {
      profilePopup.style.display = 'none';
    }
  });

  // Function to change section (e.g., inbox or sent)
  function changeSection(section) {
    currentSection.value = section; // Set the current section (inbox, sent, etc.)
    searchEmails(); // Trigger search based on the new section
  }

  // AJAX Search Function to dynamically filter emails based on section
  function searchEmails() {
    const searchQuery = document.getElementById('searchInput').value;
    const section = document.getElementById('currentSection').value; // Get current section

    // AJAX request to searchEmails.php
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/model/search.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        
        if (response.emails && response.emails.length > 0) {
          const emailList = document.getElementById('emailList');
          emailList.innerHTML = ''; // Clear the previous results

          response.emails.forEach(email => {
            // Create email HTML
            const emailDiv = document.createElement('div');
            emailDiv.classList.add('email');
            emailDiv.innerHTML = `
              <input type="checkbox" class="checkbox" name="email-select[]">
              <i class="fa-regular fa-star"></i>
              <div class="email-subject">${email.subject}</div>
              <div class="email-snippet">${email.body.substring(0, 100)}...</div>
              <div class="email-time">${new Date(email.created_at).toLocaleString()}</div>
            `;
            emailList.appendChild(emailDiv);
          });
        } else {
          document.getElementById('emailList').innerHTML = '<p>No emails found.</p>';
        }
      }
    };

    // Send the request with the search query and section
    xhr.send('search=' + encodeURIComponent(searchQuery) + '&section=' + encodeURIComponent(section));
  }
  </script>
  
</body>
</html>
