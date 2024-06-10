<?php
session_start();
include("../include/connection.php");
include("../function/validate.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $old_password = validate_input($_POST["OldPassword"]);
    $new_password = validate_input($_POST["NewPassword"]);
    $id = $_SESSION['User'];

    // Check if any field is empty
    if(empty($old_password) || empty($new_password)){
        $_SESSION["msg"] = '<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Sorry, some fields in the form are empty</strong>
    </div>';
      header("location:../account_settings.php"); 
      exit();
    }

    $sql = "SELECT password FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $old_password_from_db = $row['password'];

    // Verify if the old password matches the one in the database
    if(!password_verify($old_password, $old_password_from_db)){
        $_SESSION["msg"] = '<div class="alert alert-danger">
        <strong>Old password does not match</strong>
    </div>';
      header("location:../account_settings.php"); 
      exit();
    }
    $new_password = password_hash($new_password, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_password, $id);
        
    if($stmt->execute()){
        $_SESSION["msg"] = '<div class="alert alert-success">
        <strong>Password Updated</strong>
        </div>';
        header("location:../account_settings.php");
    }else{
        $_SESSION["msg"] = '<div class="alert alert-info">
        <strong>Oops Something went wrong</strong>
        </div>';
        header("location:../account_settings.php");
    }
}
