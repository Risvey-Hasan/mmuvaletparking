<?php
session_start();
include("../include/connection.php");
include("../function/validate.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = validate_input($_POST["name"]);
    $email = validate_input($_POST["email"]);
    $phone = validate_input($_POST["phone"]);
    $address = validate_input($_POST["address"]);
    $password = validate_input($_POST["password"]);
    $confirm_password = validate_input($_POST["confirmPassword"]);

    // Check if any field is empty
    if(empty($name) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($confirm_password)){
        $_SESSION["msg"] = '<div class="alert alert-danger">
        <strong>Sorry, some fields in the registration form are empty</strong>
    </div>';
      header("location:../register.php"); 
      exit();
    }

    // Check if password and confirm password match
    if($password != $confirm_password){
        $_SESSION["msg"] = '<div class="alert alert-danger">
            <strong>Password and confirm password don\'t match</strong>
        </div>';
        header("location:../register.php");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(name, email, phone, address, password)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $email, $phone, $address, $hashed_password);
        if($stmt->execute()){
            $_SESSION["msg"] = '<div class="alert alert-success">
            <strong>Registration Successful</strong><a href="login.php"> Login</a>
            </div>';
            header("location:../register.php");
        }else{
            $_SESSION["msg"] = '<div class="alert alert-danger">
            <strong>Something went wrong</strong>
            </div>';
            header("location:../register.php");
        }
}
?>
