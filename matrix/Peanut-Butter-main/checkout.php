<?php

include_once 'includes/getUserName.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

function totalItems($cart)
{
    $totalItems = 0;
    $sum = 0;
    foreach ($cart as $prod) {
        $quant = intval($prod['quantity']);
        $price = doubleval($prod['price']) * $quant;

        $totalItems += $quant;
        $sum += $price;
    }

    $totalItemsAndSum = [
        'totalItems' => $totalItems,
        'sum' => $sum
    ];
    return $totalItemsAndSum;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Droxford Foods | Checkout</title>
    <!-- <link rel="stylesheet" href="css/cart-style.css"> -->
    <link rel="stylesheet" href="css/checkout-style.css">

    <?php require_once('templates/header.php'); ?>

    <section class="main-section-cart" style="margin-top: 60px;">


        <h1 style="text-align:center;margin-top:30px;">Checking out your order</h1>
        <?php

        if (isset($_SESSION['order_email_error'])) {
            if (!$_SESSION['order_email_error']['result']) {
                echo '<p style="text-align:center;margin-top:30px;">Thank You for shopping with us.<br>Please check your email for your order id and order summary.</p>';
            } else {
                echo '<p style="text-align:center;margin-top:30px;">Thank You for shopping with us. Your Order Id is ' . $_SESSION['order_email_error']['order_id'] . '</p>';
            }
        }
        ?>
        <div class="wrapper wrapper-checkout">
            <section>
                <h1>Order Summary</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item) : ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>E<?= number_format($item['price'], 2) * $item['quantity'] ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Subtotal</th>
                            <?php
                            $array = totalItems($cart);
                            echo '<th>' . $array['totalItems'] . '</th>';
                            echo '<th>E' . $array['sum'] . '</th>';
                            ?>
                        </tr>
                    </tfoot>
                </table>

            </section>

            <section>
                <h1>Billing details</h1>
                <form action="checkout/index-checkout.php" method="post" onsubmit="return validateForm()">
                    <div class="form-sections">
                        <!-- Personal Details Section -->
                        <div id="personal-details" class="form-section">
                            <div class="input-group">
                                <label for="f_name">First Name: <span style="color: red;">*</span></label>
                                <?php
                                if (isset($_SESSION['agent_info'])) {
                                    echo '<input type="text" id="f_name" name="f_name" value="' . htmlspecialchars($_SESSION['agent_info']['first_name']) . '" onchange="validateFName()">';
                                } else if (isset($_SESSION['customer_info'])) {
                                    echo '<input type="text" id="f_name" name="f_name" value="' . htmlspecialchars($_SESSION['customer_info']['f_name']) . '" onchange="validateFName()">';
                                } else
                                    echo '<input type="text" id="f_name" name="f_name" placeholder="John" onchange="validateFName()">';
                                ?>
                            </div>
                            <span id="f_nameError" class="error-message"></span>
                            <div class="input-group">
                                <label for="l_name">Last Name: <span style="color: red;">*</span></label>
                                <?php
                                if (isset($_SESSION['agent_info'])) {
                                    echo '<input type="text" id="l_name" name="l_name" value="' . htmlspecialchars($_SESSION['agent_info']['last_name']) . '" onchange="validateLName()">';
                                } else if (isset($_SESSION['customer_info'])) {
                                    echo '<input type="text" id="l_name" name="l_name" value="' . htmlspecialchars($_SESSION['customer_info']['l_name']) . '" onchange="validateFName()">';
                                } else
                                    echo '<input type="text" id="l_name" name="l_name" placeholder="Doe" onchange="validateLName()">';
                                ?>

                            </div>
                            <span id="l_nameError" class="error-message"></span>

                            <div class="input-group">
                                <label for="email">Email: <span style="color: red;">*</span></label>
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
                                <label for="cell_number">Cell Number: <span style="color: red;">*</span></label>
                                <input type="text" id="cell_number" name="cell_number" value="+268">
                            </div>
                            <span id="cell_numberError" class="error-message"></span>
                        </div>

                        <!-- Address Section -->
                        <div id="address-details" class="form-section">
                            <!-- <h1>Address</h1> -->
                            <div class="input-group">
                                <label for="country">Country: <span style="color: red;">*</span></label>
                                <input type="text" id="country" name="country" value="Swaziland">
                            </div>
                            <span id="countryError" class="error-message"></span>
                            <div class="input-group">
                                <label for="city">City: <span style="color: red;">*</span></label>
                                <?php
                                if (isset($_SESSION['agent_info'])) {
                                    echo '<input type="text" id="city" name="city" value="' . htmlspecialchars($_SESSION['agent_info']['city']) . '" >';
                                } else if (isset($_SESSION['customer_info'])) {
                                    echo '<input type="text" id="city" name="city" value="' . htmlspecialchars($_SESSION['customer_info']['city']) . '" onchange="validateFName()">';
                                } else
                                    echo '<input type="text" id="city" name="city" placeholder="City">';
                                ?>
                            </div>
                            <span id="cityError" class="error-message"></span>
                            <div class="input-group">
                                <label for="address">Address: <span style="color: red;">*</span></label>
                                <?php
                                if (isset($_SESSION['agent_info'])) {
                                    echo '<textarea name="address" id="address">' . htmlspecialchars($_SESSION['agent_info']['address']) . '</textarea>';
                                } else if (isset($_SESSION['customer_info'])) {
                                    echo '<textarea name="address" id="address">' . htmlspecialchars($_SESSION['customer_info']['address']) . '</textarea>';
                                } else
                                    echo '<textarea name="address" id="address"></textarea>';
                                ?>

                            </div>
                            <span id="addressError" class="error-message"></span>
                        </div>

                        <!-- Bank Details Section -->
                        <div id="bank-details" class="form-section">
                            <!-- <h1>Payment</h1> -->
                            <label for="payment-method">Payment Method: <span style="color: red;">*</span></label>
                            <select id="payment-method" name="payment_method" required>
                                <option value="credit_card">Credit Card</option>
                                <option value="smart_card">Smart Card</option>
                                <option value="mtn_mobile_money">MTN Mobile Money</option>
                            </select>

                        </div>
                    </div>

                    <?php
                    if (count($cart) == 0) {
                        echo '<input type="submit" name="place_order" value="Place order" disabled>';
                    } else
                        echo '<input type="submit" name="place_order" value="Place order">';
                    ?>

                    <!-- TODO: link to the relevant api -->

                </form>
            </section>
        </div>
    </section>

    <?php require_once('templates/footer.php');
    ?>

    <script>
        function validateForm() {
            let isValid = true;

            // Clear previous error messages
            document.querySelectorAll('.error-message').forEach(error => error.style.display = 'none');

            // Validate f_name
            const f_name = document.getElementById('f_name');

            if (f_name.value === '') {
                document.getElementById('f_nameError').textContent = 'First name is required';
                document.getElementById('f_nameError').style.display = 'block';
                f_name.style.border = '1px solid red'
                isValid = false;
            }

            // Validate l_name
            const l_name = document.getElementById('l_name');
            if (l_name.value === '') {
                document.getElementById('l_nameError').textContent = 'Last name is required';
                document.getElementById('l_nameError').style.display = 'block';
                l_name.style.border = '1px solid red';
                isValid = false;
            }

            // Validate Email
            const email = document.getElementById('email');
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (email.value === '') {
                document.getElementById('emailError').textContent = 'Email is required';
                document.getElementById('emailError').style.display = 'block';
                email.style.border = '1px solid red';
                isValid = false;
            } else if (!emailPattern.test(email.value)) {
                document.getElementById('emailError').textContent = 'Please enter a valid email address';
                document.getElementById('emailError').style.display = 'block';
                email.style.border = '1px solid red';
                isValid = false;
            }

            const phoneNumber = document.getElementById('cell_number');
            const phonePattern = /^\+268\d{8}$/;
            if (phoneNumber.value === '') {
                document.getElementById('cell_numberError').textContent = "Please Enter your phone number.";
                document.getElementById('cell_numberError').style.display = 'inline-block';
                phoneNumber.style.border = '1px solid red';
                isValid = false;
            } else if (!phonePattern.test(phoneNumber.value)) {
                document.getElementById('cell_numberError').textContent = "Please enter a valid phone number in the format +268########.";
                document.getElementById('cell_numberError').style.display = 'inline-block';
                phoneNumber.style.border = '1px solid red';
                isValid = false;
            }

            const country = document.getElementById('country');
            if (country.value === '') {
                document.getElementById('countryError').textContent = "Country is required";
                document.getElementById('countryError').style.display = 'block';
                country.style.border = '1px solid red';
                isValid = false;
            }

            const city = document.getElementById('city');
            if (city.value === '') {
                document.getElementById('cityError').textContent = "City is required";
                document.getElementById('cityError').style.display = 'block';
                city.style.border = '1px solid red';
                isValid = false;
            }

            const address = document.getElementById('address');
            if (address.value === '') {
                document.getElementById('addressError').textContent = "Address is required";
                document.getElementById('addressError').style.display = 'block';
                address.style.border = '1px solid red';
                isValid = false;
            }

            return isValid;
        }
    </script>

    <script src="js/main.js">
    </script>

</html>