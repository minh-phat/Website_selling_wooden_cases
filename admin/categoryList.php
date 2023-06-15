
<?php
    // Initialize the session
    session_start();

    // Check if the admin is logged in, if not then redirect him to login page
    if(!isset($_SESSION["AdminLogin"]) || $_SESSION["AdminLogin"] !== true){
        header("location: ../index.php");
        exit;
    }
    //run Navigation_bar page for header of web
    include('header.php');

    require_once('conn.php'); //connect to database infile conn.php

    $query = "SELECT * FROM categories ORDER BY Category_ID ASC;";

    $result = mysqli_query($link,$query);/* dùng để chạy câu lệnh đó trong mysql*/

    
?>

<head><title>Brand List </title></head>
    <div class="layout-page">
        <div class="container" style="margin-top: 20px;">
            <div class="row">
                <div class="col-md-12">
                    
                    <?php
                        //check if  $_SESSION non-null then excute
                        if(!empty($_SESSION['notification'])){ 
                    ?>       <div class='alert alert-danger' role='alert'>
                                <?php echo htmlspecialchars($_SESSION["notification"]);?> 
                            </div>
                    <?php
                            //return $_SESSIOn null after print notification
                            $_SESSION['notification'] = "";
                        }
                    ?>
                    
                    <!-- Start buttons -->             
                    
                    <div style="margin-right: 1%; float:right;">
                        <a href="categoryAdd.php" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Add</a>
                        </div>
                    

                    <div style="margin-left: 5%; float:left;">
                        <h2 >Brand List</h2>
                    </div>
                        <!-- End buttons -->

                        <table class="table table-hover">
                            <thead>
                                <!-- Table header -->
                                <tr style="text-align: center">
                                    <th>Brand ID</th>
                                    <th>Brand Name</th>
                                    <th>Image</th>               
                                    <th>Actions</th>
                                
                                </tr>
                                <!-- End table header -->
                            </thead>
                            <tbody>
                                <!-- Fetch category data -->                           
                                <?php
                                    while ($row = mysqli_fetch_array($result)){
                                ?>                           
                                    <tr>
                                        <td style="text-align: center"><?php echo $row['Category_ID'];?></td>
                                        <td style="text-align: center"><?php echo $row['Category_Name'];?></td>
                                        <td style="text-align: center"><img src="../img/categories/<?php echo $row['Category_Image'];?>" alt="" height="100px" width="auto"></td>

                                        
                                            <td style="text-align: center">
                                                <a href="categoryUpdate.php?id=<?php echo $row['Category_ID'];?>"
                                                    class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                <a href="categoryDelete.php?id=<?php echo $row['Category_ID'];?>"
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Confirm delete?')"><i class="fas fa-trash-alt"></i></a>
                                            </td>                                  
                                    </tr>
                                <?php
                                    }
                                ?>
                                <!-- End fetching data -->
                            </tbody>
                        </table>
                    
                </div>
            </div>
        </div>
    </div>    
</body>

</html>
