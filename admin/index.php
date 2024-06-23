<?php 
$pageTitle = "Admin Dashboard";
require_once ("function/authentication.php");
require_once("include/header.php"); 
require_once("include/sidebar.php");
require_once("include/connection.php");
?>
<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text">Dashboard</span>
        </div>
        <?php 
        // Query to get count of unique student profiles having conversations with the admin
        $sql = "SELECT COUNT(DISTINCT sender) AS unique_students FROM messages WHERE receiver = 'admin@gmail.com'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $unique_students = $row['unique_students'];

        // Query to get total count of FAQs
        $sql = "SELECT COUNT(*) AS total_faqs FROM faq";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_faqs = $row['total_faqs'];
         
        // Query to get total count of slots
        $sql = "SELECT COUNT(*) AS total_slots FROM parking_slots";  
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_slots = $row['total_slots'];
        ?>
        <div class="boxes">
            <div class="box box1">
                <i class="uil uil-thumbs-up"></i>
                <span class="text">Unique Student Conversations</span>
                <span class="number"><?php echo $unique_students ?></span>
            </div>
            <div class="box box2">
                <i class="uil uil-comments"></i>
                <span class="text">FAQs</span>
                <span class="number"><?php echo $total_faqs ?></span>
            </div>
            <div class="box box3">
                <i class="uil uil-share"></i>
                <span class="text"> Total Number Of Slots</span>
                <span class="number"><?php echo $total_slots ?></span>
            </div>
        </div>
    </div>
<?php require_once("include/footer.php");?>
