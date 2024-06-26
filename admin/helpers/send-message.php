<?php
require_once("../include/connection.php");

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $messageType = 'text';
    $messageContent = '';
    $receiver = mysqli_real_escape_string($conn, $_POST['receiver']);

    if (!empty($_POST['message'])) {
        $messageContent = mysqli_real_escape_string($conn, $_POST['message']);
    } elseif (!empty($_FILES['file']['name'])) {
        $fileName = basename($_FILES['file']['name']);
        $targetFilePath = 'uploads/' . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                $messageContent = $fileName;
                $messageType = 'image';
            }
        }
    }

    if ($messageContent) {
        $sql = "INSERT INTO messages (sender, receiver, content, type) VALUES ('admin@gmail.com', '$receiver', '$messageContent', '$messageType')";
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
