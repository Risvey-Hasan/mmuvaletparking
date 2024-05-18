<?php
$pageTitle = "Assist Artists"; 
require_once("function/authentication.php");
require_once("include/header.php"); 
require_once("include/sidebar.php");
require_once("include/connection.php");
?>

<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text">Messages</span>
        </div>
        <?php
            if(isset($_SESSION["msg"])){
                echo $_SESSION["msg"];
            }
            unset($_SESSION["msg"]);
        ?>
        <div class="message-table">
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Admin Reply</th>
                        <th>Date and Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT id, subject, message, reply, created_at FROM messages";
                $result = $conn->query($sql);
                $i = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td>" . htmlspecialchars($row["subject"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
                        echo "<td>" . ($row["reply"] ? htmlspecialchars($row["reply"]) : "No reply yet") . "</td>";
                        echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                        if ($row["reply"] == "") {
                            echo "<td><button class='btn reply-btn' data-id='" . $row["id"] . "' data-subject='" . htmlspecialchars($row["subject"]) . "' data-message='" . htmlspecialchars($row["message"]) . "'>Reply</button></td>";
                        } else {
                            echo "<td></td>";
                        }
                        echo "</tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No messages found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal HTML -->
<div id="replyModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Reply to Message</h2>
        <form method="POST" action="helpers\asist_artist.php">
            <input type="hidden" name="message_id" id="message_id">
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" disabled>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" disabled></textarea>
            </div>
            <div class="form-group">
                <label for="reply">Your Reply</label>
                <textarea id="reply" name="reply" required></textarea>
            </div>
            <button type="submit" class="btn">Send Reply</button>
        </form>
    </div>
</div>

<?php require_once("include/footer.php"); ?>
