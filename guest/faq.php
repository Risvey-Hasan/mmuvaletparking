<?php
$pageTitle = "Orders";
require_once("function/authentication.php");
require_once("include/header.php"); 
require_once("include/sidebar.php");
require_once("include/connection.php");

$id = $_SESSION['User'];
$sql = "SELECT * FROM orders WHERE artist_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text">Orders</span>
        </div>
        <div class="table-design">
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Order Status</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0) {
                        $i = 1;
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . $row["order_id"] . "</td>";
                            echo "<td>" . $row["order_date"] . "</td>";
                            echo "<td>" . $row["order_status"] . "</td>";
                            echo "<td>RM" . $row["total_amount"] . "</td>";
                            echo "</tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>No orders found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once("include/footer.php");?>
