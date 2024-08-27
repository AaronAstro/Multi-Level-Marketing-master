<?php
session_start();

// Check if cart-items session exists, if not, initialize it as an empty array
if (!isset($_SESSION['cart-items'])) {
    $_SESSION['cart-items'] = array();
}

// Retrieve POST data
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
$product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
$product_price = isset($_POST['product_price']) ? $_POST['product_price'] : '';

// Add the product to the cart-items session
$_SESSION['cart-items'][] = array(
    'id' => $product_id,
    'name' => $product_name,
    'price' => $product_price
);

// Optionally, you can return a response
echo json_encode(array('status' => 'success'));
