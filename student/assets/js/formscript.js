function validateLoginform() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    if (email.trim() === '') {
        alert('Please enter your email');
        return false;
    }

    if (password.trim() === '') {
        alert('Please enter your password');
        return false;
    }
    return true;
}

function validateRegisterform() {
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    var address = document.getElementById('address').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    // Name validation
    if (name.trim() === '') {
        alert('Please enter your name');
        return false;
    }

    // Email validation
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (email.trim() === '') {
        alert('Please enter your email');
        return false;
    } else if (!emailPattern.test(email)) {
        alert('Please enter a valid email address');
        return false;
    }

    // Phone validation
    var phonePattern = /^\d{10}$/; // Example pattern for a 10-digit phone number
    if (phone.trim() === '') {
        alert('Please enter your phone number');
        return false;
    } else if (!phonePattern.test(phone)) {
        alert('Please enter a valid 10-digit phone number');
        return false;
    }

    // Address validation
    if (address.trim() === '') {
        alert('Please enter your address');
        return false;
    }

    // Password validation
    if (password.trim() === '') {
        alert('Please enter a password');
        return false;
    }

    // Confirm Password validation
    if (confirmPassword.trim() === '') {
        alert('Please confirm your password');
        return false;
    }

    // Password match validation
    if (password !== confirmPassword) {
        alert('Passwords do not match');
        return false;
    }

    return true;
}