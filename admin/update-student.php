<?php
$pageTitle = "Update Student Information";
require_once("function/authentication.php");
require_once("include/header.php");
require_once("include/sidebar.php");
require_once("include/connection.php");

$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = htmlspecialchars($_GET['search']);
    $sql = "SELECT * FROM users WHERE privilege = 1 AND (name LIKE '%$searchQuery%' OR phone LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%')";
} else {
    $sql = "SELECT * FROM users WHERE privilege = 1";
}

$result = $conn->query($sql);
?>

<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text">Students</span>
        </div>
        <?php
        if (isset($_SESSION["msg"])) {
            echo $_SESSION["msg"];
        }
        unset($_SESSION["msg"]);
        ?>
        <!-- Search Form -->
        <div class="search-form">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by name, phone, or email"
                       value="<?php echo $searchQuery; ?>">
                <button type="submit"><i class="uil uil-search"></i></button>
            </form>
        </div>

        <div class="message-table">
            <table>
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $i . "</td>"; // Serial number
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["address"]) . "</td>";
                        echo "<td><a href='update-info.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to update this artist info?\")'>Update Info</a></td>";
                        echo "</tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No artists found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once("include/footer.php"); ?>


