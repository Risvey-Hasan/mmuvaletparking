<?php 
$pageTitle = "Dashboard";
require_once ("function/authentication.php");
require_once("include/header.php"); 
require_once("include/sidebar.php");
require_once("include/connection.php");
?>
<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text">Student Dashboard</span>
        </div>
        <?php 
        $id = $_SESSION['User'];

        // Query to get total count of oders
        $sql = "SELECT COUNT(*) AS total_orders FROM orders WHERE artist_id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_orders = $row['total_orders'];

        // Query to get total count of support
        $sql = "SELECT COUNT(*) AS total_messages FROM faq WHERE user_id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_messages = $row['total_messages'];
         
        // Query to get total count of products
        $sql = "SELECT COUNT(*) AS total_products FROM products WHERE artist_id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_products = $row['total_products'];
        ?>
        <div class="boxes">
            <div class="box box1">
                <i class="uil uil-thumbs-up"></i>
                <span class="text">Total Orders</span>
                <span class="number"><?php echo $total_orders ?></span>
            </div>
            <div class="box box2">
                <i class="uil uil-comments"></i>
                <span class="text">Get Support</span>
                <span class="number"><?php echo $total_messages ?></span>
            </div>
            <div class="box box3">
                <i class="uil uil-share"></i>
                <span class="text"> Total Listing</span>
                <span class="number"><?php echo $total_products ?></span>
            </div>
        </div>
    </div>
<?php require_once("include/footer.php");?>