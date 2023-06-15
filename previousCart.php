<?php
    include('header.php');
    require_once('conn.php');

    //session()->forget('OrderIDArray');  //destroy only one session    
        unset($_SESSION['OrderIDArray']) ;
        $_SESSION['OrderIDArray'] = array();
        
        $AccountID = $_SESSION['CustomerID'];        

        
        $QueryOrder = "SELECT  * from orders Where Account_ID = '$AccountID'";
        $ResultOrder = mysqli_query($link,$QueryOrder);/* dùng để chạy câu lệnh đó trong mysql*/
        
        
        $QueryOrderDetailsIDDistinct = "SELECT DISTINCT Order_ID FROM order_details";
        $ResultOrderDetailsIDDistinct = mysqli_query($link,$QueryOrderDetailsIDDistinct);

            foreach ($ResultOrder as $RowOrder) {
                
                
                $OrderIDGet = $RowOrder['Order_ID'];
                
               
                $QueryOrderDetails = "SELECT  * from order_details Where Order_ID = '$OrderIDGet'";
                $ResultOrderDetails = mysqli_query($link,$QueryOrderDetails);/* dùng để chạy câu lệnh đó trong mysql*/  
                
                foreach ($ResultOrderDetails as $OrderDetailsRow){

                    //$Product = Products::where('Product_ID', '=' , $OrderDetailsRow['Product_ID'])->get();
                    $ProductID = $OrderDetailsRow['Product_ID'];
                    $QueryProduct = "SELECT  * from products Where Product_ID = '$ProductID'";
                    $ResultProduct = mysqli_query($link,$QueryProduct);
                    
                    foreach($ResultProduct as $RowProduct){
                        $OrderIDArray = array(
                            "OrderID" => $OrderDetailsRow['Order_ID'],
                            "Product_ID" => $OrderDetailsRow['Product_ID'],
                            "name" => $RowProduct ['Product_Name'],
                            "img" => $RowProduct['Images'],
                            //"size" => $RowOrderDetailsRow['Size'],
                            "price" =>$RowProduct['Price'],
                            "quantity" =>$OrderDetailsRow['Quantity'],
                            "purchaseDate" => $RowOrder['Date'],
                        );
                       
                    }
                            
                   
                    array_push($_SESSION['OrderIDArray'],$OrderIDArray); // Items added to cart  
                }
            
            }
            
?>
<head>
    <title>Cart</title>
    <style>
        @media (min-width: 1200px){.col-xl-1 {
            flex: 0 0 auto;
            width: 12.3333333333%;
            }
        }
        @media (min-width: 992px){.col-xl-1 {
            flex: 0 0 auto;
            width: 17.3333333333%;
            }
        }
        @media (min-width: 768px){.col-md-1{
            flex: 0 0 auto;
            width: 22.3333333333%;
            }
        }
    </style>
</head>

<!-- Open Content -->
<section class="bg-light" style="background-color: #eee;">
    <div class="container py-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-10">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-normal mb-0 text-black">Previous order</h3>
                </div>

                <!-- {{-- <form action="{{ url('purchase')}}" method="POST" enctype="multipart/form-data"> --}} -->
                    
                  
                <?php
                if (!empty($_SESSION('OrderIDArray'))){ 
                    foreach ($ResultOrderDetailsIDDistinct as $OrderDetailsIDDistinctRow){
                ?>
                        <div class="card rounded-3 mb-4">
                            
                            <?php $total = 0; $i = 0; ?>
                            <?php
                            foreach ($_SESSION['OrderIDArray'] as $row){
                                if($OrderDetailsIDDistinctRow->Order_ID === $row['OrderID']){  
                            ?>                                
                                <div class="" style="float: right!important; Width:1000px!important;">
                                    <p style="width:max-content; float:right; margin-right:10px;">Purchase Date: <?php echo $row['purchaseDate']; ?></p>
                                </div>
                                    <div class="card-body p-4" style="padding: 10px 10px 0px 10px !important;">  
                 
                            
                                        <div class="row d-flex justify-content-between align-items-center">
                                                
                                            <!-- {{-- @if (!empty(session('OrderIDArray'))) --}} -->
                                            
                                            <div class="col-md-2 col-lg-2 col-xl-2">
                                                <img src="img/products/<?php
                                                
                                                $ImagesFirst = explode('@@@', $row['img']);
                                                
                                                $item = reset($ImagesFirst);
                                                echo $item; ?>" class="img-fluid rounded-3"
                                                    alt="Cotton T-shirt">
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-xl-3">
                                                <p class="lead fw-normal mb-2"><?php $row['name'] ?></p>
                                                <!-- <p>
                                                    <span class="text-muted">Size: </span>
                                                    {{ $row['size'] }}
                                                </p> -->
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                <p>Ammount: <?php $row['quantity'] ?></p>
                                            </div>
                                            <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1" style="margin:inherit; width:auto;">
                                                <h5 style="width:max-content;">$<?php echo $row['price'] ?></h5>
                                            </div>
                                            <div class="col-md-1 col-lg-1 col-xl-1  " style="">
                                                <button type="button" class="btn btn-outline-success" 
                                                        style="margin-right: 100px; margin-left:10px; width:100px;">
                                                    <a href="{{ url('shopSingle/' . $row['Product_ID']) }} " style="text-decoration: none;color : inherit; ">Buy again</a>
                                                </button>  
                                            </div>
                                            
                                        </div>                                       
                                        <hr>
                                        <?php $total += $row['price'] * $row['quantity'];
                                        $i++; ?>
                                    
                                        <!-- {{-- @else
                                            <p>Looks like your cart is empty! You can get some items <a href="{{ 'shop' }}"
                                                    style="color: #23B35A">Here</a></p>
                                        @endif --}} 
                                            {{-- @else --}}
                                                {{-- <p>Looks like your cart is empty! You can get some items <a href="{{ 'shop' }}"
                                                        style="color: #23B35A">Here</a></p>
                                            @endif --}} -->
                                                                                                                  
                                    </div>
                            <?php  
                                }                          
                            }
                            ?>

                            <div class="" style ="padding-bottom:10px; width:100%; ">                            
                                                    
                                    <h5 class="" style="width: 150px; margin-left: 15px;">Total: $<?php echo $total ?></h5> 
                                                   
                                
                            </div>
                        </div>                      
                    <?php
                    }
                }else{    
                    ?>
                <p>Looks like your order history is empty! Go <a href="{{ 'shop' }}"
                    style="color: #23B35A">buy some</a> before checking this page ! </p>
                <?php
                }
                ?>
                
                <!-- {{-- </form> --}} -->
            </div>
        </div>
</section>
<?php
    include('footer.php');
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
