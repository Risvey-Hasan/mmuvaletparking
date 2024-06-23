<?php
session_start();
if (!isset($_SESSION['User'])) {
    header("location:./login.php");
    exit;
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "market_place";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Get the current time
$current_time = new DateTime();

try {
    // Prepare the SQL query to fetch all valid bookings for the user
    $query = $conn->prepare("
        SELECT id, parking_slot_id, created_at, period, valid
        FROM bookings
        WHERE user_id = ? AND valid = 1
    ");
    $user_email = $_SESSION['User'];
    $query->bind_param("s", $user_email);
    $query->execute();
    $result = $query->get_result();

    // Prepare statement for updating the validity of the bookings
    $updateStmt = $conn->prepare("UPDATE bookings SET valid = 0 WHERE id = ?");

    // Prepare statement for updating the status of parking slots to available
    $updateSlotStmt = $conn->prepare("UPDATE parking_slots SET status = 'available' WHERE id = ?");

    // Check each booking and update if necessary
    while ($row = $result->fetch_assoc()) {
        $booking_id = $row['id'];
        $parking_slot_id = $row['parking_slot_id'];
        $created_at = new DateTime($row['created_at']);
        $period_hours = $row['period'];

        // Calculate the end time
        $end_time = clone $created_at;
        $end_time->modify("+$period_hours hours");

        // If the current time is greater than the end time, update the valid attribute and slot status
        if ($current_time > $end_time) {
            $updateStmt->bind_param("i", $booking_id);
            $updateStmt->execute();

            $updateSlotStmt->bind_param("i", $parking_slot_id);
            $updateSlotStmt->execute();
        }
    }

    $query->close();
    $updateStmt->close();
    $updateSlotStmt->close();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
