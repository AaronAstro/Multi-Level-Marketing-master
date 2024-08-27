<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/reset-style.css">
<link rel="stylesheet" href="css/header-style.css">
<link rel="stylesheet" href="css/footer-style.css">
</head>

<body>

    <header class="navigation-bar">
        <div class="wrapper">
            <nav>

                <a href="index.php"><img src="images/logo.png" alt="logo-img" class="logo"></a>
                <div class="nav-links">

                    <a href="index.php" class="nav-link-item">Home</a>
                    <a href="about.php" class="nav-link-item">About</a>
                    <a href="contact.php" class="nav-link-item">Contact</a>
                    <a href="shop.php" class="nav-link-item">Shop</a>

                    <a href="cart.php" class="cart-link">
                        <img src="images/cart1.png" alt="" class="cart-icon">
                    </a>
                </div>
                <div class="nav-access dropdown">



                    <!-- if user is online show log out else show login -->
                    <?php if (!isset($user_id)) { ?>
                        <div class="acc-btn blue">
                            <a href="login.php" class="img-link">
                                Sign in
                            </a>
                        </div>

                    <?php   } else {
                        $user_name = $_SESSION['user_name'];
                        echo '<div class="acc-btn orange">';
                        echo '<div class="circle-container">';

                        //get first letter of username
                        $array_name = str_split($user_name);
                        echo '<p>' . $array_name[0] . '</p>';

                        echo '</div>';

                        echo '<a href="profile.php" class="access-btn ">';
                        echo $user_name;
                        echo '</a>';
                        echo '</div>';
                    ?>
                        <div class="acc-btn">
                            <a href="logout.php" class="img-link">
                                Log out
                            </a>
                        </div>

                    <?php } ?>
                    <div class="acc-btn blue">
                        <a href="agent-registration.php" class="img-link">
                            Register
                        </a>
                    </div>
                </div>
                <!-- <button class="menu-toggle">Menu</button> -->
                <div class="for-small-screen">
                    <img src="images/user.png" alt="user-img" class="icon user-icon">
                    <a href="cart.php" class="cart-link">
                        <img src="images/cart1.png" alt="" class="cart-icon">
                    </a>
                    <img src="images/menu1.png" alt="menu" class="icon menu-icon menu-toggle">
                </div>
            </nav>
        </div>
    </header>