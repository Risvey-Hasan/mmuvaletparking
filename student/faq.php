<?php
$pageTitle = "Support"; 
require_once ("function/authentication.php");
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
        <a class="btn" href="get_support.php">Submit a Question</a>
        <div class="table-design">
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
<?php require_once("include/footer.php"); ?>
