<?php
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


    <section class="signin-section" style="background-image: url('images/logo1.png');">

        <form action="/includes/signin.php" method="post" class="auth-form">
            <h1>Sign In</h1>
            <div class="input-section">
                <img src="images/contact.png" alt="" class="icon">
                <input type="text" name="email" id="email" placeholder="Email">
            </div>
            <div class="input-section">
                <img src="images/lock.png" alt="" class="icon">
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <input type="submit" name="sign_in" value="Sign In">

            <div class="social-log">
                <img src="images/facebook-icon.png" alt="Facebook" class="icon">
                <img src="images/google-icon.png" alt="Google" class="icon">
            </div>
            <div class="end-links">
                <a href="#recover-password">Forgot your password?</a>
                <a href="#register">Create a new account</a>
            </div>
        </form>
    </section>
</body>

</html>