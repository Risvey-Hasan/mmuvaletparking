<?php
$pageTitle = "Your Cart";
require_once("function/authentication.php");
require_once("include/header.php");
require_once("include/sidebar.php");
require_once("include/connection.php");

// Get the logged-in user's ID
$user_id = $_SESSION['username'];

// Retrieve the cart items for the logged-in user
$cartQuery = "SELECT cart.id AS cart_id, parking_slots.* FROM cart 
              JOIN parking_slots ON cart.slot_id = parking_slots.id 
              WHERE cart.user_id = ?";
$stmt = $conn->prepare($cartQuery);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$cartResult = $stmt->get_result();
$cartItems = [];
if ($cartResult) {
    while ($row = $cartResult->fetch_assoc()) {
        $cartItems[] = $row;
    }
}
$stmt->close();
?>

<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-shopping-cart"></i>
            <span class="text">Your Cart</span>
        </div>

        <!-- Payment Modal -->
        <div id="paymentModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Payment Form</h2>
                <form id="paymentForm">
                    <label for="cardNumber">Card Number:</label>
                    <input type="text" id="cardNumber" name="cardNumber" required minlength="16" maxlength="16">
                    <label for="expiryDate">Expiry Date (MM/YY):</label>
                    <input type="text" id="expiryDate" name="expiryDate" required pattern="\d{2}/\d{2}">
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" required minlength="3" maxlength="4">
                    <button type="submit" class="btn">Pay</button>
                </form>
            </div>
        </div>

        <!-- Display cart items as a table -->
        <div class="table-design">
            <form id="cartForm">
                <table>
                    <thead>
                    <tr>
                        <th>Select</th>
                        <th>Image</th>
                        <th>Faculty</th>
                        <th>Size</th>
                        <th>Status</th>
                        <th>Price per Hour</th>
                        <th>Amenities</th>
                        <th>Period</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $totalAmount = 0;
                    if (!empty($cartItems)) {
                        foreach ($cartItems as $item) {
                            $totalAmount += $item["price_per_hour"];
                            echo "<tr>";
                            echo "<td><input type='checkbox' name='cart_ids[]' value='" . $item['cart_id'] . "' class='item-checkbox' data-price='" . $item['price_per_hour'] . "'></td>";
                            echo "<td><img src='../images/" . htmlspecialchars($item["image"]) . "' alt='" . htmlspecialchars($item["image"]) . "' style='width:70px;height:auto;'></td>";
                            echo "<td>" . htmlspecialchars($item["faculty"]) . "</td>";
                            echo "<td>" . htmlspecialchars($item["size"]) . "</td>";
                            echo "<td>" . htmlspecialchars($item["status"]) . "</td>";
                            echo "<td>RM" . htmlspecialchars($item["price_per_hour"]) . "</td>";
                            echo "<td>" . htmlspecialchars($item["amenities"]) . "</td>";
                            // Add Period dropdown
                            echo "<td><select name='period[" . $item['cart_id'] . "]' class='period-dropdown' data-price='" . $item['price_per_hour'] . "'>";
                            for ($i = 1; $i <= 8; $i++) {
                                echo "<option value='" . $i . "'" . ($i === 1 ? " selected" : "") . ">" . $i . "</option>";
                            }
                            echo "</select></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No items in your cart</td></tr>";
                    }
                    ?>
                    </tbody>
                    <?php if (!empty($cartItems)) { ?>
                        <tfoot>
                        <tr>
                            <td colspan="6" style="border:none;"></td>
                            <td style="border:none">Total: RM<span id="total-amount"><?php echo number_format($totalAmount, 2); ?></span></td>
                            <td style="border: none"><button type="button" id="checkoutButton" class="btn">Checkout</button></td>
                        </tr>
                        </tfoot>
                    <?php } ?>
                </table>
            </form>
        </div>
    </div>
</div>

<?php require_once("include/footer.php"); ?>

<script src="assets/js/cart.js"></script>
