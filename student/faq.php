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
        <a  class="btn" href="get_support.php" >Submit a Question</a>
        <div class="table-design">
        <table>
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Admin Reply</th>
                    <th>Date and  Time</th>
                </tr>
            </thead>
            <tbody>
            <?php          
            $id = $_SESSION['User'];
            $sql = "SELECT subject, message,reply, created_at FROM faq WHERE user_id = '$id'";
            $result = $conn->query($sql);
            $i = 1;
            if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . $row["subject"] . "</td>";
                            echo "<td>" . $row["message"] . "</td>";
                            if($row["reply"] == "" ){
                                echo "<td>" . "No reply yet" . "</td>";
                            }
                            else{
                                echo "<td>" . $row["reply"] . "</td>";
                            }
                            echo "<td>" . $row["created_at"] . "</td>";
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
<?php require_once("include/footer.php");?>
