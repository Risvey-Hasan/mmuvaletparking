<?php
$pageTitle = "Contact Students";
require_once("function/authentication.php");
require_once("include/header.php");
require_once("include/sidebar.php");
require_once("include/connection.php");

// Fetch feedback messages from the database
$sql = "SELECT message FROM feedback";
$result = $conn->query($sql);
?>

<div class="dash-content">
    <div class="overview" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <div class="feedback-container">
            <h1>Feedback Messages</h1>
            <?php if ($result->num_rows > 0): ?>
                <ul class="feedback-list">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <li class="feedback-item"><?php echo htmlspecialchars($row['message']); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No feedback available.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
require_once("include/footer.php");
?>

