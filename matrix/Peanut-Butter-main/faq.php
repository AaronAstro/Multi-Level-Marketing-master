<?php

include_once 'includes/getUserName.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Droxford Foods | FAQs</title>
    <link rel="stylesheet" href="css/terms_conditions-style.css">
    <link rel="stylesheet" href="css/faq-style.css">
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

        <div class="terms-details">
            <div class="wrapper">
                <h2>Frequently Asked Questions</h2>
                <div class="faq-item">
                    <div class="faq-question">
                        <button class="toggle-btn">+</button>
                        <h3>Question 1?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi minus, iure quas eaque dolorem magni tempore quidem nisi voluptate sint, officiis dolore, at hic dolorum nobis ratione mollitia commodi et?</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <button class="toggle-btn">+</button>
                        <h3>Question 2?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi minus, iure quas eaque dolorem magni tempore quidem nisi voluptate sint, officiis dolore, at hic dolorum nobis ratione mollitia commodi et?</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <button class="toggle-btn">+</button>
                        <h3>Question 2?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi minus, iure quas eaque dolorem magni tempore quidem nisi voluptate sint, officiis dolore, at hic dolorum nobis ratione mollitia commodi et?</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <button class="toggle-btn">+</button>
                        <h3>Question 2?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi minus, iure quas eaque dolorem magni tempore quidem nisi voluptate sint, officiis dolore, at hic dolorum nobis ratione mollitia commodi et?</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <button class="toggle-btn">+</button>
                        <h3>Question 2?</h3>
                    </div>
                    <div class="faq-answer">
                        <p>You can access the Amway home page by following these easy steps.</p>
                        <br>
                        <ul>
                            <li>Open your web browser.</li>
                            <li>Go to the menu bar at the top of the browser.</li>
                            <li>Type in Amway.com</li>
                            <li>Hit the enter button.</li>
                            <li>You’ll be directed to the Amway home page.</li>
                            <li>You’ll be directed to the Amway home page.</li>
                        </ul>
                        <br>
                        <p>When you access the Amway home page, you can discover more about Amway, a global leader in selling products that support a healthy lifestyle. You can also learn about the Amway opportunity and building a personalized business.</p>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <?php require_once('templates/footer.php');
    ?>

    <script src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.toggle-btn').click(function() {
                $(this).toggleClass('active');
                var answer = $(this).closest('.faq-question').next('.faq-answer');
                if ($(this).hasClass('active')) {
                    answer.addClass('show');
                } else {
                    answer.removeClass('show');
                }
            });
        });
    </script>




</html>