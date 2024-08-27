<?php

include_once 'includes/getUserName.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Droxford Foods | Agent Registration</title>
    <!-- <link rel="stylesheet" href="css/contact-style.css"> -->
    <link rel="stylesheet" href="css/agent-regi-style.css">
    <?php require_once('templates/header.php'); ?>

    <?php
    if (isset($_SESSION['registration-error'])) {
        echo '<script> alert("' . $_SESSION['registration-error'] . '")</script>';
        unset($_SESSION['registration-error']);
    }

    ?>

    <section class="main-section-about">
        <div class="contact-form ">
            <div class="wrapper">
                <h1> <span>Agent</span> Registration.</h1>

                <?php if (!isset($_SESSION['user_id'])) { ?>

                    <p>Please create a user account or login.</p><a href="login.php">Click here</a>
                <?php } else {
                    if (isset($_SESSION['user'])) {
                        // TODO: check if user is already an agent
                        // $userIsAgent = $_SESSION['user']['is_agent'];
                        $userEmail = $_SESSION['user']['email'];

                        $sql = "SELECT * FROM `agent` WHERE  `email` = '$userEmail'";
                        $query = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($query) > 0) {
                            // FIXME: tell user the email is already taken. create a new account.
                            $result = mysqli_fetch_assoc($query);
                        }
                    }
                }

                if (isset($_SESSION['agent_info'])) { ?>
                    <p>It appears you already have an account. To add another, use another email address and complete the form.</p>
                <?php } ?>

                <form action="includes/register-agent.php" method="post" class="form-contact">
                    <div class="form-sections">
                        <!-- Personal Details Section -->
                        <div id="personal-details" class="form-section">
                            <h2>Personal</h2>
                            <div class="input-group">
                                <label for="f_name">First Name:</label>
                                <?php
                                if (isset($_SESSION['agent_info'])) {
                                    echo '<input type="text" id="f_name" name="f_name" value="' . htmlspecialchars($_SESSION['agent_info']['first_name']) . '" placeholder="John">';
                                } else
                                    echo '<input type="text" id="f_name" name="f_name" placeholder="John">';
                                ?>
                            </div>
                            <span id="f_nameError" class="error-message"></span>
                            <div class="input-group">
                                <label for="l_name">Last Name:</label>
                                <?php
                                if (isset($_SESSION['agent_info'])) {
                                    echo '<input type="text" id="l_name" name="l_name" value="' . htmlspecialchars($_SESSION['agent_info']['last_name']) . '" placeholder="Doe">';
                                } else
                                    echo '<input type="text" id="l_name" name="l_name" placeholder="Doe">';
                                ?>

                            </div>
                            <span id="f_nameError" class="error-message"></span>
                            <div class="input-group">

                                <label for="gender">Gender:</label>
                                <div id="gender">
                                    <div class="option" style="display: flex;">
                                        <!-- <input type="radio" id="male" name="gender" value="Male"> -->
                                        <input type="radio" id="male" name="gender" value="Male"
                                            <?php if (isset($_SESSION['agent_info']['gender']) && $_SESSION['agent_info']['gender'] == 'Male') echo 'checked'; ?>>
                                        <label for="male" style="margin: 0;">Male</label>
                                    </div>

                                    <div class="option" style="display: flex; ">
                                        <!-- <input type="radio" id="female" name="gender" value="Female"> -->
                                        <input type="radio" id="female" name="gender" value="Female"
                                            <?php if (isset($_SESSION['agent_info']['gender']) && $_SESSION['agent_info']['gender'] == 'Female') echo 'checked'; ?>>
                                        <label for="female" style="margin: 0;">Female</label>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group">
                                <label for="id_number">National ID:</label>
                                <?php
                                if (isset($_SESSION['agent_info'])) {
                                    echo '<input type="text" id="id_number" name="id_number" value="' . htmlspecialchars($_SESSION['agent_info']['national_id']) . '"  onchange="validateIDNumber()">';
                                } else
                                    echo '<input type="text" id="id_number" name="id_number" placeholder="#############" onchange="validateIDNumber()">';
                                ?>

                            </div>
                            <span id="id_numberError" class="error-message"></span>
                            <div class="input-group">
                                <label for="date_of_birth">Date of Birth:</label>
                                <input type="date" id="date_of_birth" name="date_of_birth">
                            </div>
                            <span id="dobError" class="error-message"></span>
                            <div class="input-group">
                                <label for="email">Email:</label>
                                <?php
                                if (isset($_SESSION['user'])) {

                                    $email = $_SESSION['user']['email'];
                                    echo '<input type="text" id="email" name="email" value="' . htmlspecialchars($email) . '">';
                                } else
                                    echo '<input type="text" id="email" name="email" placeholder="johndoe@gmail.com">';
                                ?>

                            </div>
                            <span id="emailError" class="error-message"></span>
                            <div class="input-group">
                                <label for="cell_number">Cell Number:</label>
                                <input type="text" id="cell_number" name="cell_number" placeholder="+268########" onchange="validatePhoneNumber()">
                            </div>
                            <span id="cell_numberError" class="error-message"></span>
                        </div>

                        <!-- Address Section -->
                        <div id="address-details" class="form-section">
                            <h2>Address</h2>
                            <div class="input-group">
                                <label for="country">Country:</label>
                                <?php
                                if (isset($_SESSION['agent_info'])) {
                                    echo '<input type="text" id="country" name="country" value="' . htmlspecialchars($_SESSION['agent_info']['country']) . '" placeholder="Country">';
                                } else
                                    echo '<input type="text" id="country" name="country" placeholder="Country">';
                                ?>

                            </div>
                            <div class="input-group">
                                <label for="city">City:</label>
                                <?php
                                if (isset($_SESSION['agent_info'])) {
                                    echo '<input type="text" id="city" name="city" value="' . htmlspecialchars($_SESSION['agent_info']['city']) . '" placeholder="City">';
                                } else
                                    echo '<input type="text" id="city" name="city" placeholder="City">';
                                ?>

                            </div>
                            <div class="input-group">
                                <label for="address">Address:</label>
                                <?php
                                if (isset($_SESSION['agent_info'])) {
                                    echo '<textarea name="address" id="address">' . htmlspecialchars($_SESSION['agent_info']['address']) . '</textarea>';
                                } else
                                    echo '<textarea name="address" id="address"></textarea>';
                                ?>

                            </div>
                        </div>

                        <!-- Bank Details Section -->
                        <div id="bank-details" class="form-section">
                            <h2>Bank Account Details</h2>
                            <div class="input-group">
                                <label for="bank_name">Bank Name:</label>
                                <input type="text" id="bank_name" name="bank_name" list="banks" placeholder="Select Your Bank">
                                <datalist id="banks">
                                    <option value="First National Bank">First National Bank</option>
                                    <option value="NedBank Swaziland Ltd">NedBank Swaziland Ltd</option>
                                    <option value="Standard Bank Swaziland">Standard Bank Swaziland</option>
                                    <option value="Eswatini Bank">Eswatini Bank</option>
                                </datalist>
                            </div>
                            <div class="input-group">
                                <label for="account_num">Account Number:</label>
                                <input type="text" id="account_num" name="account_num" placeholder="333-333-33" oninput="formatAccountNumber(this)">
                            </div>
                            <div class="input-group">
                                <label for="branch_num">Branch Number:</label>
                                <input type="text" id="branch_num" name="branch_num" placeholder="123456">
                            </div>
                            <!-- <div class="input-group">
                                <label for="bank_country">Country:</label>
                                <input type="text" id="bank_country" name="bank_country" placeholder="Country">
                            </div> -->
                            <div class="input-group">
                                <input type="checkbox" name="ts_cs" id="ts_cs">
                                Accept <a href="terms_conditions.php">Terms and Conditions</a>
                            </div>
                        </div>
                    </div>

                    <input type="submit" name="register_agent" value="Submit">
                </form>

            </div>
        </div>

    </section>

    <?php require_once('templates/footer.php');
    ?>

    <script src="js/validate-agent-registration.js"></script>
    <script src="js/main.js"></script>

</html>