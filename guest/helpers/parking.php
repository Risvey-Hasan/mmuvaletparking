<?php
session_start();
include("../include/connection.php");
include("../function/validate.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $subject = validate_input($_POST["subject"]);
    $message = validate_input($_POST["message"]);
    $id = $_SESSION['User'];

    // Check if any field is empty
    if(empty($subject) || empty($message)){
        $_SESSION["msg"] = '<div class="alert alert-danger">
        
        <strong>Sorry, some fields in the form are empty</strong>
    </div>';
      header("location:../get_support.php"); 
      exit();
    }

    $sql = "INSERT INTO messages(subject, message,user_id)
                VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $subject, $message,$id);
        
    if($stmt->execute()){
        $_SESSION["msg"] = '<div class="alert alert-success">
        
        <strong>Message Submitted Successfully</strong>
        </div>';
        header("location:../get_support.php");
    }else{
        $_SESSION["msg"] = '<div class="alert alert-danger">
        <strong>Oops Something went wrong</strong>
        </div>';
        header("location:../get_support.php");
    }
}
