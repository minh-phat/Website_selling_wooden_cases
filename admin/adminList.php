
<?php
    // Initialize the session
    session_start();

    // Check if the admin is logged in, if not then redirect him to login page
    if(!isset($_SESSION["AdminLogin"]) || $_SESSION["AdminLogin"] !== true){
        header("location: ../index.php");
        exit;

    }


?>
<?php
    require_once('conn.php'); //connect to database infile conn.php

    $query = "SELECT * FROM account where Account_Role = 'admin'ORDER BY Account_Name ASC ";

    $result = mysqli_query($link,$query);/* dùng để chạy câu lệnh đó trong mysql*/

    include('header.php');
?>
<head>
    <title>Admin List</title>
</head>
    <div class="layout-page">
        <div class="container" style="margin-top: 20px;">
            <div class="row">
                <div class="col-md-12">
                

                    <!-- Start buttons -->           

                    <?php 
                        if(isset($_SESSION["AdminLogin"])){
                    ?>
                        <div style="margin-right: 1%; float:right;">
                            <a href="adminRegister.php" class="btn btn-success">
                                <i class="fas fa-plus-circle"></i> Add</a>
                        </div>
                    <?php
                        }
                    ?>

                    <div style="margin-left: 5%; float:left;">
                        <h2>Admin List</h2>
                    </div>
                    <!-- End buttons -->

                    <?php 
                        //check if admin login successfull will show data , else don't show data
                        if(isset($_SESSION["AdminLogin"])){ 
                    ?>
                        <table class="table table-hover">
                            <thead>
                                <!-- Table header -->
                                <tr>
                                    <th style="text-align: center">Username</th>
                                    <th style="text-align: center">Name</th>
                                    <th style="text-align: center">Actions</th>
                                </tr>
                                <!-- End table header -->
                            </thead>
                            <tbody>
                                <!-- Fetch table data -->
                                <?php
                                while ($row = mysqli_fetch_array($result)){
                                ?>                          
                                        <tr>
                                            <td style="text-align: center"><?php echo $row['User_Name'];?></td>
                                            <td style="text-align: center"><?php echo $row['Account_Name'];?></td>
                                            <td style="text-align: center">
                                                <a href="{{ url('editAdmin/' . $row->Admin_Username) }}"
                                                    class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ url('deleteAdmin/' . $row->Admin_Username) }}"
                                                    class="btn btn-danger" onclick="return confirm('Confirm delete?')">
                                                    <i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                <?php
                                }
                                ?>   
                                
                                <!-- End fetching table data -->
                            </tbody>
                        </table>
                    <?php
                        }
                        else{
                    ?>
                    
                        <br><br>
                        <hr>
                        <div class="text-danger">Error ! No data found !</div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
