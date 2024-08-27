<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/getUserName.php';
include_once '../send_email.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (!isset($_POST['place_order'])) {
    $_SESSION['checkout_error'] = 'Incorrect request method'; // TODO: handle it in the checkout page
    header('Location: ../checkout.php');
}
//check if user has signed in
//      true -> just save the cart under the user
//      false -> then
// check if user is registered using email
//      true -> ask user to log in
//      false -> ask user to register username and password for if he / she needs to track the order


if (isset($_SESSION['user'])) {

    // Calculate total items and sum
    $cartSum = totalItems($cart);

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert into the Orders table and get the order_id
        if ($order_id = insertToOrderTable($conn, $_SESSION['user']['id'], $cartSum['totalItems'], $cartSum['sum'])) {
            echo $_SESSION['user']['id'] . ' : ' . $cartSum['totalItems'] . ' : ' . $cartSum['sum'] . ' inserted ';

            // Insert cart items into the OrderItems table
            foreach ($cart as $prod) {
                $product_id = $prod['id']; // Assuming your cart has product_id
                $quantity = intval($prod['quantity']);
                $price = doubleval($prod['price']);
                $totalPrice = $quantity * $price;

                if (!insertToOrderItemsTable($conn, $order_id, $product_id, $quantity, $price, $totalPrice)) {
                    throw new Exception("Failed to insert item $product_id into order items table");
                }

                // Update the stock in the Products table
                if (!updateProductStock($conn, $product_id, $quantity)) {
                    throw new Exception("Failed to update stock for product $product_id");
                }
            }

            //TODO: payment

            // Commit the transaction if everything is successful
            mysqli_commit($conn);
            $emailSent = sendCheckoutEmail(generateMessage($cart, $order_id), $_SESSION['user']['name'], $_SESSION['user']['email']); //send email with order items

            // confirm email is sent
            if (!$emailSent) {
                $res = [
                    'result' => true,
                    'order_id' => $order_id
                ];
                $_SESSION['order_email_error'] = $res;
            } else {
                $res = [
                    'result' => false,
                    'order_id' => $order_id
                ];
                $_SESSION['order_email_error'] = $res;
            }
            // FIXME: if user is an agent, calculate the appropriate commissions 
            // if (!isset($_SESSION['agent_info'])) {
            //     // TODO: link to msimisi and have him handle the necessary calculations
            //     // agent session, cart session

            //     die('user is an agent');
            // }

            header('Location: ../checkout.php');
        } else {
            throw new Exception("An error occurred during order insertion");
        }
    } catch (Exception $e) {
        // Rollback the transaction if any error occurs
        mysqli_rollback($conn);
        echo $e->getMessage();
    }
} else {
    #client is not logged in
    echo "Client is not logged in <br>";
    $f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
    $l_name = mysqli_real_escape_string($conn, $_POST['l_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $cell_number = mysqli_real_escape_string($conn, $_POST['cell_number']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

    // if client is a user and is not logged in
    // ask user to log in 
    if ($user = checkEmailOnDatabase($conn, $email)) {
        $directions = [
            'user_email' => $user['email'],
            'location' => 'checkout/index-checkout.php'
        ];
        $_SESSION['login_direction'] = $directions;
        header('Location: ../login.php');
        exit();
    }

    // register client as an customer 
    try {
        if (registerCustomer($conn, $f_name, $l_name, $email, $cell_number, $country, $city, $address)) {
            // redirect customer to create a password
            $directions = [
                'username' => $f_name . ' ' . $l_name,
                'email' => $email,
                'location' => 'checkout/index-checkout.php'
            ];
            $_SESSION['signup_customer'] = $directions;
            header('Location: ../signup.php');
            // sign up user and create user session. then return user back to this page
        } else {
            throw new Exception("An error occurred during order insertion");
        }
    } catch (\Throwable $th) {
        //throw $th;
    }
}

function registerCustomer($conn, $fname, $lname, $email, $cell_number, $country, $city, $address)
{
    // f_name	l_name	email	cell_number	country	city	address	
    $sql = "INSERT INTO `customer`(f_name, l_name, email, cell_number, country, city, address)
            VALUES('$fname', '$lname', '$email', '$cell_number', '$country', '$city', '$address')";
    // if(mysqli_query($conn, $sql)){
    //     return mysqli_insert_id($conn);
    // }
    // return false;

    return !(mysqli_query($conn, $sql) == false) ? mysqli_insert_id($conn) : false;
}

function checkEmailOnDatabase($conn, $email)
{
    $sql = "SELECT * FROM  `user_info` WHERE `email` = '$email'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        $result = mysqli_fetch_assoc($query);
        $user = [
            'user_id' => $result['id'],
            'name' => $result['name'],
            'email' => $result['email'],
            'is_agent' => $result['is_agent'] == '1',
            'is_customer' => $result['is_customer'] == '1'
        ];

        return $user;
    }
    return false;
}

function updateProductStock($conn, $product_id, $quantity)
{
    $sql = "UPDATE `products` SET `stock_number` = `stock_number` - $quantity 
            WHERE `id` = $product_id AND `stock_number` >= $quantity";

    return mysqli_query($conn, $sql);
}

function generateMessage($cart, $order_id)
{
    $msg = "Order id: " . $order_id . "\n\n";
    foreach ($cart as $prod) {
        $name = $prod['name'];
        $quantity = intval($prod['quantity']);
        $price = doubleval($prod['price']);
        $totalPrice = $quantity * $price;

        $msg .= $quantity . " of " . $name . " at E" . $price . ". Total at $" . $totalPrice . "\n";
    }

    return $msg;
}

function sendCheckoutEmail($msg, $agentName, $agentEmail)
{
    $subject = "Order Summary";
    $body = "Dear $agentName,\nHere is your order summary:\n\n$msg\n\nThank you for your support.\n\nBest regards,\nDroxford Foods";

    $fromEmail = 'chris24ncele@gmail.com';
    $fromName = 'Droxford Foods';

    if (sendEmail($fromEmail, $fromName, $agentEmail, $subject, $body)) {
        // echo "Email sent successfully.";
        return true;
    } else {
        return false;
    }
}

function totalItems($cart)
{
    $totalItems = 0;
    $sum = 0;
    foreach ($cart as $prod) {
        $quant = intval($prod['quantity']);
        $price = doubleval($prod['price']) * $quant;

        $totalItems += $quant;
        $sum += $price;
    }

    $totalItemsAndSum = [
        'totalItems' => $totalItems,
        'sum' => $sum
    ];
    return $totalItemsAndSum;
}

function insertToOrderTable($conn, $user_id, $total_items, $total_amount)
{
    $sql = "INSERT INTO `orders`(`user_id`, `total_items`, `total_amount`, `created_at`) 
            VALUES($user_id, $total_items, $total_amount, NOW())";

    if (mysqli_query($conn, $sql)) {
        return mysqli_insert_id($conn); // Return the order_id
    }
    return false; // Return false if the insertion fails
}

function insertToOrderItemsTable($conn, $order_id, $product_id, $quantity, $price, $totalPrice)
{
    $sql = "INSERT INTO `order_items`(`order_id`, `product_id`, `quantity`, `price_at_purchase`, `total_price_at_purchase`) 
            VALUES($order_id, $product_id, $quantity, $price, $totalPrice)";

    return mysqli_query($conn, $sql);
}
