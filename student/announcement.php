<?php
$pageTitle = "Announcement";
require_once ("function/authentication.php");
require_once ("include/header.php");
require_once ("include/sidebar.php");
require_once ("include/connection.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the default sort order
$sortOrder = "DESC";

// Check if the oldest tab is active
if (isset($_GET['tab']) && $_GET['tab'] === 'oldest') {
    $sortOrder = "ASC";
}

$stmt = $conn->prepare("SELECT * FROM announcements ORDER BY created_at $sortOrder");
$stmt->execute();
$result = $stmt->get_result();

$announcements = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $announcements[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MMU Valet Parking - Announcement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 80px;
        }

        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
            text-decoration: none;
            color: #333;
            background-color: aliceblue;
            border: 1px solid #ddd;
            margin-right: 10px;
        }

        .tab:hover {
            background-color: deepskyblue;
        }

        .active {
            background-color: dodgerblue;
            border-color: #bbb;
        }

        .announcement {
            display: flex;
            flex-direction: column;
        }

        .announcement-item {
            display: flex;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            background-color: #fafafa;
            transition: box-shadow 0.3s;
        }

        .announcement-item:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .announcement-item img {
            width: 250px;
            height: auto;
            margin-right: 20px;
            margin-left: 0;
            border-radius: 4px;
        }

        .announcement-item div {
            flex-grow: 1;
        }

        .announcement-item h3 {
            margin: 0;
            font-size: 1.5em;
            color: #555;
        }

        .announcement-item p {
            margin: 10px 0 0;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>News & Announcements</h1>
        <div class="tabs">
            <a class="tab <?php echo (!isset($_GET['tab']) || (isset($_GET['tab']) && $_GET['tab'] === 'latest')) ? 'active' : ''; ?>"
                href="?tab=latest">Latest</a>
            <a class="tab <?php echo (isset($_GET['tab']) && $_GET['tab'] === 'oldest') ? 'active' : ''; ?>"
                href="?tab=oldest">Oldest</a>
        </div>
        <div class="announcement">
            <?php foreach ($announcements as $announcement): ?>
                <div class='announcement-item'>
                    <div>
                        <h3><?= htmlspecialchars($announcement['title']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($announcement['content'])) ?></p>
                    </div>
                    <?php if (!empty($announcement['image'])): ?>
                        <?php $imagePath = '../admin/uploads/' . htmlspecialchars($announcement['image']); ?>
                        <img src='<?= $imagePath ?>' alt='Announcement Image'>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function showTab(tab) {
            document.getElementById('latest').style.display = 'none';
            document.getElementById('popular').style.display = 'none';
            document.querySelector('.tab.active').classList.remove('active');
            if (tab === 'latest') {
                document.getElementById('latest').style.display = 'block';
                document.querySelectorAll('.tab')[0].classList.add('active');
            } else if (tab === 'oldest') {
                document.getElementById('popular').style.display = 'block';
                document.querySelectorAll('.tab')[1].classList.add('active');
            }
        }
    </script>
</body>

</html>