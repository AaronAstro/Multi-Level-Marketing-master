<?php

session_start();
include 'includes/config.php';

if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   if (hasDuplicate($conn, $name, $pass)) {
      $_SESSION['signup-error'] = 'User already exists!';
   } else if (duplicateEmail($conn, $email)) {
      $_SESSION['signup-error'] = 'Email already taken';
   } else {
      // signup the user
      if (insertUser($conn, $name, $email, $pass)) {
         logUserIn($conn, $name, $email, $pass);
      }
      // include_once 'includes/getUserName.php';
   }
}

function logUserIn($conn, $name, $email, $pass)
{
   $sql = "SELECT * FROM `user_info` WHERE email = '$email' AND password = '$pass'";
   $query = mysqli_query($conn, $sql) or die('query failed');

   if (mysqli_num_rows($query) > 0) {
      $row = mysqli_fetch_assoc($query);
      $_SESSION['user_id'] = $row['id'];
      if (isset($_SESSION['signup_customer'])) {
         header('location: ' . $_SESSION['signup_customer']['location']);
         exit();
      }
      header('location:index.php');
   }
}

function insertUser($conn, $name, $email, $pass)
{
   $sql = "";
   if (isset($_SESSION['signup_customer']))
      $sql = "INSERT INTO `user_info`(name, email, password, is_customer) VALUES('$name', '$email', '$pass', 1)";
   else
      $sql = "INSERT INTO `user_info`(name, email, password) VALUES('$name', '$email', '$pass')";

   return mysqli_query($conn, $sql);
}

// FIXME: check duplicate using username, email, and password
function hasDuplicate($conn, $name, $pass)
{
   $sql = "SELECT * FROM `user_info` WHERE name = '$name' AND password = '$pass'";
   $query = mysqli_query($conn, $sql);

   return mysqli_num_rows($query) > 0 ? true : false;
}

function duplicateEmail($conn, $email)
{
   $sql = "SELECT * FROM `user_info` WHERE email = '$email'";
   $query = mysqli_query($conn, $sql);

   return mysqli_num_rows($query) > 0 ? true : false;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Droxford Foods | Sign up</title>
   <link rel="stylesheet" href="css/auth-style.css">
   <?php require_once('templates/header.php'); ?>

<body>

   <?php
   if (isset($_SESSION['signup-error'])) {
      echo "<script>alert('" . $_SESSION['signup-error'] . "')</script>";
      unset($_SESSION['signup-error']);
   }
   ?>


   <section class="signin-section" style="background-image: url('images/log.png');">

      <form action="signup.php" method="post" class="auth-form" onsubmit="return validateForm()">
         <h1 class="reg-h1">Signup Now</h1>

         <?php
         if (isset($_SESSION['signup_customer'])) {
            echo '<p>Please create a password so we can log you in for your purchase.</p>';
         }
         ?>

         <div class="input-section">
            <img src="images/user.png" alt="" class="icon">
            <?php
            if (isset($_SESSION['signup_customer'])) {
               echo '<input type="text" name="name" id="name" value="' . $_SESSION['signup_customer']['username'] . '">';
            } else {
               echo '<input type="text" name="name" id="name" placeholder="Username">';
            }
            ?>
         </div>
         <span id="nameError" class="error-message"></span>

         <div class="input-section">
            <img src="images/contact.png" alt="" class="icon">
            <?php
            if (isset($_SESSION['signup_customer'])) {
               echo '<input type="text" name="email" id="email" value="' . $_SESSION['signup_customer']['email'] . '">';
            } else {
               echo '<input type="email" name="email" id="email" placeholder="Email">';
            }
            ?>

         </div>
         <span id="emailError" class="error-message"></span>

         <div class="input-section">
            <img src="images/lock.png" alt="" class="icon">
            <input type="password" name="password" id="password" placeholder="Password">
         </div>
         <span id="passwordError" class="error-message"></span>

         <div class="input-section">
            <img src="images/lock.png" alt="" class="icon">
            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password">
         </div>
         <span id="cpasswordError" class="error-message"></span>

         <input type="submit" name="submit" class="btn" value="Signup">

         <div class="social-log">
            <img src="images/facebook-icon.png" alt="Facebook" class="icon">
            <img src="images/google-icon.png" alt="Google" class="icon">
         </div>

         <div class="end-links">
            <p>Already have an account? <a href="login.php" style="display: inline;">Login now</a></p>
         </div>
      </form>

   </section>


</body>

<script>
   function validateForm() {
      let isValid = true;

      // Clear previous error messages
      document.querySelectorAll('.error-message').forEach(error => error.style.display = 'none');

      // Validate Username
      const username = document.getElementById('name').value;
      if (username === '') {
         document.getElementById('nameError').textContent = 'Username is required';
         document.getElementById('nameError').style.display = 'block';
         isValid = false;
      }

      // Validate Email
      const email = document.getElementById('email').value;
      const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      if (email === '') {
         document.getElementById('emailError').textContent = 'Email is required';
         document.getElementById('emailError').style.display = 'block';
         isValid = false;
      } else if (!emailPattern.test(email)) {
         document.getElementById('emailError').textContent = 'Please enter a valid email address';
         document.getElementById('emailError').style.display = 'block';
         isValid = false;
      }

      // Validate Password
      const password = document.getElementById('password').value;
      if (password === '') {
         document.getElementById('passwordError').textContent = 'Password is required';
         document.getElementById('passwordError').style.display = 'block';
         isValid = false;
      } else if (password.length < 8) {
         document.getElementById('passwordError').textContent = 'Password must be at least 8 characters long';
         document.getElementById('passwordError').style.display = 'block';
         isValid = false;
      }

      // Validate Confirm Password
      const confirmPassword = document.getElementById('cpassword').value;
      if (confirmPassword !== password) {
         document.getElementById('cpasswordError').textContent = 'Passwords do not match';
         document.getElementById('cpasswordError').style.display = 'block';
         isValid = false;
      }

      return isValid;
   }
</script>

<script src="js/main.js"></script>

</html>