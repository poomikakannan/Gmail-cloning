"use strict";

// Handle search button click
document.getElementById("searchBtn").addEventListener("click", function() {
    const searchTerm = document.getElementById("searchInput").value;

    // Check if the search input is not empty
    if (searchTerm.trim() === "") {
        alert("Please enter a search term.");
        return;
    }

    // Fetch emails based on search term
    fetch(`/../../model/search.php?search=${encodeURIComponent(searchTerm)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const emailList = document.getElementById("emailList");
            emailList.innerHTML = ""; // Clear existing emails

            if (data.length === 0) {
                emailList.innerHTML = "<p>No emails found.</p>";
            } else {
                data.forEach(email => {
                    const emailDiv = document.createElement("div");
                    emailDiv.classList.add("email");
                    emailDiv.setAttribute("data-id", email.id);

                    emailDiv.innerHTML = `
                        <input type="checkbox" class="checkbox" name="email-select[]">
                        <i class="fa-regular fa-star"></i>
                        <div class="email-subject">${email.subject}</div>
                        <div class="email-snippet">${email.body.slice(0, 100)}...</div>
                        <div class="email-time">${new Date(email.created_at).toLocaleString()}</div>
                    `;
                    emailList.appendChild(emailDiv);
                });
            }
        })
        .catch(error => console.error('Error fetching emails:', error));
});
