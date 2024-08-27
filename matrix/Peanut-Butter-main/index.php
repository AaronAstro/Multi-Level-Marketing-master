<?php

include_once 'includes/getUserName.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Droxford Foods | Home</title>
    <link rel="stylesheet" href="css/main-style.css">
    <?php require_once('templates/header.php'); ?>

    <section class="main-section">
        <div class="welcome-img" style="background-image: url('images/banner22.png');">
            <div class="wrapper">
                <div class="say-hello">
                    <h1>Droxford Farm</h1>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing
                        elit. Optio ab officiis eveniet debitis, nostrum
                        ea quaerat. Eos, odio pariatur expedita vitae
                        reprehenderit est sint ipsa iure repellat,
                        corporis sequi fugit?
                    </p>
                    <a href="store.php" class="shop-now">Shop Now</a>
                </div>
            </div>
        </div>



        <div class="wrapper">
            <div class="insider-row">
                <img src="images/insider.png" alt="">
                <div class="info">
                    <h1>Droxford Farm Insider</h1>

                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Aperiam doloremque illum minus! Incidunt voluptatem tempora ad,
                        quas unde ducimus recusandae ullam quis. Eveniet, accusantium
                        odit illum nostrum minus consequatur nobis.
                    </p>
                    <a href="about.php">Learn more ></a>
                </div>
            </div>

        </div>
    </section>


    <?php require_once('templates/footer.php');
    ?>

    <script src="js/main.js"></script>

</html>