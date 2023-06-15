
<?php
    include('header.php');
?>
<?php
    //session_start();

    require_once "conn.php";

    
    $queryCategory = "SELECT * FROM categories ORDER BY Category_Name ASC;";
    $resultCategory = mysqli_query($link,$queryCategory);/* dùng để chạy câu lệnh đó trong mysql*/

    $ProductID = $_GET['productID'];
    $queryProduct = "SELECT  * from products INNER JOIN categories on products.Category_ID = categories.Category_ID where Product_ID= '$ProductID'";
    $resultProduct = mysqli_query($link,$queryProduct);/* dùng để chạy câu lệnh đó trong mysql*/

    foreach($resultProduct as $rowCategory){
        $Category_ID = $rowCategory['Category_ID'];
    }

    $queryProductRelate = "SELECT * FROM products where Category_ID = '$Category_ID' and Product_ID <> '$ProductID' ORDER BY Product_Name ASC Limit 3";
    $resultProductRelate = mysqli_query($link,$queryProductRelate);/* dùng để chạy câu lệnh đó trong mysql*/

    // if($_SERVER["REQUEST_METHOD"] == "POST"){

    //     header("location: shop.php");//go to listAdmin.php page 

    //     // $quantity = $_POST['quantity'];

        
    //     // $_SESSION['cart']=array();

    //     // $arr=array("productID"=>"$product","quantity"=>$quantity,"img"=>$image);
    //     // array_push($_SESSION['cart'],$arr); // Items added to cart

        
    // }


?>
<head>
    <title>Product</title>
</head>

<?php
    foreach ($resultProduct as $showProducts){
?>
<!-- Open Content -->
<section class="bg-light">
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-5 mt-5">
                <div class="card mb-3">
                    <img class="card-img img-fluid" src="img/products/<?php
                    $ImagesFirst = explode('@@@',  $showProducts['Images']);
                    $item = reset($ImagesFirst);
                    echo $item; ?>" alt="Card image cap"
                        id="product-detail">
                </div>

                <div class="row">
                    <!--Start Controls-->
                    <div class="col-1 align-self-center">
                        <a href="#multi-item-example" role="button" data-bs-slide="prev">
                            <i class="text-dark fas fa-chevron-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </div>
                    <!--End Controls-->
                    <!--Start Carousel Wrapper-->
                    <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item"
                        data-bs-ride="carousel">
                        <!--Start Slides-->
                        <div class="carousel-inner product-links-wap" role="listbox">

                            <!--First slide-->

                            <div class="carousel-item active">
                                <div class="row">
                                    <?php
                                        $path = 'img/products/';
                                        $ImagesAll = explode('@@@',  $showProducts['Images']);
                                        foreach ($ImagesAll as $item) {
                                            $img = $path . $item;
                                    ?>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?php echo $img; ?>"
                                                alt="Product Image 1">
                                        </a>
                                    </div>
                                    <?php                                           
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!--End Slides-->
                    </div>
                    <!--End Carousel Wrapper-->
                    <!--Start Controls-->
                    <div class="col-1 align-self-center">
                        <a href="#multi-item-example" role="button" data-bs-slide="next">
                            <i class="text-dark fas fa-chevron-right"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <!--End Controls-->
                </div>
            </div>
            <!-- col end -->
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h2"><?php echo  $showProducts['Product_Name'] ?></h1>
                        <p class="h3 py-2">$<?php echo $showProducts['Price']; ?></p>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Category:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong><?php echo $showProducts['Category_Name'] ?></strong></p>
                            </li>
                        </ul>

                        <h6>Description:</h6>
                        <p><?php echo $showProducts['Details'] ?></p>

                        <form action="handleAddCart.php?productID=<?php echo $showProducts['Product_ID'];?>" method="POST">
                            <input type="hidden" name="productID" value="{{ $data->Product_ID }}" id="">
                            <div class="row">
                                <div class="col-auto">
                                    <ul class="list-inline pb-3">
                                        <li class="list-inline-item text-right">
                                            Quantity:
                                            <input type="hidden" name="quantity" id="product-quanity" value="1" max="">
                                        </li>
                                        <li class="list-inline-item"><span class="btn btn-success"
                                                id="btn-minus">-</span></li>
                                        <li class="list-inline-item"><span class="badge bg-secondary"
                                                id="var-value">1</span></li>
                                        <li class="list-inline-item"><span class="btn btn-success"
                                                id="btn-plus">+</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col d-grid">
                                    <button type="submit" class="btn btn-success btn-lg" name="submit"
                                        value="buy">Buy</button>
                                </div>
                                <div class="col d-grid">
                                    <!-- <a href="{{ url('customerAddCart/' . $data->Product_ID) }}"> -->
                                        <button type="submit" class="btn btn-success btn-lg" name="submit"
                                            value="addtocard">Add To Cart</button>
                                    <!-- </a> -->
                                    <!-- @if (Session::has('fail'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ Session::get('fail') }}
                                        </div>
                                    @endif -->
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
</section>
<?php
    }
?>
<!-- Close Content -->

<!-- Start Article -->
<section class="py-5">
    <div class="container">
        <div class="text-left p-2 pb-3">
            <h4>Related Products</h4>
        </div>
        <div class="d-flex justify-content-around">
            <?php
            foreach ($resultProductRelate as $row){
            ?>
                <!--Start Carousel Wrapper-->
                <div id="carousel-related-product" style="width: 30%; height:auto; display:inline-block">
                    <a href="shopSingle.php?productID=<?php echo $row['Product_ID'];?>" style="text-decoration: none;color:black;">
                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0">
                                <?php
                                $path = 'img/products/';
                                $ImagesAll = explode('@@@', $row['Images']);
                                $item = reset($ImagesAll);
                                $img = $path . $item;
                                echo "<img class='card-img rounded-0 img-fluid' src='$img'>";
                                ?>
                                <div
                                    class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-uns tyled">
                                        <li><?php echo $row['Product_Name']; ?>
                                        </li> 
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                
                                <ul class="list-unstyled d-flex justify-content-center mb-1">
                                    <li>
                                    </li>
                                </ul>
                                <p class="text-center mb-0" style="color: #59ab6e; font-size: 25px !important;">
                                    $<?php echo  $row['Price'] ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
                }
            ?>
        </div>
    </div>
</section>

<!-- End Article -->
<?php
    include('footer.php')
?>
<!-- Start Script -->
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/templatemo.js"></script>
<script src="js/custom.js"></script>
<!-- End Script -->
<!-- Start Slider Script -->
<script src="js/slick.min.js"></script>
<script>
    $('#carousel-related-product').slick({
        infinite: true,
        arrows: false,
        slidesToShow: 4,
        slidesToScroll: 3,
        dots: true,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3
                }
            }
        ]
    });
</script>
<!-- End Slider Script -->

</body>

</html>
