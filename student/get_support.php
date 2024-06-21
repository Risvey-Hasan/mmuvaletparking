<?php 
$pageTitle = "Get Support";
require_once ("function/authentication.php");
require_once("include/header.php"); 
require_once("include/sidebar.php");
require_once("include/connection.php");
?>
<div class="dash-content">
    <div class="overview">
        <div class="container">
            <form id="registrationForm" method="post" action="helpers/get_support.php" onsubmit="return validateRegiterform()">
                <div class="form-group">
                    <h2>Get Support</h2>
                </div>
                <div class="form-group">
                    <?php
                        if(isset($_SESSION["msg"])){
                            echo $_SESSION["msg"];
                        }
                        unset($_SESSION["msg"]);
                    ?>
                </div>
                <div class="form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea name="message" required></textarea>
                </div>
                <button type="submit">Submit</button>
            </form>

            <div class="message-table">
                    </br>
                    </br>
                <h2>View all FAQ</h2>
                <table>
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Admin Reply</th>
                            <th>Date and Time</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT id, subject, message, reply, created_at FROM faq";
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
                            echo "</tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>No messages found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once("include/footer.php"); ?>
