<?php
$pageTitle = "Manage Parking Slots";
require_once("function/authentication.php");
require_once("include/header.php");
require_once("include/sidebar.php");
require_once("include/connection.php");

$successMessages = [];

// Check if the form is submitted to add to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION['username'];
    $slot_id = $_POST['slot_id'];

    // Check if the item is already in the cart
    $checkCartQuery = "SELECT * FROM cart WHERE user_id = ? AND slot_id = ?";
    $stmt = $conn->prepare($checkCartQuery);
    $stmt->bind_param("si", $user_id, $slot_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Item already in cart
        $successMessages[$slot_id] = "Already In Cart";
    } else {
        // Insert the selected slot into the cart table
        $insertCartQuery = "INSERT INTO cart (user_id, slot_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertCartQuery);
        $stmt->bind_param("si", $user_id, $slot_id);
        $stmt->execute();
        $stmt->close();

        // Store success message for the specific slot
        $successMessages[$slot_id] = "Item added to cart successfully!";
    }
}

// Initialize search filters
$searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';
$searchSize = isset($_GET['searchSize']) ? $_GET['searchSize'] : '';
$searchStatus = isset($_GET['searchStatus']) ? $_GET['searchStatus'] : '';

// Get all the slots from the database with search filters
$slotQuery = "SELECT * FROM `parking_slots` WHERE (faculty LIKE ? OR amenities LIKE ? OR slot_number LIKE ?) AND (size LIKE ?) AND (status LIKE ?)";
$stmt = $conn->prepare($slotQuery);
$searchQueryWildcard = "%" . $searchQuery . "%";
$searchSizeWildcard = "%" . $searchSize . "%";
$searchStatusWildcard = "%" . $searchStatus . "%";
$stmt->bind_param("sssss", $searchQueryWildcard, $searchQueryWildcard, $searchQueryWildcard, $searchSizeWildcard, $searchStatusWildcard);
$stmt->execute();
$slotResult = $stmt->get_result();
$slots = [];
if ($slotResult) {
    while ($row = $slotResult->fetch_assoc()) {
        $slots[] = $row;
    }
}
?>

<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text">View Slots</span>
        </div>

        <!-- Search Form -->
        <div class="search">
            <form method="GET" action="parking-slots.php" class="search-form">
                <input type="text" name="searchQuery" placeholder="Faculty, Amenities, or Slot Number"
                       value="<?php echo htmlspecialchars($searchQuery); ?>">
                <select name="searchSize">
                    <option value="">Select Size</option>
                    <option value="compact" <?php if ($searchSize == 'compact') echo 'selected'; ?>>Compact</option>
                    <option value="standard" <?php if ($searchSize == 'standard') echo 'selected'; ?>>Standard</option>
                    <option value="large" <?php if ($searchSize == 'large') echo 'selected'; ?>>Large</option>
                </select>
                <select name="searchStatus">
                    <option value="">Select Status</option>
                    <option value="available" <?php if ($searchStatus == 'available') echo 'selected'; ?>>Available
                    </option>
                    <option value="occupied" <?php if ($searchStatus == 'occupied') echo 'selected'; ?>>Occupied
                    </option>
                    </option>
                    <option value="reserved" <?php if ($searchStatus == 'reserved') echo 'selected'; ?>>Reserved
                    </option>
                </select>
                <button type="submit" class="btn search-btn"><i class="uil uil-search"></i></button>
            </form>
        </div>


        <!-- Display slots as cards -->
        <div class="cards">
            <?php
            if (!empty($slots)) {
                foreach ($slots as $slot) {
                    echo "<div class='card'>";
                    echo "<img src='../images/" . htmlspecialchars($slot["image"]) . "' alt='" . htmlspecialchars($slot["image"]) . "' class='slot-image'>";
                    echo "<div class='container'>";
                    echo "<h4><b>Slot Number: " . htmlspecialchars($slot["slot_number"]) . "</b></h4>";
                    echo "<h4><b>Faculty: " . htmlspecialchars($slot["faculty"]) . "</b></h4>";
                    echo "<p>Size: " . htmlspecialchars($slot["size"]) . "</p>";
                    echo "<p>Status: " . htmlspecialchars($slot["status"]) . "</p>";
                    echo "<p>Price per Hour: RM" . htmlspecialchars($slot["price_per_hour"]) . "</p>";
                    echo "<p>Amenities: " . htmlspecialchars($slot["amenities"]) . "</p>";
                    echo "<p>Last Updated: " . htmlspecialchars($slot["last_updated"]) . "</p>";
                    echo "<form method='post' action='parking-slots.php'>";
                    echo "<input type='hidden' name='slot_id' value='" . $slot['id'] . "'>";
                    echo "<button type='submit' name='add_to_cart' class='btn book-btn'>Add to Cart</button>";
                    echo "</form>";

                    // Display success message if the item was added to cart
                    if (isset($successMessages[$slot['id']])) {
                        echo "<p class='success-message'>" . $successMessages[$slot['id']] . "</p>";
                    }

                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No slots found</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php require_once("include/footer.php"); ?>
