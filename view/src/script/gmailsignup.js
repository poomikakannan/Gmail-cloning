"use strict";

function validatePassword() {
    const password = document.getElementById('password').value;
    const tooltip = document.getElementById('password-tooltip');
    tooltip.classList.add('show');

    const length = document.getElementById('characters');
    if (password.length >= 8 && password.length <= 20) {
        length.classList.remove('invalid');
        length.classList.add('valid');
    } else {
        length.classList.remove('valid');
        length.classList.add('invalid');
    }

    const uppercase = document.getElementById('upper');
    if (/[A-Z]/.test(password)) {
        uppercase.classList.remove('invalid');
        uppercase.classList.add('valid');
    } else {
        uppercase.classList.remove('valid');
        uppercase.classList.add('invalid');
    }

    const lowercase = document.getElementById('lower');
    if (/[a-z]/.test(password)) {
        lowercase.classList.remove('invalid');
        lowercase.classList.add('valid');
    } else {
        lowercase.classList.remove('valid');
        lowercase.classList.add('invalid');
    }

    const number = document.getElementById('number');
    if (/\d/.test(password)) {
        number.classList.remove('invalid');
        number.classList.add('valid');
    } else {
        number.classList.remove('valid');
        number.classList.add('invalid');
    }


    const special = document.getElementById('special');
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        special.classList.remove('invalid');
        special.classList.add('valid');
    } else {
        special.classList.remove('valid');
        special.classList.add('invalid');
    }
}


// validate the form
function validateForm() {
    let isValid = true;

    // input values
    const name = document.getElementById('name').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const email = document.getElementById('email').value;

    // regex patterns
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#\$%\^&\*\(\)\_\+\-=\[\]\{\};:"\\|,.<>\/?]).{8,}$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    //error messages
    clearerror("name");
    clearerror("email");
    clearerror("password");
    clearerror("confirm-password");

    if (name.trim() === "") {
        displayerror("name", "Please enter a name.");
        isValid = false;
    }

    // Validate email
    if (!emailRegex.test(email)) {
        displayerror("email", "Please enter a email");
        isValid = false;
    }

    // Validate password
    if (!passwordRegex.test(password)) {
        displayerror("password", "Please enter a password");
        isValid = false;
    }

    // Validate confirm password match
    if (password !== confirmPassword) {
        displayerror("confirm-password", "Passwords do not match.");
        isValid = false;
    }

    return isValid;
}

// display error messages
function displayerror(elementId, message) {
    const errorElement = document.getElementById(`error-${elementId}`);
    errorElement.textContent = message;
    errorElement.style.display = "block";
}

//clear error messages
function clearerror(elementId) {
    const errorElement = document.getElementById(`error-${elementId}`);
    errorElement.textContent = "";
    errorElement.style.display = "none";
}

document.getElementById('password').addEventListener('focus', function () {
    document.getElementById('password-tooltip').style.visibility = 'visible';
});

document.getElementById('password').addEventListener('blur', function () {
    document.getElementById('password-tooltip').style.visibility = 'hidden';
});

document.querySelector('form').addEventListener('submit', function (e) {
    if (!validateForm()) {
        e.preventDefault();
    }
});



