<?php
$pageTitle = "Contact Students";
require_once("function/authentication.php");
require_once("include/header.php");
require_once("include/sidebar.php");
require_once("include/connection.php");

// Fetch distinct users from the messages table
$userQuery = "SELECT DISTINCT sender FROM messages WHERE sender != 'admin@gmail.com'";
$userResult = mysqli_query($conn, $userQuery);
$senders = [];
if ($userResult) {
    while ($row = mysqli_fetch_assoc($userResult)) {
        $senders[] = $row['sender'];
    }
}

//Fetch distinct names for the users from the user table
$userNamesQuery = "SELECT DISTINCT * FROM users";
$userNameResult = mysqli_query($conn, $userNamesQuery);
$userNames = [];
if ($userNameResult) {
    while ($row = mysqli_fetch_assoc($userNameResult)) {
        if (in_array($row['email'], $senders)) {
            array_push($userNames, $row['name']);
        }
    }
}

// Fetch messages from the database for the selected user
$selectedUser = isset($_GET['user']) ? $_GET['user'] : '';
$messageQuery = "SELECT * FROM messages WHERE sender = '$selectedUser' OR sender = 'admin@gmail.com' AND receiver = '$selectedUser' ORDER BY timestamp ASC";
$messageResult = mysqli_query($conn, $messageQuery);
$messages = [];
if ($messageResult) {
    while ($row = mysqli_fetch_assoc($messageResult)) {
        $messages[] = $row;
    }
}
?>

<div class="dash-content">
    <div class="overview" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <div class="chat-container">
            <div class="sidebar">
                <p>Conversations</p>
                <ul class="user-list">
                    <?php $i = sizeof($userNames) -1 ?>
                    <?php foreach ($userNames as $user): ?>
                        <a href="?user=<?php echo urlencode($senders[$i]); ?>" class="user-link <?php echo $senders[$i] == $selectedUser ? 'selected' : ''; ?>">
                            <li class="user-list-item">
                                <?php echo htmlspecialchars($user); ?>
                            </li>
                        </a>
                        <?php $i-- ?>
                    <?php endforeach; ?>
                </ul>
            </div>
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
                <form id="chat-form" enctype="multipart/form-data">
                    <input type="hidden" id="receiver" value="<?php echo htmlspecialchars($selectedUser); ?>">
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
