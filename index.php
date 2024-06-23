<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background: url('images/Campus.webp') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.85);
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 90%;
            margin: 20px;
        }
        .logo {
            width: 300px;
            height: auto;
            margin-bottom: 0px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .login-btn {
            background-color: #25a58f;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .login-btn:hover {
            background-color: #1d536e;
            transform: translateY(-2px);
        }
        .login-btn:active {
            transform: translateY(1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="images/mmulogo.jpg" alt="Logo" class="logo">
        <h1>MMU Valet Parking System</h1>
        <button class="login-btn" onclick="location.href='student/login.php'">Login</button>
    </div>
</body>
</html>
