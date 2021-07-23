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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Mulish' rel='stylesheet'>

    <!--Font Awesome -->
    <link rel="stylesheet" type="text/css" href="inc/fontawesome-5-pro-master/css/all.css">

    <!--CSS-->
    <link rel="stylesheet" type="text/css" href="inc/css/products.css">
    <link rel="stylesheet" type="text/css" href="inc/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="inc/css/footer.css">
    <link rel="stylesheet" type="text/css" href="inc/css/list.css">

    <title>Auction - Buy</title>
    <link rel="shortcut icon" href="inc/pictures/cyberhuskies.ico">
</head>

<body class="text-dark" style="padding-top: 78px;">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top navb" style="transition: 0.3s">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link border-top border-light border-2 me-2" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item add-border">
                        <a class="nav-link active border-top border-light border-2 me-2" href="list.php?category=All%20Products">Buy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link border-top border-light border-2 me-2" href="upload-product.php">Sell</a>
                    </li>
                    <li class="nav-item dropdown border-top border-light border-2 me-2">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <!-- DB Connection to get categories-->
                            <?php
                            require $_SERVER['DOCUMENT_ROOT'] . '/CyberHuskies/inc/db_connection.php';
                            require $_SERVER['DOCUMENT_ROOT'] . '/CyberHuskies/inc/functions.php';
                            $sqlGetCategories = "SELECT * FROM category";
                            $resultGetCategories = mysqli_query($connection, $sqlGetCategories);
                            if (mysqli_num_rows($resultGetCategories) > 0) {
                                while ($rowGetCategories = mysqli_fetch_assoc($resultGetCategories)) {
                                    echo '<li><a class="dropdown-item text-center" href="list.php?category=' . $rowGetCategories['category_name'] . '">' . $rowGetCategories['category_name'] . '</a></li>';
                                }
                            }
                            ?>
                            <li>
                                <hr class="divider">
                            </li>
                            <li><a class="dropdown-item text-center" href="list.php?category=All%20Products">All
                                    Products</a></li>
                            <li><a class="dropdown-item text-center" href="list.php?category=Cooming%20Soon">Cooming
                                    Soon</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link border-top border-light border-2 me-2" href="#footer-section">Contact Us</a>
                    </li>
                    <form class="d-lg-flex d-grid gap-1 col-lg-5" action='list.php' method="get">
                        <input class="form-control me-2" type="search" placeholder="Search products..." aria-label="Search" name="search">
                        <button id="searchProduct" class="btn btn-danger d-grid" type="submit">Search</button>
                    </form>
                </ul>
                <ul class="navbar-nav me-right mb-2 mb-lg-0">

                    <!-- Check if any user is logged in -->
                    <?php
                    if (empty($_SESSION['username'])) {
                    ?>

                        <!-- Modal Buttons -->
                        <form class="d-lg-flex d-grid gap-2">
                            <button type="button" class="btn btn-register" data-bs-toggle="modal" data-bs-target="#logInModal"> <i class="fad fa-sign-in-alt"></i> <span class="button-text">Log In</span></button>
                            <button type="button" class="btn btn-register" data-bs-toggle="modal" data-bs-target="#signUpModal"><i class="fas fa-user-plus"></i> <span class="button-text">Sign Up</span></button>
                        </form>
                </ul>
            </div>
        </div>
    </nav> <!-- End Navbar -->
    <!-- Log in Modal -->
    <div class="modal fade" id="logInModal" tabindex="-1" aria-labelledby="logInModal" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h1 class="modal-title w-100 text-success">Log In</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-dark">

                    <!-- Log In Form -->
                    <form id="logInForm" action="php/logIn.php" method="post">
                        <br>
                        <!-- Username -->
                        <div class="form-group row justify-content-center px-lg-5 px-3">

                            <div class="col-12 form-floating">
                                <input type="text" id="usernameLog" placeholder="Username" class="form-control">
                                <label class="ms-2" for="usernameLog">Username</label>

                                <!-- Response for username -->
                                <span id="logInMessageUsername" class="text-danger mt-1"></span>
                            </div>
                        </div><br>

                        <!-- Password -->
                        <div class="form-group row justify-content-center px-lg-5 px-3">
                            <div class="col-12 form-floating">
                                <input type="password" id="passwordLog" placeholder="Password" class="form-control" aria-label="Password..." aria-describedby="but">
                                <label class="ms-2" for="passwordLog">Password</label>

                                <!-- Response for password -->
                                <span id="logInMessagePassword" class="text-danger mt-1"></span>
                            </div>
                        </div><br>

                        <!-- Remember me -->
                        <div class="form-group row justify-content-center my-1 px-lg-5 px-3">
                            <div class="col-lg-7 col-6">
                                <input class="form-check-input" type="checkbox" id="rememberMeCheck">
                                <label class="form-check-label" for="rememberMeCheck" style="user-select: none;">
                                    Remember me
                                </label>
                            </div>
                            <div class="col-lg-5 col-6 text-end">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#ressetPasswordModal" data-bs-dismiss="modal" class="text-secondary">Forgot password?</a>
                            </div>
                        </div><br>

                        <!-- Log in Button -->
                        <div class="form-group row justify-content-center px-lg-5 px-3">
                            <div class="col-12">
                                <button type="submit" id="submitLogIn" class="btn btn-success w-100 " form="logInForm" style="height: 50px;">Log
                                    In</button>
                            </div>
                        </div><br>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <p class="text-secondary">Don't have an account? <a href="#" class="text-success h6" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#signUpModal">Create one</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Forget Password Modal -->
    <div class="modal fade" id="ressetPasswordModal" tabindex="-1" aria-labelledby="ressetPasswordModal" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h1 class="modal-title w-100 text-dark" style="font-size: 70px;"><i class="fad fa-lock-alt"></i>
                    </h1>
                </div>
                <div class="modal-body text-dark">

                    <!-- Password Resset Form -->
                    <form id="ressetPasswordForm" action="php/passwordResset.php" method="post">

                        <!-- Username -->
                        <div class="form-group row justify-content-center px-lg-5 px-3">
                            <div class="col-12 text-center mb-1">
                                <span class="h5">Trouble Logging In?</span><br>
                            </div>
                            <div class="col-12 text-center mb-3">
                                <span class="">Enter your username and we'll send you a link to
                                    get back into your account.</span>
                            </div> <br><br>
                            <div class="col-12 form-floating">
                                <input type="text" id="usernameResset" placeholder="Username" class="form-control">
                                <label class="ms-2" for="usernameResset">Username</label>

                            </div>
                        </div><br>

                        <!-- Resset Password Button -->
                        <div class="form-group row justify-content-center px-lg-5 px-3">
                            <div class="col-sm-12">
                                <button type="submit" id="submitRessetPassword" class="btn btn-primary w-100 " form="ressetPasswordForm" style="height: 50px;">Send Password Resset Link</button>
                            </div>
                        </div><br>

                        <!-- OR create new account-->
                        <div class="form-group row justify-content-center px-lg-5 px-3">
                            <div class="col-5">
                                <hr>
                            </div>
                            <div class="col-2 text-center">
                                <span class="text-secondary"> OR</span>
                            </div>
                            <div class="col-5">
                                <hr>
                            </div>
                            <div class="col-12 text-center">
                                <a href="#" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#signUpModal" class="text-dark h6">Create New
                                    Account</a>
                            </div>

                            <!-- Message -->
                            <span id="ressetMessageLink" class="col-sm-12 mt-4 text-center alert d-none"></span>

                        </div> <br>
                    </form>
                </div>

                <!-- Back to log in Button -->
                <a href="#" class="modal-footer justify-content-center text-dark h6 w-100 mb-0 py-3" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#logInModal" style="background-color: whitesmoke; text-decoration: none;">Back to Login</a>
            </div>
        </div>
    </div>

    <!-- Modal Sign up -->
    <div class="modal fade" id="signUpModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h1 class="modal-tittle w-100 text-primary">Sign Up
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-dark">

                    <!-- Sign Up Form -->
                    <form id="signUpForm" action="php/signUp.php" method="post">

                        <!-- First Name Last Name-->
                        <br>
                        <div class="form-group row justify-content-center px-lg-5 px-3">

                            <!-- First name -->
                            <div class="col-lg-6 form-floating">
                                <input type="text" id="first_name" placeholder="First name" class="form-control" />
                                <label for="first_name" class="ms-2">First name</label>

                                <!-- Response for First Name and Last Name -->
                                <span id="signUpMessageName" class="text-danger mt-1"></span>
                            </div>

                            <!-- Last name -->
                            <div class="col-lg-6 form-floating mt-lg-0 mt-4">
                                <input type="text" id="last_name" placeholder="Last name" class="form-control" />
                                <label for="last_name" class="ms-2">Last name</label>
                            </div>
                        </div>
                        <br />

                        <!-- Username -->
                        <div class="form-group row justify-content-center px-lg-5 px-3">
                            <div class="col-12 form-floating">
                                <input type="text" id="usernameSignUp" placeholder="Username" class="form-control" />
                                <label for="usernameSignUp" class="ms-2">Username</label>

                                <!-- Response for username -->
                                <span id="signUpMessageUsername" class="text-danger mt-1"> <span class="text-secondary ms-2">You can use letters, numbers,
                                        periods &
                                        dash </span> </span>
                            </div>
                        </div>
                        <br />

                        <!-- Email -->
                        <div class="form-group row justify-content-center px-lg-5 px-3">
                            <div class="col-12 form-floating">
                                <input type="text" id="email" placeholder="Email" class="form-control" />
                                <label for="email" class="ms-2">Email</label>

                                <!-- Response for email -->
                                <span id="signUpMessageEmail" class="text-danger mt-1"></span>
                            </div>
                        </div>
                        <br />

                        <!-- Password and Confirm password  -->
                        <div class="form-group row justify-content-center px-lg-5 px-3">

                            <!-- Password -->
                            <div class="col-lg-6 form-floating">
                                <input type="password" id="passSignUp" placeholder="Password" class="form-control" />
                                <label for="passSignUp" class="ms-2">Password</label>
                            </div>

                            <!-- Confirm password -->
                            <div class="col-lg-6 form-floating mt-lg-0 mt-4">
                                <input type="password" id="confirmPassSignUp" placeholder="Confirm" class="form-control" />
                                <label for="confirmPassSignUp" class="ms-2">Confirm</label>
                            </div>

                            <!-- Response for password -->
                            <div class="col-12">
                                <span id="signUpMessagePassword" class="text-danger mt-1"></span>
                            </div>
                        </div>

                        <!-- Checkbox for show password -->
                        <div class="form-group row px-lg-5 px-3 mt-1">
                            <div class="form-group col-lg-6 col-12">
                                <input class="form-check-input" type="checkbox" id="showPasswordCheck">
                                <label class="form-check-label ms-2" for="showPasswordCheck" style="user-select: none;">
                                    Show password
                                </label>
                            </div>
                        </div><br>

                        <!-- Phone Number -->
                        <div class="form-group row justify-content-center px-lg-5 px-3">
                            <div class="col-12 form-floating">
                                <input type="number" id="phone_number" placeholder="Phone number (Optional)" class="form-control" />
                                <label for="phone_number" class="ms-2">Phone number (Optional)</label>
                            </div>
                        </div>
                        <br>

                        <!-- Select for user Type -->
                        <div class="form-group row justify-content-center px-lg-5 px-3">
                            <div class="col-12 form-floating">
                                <select class="form-select" id="user_type">
                                    <option value="costumer" selected>Customer</option>
                                    <option value="salessman">Salessman</option>
                                </select>
                                <label for="user_type" class="ms-2">Select how you want to register
                                    as</label>
                            </div>
                            <div class="col-12 mb-1 mt-3">
                                <span class="text-dark">By signing up, I agree to the Privacy Policy and
                                    the Terms of Services.</span>
                            </div>
                        </div> <br>

                        <!-- Register button -->
                        <div class="row justify-content-center px-lg-5 px-3">
                            <div class="col-12 form-floating">
                                <button type="submit" form="signUpForm" id="submitSignUp" class="btn btn-primary w-100" style="height: 50px;">Register</button>
                            </div>
                        </div>
                        <br />
                    </form>
                </div>

                <!-- Modal buttons -->
                <div class="modal-footer justify-content-center">
                    <p class="text-secondary">Already have an account? <a href="#" class="text-primary h6" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#logInModal">Log In</a> </p>
                </div>
            </div>
        </div>
    </div>
    <!-- If an user is logged in -->
<?php
                    } else {
?>
    <li class="nav-item dropdown me-3 border-top border-light border-2">
        <a class="nav-link dropdown-toggle" href="#" id="navbarAccount" role="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="button-text"><?php echo $_SESSION['username'] ?></span> <i class="fad fa-user-circle"></i></a>
        <ul class="dropdown-menu me-2" aria-labelledby="navbarAccount">
            <?php
                        if ($_SESSION['user_type'] === 'salessman') {
                            echo '<li><a class="dropdown-item ps-4" href="accounts/myproducts.php">My products <i class="fad fa-stream"></i></a></li>';
                        }
            ?>
            <li><a id="logout" class="dropdown-item ps-4" href="inc/php/logout.php">log out <i class="fad fa-sign-out"></i></a></li>
        </ul>
    </li>
    <li class="nav-item me-2">
        <a class="nav-link" href="mycart.php"> <i class="shopping-icon fad fa-shopping-cart"></i></a>
    </li>
    </ul>
    </div>
    </div>
    </nav> <!-- End Navbar -->
<?php
                    }
                    // Geting category name from user 
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        // User searched with category
                        if (isset($_GET['category'])) {
                            $category_name = test_input($_GET['category']);
                            // Check if category is with letters only
                            if ($category_name === 'All Products') {
                                $sqlProducts = "SELECT name, product_id, picture_cover_url, starting_price, sale_start FROM product";
                                $resultProducts = mysqli_query($connection, $sqlProducts);
                                $countRows = mysqli_num_rows($resultProducts);
                                if ($countRows  > 0) {
                                    if ($countRows >= 4) {
                                        $justify = 'start';
                                    } else {
                                        $justify = 'center';
                                    }
                                    echo '<!-- products from certain category -->
                            <div class="container-fluid products-from-category-container">
                                <div class="row">
                                    <h1 class="col-12 text-center mt-4 mb-lg-3 mb-0">All Products</h1>
                                </div><br><br>
                                <div class="products-from-category row justify-content-' . $justify . '"> ';

                                    while ($rowProducts = mysqli_fetch_assoc($resultProducts)) {
                                        echo '<div class=" col-xl-3 col-lg-5 col-12">
                                    <a href="products.php?pid=' . $rowProducts['product_id'] . '" class="href product row justify-content-center">
                                        <div class="prod-img col-12 text-center">
                                            <img class="img-fluid" src="inc/pictures/product-picture/' . $rowProducts['picture_cover_url'] . '">
                                        </div>
                                        <div class="prod-details col-12">
                                            <div class="prod-name text-center mb-2">' . $rowProducts['name'] . '</div>
                                            <div class="text-center mb-2"><b>At auction starting from </b><br>' . $rowProducts['sale_start'] . '</div>
                                            <div class="min-price text-center"><b>Reserve price: </b> &euro;' . $rowProducts['starting_price'] . '</div>
                                        </div>    
                                    </a>
                                </div> ';
                                    }
                                    echo '</div>
                            </div><!-- End products from certain category -->';
                                }
                            } else if ($category_name === 'Cooming Soon') {
                                $sqlProducts = "SELECT name, product_id, picture_cover_url, starting_price, sale_start FROM product WHERE sale_start > NOW()";
                                $resultProducts = mysqli_query($connection, $sqlProducts);
                                $countRows = mysqli_num_rows($resultProducts);
                                if ($countRows  > 0) {
                                    if ($countRows >= 4) {
                                        $justify = 'start';
                                    } else {
                                        $justify = 'center';
                                    }
                                    echo '<!-- products from cooming soon category -->
                            <div class="container-fluid products-from-category-container">
                                <div class="row">
                                    <h1 class="col-12 text-center mt-4 mb-lg-3 mb-0">Cooming Soon</h1>
                                </div><br><br>
                                <div class="products-from-category row justify-content-' . $justify . '"> ';

                                    while ($rowProducts = mysqli_fetch_assoc($resultProducts)) {
                                        echo '<div class=" col-xl-3 col-lg-5 col-12">
                                    <a href="products.php?pid=' . $rowProducts['product_id'] . '" class="href product row justify-content-center">
                                        <div class="prod-img col-12 text-center">
                                            <img class="img-fluid" src="inc/pictures/product-picture/' . $rowProducts['picture_cover_url'] . '">
                                        </div>
                                        <div class="prod-details col-12">
                                            <div class="prod-name text-center mb-2">' . $rowProducts['name'] . '</div>
                                            <div class="text-center mb-2"><b>At auction starting from </b><br>' . $rowProducts['sale_start'] . '</div>
                                            <div class="min-price text-center"><b>Reserve price: </b> &euro;' . $rowProducts['starting_price'] . '</div>
                                        </div>    
                                    </a>
                                </div> ';
                                    }
                                    echo '</div>
                            </div><!-- End products from cooming soon category -->';
                                }
                            } else {
                                $sqlProducts = "SELECT name, product_id, picture_cover_url, starting_price, sale_start FROM product WHERE category_id IN ( SELECT category_id FROM category WHERE category_name = ? )";
                                // Create prepared statement
                                $stmt = mysqli_stmt_init($connection);
                                // Prepare the prepared statement
                                if (!mysqli_stmt_prepare($stmt, $sqlProducts)) {
                                    echo '<br><br><br><br>
                        <h1 class="otherProduct-header mt-2">There are no products under this Category yet. <i class="fad fa-frown"></i></h1>
                            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                } else {
                                    // Bind parameters
                                    mysqli_stmt_bind_param($stmt, 's', $category_name);
                                    // Run parameters
                                    mysqli_stmt_execute($stmt);
                                    $resultProducts = mysqli_stmt_get_result($stmt);
                                    $countRows = mysqli_num_rows($resultProducts);
                                    if ($countRows  > 0) {
                                        if ($countRows >= 4) {
                                            $justify = 'start';
                                        } else {
                                            $justify = 'center';
                                        }
                                        echo '<!-- products from certain category -->
                            <div class="container-fluid products-from-category-container">
                                <div class="row">
                                    <h1 class="col-12 text-center mt-4 mb-lg-3 mb-0">' . $category_name . '</h1>
                                </div><br><br>
                                <div class="products-from-category row  justify-content-' . $justify . '"> ';

                                        while ($rowProducts = mysqli_fetch_assoc($resultProducts)) {
                                            echo '<div class=" col-xl-3 col-lg-5 col-12">
                                    <a href="products.php?pid=' . $rowProducts['product_id'] . '" class="href product row justify-content-center">
                                        <div class="prod-img col-12 text-center">
                                            <img class="img-fluid" src="inc/pictures/product-picture/' . $rowProducts['picture_cover_url'] . '">
                                        </div>
                                        <div class="prod-details col-12">
                                            <div class="prod-name text-center mb-2">' . $rowProducts['name'] . '</div>
                                            <div class="text-center mb-2"><b>At auction starting from </b><br>' . $rowProducts['sale_start'] . '</div>
                                            <div class="min-price text-center"><b>Reserve price: </b> &euro;' . $rowProducts['starting_price'] . '</div>
                                        </div>    
                                    </a>
                                </div> ';
                                        }
                                        echo '</div>
                            </div><!-- End products from certain category -->';
                                    } else {
                                        echo '<br><br><br><br>
                            <h1 class="otherProduct-header mt-2">There are no products under this Category yet. <i class="fad fa-frown"></i></h1>
                                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                    }
                                }
                            }
                        }

                        // User searched with product name
                        if (isset($_GET['search'])) {
                            if (!empty($_GET['search'])) {
                                $name = test_input($_GET['search']);
                                $sqlSearch = "SELECT name, product_id, picture_cover_url, starting_price, sale_start FROM product WHERE name LIKE CONCAT('%', ?, '%')";
                                // Create prepared statement
                                $stmt = mysqli_stmt_init($connection);
                                // Prepare the prepared statement
                                if (!mysqli_stmt_prepare($stmt, $sqlSearch)) {
                                    echo '<br><br><br><br>
                    <h1 class="otherProduct-header mt-2">No product found. <i class="fad fa-frown"></i><br> <span class="h4">Try searching another product</span></h1>
                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                } else {
                                    // Bind parameters
                                    mysqli_stmt_bind_param($stmt, 's', $name);
                                    // Run parameters
                                    mysqli_stmt_execute($stmt);
                                    $resultSearch = mysqli_stmt_get_result($stmt);

                                    if (mysqli_num_rows($resultSearch) > 0) {
                                        echo '<!-- products from search -->
                            <div class="container-fluid products-from-category-container">
                                <div class="row">
                                    <h1 class="col-12 text-center mt-4 mb-lg-3 mb-0">Search : ' . $name . '</h1>
                                </div><br><br>
                                <div class="products-from-category row justify-content-center"> ';

                                        while ($rowSearch = mysqli_fetch_assoc($resultSearch)) {
                                            echo '<div class=" col-xl-3 col-lg-5 col-12">
                                    <a href="products.php?pid=' . $rowSearch['product_id'] . '" class="href product row justify-content-center">
                                        <div class="prod-img col-12">
                                            <img class="img-fluid" src="inc/pictures/product-picture/' . $rowSearch['picture_cover_url'] . '">
                                        </div>
                                        <div class="prod-details col-12">
                                            <div class="prod-name text-center mb-2">' . $rowSearch['name'] . '</div>
                                            <div class="text-center mb-2"><b>At auction starting from </b><br>' . $rowSearch['sale_start'] . '</div>
                                            <div class="min-price text-center"><b>Reserve price: </b> &euro;' . $rowSearch['starting_price'] . '</div>
                                        </div>    
                                    </a>
                                   </div> ';
                                        }
                                        echo '</div>
                            </div><!-- End products from certain category -->';
                                    } else {
                                        echo '<br><br><br><br>
                            <h1 class="otherProduct-header mt-2">No product found. <i class="fad fa-frown"></i><br> <span class="h4">Try searching another product</span></h1>
                                <br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                                    }
                                }
                            } else {
                                echo '<br><br><br><br>
                    <h1 class="otherProduct-header mt-2">No product found. <i class="fad fa-frown"></i><br> <span class="h4">Try searching another product</span></h1>
                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                            }
                        }
                        if (!isset($_GET['search']) && !isset($_GET['category'])) {
                            echo '<br><br><br><br>
                <h1 class="otherProduct-header mt-2">No product found. <i class="fad fa-frown"></i><br> <span class="h4">Try searching another product</span></h1>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                        }
                    }
require_once 'inc/php/footer.php';
?>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- JS link -->
<script src="inc/js/registration.js"></script>
<script type="text/javascript" src="inc/js/navbar.js"></script>

</body>

</html>