<?php
session_start(); // Start the session

// Function to calculate the total sum of cart items
function calculateCartTotal()
{
    $total = 0;

    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            if (isset($item['price']) && isset($item['quantity'])) {
                $total += $item['price'] * $item['quantity'];
            }
        }
    }

    return number_format($total, 2); // Format the total to 2 decimal places
}

// Calculate the total
$total = calculateCartTotal();

// Output the total as JSON
header('Content-Type: application/json');
echo json_encode(['total' => $total]);
