<?php
$pageTitle = "Manage Parking Slots";
require_once("function/authentication.php");
require_once("include/header.php");
require_once("include/sidebar.php");
require_once("include/connection.php");

// Handle form submission to create a new slot
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_slot'])) {
    $faculty = $_POST['faculty'];
    $size = $_POST['size'];
    $status = $_POST['status'];
    $price_per_hour = $_POST['price_per_hour'];
    $amenities = isset($_POST['amenities']) ? $_POST['amenities'] : '';

    // Handle file upload
    $image = "slots/default.png"; // Default image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../images/slots/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = "slots/" . basename($_FILES['image']['name']);
        }
    }

    $insertQuery = "INSERT INTO `parking_slots` (faculty, size, status, price_per_hour, amenities, image) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssdss", $faculty, $size, $status, $price_per_hour, $amenities, $image);
    $stmt->execute();
    $stmt->close();

    // Redirect to avoid form resubmission
    header("Location: slot-management.php");
    exit();
}

// Handle form submission to update a slot
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_slot'])) {
    $id = $_POST['id'];
    $size = $_POST['size'];
    $status = $_POST['status'];
    $price_per_hour = $_POST['price_per_hour'];
    $amenities = $_POST['amenities'];

    // Handle file upload
    $image = "slots/default.png"; // Default image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../images/slots/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        // Create the directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = "slots/" . basename($_FILES['image']['name']);
        }
    } else {
        // Get existing image if no new image is uploaded
        $result = $conn->query("SELECT image FROM `parking_slots` WHERE id = $id");
        $row = $result->fetch_assoc();
        $image = $row['image'];
    }

    $updateQuery = "UPDATE `parking_slots` SET size=?, status=?, price_per_hour=?, amenities=?, image=?, last_updated=NOW() WHERE id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssdsi", $size, $status, $price_per_hour, $amenities, $image, $id);
    $stmt->execute();
    $stmt->close();

    // Redirect to avoid form resubmission
    header("Location: slot-management.php");
    exit();
}

// Handle deletion of a slot
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_slot'])) {
    $id = $_POST['id'];

    $deleteQuery = "DELETE FROM `parking_slots` WHERE id=?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
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
        <button id="addSlotBtn" class="btn">Add Slot</button>
        <div class="table-design">

            <!-- Add Slot Form (hidden by default) -->
            <div id="addSlotForm" style="display: none;">
                <form action="slot-management.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="create_slot" value="1">
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

                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image">

                    <button type="submit" class="btn">Save</button>
                    <button type="button" class="btn cancel-update">Cancel</button>
                </form>
            </div>

            <!--WRITE THE TABLE HERE-->
            <table>
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Image</th>
                    <th>Faculty</th>
                    <th>Size</th>
                    <th>Status</th>
                    <th>Price per Hour</th>
                    <th>Amenities</th>
                    <th>Creation Date</th>
                    <th>Last Updated</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                if (!empty($slots)) {
                    foreach ($slots as $slot) {
                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td><img src='../images/" . htmlspecialchars($slot["image"]) . "' alt='Slot Image' style='width:70px;height:auto;'></td>";
                        echo "<td>" . htmlspecialchars($slot["faculty"]) . "</td>";
                        echo "<td>" . htmlspecialchars($slot["size"]) . "</td>";
                        echo "<td>" . htmlspecialchars($slot["status"]) . "</td>";
                        echo "<td>RM" . htmlspecialchars($slot["price_per_hour"]) . "</td>";
                        echo "<td>" . htmlspecialchars($slot["amenities"]) . "</td>";
                        echo "<td>" . htmlspecialchars($slot["creation_date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($slot["last_updated"]) . "</td>";
                        echo "<td>";
                        echo "<button class='btn update-btn' data-id='" . $slot["id"] . "' data-size='" . htmlspecialchars($slot["size"]) . "' data-status='" . htmlspecialchars($slot["status"]) . "' data-price='" . htmlspecialchars($slot["price_per_hour"]) . "' data-amenities='" . htmlspecialchars($slot["amenities"]) . "'>Update</button>";
                        if ($slot["status"] !== "occupied" && $slot["status"] !== "reserved") {
                            echo "<button class='btn delete-btn' data-id='" . $slot["id"] . "'>Delete</button>";
                        }
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='10'>No slots found</td></tr>";
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
        var form = document.getElementById('addSlotForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    document.querySelectorAll('.cancel-update').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('addSlotForm').style.display = 'none';
        });
    });

    // JavaScript for Update Slot Form
    document.querySelectorAll('.update-btn').forEach(button => {
        button.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            var size = this.getAttribute('data-size');
            var status = this.getAttribute('data-status');
            var price = this.getAttribute('data-price');
            var amenities = this.getAttribute('data-amenities');

            var updateForm = document.getElementById('updateSlotForm');
            if (updateForm) {
                updateForm.remove();
            }

            updateForm = document.createElement('div');
            updateForm.id = 'updateSlotForm';
            updateForm.style.display = 'block';
            updateForm.innerHTML = `
                <form action="slot-management.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="update_slot" value="1">
                    <input type="hidden" name="id" value="${id}">
                    <label for="size">Size:</label>
                    <select id="size" name="size" required>
                        <option value="compact" ${size === 'compact' ? 'selected' : ''}>Compact</option>
                        <option value="standard" ${size === 'standard' ? 'selected' : ''}>Standard</option>
                        <option value="large" ${size === 'large' ? 'selected' : ''}>Large</option>
                    </select>
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="available" ${status === 'available' ? 'selected' : ''}>Available</option>
                        <option value="occupied" ${status === 'occupied' ? 'selected' : ''}>Occupied</option>
                        <option value="reserved" ${status === 'reserved' ? 'selected' : ''}>Reserved</option>
                        <option value="under maintenance" ${status === 'under maintenance' ? 'selected' : ''}>Under Maintenance</option>
                    </select>
                    <label for="price_per_hour">Price per Hour (RM):</label>
                    <input type="number" id="price_per_hour" name="price_per_hour" step="0.01" value="${price}" required>
                    <label for="amenities">Amenities:</label>
                    <input type="text" id="amenities" name="amenities" maxlength="255" value="${amenities}">
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image">
                    <button type="submit" class="btn">Save</button>
                    <button type="button" class="btn cancel-update">Cancel</button>
                </form>
            `;
            document.body.appendChild(updateForm);

            updateForm.querySelector('.cancel-update').addEventListener('click', function () {
                updateForm.remove();
            });
        });
    });

    // JavaScript for Delete Slot Confirmation
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            var id = this.getAttribute('data-id');

            var deleteForm = document.getElementById('deleteSlotForm');
            if (deleteForm) {
                deleteForm.remove();
            }

            deleteForm = document.createElement('div');
            deleteForm.id = 'deleteSlotForm';
            deleteForm.style.display = 'block';
            deleteForm.innerHTML = `
                <form action="slot-management.php" method="post">
                    <input type="hidden" name="delete_slot" value="1">
                    <input type="hidden" name="id" value="${id}">
                    <p>Are you sure you want to delete this slot?</p>
                    <button type="submit" class="btn delete-btn">Yes</button>
                    <button type="button" class="btn cancel-delete">No</button>
                </form>
            `;
            document.getElementsByClassName("overview")[0].appendChild(deleteForm);

            deleteForm.querySelector('.cancel-delete').addEventListener('click', function () {
                deleteForm.remove();
            });
        });
    });
</script>
