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
    <div class="overview">
        <div class="chat-container">
            <div class="chat-box" id="chat-box">
                <?php foreach ($messages as $message): ?>
                    <div class="chat-message <?php echo $message['sender'] == 'admin@gmail.com' ? 'admin' : 'user'; ?>">
                        <?php if ($message['type'] == 'text'): ?>
                            <p><?php echo htmlspecialchars($message['content']); ?></p>
                        <?php elseif ($message['type'] == 'image'): ?>
                            <img src="uploads/<?php echo $message['content']; ?>" alt="Image">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <form id="chat-form" enctype="multipart/form-data">
                <input type="text" id="message-input" placeholder="Type your message">
                <label for="file-input" class="custom-file-upload">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                        <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128z"/>
                    </svg>
                </label>
                <input type="file" id="file-input" accept="image/*">
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/chatroom.js"></script>
<?php require_once("include/footer.php"); ?>
