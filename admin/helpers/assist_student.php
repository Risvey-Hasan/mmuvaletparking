<?php
session_start();
include("../include/connection.php");
include("../function/validate.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message_id = validate_input($_POST["message_id"]);
    $reply = validate_input($_POST["reply"]);

    if (empty($message_id) || empty($reply)) {
        $_SESSION["msg"] = '<div class="alert alert-danger">
            <strong>All fields are required.</strong>
        </div>';
        header("location:../faq-admin.php");
        exit();
    }

    $sql = "UPDATE messages SET reply = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $reply, $message_id);

    if ($stmt->execute()) {
        $_SESSION["msg"] = '<div class="alert alert-success">
            <strong>Reply sent successfully.</strong>
        </div>';
        header("location:../faq-admin.php");
    } else {
        $_SESSION["msg"] = '<div class="alert alert-danger">
            <strong>Oops! Something went wrong.</strong>
        </div>';
        header("location:../faq-admin.php");
    }
}

