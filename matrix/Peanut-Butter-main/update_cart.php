<?php
session_start(); // Start the session

// Set content type to JSON
header('Content-Type: application/json');

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

$response = ['success' => false, 'message' => 'Invalid request'];

if ($data) {
    if (isset($data['action'])) {
        $productId = $data['id'];

        switch ($data['action']) {
            case 'remove':
                // Handle item removal
                if (isset($_SESSION['cart'][$productId])) {
                    unset($_SESSION['cart'][$productId]);
                    $response = ['success' => true, 'message' => 'Item removed from cart', 'cart' => $_SESSION['cart']];
                } else {
                    $response = ['success' => false, 'message' => 'Item not found in cart'];
                }
                break;

            case 'increment':
                // Handle item increment
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += 1; // Increase quantity
                    $response = ['success' => true, 'message' => 'Item quantity increased', 'cart' => $_SESSION['cart']];
                } else {
                    $response = ['success' => false, 'message' => 'Item not found in cart'];
                }
                break;

            case 'decrement':
                // Handle item decrement
                if (isset($_SESSION['cart'][$productId])) {
                    if ($_SESSION['cart'][$productId]['quantity'] > 1) {
                        $_SESSION['cart'][$productId]['quantity'] -= 1; // Decrease quantity
                        $response = ['success' => true, 'message' => 'Item quantity decreased', 'cart' => $_SESSION['cart']];
                    } else {
                        // If quantity is 1, remove the item
                        unset($_SESSION['cart'][$productId]);
                        $response = ['success' => true, 'message' => 'Item removed from cart', 'cart' => $_SESSION['cart']];
                    }
                } else {
                    $response = ['success' => false, 'message' => 'Item not found in cart'];
                }
                break;

            default:
                $response = ['success' => false, 'message' => 'Invalid action'];
                break;
        }
    } else if (isset($data['id']) && isset($data['name']) && isset($data['price'])) {
        // Handle adding items to the cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $productId = $data['id'];
        $productName = $data['name'];
        $productPrice = $data['price'];
        $productDescription = isset($data['description']) ? $data['description'] : '';
        $productImage = isset($data['image']) ? $data['image'] : '';
        $productStockNumber = $data['stockNumber'];


        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += 1; // Increase quantity
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => 1,
                'description' => $productDescription,
                'stockNumber' => $productStockNumber,
                'image' => $productImage
            ];
        }

        $response = ['success' => true, 'message' => 'Cart updated', 'cart' => $_SESSION['cart']];
    } else {
        $response = ['success' => false, 'message' => 'Invalid data'];
    }
}

// Output the JSON response
echo json_encode($response);
