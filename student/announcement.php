<?php
$pageTitle = "Announcement";
require_once ("function/authentication.php");
require_once ("include/header.php");
require_once ("include/sidebar.php");
require_once ("include/connection.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM announcements ORDER BY id DESC");
$latestAnnouncements = [];
$popularAnnouncements = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Store announcements into respective arrays
        if (count($latestAnnouncements) < 3) {
            $latestAnnouncements[] = $row;
        }
        $popularAnnouncements[] = $row;
    }
} else {
    echo "<p>No announcements found.</p>";
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
        }

        .container {
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            border: 1px solid #000;
            cursor: pointer;
        }

        .active {
            background-color: #ddd;
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
        }

        .announcement-item img {
            width: 200px;
            /* Increased width */
            height: auto;
            /* Auto height to maintain aspect ratio */
            margin-right: 20px;
            margin-left: 0;
            /* Align to the left */
        }

        .announcement-item div {
            flex-grow: 1;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>News & Announcements</h1>
        <div class="tabs">
            <div class="tab active" onclick="showTab('latest')">Latest</div>
            <div class="tab" onclick="showTab('popular')">Popular</div>
        </div>
        <div id="latest" class="announcement">
            <?php foreach ($latestAnnouncements as $announcement): ?>
                <div class='announcement-item'>
                    <h3><?= htmlspecialchars($announcement['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($announcement['content'])) ?></p>
                    <?php if (!empty($announcement['image'])): ?>
                        <?php $imagePath = '../admin/uploads/' . htmlspecialchars($announcement['image']); ?>
                        <img src='<?= $imagePath ?>' alt='Announcement Image'>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div id="popular" class="announcement" style="display: none;">
            <?php foreach ($popularAnnouncements as $announcement): ?>
                <div class='announcement-item'>
                    <h3><?= htmlspecialchars($announcement['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($announcement['content'])) ?></p>
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
            } else {
                document.getElementById('popular').style.display = 'block';
                document.querySelectorAll('.tab')[1].classList.add('active');
            }
        }
    </script>
</body>

</html>