<?php
$pageTitle = "Contact Us";
require_once("function/authentication.php");
require_once("include/header.php");
require_once("include/sidebar.php");
require_once("include/connection.php");

// Fetch messages from the database for the logged-in user
$loggedInUser = $_SESSION['username'];
$messageQuery = "SELECT * FROM messages WHERE sender = '$loggedInUser' OR receiver = '$loggedInUser' ORDER BY timestamp ASC";
$messageResult = mysqli_query($conn, $messageQuery);
$messages = [];
if ($messageResult) {
    while ($row = mysqli_fetch_assoc($messageResult)) {
        $messages[] = $row;
    }
}
?>
<div class="dash-content">
    <h2>Contact Us</h2>
    <div class="overview">
        <div class="chat-container">
            <div class="chat-box-container">
                <div class="chat-box" id="chat-box">
                    <?php foreach ($messages as $message): ?>
                        <div class="chat-message <?php echo $message['sender'] == 'admin@gmail.com' ? 'admin' : 'user'; ?>">
                            <p class="timestamp"><?php echo htmlspecialchars($message['timestamp']); ?></p>
                            <?php if ($message['type'] == 'text'): ?>
                                <p><?php echo htmlspecialchars($message['content']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <form id="chat-form" enctype="multipart/form-data" class="chat-form">
                    <input type="text" id="message-input" placeholder="Type your message" class="message-input">
                    <input type="file" id="file-input" accept="image/*">
                    <button type="submit" class="send-button">Send</button>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="assets/js/chatroom.js"></script>
<?php require_once("include/footer.php"); ?>
