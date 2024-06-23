<?php
require_once("../include/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $user_email = $_SESSION['username']; // Assuming email is stored in session
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];
    $amount = $_POST['amount'];
    $selectedData = json_decode($_POST['selectedData'], true);

    // Insert each selected item into the bookings table
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, parking_slot_id, card_number, expiry_date, cvv, amount, period, valid) VALUES (?, ?, ?, ?, ?, ?, ?, false)");

    foreach ($selectedData as $item) {
        $parking_slot_id = $item['id'];
        $period = $item['period'];
        $stmt->bind_param("sissdii", $user_email, $parking_slot_id, $cardNumber, $expiryDate, $cvv, $amount, $period);
        $stmt->execute();
    }

    $stmt->close();

    // Function to delete paid items from the cart table
    function deletePaidItemsFromCart($conn, $user_email, $selectedData) {
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND slot_id = ?");

        foreach ($selectedData as $item) {
            $slot_id = $item['id'];
            $stmt->bind_param("si", $user_email, $slot_id);
            $stmt->execute();
        }

        $stmt->close();
    }

    // Call the function to delete items from the cart
    deletePaidItemsFromCart($conn, $user_email, $selectedData);

    $conn->close();

    // Redirect or show success message
    echo "Payment successful!";
}
?>
