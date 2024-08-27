<?php

include_once 'includes/getUserName.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Droxford Foods | About</title>
    <link rel="stylesheet" href="css/about-style.css">
    <?php require_once('templates/header.php'); ?>

    <section class="main-section-about">
        <div class="hero" style="background-image: url('images/banner22.png');">
            <div class="wrapper">
                <h1>BROXFORD Farm: Cultivating Prosperity, Together.</h1>
                <p>
                    Together, we foster a culture of shared success and mutual support, creating an environment where every member thrives.
                </p>
            </div>
        </div>



        <div class="about-section">
            <div class="wrapper">
                <h1>About Us</h1>

                <div class="about-items" style="background-image: url(images/group-1@2x.png);">
                    <div class="about-item item-1">
                        <h2>Company Overview</h2>
                        <p>
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vero laudantium, neque minima deserunt voluptates quae! Cupiditate quis aperiam consectetur illo, quas veniam excepturi tempore nam dolorum suscipit iure beatae porro.
                        </p>
                    </div>
                    <div class="about-item item-2 first">
                        <h2>Mission Statement</h2>
                        <p>
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vero laudantium, neque minima deserunt voluptates quae! Cupiditate quis aperiam consectetur illo, quas veniam excepturi tempore nam dolorum suscipit iure beatae porro.
                        </p>
                    </div>
                    <div class="about-item items-3 ">
                        <h2>Customer Commitment</h2>
                        <p>
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vero laudantium, neque minima deserunt voluptates quae! Cupiditate quis aperiam consectetur illo, quas veniam excepturi tempore nam dolorum suscipit iure beatae porro.
                        </p>
                    </div>
                    <div class="about-item first">
                        <!-- <img src="images/400g-Smooth-and-Creamy-Peanut-Butter.jpg" alt="Butter intem"> -->
                        <h2>History</h2>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed dolorum recusandae veritatis, obcaecati est labore perferendis dolor eveniet, molestiae quaerat eaque quibusdam dicta suscipit facere totam placeat odio culpa officiis?
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="top-products">
            <div class="wrapper">
                <h1>Our Top Products</h1>

                <div class="products-listing">
                    <div class="listing">
                        <p class="number">
                            01.
                        </p>
                        <div class="description">
                            <h3 class="item-title">400g Peanut Butter</h3>
                            <p>
                                The smooth peanut butter for all your daily needs with natural proteins <br>
                                Carefully selected peanuts roasted and smoothed to the best cream for your daily needs. Its a good supply of protein good for the entire family and daily use. The product has natural ingredients to serve you healthy needs. The nuts are sourced from selected farms with natural preparations for the best taste.
                            </p>
                            <a href="shop.php" class="shop-now">Shop now</a>
                        </div>
                        <img src="images/400g-Smooth-and-Creamy-Peanut-Butter.jpg" alt="product item">
                    </div>
                    <div class="listing">
                        <img src="images/h2-product5.jpg" alt="product item" class="prod-item-3">
                        <p class="number">
                            02.
                        </p>
                        <div class="description">
                            <h3 class="item-title">Raw Cashew Butter</h3>
                            <p>
                                Sumptuous, filling, and temptingly healthy, our Biona Organic Granola with Wild Berries is just the thing to get you out of bed. The goodness of rolled wholegrain oats are combined with a variety of tangy organic berries, and baked into crispy clusters that are as nutritious.
                            </p>
                            <a href="shop.php" class="shop-now">Shop now</a>
                        </div>
                    </div>
                    <div class="listing">
                        <p class="number">
                            03.
                        </p>
                        <div class="description">
                            <h3 class="item-title">Chocolate Hazelnut</h3>
                            <p>
                                Sumptuous, filling, and temptingly healthy, our Biona Organic Granola with Wild Berries is just the thing to get you out of bed. The goodness of rolled wholegrain oats are combined with a variety of tangy organic berries, and baked into crispy clusters that are as nutritious.
                            </p>
                            <a href="shop.php" class="shop-now">Shop now</a>
                        </div>
                        <img src="images/h2-product6.jpg" alt="product item">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once('templates/footer.php');
    ?>

    <script src="js/main.js"></script>

</html>