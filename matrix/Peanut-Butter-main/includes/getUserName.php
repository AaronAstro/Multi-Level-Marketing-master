<?php

require_once 'config.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    //update 
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT `name`, `email`, `is_agent`, `is_customer`  FROM `user_info` WHERE `id` = $user_id";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $result = mysqli_fetch_assoc($query);

        $user = [
            'id' => $user_id,
            'name' => $result['name'],
            'email' => $result['email'],
            'is_agent' => $result['is_agent'] == 1,
            'is_customer' => $result['is_customer'] == 1
        ];

        getAgent($conn, $result['email']); // get agent details
        getCustomer($conn,  $result['email']); //get email details

        $_SESSION['user_name'] = $result['name'];
        $_SESSION['user'] = $user;
    }
}
/*  can use user id to locate all agent accounts linked to one user */
/*  this function uses an email to locate the first account */
function getAgent($conn, $email)
{
    $sql = "SELECT * FROM agent WHERE email = '$email'";
    $query = mysqli_query($conn, $sql);


    if (mysqli_num_rows($query) > 0) {
        $result = mysqli_fetch_assoc($query);

        $agentArray = [
            'agent_id' => $result['agent_id'],
            'first_name' => $result['first name'],
            'last_name' => $result['last name'],
            'gender' => $result['gender'],
            'national_id' => $result['national_id'],
            'email' => $result['email'],
            // something is missing
            'country' => $result['country'],
            'city' => $result['city'],
            'address' => $result['address'],
            // something is missing
            'user_id' => $result['user_id']
        ];

        $_SESSION['agent_info'] = $agentArray;

        // $_SESSION['agent_id'] = $result['agent_id'];
        // echo $result['agent_id'];
    }
}

function getCustomer($conn,  $email)
{
    $sql = "SELECT * FROM customer WHERE email = '$email'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        $result = mysqli_fetch_assoc($query);

        $customer = [
            'customer_id' => $result['id'],
            'f_name' => $result['f_name'],
            'l_name' => $result['l_name'],
            'email' => $result['email'],
            'cell_number' => $result['cell_number'],
            'country' => $result['country'],
            'city' => $result['city'],
            'address' => $result['address']
        ];

        $_SESSION['customer_info'] = $customer;
    }
}
