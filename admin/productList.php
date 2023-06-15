<?php
    
    session_start();

    //Destroy session notification
    unset($_SESSION['success']);
    unset($_SESSION['failed']);
    unset($_SESSION['notification']);

    // Check if the admin is logged in, if not then redirect him to login page
    if(!isset($_SESSION["AdminLogin"]) || $_SESSION["AdminLogin"] !== true){
        header("location: ../index.php");
        exit;

    }

    //show data category in <input>
    require_once('conn.php'); //connect to database infile conn.php
    //$query = "SELECT * FROM products ORDER BY Product_ID ASC;";
    $query = "SELECT  * from products INNER JOIN categories on products.Category_ID = categories.Category_ID";
    $result = mysqli_query($link,$query);/* dùng để chạy câu lệnh đó trong mysql*/

    include('header.php')
    
?>
    <div class="layout-page">
        <div class="container" style="margin-top: 20px;">
            <div class="row">
                <div class="col-md-12">
                    <!-------------------<< print notification when add data--------------------- -->
                    <?php
                            if(isset($_SESSION["success"])){
                        ?>
                                <div class="alert alert-success" role="alert">
                                <?php echo htmlspecialchars($_SESSION["success"]);?>
                                    
                                </div>
                        <?php
                            $_SESSION["success"] = null ;
                            }
                        ?>
                        <?php
                            if(isset($_SESSION["failed"])){
                        ?>
                                <div class="alert alert-danger" role="alert">
                                <?php echo htmlspecialchars($_SESSION["failed"]);?>
                                    
                                </div>
                        <?php
                                $_SESSION["failed"] = null;
                            }
                        ?>
                         <?php
                            if(isset($_SESSION["notification"])){
                        ?>
                                <div class="alert alert-danger" role="alert">
                                <?php echo htmlspecialchars($_SESSION["notification"]);?>
                                    
                                </div>
                        <?php
                                $_SESSION["notification"] = null;
                            }
                        ?>
                        <!-- ----------------print notification when add data>>-------------- -->
                    
                    <!-- Add button and search -->
                    <div style="margin-right: 1%; float:right;box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;">
                            <a href="productAdd.php" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Add</a>
                    </div>

                    <!-- Search function if admin is logged in -->
                    <div style="margin-right: 1%; float:right;">
                        <form action="{{ url('searchProduct') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search products" name="search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" style="height:100%;box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;"><i
                                            class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>


                    <!-- Page title -->
                    <div style="margin-left: 5%; float:left;">
                        <h2>Product List</h2>
                    </div>
                    <table class="table table-hover" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;">
                        <thead>
                            <!-- Table header -->
                            <tr style="text-align: center; vertical-align:middle">
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th style="width: 15%">Details</th>
                                <th>Images</th>
                                <th>Thickness </th>
                                <th>Width</th>
                                <th>Length</th>
                                <th style="width: 9%">Actions</th> <!--magic number for the 2 buttons to stay on the same line on <=80% zoom-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //Fetch table data -->
                            while ($row = mysqli_fetch_array($result)){
                            ?>
                                <tr style="text-align: center; vertical-align:middle">
                                    <td><?php echo $row['Product_ID']; ?></td>
                                    <td><?php echo $row['Product_Name']; ?></td>
                                    <td><?php echo $row['Category_Name']; ?></td>
                                    <td>$<?php echo $row['Price']; ?></td>
                                    <td><?php echo $row['Details']; ?></td>
                                    <td>
                                        <?php
                                        $path = '../img/products/';
                                        $ImagesAll = explode('@@@', $row['Images']);
                                        foreach ($ImagesAll as $item) {
                                            $img = $path . $item;
                                            echo "<img src='$img' width='100px' height='100px' style='margin-left:5px; border-radius: 5px;'>";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $row['Thickness']; ?></td>
                                    <td><?php echo $row['Width']; ?></td>
                                    <td><?php echo $row['Longs']; ?></td>
                                    <td>
                                        <!-- If admin class is full control then enable update, delete button -->
                                            <a href="productUpdate.php?id=<?php echo $row['Product_ID'] ?>" class="btn btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="productDelete.php?id=<?php echo $row['Product_ID'];?>" class="btn btn-danger"
                                                onclick="return confirm('Confirm delete?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                    
                                    </td>
                                </tr>
                            <?php
                                
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
