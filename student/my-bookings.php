<?php
$pageTitle = "My Bookings";
require_once("function/authentication.php");
require_once("include/header.php");
require_once("include/sidebar.php");
require_once("include/connection.php");

// Retrieve the user's email from the session
$user_email = $_SESSION['username'];

// Prepare arrays to store the booking data
$bookings = [];
$parking_slots = [];

try {
    // Prepare the SQL query to fetch only valid bookings and related parking slot information for the user
    $query = $conn->prepare("
        SELECT 
            b.parking_slot_id, b.period, b.created_at, b.valid,
            p.faculty, p.size, p.amenities, p.image, p.slot_number
        FROM bookings b
        JOIN parking_slots p ON b.parking_slot_id = p.id
        WHERE b.user_id = ? AND b.valid = 1
    ");
    $query->bind_param("s", $user_email);
    $query->execute();
    $result = $query->get_result();

    // Check if any bookings were found and store them in arrays
    while ($row = $result->fetch_assoc()) {
        $bookings[] = [
            'parking_slot_id' => $row['parking_slot_id'],
            'period' => $row['period'],
            'created_at' => $row['created_at'],
            'valid' => $row['valid']
        ];
        $parking_slots[] = [
            'faculty' => $row['faculty'],
            'size' => $row['size'],
            'amenities' => $row['amenities'],
            'image' => $row['image'],
            'slot_number' => $row['slot_number']
        ];
    }

    $query->close();
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-shopping-cart"></i>
            <span class="text">Your Bookings</span>
        </div>
        <div class="table-design">
        <?php if (!empty($bookings)) : ?>
            <table>
                <tr>
                    <th>View</th>
                    <th>Booked From</th>
                    <th>Booked For</th>
                    <th>Size</th>
                    <th>Faculty</th>
                    <th>Amenities</th>
                    <th>Slot Number</th>
                </tr>
                <?php foreach ($bookings as $index => $booking) : ?>
                    <tr>
                        <td><img src="<?= '../images/' . htmlspecialchars($parking_slots[$index]['image']) ?>" style="width:70px;height:auto;"></td>
                        <td><?= htmlspecialchars($booking['created_at']) ?></td>
                        <td><?= htmlspecialchars($booking['period']) . ' Hour(s)' ?></td>
                        <td><?= ucfirst(htmlspecialchars($parking_slots[$index]['size'])) ?></td>
                        <td><?= ucwords(htmlspecialchars($parking_slots[$index]['faculty'])) ?></td>
                        <td><?= ucwords(htmlspecialchars($parking_slots[$index]['amenities'])) ?></td>
                        <td><?= htmlspecialchars($parking_slots[$index]['slot_number']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>No bookings found.</p>
        <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once("include/footer.php"); ?>
