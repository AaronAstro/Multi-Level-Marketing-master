<?php

include_once 'includes/getUserName.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Droxford Foods | Cart</title>
    <link rel="stylesheet" href="css/cart-style.css">

    <?php require_once('templates/header.php'); ?>

    <section class="main-section-cart">

        <div class="wrapper">

            <div class="title-cart">
                <h1>Your Cart</h1>
                <p>(<span id="total-sum">0</span> Items)</p>
                <?php
                if (empty($cart)) { ?>
                    <a href="shop.php">Visit Shop</a>
                <?php } ?>
            </div>


            <div class="cart-content">
                <div class="cart-summary">
                    <h2>Order Summary</h2>
                    <div class="totals">
                        <div class="total">
                            <p>Subtotal</p>
                            <p id="cart-subtotal">0.00</p>
                        </div>
                        <div class="total">
                            <p>Shipping</p>
                            <p id="cart-shipping">0.00</p>
                        </div>
                        <div class="total">
                            <p>Total</p>
                            <p id="cart-total">0.00</p>
                        </div>
                    </div>
                    <a href="checkout.php">Proceed To Cash Out</a>
                </div>

                <!-- Display the cart items -->
                <?php
                if (!empty($cart)) {
                ?>
                    <div class="cart-items">

                        <?php
                        foreach ($cart as $itemId => $item) {
                            echo '<div class="cart-item" data-product-id="' . $itemId . '" data-product-price="' . htmlspecialchars($item['price']) . '" data-product-stock-number="' . htmlspecialchars($item['stockNumber']) . '">';

                            echo '<img src="' . htmlspecialchars($item['image']) . '" alt="">';
                            echo '<div class="cart-item-info">';

                            echo '<h3>' . htmlspecialchars($item['name']) . '</h3>';
                            echo '<p class="description"> ' . htmlspecialchars($item['description']) . ' </p>';
                            echo '<p class="price">E' . htmlspecialchars($item['price']) . '</p>';

                        ?>
                            <div class="cart-item-actions">
                                <img src="images/bin.png" alt="" class="delete-item delete">
                                <!-- <button class="delete">Delete Item</button> -->
                                <div class="number-input-container">
                                    <button class="btn" data-action="decrement">-</button>
                                    <input type="number" class="number-input" value="<?php echo htmlspecialchars($item['quantity']); ?>">
                                    <button class="btn" data-action="increment">+</button>
                                </div>
                            </div>
                        <?php

                            echo '</div>';
                            echo '</div>';
                        }

                        ?>
                    </div>
                <?php

                } else {
                }
                ?>

            </div>


    </section>

    <?php require_once('templates/footer.php');
    ?>



    <script src="js/main.js">
        //TODO: Determine if shipping price is necessary
        //TODO: Work on check out and save the cart as payed
        //TODO: Determine if shipping price is necessary
    </script>



</html>