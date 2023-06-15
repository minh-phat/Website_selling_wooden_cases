
<?php
    include('header.php');
    require_once "conn.php";

    $queryCategory = "SELECT * FROM categories ORDER BY Category_Name ASC;";
    $resultCategory = mysqli_query($link,$queryCategory);/* dùng để chạy câu lệnh đó trong mysql*/


    $queryProduct = "SELECT * FROM products ORDER BY Product_Name ASC;";
    $resultProduct= mysqli_query($link,$queryProduct);/* dùng để chạy câu lệnh đó trong mysql*/

    if(isset($_GET['categoryID'])){
        $Category_ID = $_GET['categoryID'];// get data from path

        $queryProduct = "SELECT * FROM products where Category_ID = '$Category_ID' ORDER BY Product_Name ASC;";
        $resultProduct = mysqli_query($link,$queryProduct);/* dùng để chạy câu lệnh đó trong mysql*/
    }else{
       
    }
    

   
?>
<head>
    <title>Shop</title>
</head>

<!-- Start Content -->
<div class="container py-5">
    <div class="row">

        <div class="col-lg-3">
            <h1 class="h2 pb-4">Brands</h1>
            <ul class="list-unstyled templatemo-accordion">
                <?php
                    foreach ($resultCategory as $row){
                ?>
                    <a class="d-flex justify-content-between h3" style="text-decoration:none"
                        href="shop.php?categoryID=<?php echo $row['Category_ID']; ?>">
                        <li class="pb-3">
                            <?php echo $row['Category_Name'] ;?>
                            <i class="fa fa-fw fa-chevron-circle-right mt-1"></i>
                        </li>
                    </a>
                <?php
                    }
                ?>

            </ul>
        </div>

        <div class="col-lg-9">
            <div class="row">
                <?php
                foreach ($resultProduct as $showProducts){
                ?>
                    <div class="col-md-4">
                        <a href="shopSingle.php?productID=<?php echo $showProducts['Product_ID']?>"
                            style="text-decoration: none;color:black;">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <?php
                                    $path = 'img/products/';
                                    $ImagesAll = explode('@@@', $showProducts['Images']);
                                    $item = reset($ImagesAll);
                                    $img = $path . $item;
                                    echo "<img class='card-img rounded-0 img-fluid' src='$img'>";
                                    ?>
                                    <div
                                        class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled">
                                            <li>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                        <li><?php echo $showProducts['Product_Name']; ?>
                                        </li> 
                                    </ul>
                                    <ul class="list-unstyled d-flex justify-content-center mb-1">
                                        <li>
                                        </li>
                                    </ul>
                                    <p class="text-center mb-0" style="color: #59ab6e; font-size: 25px !important;">
                                        $<?php echo $showProducts['Price'] ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
<?php
    include('footer.php');
?>
<!-- Start Script -->
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/templatemo.js"></script>
<script src="js/custom.js"></script>
<!-- End Script -->
</body>

</html>
