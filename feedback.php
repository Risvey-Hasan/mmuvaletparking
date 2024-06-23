<?php
// Include the database connection file
require_once('student/include/connection.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO feedback (message) VALUES (?)");
    $stmt->bind_param("s", $message);

    // Execute the statement
    if ($stmt->execute()) {
        $feedback_status = "Thank you for your feedback!";
    } else {
        $feedback_status = "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        textarea {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            resize: vertical;
        }
        button {
            padding: 10px;
            margin: 10px 0;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .feedback-status {
            text-align: center;
            margin-top: 20px;
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Feedback Form</h1>
    <form method="POST" action="">
        <textarea name="message" rows="5" placeholder="Enter your feedback here..." required></textarea>
        <button type="submit">Submit Feedback</button>
    </form>
    <?php if (isset($feedback_status)): ?>
        <p class="feedback-status"><?php echo $feedback_status; ?></p>
    <?php endif; ?>
</div>
</body>
</html>
