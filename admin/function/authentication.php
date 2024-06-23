<?php
session_start();
if(!($_SESSION['Admin'])){
    header("location:../student/login.php");
}

require_once("include/connection.php");

// Get the current time
$current_time = new DateTime();

try {
    // Prepare the SQL query to fetch all bookings
    $query = $conn->prepare("
        SELECT id, created_at, period, valid 
        FROM bookings
        WHERE valid = 1
    ");
    $query->execute();
    $result = $query->get_result();

    // Prepare statement for updating the validity of the bookings
    $updateStmt = $conn->prepare("UPDATE bookings SET valid = 0 WHERE id = ?");

    // Check each booking and update if necessary
    while ($row = $result->fetch_assoc()) {
        $booking_id = $row['id'];
        $created_at = new DateTime($row['created_at']);
        $period_hours = $row['period'];

        // Calculate the end time
        $end_time = clone $created_at;
        $end_time->modify("+$period_hours hours");

        // If the current time is greater than the end time, update the valid attribute
        if ($current_time > $end_time) {
            $updateStmt->bind_param("i", $booking_id);
            $updateStmt->execute();
        }
    }

    $query->close();
    $updateStmt->close();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
