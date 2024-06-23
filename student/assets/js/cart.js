// Get the modal
var modal = document.getElementById('paymentModal');

// Get the button that opens the modal
var checkoutButton = document.getElementById('checkoutButton');


// Get the <span> element that closes the modal
var span = document.getElementsByClassName('close')[0];

// When the user clicks the button, open the modal
checkoutButton.addEventListener('click', function(event) {
    event.preventDefault();

    let selectedItems = document.querySelectorAll('.item-checkbox:checked');

    if (selectedItems.length === 0) {
        alert("Please select at least one item to checkout.");
        return;
    }
    modal.style.display = "block";
});

// When the user clicks on <span> (x), close the modal
span.addEventListener('click', function() {
    modal.style.display = "none";
});

// When the user clicks anywhere outside of the modal, close it
window.addEventListener('click', function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});

// Payment form validation and submission
document.getElementById('paymentForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let cardNumber = document.getElementById('cardNumber').value;
    let expiryDate = document.getElementById('expiryDate').value;
    let cvv = document.getElementById('cvv').value;

    if (cardNumber.length !== 16) {
        alert("Card number must be 16 digits long.");
        return;
    }

    if (!/^\d{2}\/\d{2}$/.test(expiryDate)) {
        alert("Expiry date must be in MM/YY format.");
        return;
    }

    if (cvv.length < 3 || cvv.length > 4) {
        alert("CVV must be 3 or 4 digits long.");
        return;
    }

    // Collect selected items and periods
    let selectedItems = document.querySelectorAll('.item-checkbox:checked');
    let selectedData = [];
    selectedItems.forEach(item => {
        let period = document.querySelector('select[name="period[' + item.value + ']"]').value;
        selectedData.push({
            id: item.value,
            period: period
        });
    });


    // Prepare form data for submission
    let formData = new FormData();
    formData.append('cardNumber', cardNumber);
    formData.append('expiryDate', expiryDate);
    formData.append('cvv', cvv);
    formData.append('amount', document.getElementById('total-amount').textContent);
    formData.append('selectedData', JSON.stringify(selectedData));

    // Submit the form data to checkout.php
    fetch('helpers/checkout.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            window.location.href = 'cart.php'; // Redirect to cart.php
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

// Calculate the total amount based on selected items and periods
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.item-checkbox:checked').forEach(checked => {
        const price = parseFloat(checked.getAttribute('data-price'));
        const period = parseInt(document.querySelector('select[name="period[' + checked.value + ']"]').value);
        total += price * period;
    });
    document.getElementById('total-amount').textContent = total.toFixed(2);
}

// Add event listeners to recalculate total when items or periods change
document.querySelectorAll('.item-checkbox, .period-dropdown').forEach(element => {
    element.addEventListener('change', calculateTotal);
});

// Initialize the total amount calculation
calculateTotal();
