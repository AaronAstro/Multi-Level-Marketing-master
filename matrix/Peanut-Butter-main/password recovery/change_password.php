<?php

require_once '../includes/config.php';
session_start();


if (isset($_POST['change_password'])  && isset($_SESSION['recovery_user'])) {

    $user = $_SESSION['recovery_user'];
    echo 'attempting to change password';

    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $passwordC = mysqli_real_escape_string($conn, $_POST['password']);

    if ($password === $passwordC) {
        echo 'pass entered';
        //insert new pass
        $pass = md5($password);


        if (setNewPassword($conn, $user, $pass)) {
            // alert password changed successfully

            header('Location: ../index_recover.php');
            $_SESSION['password_changed'] = "Your password has been changed successfully";

            unset($_SESSION['recovery_user']);
            unset($_SESSION['otp_sent']);
            unset($_SESSION['allow_new_pass']);
        }
    }
} else {
    echo 'anosnoajsncojasncojasn';
}


function setNewPassword($conn, $user, $password)
{
    $user_id = $user['user_id'];
    $user_email = $user['email'];

    $sql = "UPDATE `user_info` SET `password` = '$password' WHERE `id` = '$user_id' AND `email` = '$user_email'";

    try {
        // Execute the query
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            throw new Exception("Error updating OTP: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        // Handle any exceptions or errors
        die('Execption ' . $e->getMessage());
    }
}
