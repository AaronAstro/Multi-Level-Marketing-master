<?php

require_once 'getUserName.php';
require_once '../send_email.php';

if (!isset($_POST['register_agent'])) {
    registrationError('Incorrect registration method. Please use the submit button.');
}

if (!isset($_POST['ts_cs'])) {
    registrationError('You must accept the terms and conditions to register.');
}

// Retrieve and sanitize form inputs
$f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
$l_name = mysqli_real_escape_string($conn, $_POST['l_name']);
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
$id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
$date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$cell_number = mysqli_real_escape_string($conn, $_POST['cell_number']);
$country = mysqli_real_escape_string($conn, $_POST['country']);
$city = mysqli_real_escape_string($conn, $_POST['city']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
$account_num = mysqli_real_escape_string($conn, $_POST['account_num']);
$branch_num = mysqli_real_escape_string($conn, $_POST['branch_num']);
$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session


// Insert data into the database
$sql = "INSERT INTO agent (
    `first name`, `last name`, `gender`, `national_id`, `date_of_birth`, `email`, `cell_number`,
    `country`, `city`, `address`, `bank_name`, `account`, `branch_code`, `user_id`
) VALUES (
    '$f_name', '$l_name', '$gender', '$id_number', '$date_of_birth', '$email', '$cell_number',
    '$country', '$city', '$address', '$bank_name', '$account_num', '$branch_num', '$user_id'
)";

// Remove duplicate emails
if (hasEmailDuplicate($conn, $email)) {
    registrationError('Email is already taken.');
}

// insert agent details on db
if (mysqli_query($conn, $sql)) {


    editUserAccount($conn, $email); // Update user account at user_info table
    getAgent($conn, $email); // create session ['agent_info'] contains details about the agent

    // send confirmation email
    $agentName = $f_name . ' ' . $l_name;
    $agentEmail = $email;
    $subject = "Welcome to Our Platform!";
    $body = "Dear $agentName,\nThank you for registering as an agent with us. We are excited to have you on board!\nThis will be the email that we will use to contact you. \nBest regards,\nDroxford Foods";

    // function sendEmail($fromEmail, $fromName, $toEmail, $subject, $body) {
    $fromEmail = 'chris24ncele@gmail.com';
    $fromName = 'Droxford Foods';

    if (sendEmail($fromEmail, $fromName, $agentEmail, $subject, $body)) {
        // echo "Email sent successfully.";
        registrationSuccessful('Registration was successful. Check your email.');
    } else {
        registrationSuccessful('Registration was successful. Please confirm your email address on yur profile.');
    }
} else {
    // redirect user to agent-registration page. Display the error
    registrationError('A database write error occurred. Please Contact us if you see this message.');
}


// update user profile of user_info
function editUserAccount($conn, $email)
{
    $sql = "UPDATE `user_info` SET `is_agent` = TRUE WHERE `email` = '$email'";
    return mysqli_query($conn, $sql);
}

function hasEmailDuplicate($conn, $email)
{
    $sql = "SELECT * FROM agent WHERE email = '$email'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        return true;
    }
    return false;
}

function registrationSuccessful($msg)
{
    $_SESSION['registration-success'] = $msg;

    if (file_exists('../profile.php')) {
        header('Location: ../profile.php');
    } else {
        header('Location: ../shop.php');
    }
}

function registrationError($msg)
{
    $_SESSION['registration-error'] = $msg;
    header('Location: ../agent-registration.php');
    exit();
}
