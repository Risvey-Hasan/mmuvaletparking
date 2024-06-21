<?php
$pageTitle = "Manage Parking Slots";
require_once("function/authentication.php");
require_once("include/header.php");
require_once("include/sidebar.php");
require_once("include/connection.php");

// Handle form submission to create a new slot
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faculty = $_POST['faculty'];
    $size = $_POST['size'];
    $status = $_POST['status'];
    $price_per_hour = $_POST['price_per_hour'];
    $amenities = isset($_POST['amenities']) ? $_POST['amenities'] : '';

    $insertQuery = "INSERT INTO `parking_slots` (faculty, size, status, price_per_hour, amenities) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssds", $faculty, $size, $status, $price_per_hour, $amenities);
    $stmt->execute();
    $stmt->close();

    // Redirect to avoid form resubmission
    header("Location: slot-management.php");
    exit();
}

// Get all the slots from the database
$slotQuery = "SELECT * FROM `parking_slots`";
$slotResult = mysqli_query($conn, $slotQuery);
$slots = [];
if ($slotResult) {
    while ($row = mysqli_fetch_assoc($slotResult)) {
        $slots[] = $row;
    }
}

?>

<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text">Manage Slots</span>
        </div>
        <div class="table-design">
            <!-- Add Slot Button -->
            <button id="addSlotBtn" class="btn">Add Slot</button>

            <!-- Add Slot Form (hidden by default) -->
            <div id="addSlotForm" style="display: none;">
                <form action="slot-management.php" method="post">
                    <label for="faculty">Faculty:</label>
                    <input type="text" id="faculty" name="faculty" maxlength="5" required>

                    <label for="size">Size:</label>
                    <select id="size" name="size" required>
                        <option value="compact">Compact</option>
                        <option value="standard">Standard</option>
                        <option value="large">Large</option>
                    </select>

                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="reserved">Reserved</option>
                        <option value="under maintenance">Under Maintenance</option>
                    </select>

                    <label for="price_per_hour">Price per Hour (RM):</label>
                    <input type="number" id="price_per_hour" name="price_per_hour" step="0.01" required>

                    <label for="amenities">Amenities:</label>
                    <input type="text" id="amenities" name="amenities" maxlength="255">

                    <button type="submit" class="btn">Save</button>
                </form>
            </div>

            <!--WRITE THE TABLE HERE-->
            <table>
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Faculty</th>
                    <th>Size</th>
                    <th>Status</th>
                    <th>Price per Hour</th>
                    <th>Amenities</th>
                    <th>Creation Date</th>
                    <th>Last Updated</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                if (!empty($slots)) {
                    foreach ($slots as $slot) {
                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td>" . htmlspecialchars($slot["faculty"]) . "</td>";
                        echo "<td>" . htmlspecialchars($slot["size"]) . "</td>";
                        echo "<td>" . htmlspecialchars($slot["status"]) . "</td>";
                        echo "<td>RM" . htmlspecialchars($slot["price_per_hour"]) . "</td>";
                        echo "<td>" . htmlspecialchars($slot["amenities"]) . "</td>";
                        echo "<td>" . htmlspecialchars($slot["creation_date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($slot["last_updated"]) . "</td>";
                        echo "</tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='8'>No slots found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once("include/footer.php"); ?>

<!-- JavaScript for Add Slot Form -->
<script>
    var addSlotBtn = document.getElementById('addSlotBtn');
    addSlotBtn.addEventListener('click', function () {
        if (addSlotBtn.innerText !== 'Cancel') {
            document.getElementById('addSlotBtn').innerText = 'Cancel';
        } else {
            addSlotBtn.innerText = 'Add Slot'
        }
        var form = document.getElementById('addSlotForm');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });
</script>
