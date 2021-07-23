<?php
session_start();
if (isset($_COOKIE['username']) && !empty($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Mulish' rel='stylesheet'>

    <!--Font Awesome -->
    <link rel="stylesheet" type="text/css" href="inc/fontawesome-5-pro-master/css/all.css">

    <!--CSS-->
    <link rel="stylesheet" type="text/css" href="inc/css/checkout.css">

    <title>Auction - Checkout</title>
    <link rel="shortcut icon" href="inc/pictures/cyberhuskies.ico">
</head>

<body class="text-dark">
    <div class="row mx-lg-1 mx-0">
        <?php
        // Geting checkout sesion
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'costumer') {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($_GET['sessionid']) || !empty($_GET['sessionid'])) {
                    $sessionid = $_GET['sessionid'];
                    require $_SERVER['DOCUMENT_ROOT'] . '/CyberHuskies/inc/db_connection.php';
                    // Checking if is a valid session id
                    $sqlSearchSessionId = "SELECT * FROM bid WHERE costumer_id = ? AND sessionid = ? AND payed = 0";
                    // Create a prepared statement 
                    $stmt = mysqli_stmt_init($connection);
                     // Prepare the prepared statement
                    if (!mysqli_stmt_prepare($stmt, $sqlSearchSessionId)) {
                        echo '<div class="container px-5 text-center"><br><br><br><br>
                                    <div class="alert alert-danger py-5" role="alert">
                                            <i class="fad fa-exclamation-circle"></i> We ran into a problem. Please try again later.
                                    </div>
                                </div>';
                    } else {
                        // Bind parameters
                        mysqli_stmt_bind_param($stmt, 'is', $_SESSION['costumer_id'], $sessionid);
                        // Run parameters
                        mysqli_stmt_execute($stmt);
                        $resultSearchSessionId = mysqli_stmt_get_result($stmt);
                        if (mysqli_num_rows($resultSearchSessionId) == 1) {
                            while ($rowSearchSessionId = mysqli_fetch_assoc($resultSearchSessionId)) {
                                // Getting all product infor
                                $sqlGetProduct = "SELECT * FROM product WHERE product_id = " . $rowSearchSessionId['product_id'] . "";
                                $resultGetProduct = mysqli_query($connection, $sqlGetProduct);
                                if (mysqli_num_rows($resultGetProduct) == 1) {
                                    while ($rowGetProduct = mysqli_fetch_assoc($resultGetProduct)) {
        ?>
        <!-- Checkout details -->
        <div class="col-lg-6 col-12 pe-lg-5 pe-0 pt-5 ">

            <div class="row justify-content-end">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="text-center otherProduct-header"> Auction Checkout </h1>
                        </div> <br><br><br><br>

                        <!-- Payment Form -->
                        <div class="col-12 text-lg-start text-center">
                            <p class="h5">Shipping address</p>
                            <hr>
                            <form id="checkoutForm" action="inc/php/pay.php" method="post">

                                <!-- Address -->
                                <div class="form-group row">
                                    <div class="col-12 form-floating">
                                        <input type="text" id="address" placeholder="Address" class="form-control" />
                                        <label for="address" class="ms-2">Address</label>
                                    </div>
                                </div><br>

                                <!-- Building -->
                                <div class="form-group row justify-content-center">
                                    <div class="col-12 form-floating">
                                        <input type="text" id="building" placeholder="Building" class="form-control" />
                                        <label for="building" class="ms-2">Building, Apartment etc</label>
                                    </div>
                                </div><br>

                                <!-- City -->
                                <div class="form-group row justify-content-center ">
                                    <div class="col-sm-12 form-floating">
                                        <input type="text" id="city" placeholder="City" class="form-control" />
                                        <label for="city" class="ms-2">City</label>
                                    </div>
                                </div><br>

                                <!-- Country/Region Postal code-->
                                <div class="form-group row justify-content-center">
                                    <!-- Country/Region -->
                                    <div class="form-floating col-sm-6 mb-4 mb-lg-0">
                                        <input type="text" id="country" placeholder="Country/Region"
                                            class="form-control" />
                                        <label for="country" class="ms-2">Country/Region</label>
                                    </div>
                                    <!-- Postal Code -->
                                    <div class="form-floating col-sm-6">
                                        <input type="text" id="postal" placeholder="Postal code" class="form-control" />
                                        <label for="postal" class="ms-2">Postal code</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <!-- Response for Shipment details -->
                                        <span id="shippmentResponse"
                                            class="text-danger mt-1 .validationResponse"></span>
                                    </div>
                                </div>
                                <br /><br>

                                <p class="h5 text-lg-start text-center">Payment</p>
                                <p class="text-secondary" style="font-size: smaller;">All transactions are secure and
                                    encrypted.</p>
                                <hr>
                                <!-- Name on card -->
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-12 form-floating">
                                        <input type="text" id="nameCard" placeholder="Name on card"
                                            class="form-control" />
                                        <label for="nameCard" class="ms-2">Name on Card</label>
                                    </div>
                                </div><br />
                                <!-- Card Number -->
                                <div class="form-group row justify-content-center ">
                                    <div class="col-sm-12 form-floating">
                                        <input type="number" id="cardNumber" placeholder="Card Number"
                                            class="form-control" />
                                        <label for="cardNumber" class="ms-2">Card Number</label>
                                    </div>
                                </div><br>
                                <!-- Valid Through & CVC Code -->
                                <div class="form-group row justify-content-center">
                                    <!-- Valid Through -->
                                    <div class="form-floating col-sm-6 mb-4 mb-lg-0">
                                        <input type="text" id="validThrough" placeholder="Valid Through"
                                            class="form-control" />
                                        <label for="validThrough" class="ms-2">Valid Through</label>
                                    </div>
                                    <!-- CVC Code -->
                                    <div class="form-floating col-sm-6">
                                        <input type="number" id="cvcCode" placeholder="CVC Code" class="form-control" />
                                        <label for="cvcCode" class="ms-2">CVC Code</label>
                                    </div>
                                    <!-- Response for Payment details -->
                                    <span id="paymentResponse" class="text-danger mt-1 mb-3 validationResponse"></span>
                                </div><br />
                            </form>
                        </div> <!-- End Payment Form -->
                    </div>
                </div>
            </div>
            <br>
        </div> <!-- End Checkout details -->

        <!-- Order Sumary -->
        <div class="col-lg-6 col-12 ps-lg-5 ps-5 pt-lg-5 pt-0 border-start border-2"
            style="background-color: whitesmoke; ">

            <div class="row justify-content-start">
                <div class="col-lg-8 col-12">
                    <div class="row">
                        <div class="col-12 text-lg-start text-center">
                            <span style="line-height: 3.5em;
                                    font-size: 1.6em;"> ORDER SUMMARY </span>
                        </div> <br><br><br><br>
                        <div class="row mt-lg-3 mt-0">
                            <div class="col-lg-3 col-12 text-center">
                                <img src="inc/pictures/product-picture/<?php echo $rowGetProduct['picture_cover_url']; ?>" onerror=this.src="inc/pictures/blank.jpg"
                                    height="100" width="100" class="rounded">
                            </div>
                            <div class="col-lg-7 col-9 align-self-center mt-lg-0 mt-4">
                                <p><?php echo $rowGetProduct['name']; ?></p>
                            </div>
                            <div class="col-lg-2 col-3 align-self-center text-end mt-lg-0 mt-4">
                                <span class="price"><span id="calculate"><?php echo $rowGetProduct['bid_now']; ?></span>$</span>
                            </div>
                            <div class="col-lg-12">
                                <hr class="mt-4">
                            </div>
                        </div>
                        <div class="row text-secondary">
                            <div class="col-6">
                                <p>Subtotal</p>
                            </div>
                            <div class="col-6 text-end">
                                <span class="text-dark price"><?php echo $rowGetProduct['bid_now']; ?>$</span>
                            </div>
                        </div>
                        <div class="row text-secondary">
                            <div class="col-6">
                                <p>Shipping</p>
                            </div>
                            <div class="col-6 text-end">
                                <span class="text-dark price">0$</span>
                            </div>
                            <div class="col-lg-12">
                                <hr class="mt-4">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>Total</p>
                            </div>
                            <div class="col-6 text-end">
                                <span class="h6 text-secondary">EU </span>
                                <span class="h2"><?php echo $rowGetProduct['bid_now']; ?>&euro;</span>
                            </div>
                        </div><br><br><br>
                        <div class="row mb-lg-0 mb-5">
                            <div class="col-lg-12">
                                <button id="pay<?php echo $rowSearchSessionId['product_id'];?>" type="submit" form="checkoutForm" class="btn btn-primary w-100 pay"
                                    style="height: 50px;">Pay
                                    now</button>
                            </div>
                            <div class="col-lg-12 mt-5 alert-error d-none">
                                <div class="alert alert-danger text-center" role="alert">
                                    <i class="fad fa-exclamation-circle"></i> A simple danger alert—check it out!
                                </div>
                            </div>
                            <div class="col-lg-12 mt-5 alert-done d-none">
                                <div class="alert alert-success text-center" role="alert">
                                    <i class="fas fa-check-circle"></i> Payment completed successfully!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End order sumamry -->

        <?php
                                }
                            } else {
                                echo '<div class="container px-5 text-center"><br><br><br><br>
                                    <div class="alert alert-danger py-5" role="alert">
                                        <i class="fad fa-exclamation-circle"></i> We ran into a problem. Please try again later.
                                    </div>
                                </div>';
                            }
                        }
                    } else {
                        echo '<div class="container px-5 text-center"><br><br><br><br>
                            <div class="alert alert-danger align-self-center py-5" role="alert">
                                <i class="fad fa-exclamation-circle"></i> We ran into a problem. Please try again later.
                            </div>
                        </div>';
                    }
                }
                } else {
                    echo '<div class="container px-5 text-center"><br><br><br><br>
                    <div class="alert alert-danger py-5" role="alert">
                            <i class="fad fa-exclamation-circle"></i> We ran into a problem. Please try again later.
                    </div>
                </div>';
                }
            } else {
                echo '<div class="container px-5 text-center"><br><br><br><br>
                    <div class="alert alert-danger py-5" role="alert">
                            <i class="fad fa-exclamation-circle"></i> We ran into a problem. Please try again later.
                    </div>
                </div>';
            }
        } else {
            echo '<div class="container px-5 text-center"><br><br><br><br>
                    <div class="alert alert-danger py-5" role="alert">
                            <i class="fad fa-exclamation-circle"></i> We ran into a problem. Please try again later.
                    </div>
                </div>';
        }
        ?>

        <!-- Script -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- JS link -->
        <script src="inc/js/checkout.js"></script>
</body>

</html>