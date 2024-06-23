<?php
require_once("../include/connection.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        echo "User not logged in.";
        exit;
    }

    // Retrieve the form data
    $user_email = $_SESSION['username'];
    $cardNumber = htmlspecialchars($_POST['cardNumber']);
    $expiryDate = htmlspecialchars($_POST['expiryDate']);
    $amount = htmlspecialchars($_POST['amount']);
    $selectedData = json_decode($_POST['selectedData'], true);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Prepare statement for retrieving slot_ids from cart
        $selectStmt = $conn->prepare("SELECT id, slot_id FROM cart WHERE user_id = ?");
        $selectStmt->bind_param("s", $user_email);
        $selectStmt->execute();
        $result = $selectStmt->get_result();

        // Fetch all slot_ids into an array
        $slotIds = [];
        while ($row = $result->fetch_assoc()) {
            $slotIds[$row['id']] = $row['slot_id'];
        }
        $selectStmt->close();

        // Prepare statement for inserting into bookings
        $insertStmt = $conn->prepare("INSERT INTO bookings (user_id, parking_slot_id, card_number, expiry_date, amount, period, valid) VALUES (?, ?, ?, ?, ?, ?, true)");

        // Prepare statement for updating the status of parking slots to reserved
        $updateSlotStmt = $conn->prepare("UPDATE parking_slots SET status = 'reserved' WHERE id = ?");

        foreach ($selectedData as $item) {
            $itemId = $item['id'];
            $period = $item['period'];

            // Retrieve slot_id from the previously fetched array
            if (isset($slotIds[$itemId])) {
                $slot_id = $slotIds[$itemId];

                // Insert the retrieved slot_id into the bookings table
                $insertStmt->bind_param("sissdi", $user_email, $slot_id, $cardNumber, $expiryDate, $amount, $period);
                $insertStmt->execute();

                // Update the status of the parking slot to reserved
                $updateSlotStmt->bind_param("i", $slot_id);
                $updateSlotStmt->execute();
            } else {
                throw new Exception("Failed to retrieve slot_id for item ID: $itemId");
            }
        }

        $insertStmt->close();
        $updateSlotStmt->close();

        // Function to delete paid items from the cart table
        function deletePaidItemsFromCart($conn, $user_email, $selectedData) {
            $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND id = ?");

            foreach ($selectedData as $item) {
                $itemId = $item['id'];
                $stmt->bind_param("si", $user_email, $itemId);
                $stmt->execute();
            }

            $stmt->close();
        }

        // Call the function to delete items from the cart
        deletePaidItemsFromCart($conn, $user_email, $selectedData);

        // Commit transaction
        $conn->commit();

        // Show success message
        echo "Payment successful!";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $conn->close();
}
?>
