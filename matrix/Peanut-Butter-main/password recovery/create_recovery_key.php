<?php

require_once '../includes/config.php';
session_start();

require_once '../send_email.php';

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (!checkEmail($conn, $email)) {
        // TODO: return to add email and give error
        $_SESSION['recovery_error'] = 'Email not found.';
        header('Location: ../index_recover.php');
        exit();
    }

    // TODO: create unique OTP

    $otp = generateOTP(6);

    if (insertOTP($conn, $otp, $email)) { // insert otp in user_info        

        $agentName = $_SESSION['recovery_user']['name'];
        $agentEmail = $email;
        $subject = "Password recovery";
        $body = "Dear $agentName,\nYou have requested a password reset on your email.\n\nYour One Time Pin is: $otp.\n\nIf this was not you, please contact us immediately. \nBest regards,\nDroxford Foods";

        // function sendEmail($fromEmail, $fromName, $toEmail, $subject, $body) {
        $fromEmail = 'chris24ncele@gmail.com';
        $fromName = 'Droxford Foods';

        if (sendEmail($fromEmail, $fromName, $agentEmail, $subject, $body)) {
            otpSent(true);
        } else {
            otpSent(false);
        }
    }
}

function otpSent($isSuccessful)
{
    $_SESSION['otp_sent'] = $isSuccessful;
    header('Location: ../index_recover.php');
    exit();
}


function insertOTP($conn, $otp, $email)
{
    $sql = "UPDATE `user_info` SET `otp` = '$otp' WHERE `email` = '$email'";

    try {
        // Execute the query
        if (mysqli_query($conn, $sql)) {
            echo "OTP updated successfully.";
            return true;
        } else {
            throw new Exception("Error updating OTP: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        // Handle any exceptions or errors
        return false;
    }
}

function checkEmail($conn, $email)
{
    $sql = "SELECT * FROM `user_info` WHERE `email` = '$email'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        $result = mysqli_fetch_assoc($query);

        $data = [
            'user_id' => $result['id'],
            'name' => $result['name'],
            'email' => $result['email']
        ];

        $_SESSION['recovery_user'] = $data;

        return true;
    } else return false;
}

function generateOTP($length)
{
    // Define the characters allowed in the OTP (numbers and letters)
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = '0123456789';

    $otp = '';

    // Loop to generate a random string of the specified length
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $otp;
}
