<?php

include 'includes/config.php';
session_start();

if (isset($_POST['submit'])) {

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_info` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if (mysqli_num_rows($select) > 0) {
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      if (isset($_SESSION['login_direction'])) {
         header('location: ' . $_SESSION['login_direction']['location']);
         unset($_SESSION['login_direction']);
         exit();
      }
      header('location:index.php');
   } else {
      $login_detail = [
         'logged_email' => $email,
         'message' => 'Incorrect login details.'
      ];
      $_SESSION['incorrect_login'] = $login_detail;
   }
}

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



   <section class="signin-section" style="background-image: url('images/log.png');">

      <form action="" method="post" class="auth-form">
         <h1>Log In</h1>
         <?php

         if (isset($_SESSION['login_direction'])) {
            echo '<p>Please Enter Your Log in credentials.</p>';
         }

         ?>

         <div class="input-section">
            <img src="images/contact.png" alt="" class="icon">
            <?php
            if (isset($_SESSION['login_direction'])) {

               echo '<input type="text" name="email" id="email" value="' . $_SESSION['login_direction']['user_email'] . '" placeholder="Email">';
            } else if (isset($_SESSION['incorrect_login'])) {
               echo '<input type="text" name="email" id="email" value="' . $_SESSION['incorrect_login']['logged_email'] . '" placeholder="Email">';
            } else
               echo '<input type="text" name="email" id="email"  placeholder="Email">';
            ?>
         </div>
         <div class="input-section">
            <img src="images/lock.png" alt="" class="icon">
            <input type="password" name="password" id="password" placeholder="Password">
         </div>
         <input type="submit" name="submit" value="Sign In">

         <div class="social-log">
            <img src="images/facebook-icon.png" alt="Facebook" class="icon">
            <img src="images/google-icon.png" alt="Google" class="icon">
         </div>
         <div class="end-links">
            <a href="index_recover.php">Forgot your password?</a>
            <a href="signup.php">Create a new account</a>
         </div>
      </form>
   </section>

</body>

<script src="js/main.js"></script>

<?php
if (isset($_SESSION['incorrect_login'])) {
   echo '<script> alert("' . $_SESSION['incorrect_login']['message'] . '"); </script>';
   unset($_SESSION['incorrect_login']);
}
?>

</html>