"use strict";
function validateForm() {
    // Clear previous error messages
    document.getElementById('emailError').innerText = '';
    document.getElementById('passwordError').innerText = '';

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    let isValid = true;

    // Email is not empty
    if (email.trim() === "") {
        document.getElementById('emailError').innerText = 'Email is required.';
        isValid = false;
    } else {
        // Email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            document.getElementById('emailError').innerText = 'Please enter a valid email address.';
            isValid = false;
        }
    }

    // Password is not empty
    if (password.trim() === "") {
        document.getElementById('passwordError').innerText = 'Password is required.';
        isValid = false;
    }

    // If validation fails, prevent form submission
    return isValid;
}
