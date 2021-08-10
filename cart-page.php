<?php

session_start();
require_once("./dbconfig.php");
require_once("./OrdersTable.php");
$priceTotal = 0;
$orderText = "";






if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['go-to-cart-page'])) {
        $productsFromMiniCart = $_POST["shoesArray"];
        $_SESSION['arrayInfo'] = $productsFromMiniCart;
        if (empty($productsFromMiniCart)) {
            header("Location: ./index.php");
        }

        foreach ($productsFromMiniCart as $currentProduct) {
            $priceTotal += $currentProduct["price"];
            $orderText = $orderText . "Shoes: " . $currentProduct["name"] . "  Size: " . $currentProduct["shoeSize"] . nl2br("\n");
            $_SESSION['totalPrice'] = $priceTotal;
            $_SESSION['orderInfo'] = $orderText;
        }
    }

    if (isset($_POST['create-order'])) {

        $productsFromMiniCart = $_SESSION['arrayInfo'];
        $priceTotal = $_SESSION['totalPrice'];
        $orderText = $_SESSION['orderInfo'];


        $city = $_POST["city"];
        $address = $_POST["address"];
        $phone = $_POST["phone-number"];
        $email = $_POST["email"];
        $price = $_POST["total-price"];
        $order_info = $_POST["order-info"];

        if (
            filter_var($city, FILTER_SANITIZE_STRING) && !filter_var((int)$city, FILTER_VALIDATE_INT) && filter_var($address, FILTER_SANITIZE_STRING) && filter_var($email, FILTER_VALIDATE_EMAIL)
            && filter_var((int)$phone, FILTER_VALIDATE_INT) && ((int)$phone != 0) && filter_var($price, FILTER_VALIDATE_INT) && filter_var($order_info, FILTER_SANITIZE_STRING)
        ) {
            $ordersTable = new OrdersTable();
            $ordersTable->createOrder($city, $address, $phone, $email, $price, $order_info);
            header("Location: ./index.php");
        } else {
            $errorMsg = "One or more inputs is invalid";
            $_SESSION['error'] = $errorMsg;
        }
    }
}

if (isset($_GET["logout"])) {
    setcookie("userIsLoggedIn", 0, time() - 3600);
    session_unset();
    header("Location: ./index.php");
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Create order from your shopping cart">
    <meta name="keywords" content="NIKE, Shoes, Order, Shop Cart">
    <title>New Order</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/cart-page.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="navbar-brand">
                    <a aria-label="Homepage" class="d-sm-b prl2-sm prl3-lg" href="index.php">
                        <svg class="pre-logo-svg" height="60px" width="60px" fill="#111" viewBox="0 0 69 32">
                            <path d="M68.56 4L18.4 25.36Q12.16 28 7.92 28q-4.8 0-6.96-3.36-1.36-2.16-.8-5.48t2.96-7.08q2-3.04 6.56-8-1.6 2.56-2.24 5.28-1.2 5.12 2.16 7.52Q11.2 18 14 18q2.24 0 5.04-.72z">
                            </path>
                        </svg>
                    </a>
                </div>

                <div class="d-flex justify-content-center">
                    <div class="navbar-nav">
                        <a class="nav-link" href="#">Men</a>
                        <a class="nav-link" href="#">Women</a>
                        <a class="nav-link" href="#">Kids</a>
                    </div>
                </div>

                <div id="cart-and-login" class="d-flex justify-content-end me-5">

                    <?php if (isset($_COOKIE["userIsLoggedIn"])) : ?>


                        <div id="user-logged-in" class="align-self-center">
                            <a id="logout-link" href="./index.php?logout=true">
                                <i class="fa fa-user" aria-hidden="true"></i> SIGN OUT
                            </a>
                            <p id="user-email"><?= htmlspecialchars($_SESSION["email"]) ?></p>
                        </div>

                        <div id="orders" class="align-self-center ms-3">
                            <button type="button" class="btn btn-outline-dark">
                                <a id="see-orders" href="#"> MY ORDERS
                                </a>
                            </button>
                        </div>

                    <?php else : ?>
                        <div id="user-logged-out" class="align-self-center">
                            <a id="login-link" href="./login.php">
                                <i class="fa fa-user" aria-hidden="true"></i> SIGN IN
                            </a>

                        </div>


                    <?php endif; ?>

                </div>
            </div>
        </nav>

    </header>

    <section>

        <div class="container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"></th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Size</th>

                    </tr>
                </thead>
                <tbody>

                    <?php for ($index = 0; $index < sizeof($productsFromMiniCart); $index++) : ?>

                        <tr>
                            <th scope="row"><?= htmlspecialchars($index + 1) ?></th>
                            <td><img class="img-thumbnail" src=<?= htmlspecialchars($productsFromMiniCart[$index]["imgURL"]) ?> alt="Shoes" height="200px" width="250px"></td>
                            <td><?= htmlspecialchars($productsFromMiniCart[$index]["name"]) ?></td>
                            <td><?= htmlspecialchars($productsFromMiniCart[$index]["price"]) ?></td>
                            <td><?= htmlspecialchars($productsFromMiniCart[$index]["shoeSize"]) ?></td>

                        </tr>

                    <?php endfor; ?>

                </tbody>

            </table>

            <div class="center-holder">
                <p id="total-price"> Total Price: <?= htmlspecialchars($priceTotal) ?>$</p>
            </div>


        </div>

        <div class="order-info container shadow-lg p-3 mb-5 bg-body rounded">
            <h2>CREATE ORDER</h2>

            <?php
            if (isset($_SESSION["error"])) {
                $error = $_SESSION["error"];
                echo "<div class=\"alert alert-danger\" role=\"alert\" style=\"text-align: center;\">$error</div>";
            }
            ?>

            <form class="order-form" method="POST">
                <div class="mb-3">
                    <label for="city-name" class="form-label">City</label>
                    <input type="text" name="city" class="form-control" id="city-name" aria-label="Enter your city" required>

                </div>
                <div class="mb-3">
                    <label for="user-address" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" id="user-address" aria-label="Enter your address" required>
                </div>
                <div class="mb-3">
                    <label for="user-phone-number" class="form-label">Phone number</label>
                    <input type="tel" name="phone-number" class="form-control" id="user-phone-number" aria-label="Enter your phone number" required>
                </div>

                <?php if (isset($_COOKIE["userIsLoggedIn"])) : ?>
                    <input type="hidden" name="email" class="form-control" value="<?= htmlspecialchars($_SESSION["email"]) ?>">

                <?php else : ?>
                    <div class="mb-3">
                        <label for="user-email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="user-phone-number" aria-label="Enter your email" required>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="total-price" class="form-control" value="<?= htmlspecialchars($priceTotal) ?>">
                <input type="hidden" name="order-info" class="form-control" value="<?= htmlspecialchars($orderText) ?>">
                <div class="center-holder">
                    <input type="hidden" name="total-price" class="form-control" value="<?= htmlspecialchars($priceTotal) ?>">
                    <input type="hidden" name="order-info" class="form-control" value="<?= htmlspecialchars($orderText) ?>">
                    <input id="btn-create-order" class="btn btn-dark" name="create-order" type="submit" value="ORDER NOW" aria-label="Create your order">
                </div>

            </form>


        </div>
    </section>


    <footer class="footer mt-auto bg-dark text-center text-white">

        <div class="container p-1 pb-0">

            <section class="mb-4">

                <a class="btn btn-outline-light btn-floating m-1" href="https://www.facebook.com/nike/" role="button" aria-label="Facebook link"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017
        1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                    </svg>
                </a>

                <a class="btn btn-outline-light btn-floating m-1" href="https://twitter.com/nike" role="button" aria-label="Twitter link"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533
         6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632
          3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                    </svg></a>

                <a class="btn btn-outline-light btn-floating m-1" href="https://www.instagram.com/nike/" role="button" aria-label="Instagram link"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927
         0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372
          1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01
           3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99
            10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01
             10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047
              1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478
               2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24
                1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                    </svg></a>
            </section>

        </div>

        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2021 Copyright:
            <a class="text-white" href="https://www.nike.com/">Nike.com</a>
        </div>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

<?php
unset($_SESSION["error"]);
?>