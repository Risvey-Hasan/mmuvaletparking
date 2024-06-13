<?php
$pageTitle = "Announcement"; 
require_once("function/authentication.php");
require_once("include/header.php"); 
require_once("include/sidebar.php");
require_once("include/connection.php");
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
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .form-section, .announcement-section {
            margin-bottom: 40px;
        }
        .form-section h2, .announcement-section h2 {
            margin-bottom: 20px;
        }
        .form-section form div, .announcement-item {
            margin-bottom: 20px;
        }
        .announcement-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid #ddd;
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

            if (isset($_POST['add'])) {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $image = $_FILES['image']['name'];
                $target = "uploads/" . basename($image);

                if (!file_exists('uploads/')) {
                    mkdir('uploads/', 0777, true);
                }

                $sql = "INSERT INTO announcements (title, content, image) VALUES ('$title', '$content', '$image')";
                if ($conn->query($sql) === TRUE) {
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                        echo "<p>Announcement added successfully</p>";
                    } else {
                        echo "<p>Failed to upload image. Please check the target directory and permissions.</p>";
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            if (isset($_POST['delete'])) {
                $id = $_POST['id'];
                $sql = "DELETE FROM announcements WHERE id=$id";
                if ($conn->query($sql) === TRUE) {
                    echo "<p>Announcement deleted successfully</p>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            $result = $conn->query("SELECT * FROM announcements");
            while ($row = $result->fetch_assoc()) {
                echo "<div class='announcement-item'>";
                echo "<div>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p>";
                echo "<img src='uploads/" . $row['image'] . "' alt='Announcement Image' width='100'>";
                echo "</div>";
                echo "<form action='announcement.php' method='post'>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                echo "<button type='submit' name='delete'>Delete</button>";
                echo "</form>";
                echo "</div>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
