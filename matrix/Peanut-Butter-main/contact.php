<?php

include_once 'includes/getUserName.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Droxford Foods | Contact</title>
    <link rel="stylesheet" href="css/contact-style.css">
    <?php require_once('templates/header.php'); ?>

    <section class="main-section-about">
        <div class="hero" style="background-image: url('images/banner22.png');">
            <div class="wrapper">
                <h1>Your Satisfaction, Our Priority: Contact Us Today</h1>
                <p>
                    At Broxford Farm, customer satisfaction is our priority. Contact us with any feedback or inquiries, and we'll ensure a prompt response.
                </p>
            </div>
        </div>


        <div class="conatct-tabs">
            <div class="wrapper">

                <div class="contact-tab">
                    <img src="images/location.png" alt="location-icon" class="icon">
                    <h3>Address:</h3>
                    <p>30 Commercial Road Fratton, Australia</p>
                </div>
                <div class="contact-tab">
                    <img src="images/icons8-cell-50.png" alt="cell-icon" class="icon">
                    <h3>Phone Number:</h3>
                    <p>1-888-452-1505 <br> 1-888-452-1505 </p>
                </div>
                <div class="contact-tab">
                    <img src="images/icons8-mail-50.png" alt="e-mail-icon" class="icon">
                    <h3>Address</h3>
                    <a href="mailto:info@droxfordfoods.co.sz">info@droxfordfoods.co.sz</a>
                    <a href="mailto:sales@droxfordfoods.co.sz">sales@droxfordfoods.co.sz</a>
                </div>
            </div>
        </div>



        <div class="contact-form">
            <div class="wrapper">
                <h1> <span>Feel free</span> to contact with us any time.</h1>
                <form action="send_email.php" method="post" class="form-contact">

                    <?php
                    if (isset($_SESSION['agent_info'])) {
                        $agent_details = $_SESSION['agent_info'];
                        //var_dump($agent_details);
                    ?>
                        <div class="input-group">
                            <label for="name">Name:</label>
                            <?php echo '<input type="text" id="name" name="name" value="' . htmlspecialchars($agent_details['last_name']) . ' ' . htmlspecialchars($agent_details['first_name']) . '" required>'; ?>
                        </div>
                        <div class="input-group">
                            <label for="email">Email:</label>
                            <?php echo '<input type="email" id="email" name="email" value="' . htmlspecialchars($agent_details['email']) . '" required>'; ?>
                        </div>


                    <?php } else { ?>
                        <div class="input-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="input-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                    <?php } ?>

                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>

                    <input type="submit" name="submit_contact" value="Submit">
                </form>
            </div>
        </div>

    </section>

    <?php require_once('templates/footer.php');
    ?>

    <script src="js/main.js"></script>

</html>