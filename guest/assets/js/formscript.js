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

    if (name.trim() === '') {
        alert('Please enter your name');
        return false;
    }

    if (email.trim() === '') {
        alert('Please enter your email');
        return false;
    }

    if (phone.trim() === '') {
        alert('Please enter your phone number');
        return false;
    }

    if (address.trim() === '') {
        alert('Please enter your address');
        return false;
    }

    if (password.trim() === '') {
        alert('Please enter a password');
        return false;
    }

    if (confirmPassword.trim() === '') {
        alert('Please confirm your password');
        return false;
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match');
        return false;
    }

    return true;
}