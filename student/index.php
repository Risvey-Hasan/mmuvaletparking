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
        $username = $_SESSION['username'];

        // Query to get total count of cart items
        $sql = "SELECT COUNT(*) AS total_cart FROM cart WHERE user_id='$username'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_cart = $row['total_cart'];

        // Query to get total count of support messages
        $sql = "SELECT COUNT(*) AS total_support_messages FROM faq WHERE user_id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_support_messages = $row['total_support_messages'];
        
        // Query to get total count of products
        $sql = "SELECT COUNT(*) AS total_products FROM products WHERE artist_id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_products = $row['total_products'];

        // Query to get total count of parking slots
        $sql = "SELECT COUNT(*) AS total_parking_slots FROM parking_slots";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_parking_slots = $row['total_parking_slots'];

        // Query to get total count of messages (from contact page)
        $sql = "SELECT COUNT(*) AS total_contact_messages FROM messages WHERE sender='$username' OR receiver='$username'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_contact_messages = $row['total_contact_messages'];

        // Query to get total count of bookings
        $sql = "SELECT COUNT(*) AS total_bookings FROM bookings WHERE user_id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_bookings = $row['total_bookings'];

        // Query to get total count of available parking slots
        $sql = "SELECT COUNT(*) AS total_available_slots FROM parking_slots WHERE status='available'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_available_slots = $row['total_available_slots'];
        ?>

        <div class="boxes">
            <div class="box box1">
                <i class="uil uil-thumbs-up"></i>
                <span class="text">Cart Items</span>
                <span class="number"><?php echo $total_cart ?></span>
            </div>
            <div class="box box2">
                <i class="uil uil-comments"></i>
                <span class="text">Get Support</span>
                <span class="number"><?php echo $total_support_messages ?></span>
            </div>
            <div class="box box3">
                <i class="uil uil-parking-circle"></i>
                <span class="text">Total Parking Slots</span>
                <span class="number"><?php echo $total_parking_slots ?></span>
            </div>
            <div class="box box4">
                <i class="uil uil-envelope"></i>
                <span class="text">Total Messages</span>
                <span class="number"><?php echo $total_contact_messages ?></span>
            </div>
            <div class="box box5">
                <i class="uil uil-box"></i>
                <span class="text">Available Slots</span>
                <span class="number"><?php echo $total_available_slots ?></span>
            </div>

            <div class="box box6">
                <i class="uil uil-box"></i>
                <span class="text">My Booking</span>
                <span class="number"><?php echo $total_bookings ?></span>
            </div>
        </div>
    </div>
<?php require_once("include/footer.php"); ?>
