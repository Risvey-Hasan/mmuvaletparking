<?php
session_start();
include("../include/connection.php");
include("../function/validate.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = validate_input($_GET['id']);

    if (empty($id)) {
        $_SESSION["msg"] = '<div class="alert alert-danger">
            <strong>Invalid student ID</strong>
        </div>';
        header("location:../remove_artist.php");
        exit();
    }

    $sql = "DELETE FROM users WHERE id = ? AND privilege = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION["msg"] = '<div class="alert alert-success">
            <strong>Artist deleted successfully</strong>
        </div>';
        header("location:../remove_artist.php");
    } else {
        $_SESSION["msg"] = '<div class="alert alert-danger">
            <strong>Oops! Something went wrong</strong>
        </div>';
        header("location:../remove_artist.php");
    }
} else {
    $_SESSION["msg"] = '<div class="alert alert-danger">
        <strong>Invalid request method</strong>
    </div>';
    header("location:../remove_artist.php");
}
