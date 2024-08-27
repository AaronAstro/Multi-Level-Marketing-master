<?php

require_once '../includes/config.php';
session_start();

if (isset($_POST['submit-otp'])) {

    $otp = mysqli_real_escape_string($conn, $_POST['OTP']);

    if (isset($_SESSION['recovery_user'])) {
        $user = $_SESSION['recovery_user'];

        if (confirmOTP($conn, $user['user_id'], $otp)) { // otp is correct
            $_SESSION['allow_new_pass'] = true;
            header('Location: ../index_recover.php');
            // TODO: Open change password form
        } else {
            $_SESSION['reset_error'] = "Your OTP is incorrect";
            header('Location: ../index_recover.php');
        }
    } else {
        echo 'user not found';
    }
}

function deleteOTP($conn, $user_id)
{
    $sql = "UPDATE `user_info` SET `otp` = NULL WHERE `user_id` = '$user_id'";

    try {
        if ($query = mysqli_query($conn, $sql)) {
            unset($_SESSION['allow_new_pass']);
        } else {
            throw new Exception("Error updating OTP: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        // Handle any exceptions or errors
        die('Execption ' . $e->getMessage());
    }
}

function confirmOTP($conn, $user_id, $otp)
{
    $sql = "SELECT `otp` FROM `user_info` WHERE `id` = '$user_id'";

    try {
        if ($query = mysqli_query($conn, $sql)) {
            $result = mysqli_fetch_assoc($query);
            return $otp === $result['otp'];
        } else {
            throw new Exception("Error updating OTP: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        // Handle any exceptions or errors
        die('Execption ' . $e->getMessage());
    }
}
