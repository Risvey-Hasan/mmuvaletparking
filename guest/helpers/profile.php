<?php
session_start();
include("../include/connection.php");
include("../function/validate.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = validate_input($_POST["name"]);
    $email = validate_input($_POST["email"]);
    $phone = validate_input($_POST["phone"]);
    $address = validate_input($_POST["address"]);
    $id = $_SESSION['User'];

    // Check if any field is empty
    if(empty($name) || empty($email) || empty($phone) || empty($address)){
        $_SESSION["msg"] = '<div class="alert alert-danger">
        <strong>Sorry, some fields in the profile form are empty</strong>
    </div>';
      header("location:../profile.php"); 
      exit();
    }

    $sql = "UPDATE users SET name=?, phone=?, address=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $phone, $address, $email,$id);

    if($stmt->execute()){
        $_SESSION["msg"] = '<div class="alert alert-success">
        <strong>Profile  Successfully Updated</strong>
        </div>';
        header("location:../profile.php");
    }else{
        $_SESSION["msg"] = '<div class="alert alert-info">
        <strong>Oops Something went wrong</strong>
        </div>';
        header("location:../profile.php");
    }
}
