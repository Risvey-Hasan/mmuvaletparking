<?php
require_once("../include/connection.php");
require_once("../function/authentication.php");

$response = ['success' => false, 'sender' => $_SESSION['username']];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $messageType = 'text';
    $messageContent = '';
    $sender = $_SESSION['username'];

    if (!empty($_POST['message'])) {
        $messageContent = mysqli_real_escape_string($conn, $_POST['message']);
    }

    if ($messageContent) {
        $sql = "INSERT INTO messages (sender, receiver, content, type) VALUES ('$sender', 'admin@gmail.com', '$messageContent', 'text')";
        if (mysqli_query($conn, $sql)) {
            $response['success'] = true;
            $response['message'] = [
                'type' => $messageType,
                'content' => $messageContent
            ];
        }
    }
}

echo json_encode($response);
?>
