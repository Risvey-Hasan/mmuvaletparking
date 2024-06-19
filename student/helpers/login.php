<?php
session_start();
include("../include/connection.php");
include("../function/validate.php");


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = validate_input($_POST["email"]);
    $password = validate_input($_POST["password"]);
    
    if(empty($email) || empty($password)){
        $_SESSION["msg"] = '<div class= "alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Email or password is empty!!!</strong>
        </div>';
        header("location:../login.php");
        exit();
    }

    $sql = "SELECT * FROM `users` WHERE email = '$email'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    if($row > 0){
        if(password_verify($password,$row['password'])){
            if($row['privilege'] == 1){
                $_SESSION['User'] = $row["id"];
                $_SESSION['username'] = $row['email'];
                header("location:../index.php");
                }
                else if($row['privilege'] == 2){
                    $_SESSION['Admin'] = $row["id"];
                    $_SESSION['Admin_name'] = $row["name"];
                    header("location:../../admin/index.php"); 
                }
                else{
                    $_SESSION["msg"] = '<div class= "alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Invalid Login attempt!!!</strong>
                    </div>';
                    header("location:../login.php");
                }
        }
        else{
            $_SESSION["msg"] = '<div class= "alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Invalid Email or Password!!!</strong>
        </div>';
        header("location:../login.php");
        exit();
        }
        
    }else{
        $_SESSION["msg"] = '<div class= "alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Invalid Email or Password!!!</strong>
        </div>';
        header("location:../login.php");
        exit();
    }
}
?>