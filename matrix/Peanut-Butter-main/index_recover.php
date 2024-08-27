<?php

include 'includes/config.php';
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Droxford Foods | Sign in</title>
   <link rel="stylesheet" href="css/auth-style.css">
   <?php require_once('templates/header.php'); ?>

<body>

   <?php
   if (isset($_SESSION['password_changed'])) {
      echo '<script> alert("' . $_SESSION['password_changed'] . '"); </script>';
      unset($_SESSION['password_changed']);
   }


   ?>

   <section class="signin-section" style="background-image: url('images/log.png');">

      <?php
      if (!isset($_SESSION['otp_sent'])) { // if the otp has not been sent yet
      ?>
         <form action="password recovery/create_recovery_key.php" method="post" class="auth-form">
            <h1>Reset Password</h1>
            <!-- <p style="margin-left: 15px">Please enter your email address</p> -->


            <div class="input-section" style="margin-top: 35px;">
               <img src="images/contact.png" alt="" class="icon">
               <input type="text" name="email" id="email" placeholder="Email">
            </div>
            <?php
            if (isset($_SESSION['recovery_error'])) {
               echo '<span id="emailError" class="error-message" style="display:inline;">'
                  . $_SESSION['recovery_error'] .
                  '</span>';
            }
            ?>

            <input type="submit" name="submit" value="Submit">
            <div class="end-links">
               <a href="login.php">Back to login</a>
            </div>
         </form>

         <?php } else {
         if (!isset($_SESSION['allow_new_pass'])) { ?>
            <!-- 
            TODO: use js to confirm if the otp is correct and the display the inputs for password
             -->
            <form action="password recovery/confirm_otp.php" method="post" class="auth-form">
               <h1>Enter your OTP </h1>
               <span style="color:black">Your One Time Pin (OTP) has been send to your email. Please enter it here so we know it you.</span>
               <input type="text" name="OTP" placeholder="######">

               <?php
               if (isset($_SESSION['reset_error'])) {
                  echo '<span >' . $_SESSION['reset_error'] . '</span>';
                  unset($_SESSION['reset_error']);
               }

               ?>

               <input type="submit" name="submit-otp" value="Change Password">
            </form>
      <?php
         }
      }
      ?>

      <?php
      if (isset($_SESSION['allow_new_pass']) and $_SESSION['allow_new_pass'] == true) { ?>

         <form action="password recovery/change_password.php" method="post" class="auth-form">
            <h2>Create new password</h2>
            <div class="input-section" style="margin-top: 35px;">
               <img src="images/lock.png" alt="" class="icon">
               <input type="password" name="password" id="password" placeholder="Enter new password">
            </div>
            <div class="input-section" style="margin-top: 35px;">
               <img src="images/lock.png" alt="" class="icon">
               <input type="password" name="passwordC" id="passwordC" placeholder="Confirm your password">
            </div>
            <input type="submit" name="change_password" value="Change Password">
         </form>

      <?php
      }
      ?>



   </section>

</body>

<script src="js/main.js"></script>

</html>