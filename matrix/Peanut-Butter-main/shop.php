<?php

include_once 'includes/getUserName.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Droxford Foods | Shop</title>
    <link rel="stylesheet" href="css/shop-style.css">

    <?php require_once('templates/header.php'); ?>

    <section class="main-section-about">
        <div class="hero" style="background-image: url('images/banner22.png');">
            <div class="wrapper">
                <h1>Indulge in Nature's Finest: Browse Droxford Farm's Signature Products!</h1>
                <p>
                    Experience the convenience of shopping directly from our farm's bounty, where each product is carefully curated to ensure freshness and quality. With Droxford Farm, your satisfaction is guaranteed!
                </p>
            </div>
        </div>

        <?php
            if (isset($_SESSION['registration-success'])) {
                echo '<script> alert("' . $_SESSION['registration-success'] . '")</script>';
                unset($_SESSION['registration-success']);
            }
        ?>


        <div class="shop-container">
            <div class="wrapper">
                <div class="category">
                    <form action="" method="post" class="search-form">
                        <input type="text" class="search-item" placeholder="Search products...">
                        <button type="submit" style="border-bottom-width: 0px; border-right-width: 0px; border-top-width: 0px; border-left-width: 0px;"><img src="images/search.png" alt="" class="icon"></button>
                    </form>
                    <h2 id="shopCategories">Shop Categories</h2>
                    <div class="shop-category-db">
                        <button id="toggleButton" class="">Toggle Categories</button>
                        <ul class=" category-list" id="categoryList" style="z-index: 1000;">
                            <li><a href="">category 1</a></li>
                            <li><a href="">category 2</a></li>
                            <li><a href="">category 3</a></li>
                            <li><a href="">category 4</a></li>
                        </ul>
                    </div>
                </div>

                <?php

                $sql = 'SELECT * FROM `products` WHERE `stock_number` > 0';
                $query = mysqli_query($conn, $sql);
                if (mysqli_num_rows($query) > 0) {
                    // $result = mysqli_fetch_assoc($query);
                ?>
                    <div class="shop-items">

                        <?php
                    
                        while ($products = mysqli_fetch_assoc($query)) {
                            $prod_id = $products['id'];
                            $prod_name = $products['name'];
                            $prod_description = $products['description'];
                            $prod_price = $products['price'];
                            $prod_stock_number = $products['stock_number'];
                            $prod_image_path = $products['image_path'];

                            echo '<div class="shop-item">';
                            echo '<img src="' . $prod_image_path . '" alt="">';
                            echo '<p class="item-name">' . $prod_name . '</p>';
                            echo '<p class="item-price">E' . $prod_price . '</p>';
                            echo '<button 
                            class="add-to-cart" id="add-to-cart" 
                            data-product-id="' . $prod_id . '"
                            data-product-name="' . $prod_name . '"
                            data-product-price="' . $prod_price . '"
                            data-product-description="' . $prod_description . '"  
                            data-product-image="' . $prod_image_path . '" 
                            data-product-stock-number="' . $prod_stock_number . '" 
                            >Add to cart</button>';
                            echo '</div>';
                        }

                        ?>

                    </div>

                <?php
                }
                ?>

            </div>
        </div>


    </section>

    <?php require_once('templates/footer.php');
    ?>

    <script src="js/main.js">
    </script>

</html>