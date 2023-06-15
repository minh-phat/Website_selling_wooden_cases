<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="img/logoWebsite.ico">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/templatemo.css">
    <link rel="stylesheet" href="css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet"href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"> <!--link icon fontawsome-->
    <link rel="stylesheet" href="css/fontawesome.min.css ">
    <link rel="stylesheet" type="text/css" href="css/slick.min.css">
    <link rel="stylesheet" type="text/css" href="'css/slick-theme.css">

    <script src="js/JSCustomer/jquery-1.11.0.min.js"></script>
    <script src="js/JSCustomer/jquery-migrate-1.2.1.min.js"></script>
    <script src="js/JSCustomer/bootstrap.bundle.min.js"></script>
    <script src="js/JSCustomer/templatemo.js"></script>
    <script src="js/JSCustomer/custom.js"></script>
    <!--
    
TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

-->
</head>

<body>



    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <a class="navbar-brand text-success logo h2 align-self-center" href="{{ url('/') }}">
                Selling Wooden Cases
                <!-- <img src="../img/logoWebsite.png" style="width: 40px; height: 40px;" /> -->
            </a>
            <!-- End logo -->

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill d-lg-flex justify-content-lg-between"
                id="templatemo_main_nav">
                <!-- Navigation buttons -->
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between"
                        style="margin-left: 15%;
                              margin-right: 15%; font-size: 18px">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="shop.php">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                    </ul>
                </div>
                <!-- End navigation buttons -->
                <div class="navbar align-self-center d-flex">
                    <!-- Search button -->
                    <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="inputMobileSearch" placeholder="Search ...">
                            <div class="input-group-text">
                                <i class="fa fa-fw fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal"
                        data-bs-target="#templatemo_search">
                        <i class="fa fa-fw fa-search text-dark mr-2" style="font-size: 18px !important"></i>
                    </a>
                    <!-- Cart button -->
                    <?php
                        if(isset($_SESSION['CustomerLogin'])){
                    ?>
                    
                    <a class="nav-icon position-relative text-decoration-none" href="cart.php"
                        style="margin: 0">
                        <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                        <?php if(isset($_SESSION['cart'])){ ?>
                            <span
                                class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark"
                                style="position: static !important"><?php echo count($_SESSION['cart']) ?>
                            </span>
                        <?php
                            }
                            else{                           
                        ?>
                            <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill"
                                style="position: static !important;">
                            </span>
                        <?php
                            }
                        ?>
                    </a>

                    
                        <div class="btn-group">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false" style="font-size: 18px;color:rgb(35, 179, 90); padding:0">
                                <i class="fas fa-user"></i> | <?php echo htmlspecialchars($_SESSION['Name']);?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="profile.php">
                                        Profile
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="previousCart.php">
                                    Order cart
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="logout.php">
                                        Sign out
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    <?php
                        }
                        else{
                    ?>
                        <a class="nav-icon position-relative text-decoration-none" href="login.php">
                            <i class="fa fa-fw fa-user text-dark mr-3"></i>
                        </a>
                    <?php
                        }
                    ?>
                </div>
            </div>

        </div>
    </nav>
    <!-- Close Header -->

    <!-- Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('searchShop') }}" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="search"
                        placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

