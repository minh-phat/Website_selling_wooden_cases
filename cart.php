
<?php
    include('header.php');

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        require_once('conn.php');

        // don't need validate
        $Address = $_POST["address"];
        $Note= $_POST["note"];
        $Phone = $_POST["phone"];

        $AccountID = $_SESSION['CustomerID'];
        //$currentDate = new DateTime();
        $Date = date('d-m-y h:i:s');
        $query2 = "INSERT INTO orders (`Account_ID`,`Receive_Phone`,`Receive_Address`, `Date`, `Note`) VALUES ('". $AccountID."','".$Phone."','".$Address ."','".$Date."','".$Note."')";
        //$result = mysqli_query($link,$query);/* dùng để chạy câu lệnh đó trong mysql*/
        if(mysqli_query($link,$query2)){

            $QueryOrderIDCurrent = "SELECT * FROM orders ORDER BY Order_ID DESC";
            $ResultOrder = mysqli_query($link,$QueryOrderIDCurrent);
            foreach($ResultOrder as $row){
                
                $OrderIDCurrent = $row['Order_ID'];
                break;
            }
        

            foreach($_SESSION['cart'] as $row){
                $QueryAddOrderDetails = "INSERT INTO order_details (`Order_ID`,`Product_ID`,`Quantity`) VALUES ('". $OrderIDCurrent."','".$row['productID']."','".$row['quantity'] ."')";
                
                $ResulQueryAddOrderDetails = mysqli_query($link,$QueryAddOrderDetails);
            }
            $_SESSION['success'] = "Purchase successful.";
           
        }
    }



?>
<head>
    <title>Cart</title>
</head>

<!-- Open Content -->
<section class="bg-light" style="background-color: #eee;">
    <div class="container py-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-10">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-normal mb-0 text-black">Shopping Cart</h3>
                </div>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <?php
                            if(isset($_SESSION["success"])){
                        ?>
                                <div class="alert alert-success" role="alert">
                                <?php echo htmlspecialchars($_SESSION["success"]);?>
                                    
                                </div>
                        <?php
                                 unset($_SESSION['success']);
                            }
                        ?>

                    <div class="card rounded-3 mb-4">
                        <div class="card-body p-4">
                            <?PHP
                            if (!empty($_SESSION['cart'])){
                            ?>
                                <?php $total = 0;
                                $i = 0; ?>
                                <?PHP
                                    foreach ($_SESSION['cart'] as $row){
                                ?>
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                        <?php
                                            $path = 'img/products/';
                                            $ImagesAll = explode('@@@', $row['img']);
                                            $item = reset($ImagesAll);
                                            $img = $path . $item;
                                        ?>
                                            <img src="<?php echo $img;?>" class="img-fluid rounded-3"
                                                alt="Cotton T-shirt">
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                            <p class="lead fw-normal mb-2"><?php echo $row['name'] ?></p>
                                            <!-- <p>
                                                <span class="text-muted">Size: </span>
                                                {{ $row['size'] }}
                                            </p> -->
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                            <p>Ammount: <?php echo $row['quantity'] ?></p>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                            <h5 class="mb-0">$<?php echo $row['price'] ?></h5>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-xl-1  ">
                                            <a href="handle.php?remove=<?php echo $i;?>" class="text-danger"
                                                onclick="return confirm('Confirm delete?')">
                                                <i class="fas fa-trash fa-lg"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php $total += $row['price'] * $row['quantity'];
                                    $i++; ?>
                                    <?PHP
                                        }
                            }else{
                                    ?>
                            
                                <p>Looks like your cart is empty! You can get some items <a href="{{ 'shop' }}"
                                        style="color: #23B35A">Here</a></p>
                            <?php
                                }
                            ?>
                            <div class="row d-flex justify-content">
                                <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-10">
                                    <?php
                                        if (!empty($_SESSION['cart'])){
                                    ?>
                                        <h5 class="mb-0">Total: $<?php echo $total;?></h5>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        if (!empty($_SESSION['cart'])){
                    ?>
                        <!-- disables the information fields when no item is presence -->
                        <div class="card rounded-3 mb-4">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="inputname">Recieve Address</label>
                                        <input type="text" class="form-control mt-1" name="address"
                                            placeholder="Address">
                                    </div>
                                    <!-- @error('address')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror -->
                                    <div class="mb-3">
                                        <label for="inputemail">Recieve Phone</label>
                                        <input type="text" class="form-control mt-1" name="phone"
                                            placeholder="Phone">
                                    </div>
                                    <!-- @error('phone')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror -->
                                    <div class="mb-3">
                                        <label for="inputmessage">Note</label>
                                        <textarea class="form-control mt-1" id="message" name="note" placeholder="Note" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>

                    <?php
                        if (!empty($_SESSION['cart'])){
                    ?>
                        <div class="card rounded-3 mb-4">
                            <div class="card-body p-3">
                                <!-- {{-- <a href="" class="btn btn-success" style="float: right" type="submit">Purchase</a> --}} -->
                                <button class="btn btn-block btn-primary" type="submit"
                                    style="float:right;">Purchase</button>
                                <a href="{{ url()->previous() }}" class="btn btn-outline-danger"
                                    style="float: right; margin-right: 1%">Back</a>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                </form>
            </div>
        </div>
</section>

<?php
    include('footer.php')
?>
</body>
    <!-- Start Script -->
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/jquery-migrate-1.2.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/templatemo.js"></script>
    <script src="js/custom.js"></script>
    <!-- End Script -->
</html>
