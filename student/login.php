<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/design.css" type="text/css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form id="loginForm" method="post" action="helpers/login.php" onsubmit="return validateLoginform()">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
</br>
</br>
        <button onclick="window.location.href='register.php'">Registration</button>
    </div>
    <script src="assets/js/formscript.js"></script>
</body>
</html>
