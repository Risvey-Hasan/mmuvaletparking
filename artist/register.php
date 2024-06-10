<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="assets/css/externalstyle.css" type="text/css"/>
</head>
<body>
    <div class="container">
        <h2>Student Registration</h2>
        <form id="registrationForm" method="post" action="helpers/register.php" onsubmit="return validateRegiterform()">
           <div class="form-group">
               <?php
                   session_start();
                    if(isset($_SESSION["msg"])){
                        echo $_SESSION["msg"];
                    }
                    unset($_SESSION["msg"]);
                ?>
           </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
<script src="assets/js/formscript.js"></script>
</html>
