<?php
$pageTitle = "Announcement";
require_once ("function/authentication.php");
require_once ("include/header.php");
require_once ("include/sidebar.php");
require_once ("include/connection.php");

// Handle adding a new announcement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO announcements (title, content, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $image);

    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (!file_exists('uploads/')) {
        mkdir('uploads/', 0777, true);
    }

    if ($stmt->execute()) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            header("Location: announcement.php?status=success"); // Redirect after successful post
            exit();
        } else {
            header("Location: announcement.php?status=image_upload_fail");
            exit();
        }
    } else {
        header("Location: announcement.php?status=error");
        exit();
    }

    $stmt->close();
}

// Handle deleting an announcement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM announcements WHERE id=?");
    $stmt->bind_param("i", $id);

    $id = $_POST['id'];

    if ($stmt->execute()) {
        header("Location: announcement.php?status=delete_success"); // Redirect after successful delete
        exit();
    } else {
        header("Location: announcement.php?status=delete_error");
        exit();
    }

    $stmt->close();
}

require_once ("include/connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Announcements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
        }

        h2 {
            color: #444;
            margin-bottom: 20px;
        }

        .form-section,
        .announcement-section {
            margin-bottom: 40px;
        }

        .form-section form div,
        .announcement-item {
            margin-bottom: 20px;
        }

        .form-section label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-section input[type="text"],
        .form-section textarea,
        .form-section input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-section button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            background-color: dodgerblue;
            color: white;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .form-section button:hover {
            background-color: deepskyblue;
        }

        .announcement-section h2 {
            color: #444;
        }

        .announcement-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fafafa;
            margin-bottom: 10px;
            transition: box-shadow 0.3s;
        }

        .announcement-item:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .announcement-item img {
            max-width: 100px;
            height: auto;
            border-radius: 4px;
        }

        .announcement-item-content {
            flex: 1;
            margin-right: 20px;
        }

        .announcement-item-content h3 {
            margin: 0;
            font-size: 1.2em;
            color: #555;
        }

        .announcement-item-content p {
            margin: 10px 0 0;
            line-height: 1.6;
        }

        .announcement-item form button {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            background-color: crimson;
            color: white;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .announcement-item form button:hover {
            background-color: darkred;
        }

        .announcement-item form {
            display: flex;
            align-items: center;
        }

        .delete-button-container {
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-section">
            <h2>Add New Announcement</h2>
            <form action="announcement.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div>
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" required></textarea>
                </div>
                <div>
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" required>
                </div>
                <button type="submit" name="add">Add Announcement</button>
            </form>
        </div>

        <div class="announcement-section">
            <h2>Current Announcements</h2>
            <?php
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $result = $conn->query("SELECT * FROM announcements");
            while ($row = $result->fetch_assoc()) {
                echo "<div class='announcement-item'>";
                echo "<div class='announcement-item-content'>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
                echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Announcement Image'>";
                echo "</div>";
                echo "<form action='announcement.php' method='post' class='delete-button-container'>";
                echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
                echo "<button type='submit' name='delete'>Delete</button>";
                echo "</form>";
                echo "</div>";
            }

            $conn->close();
            ?>
        </div>
    </div>
<?php require_once("include/footer.php"); ?>