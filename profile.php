
<?php
    include('header.php');

    require_once "conn.php";

    $accountID = $_SESSION['CustomerID'];
    $queryCategory = "SELECT * FROM account Where AccountID = '$accountID'";
    $resultCategory = mysqli_query($link,$queryCategory);/* dùng để chạy câu lệnh đó trong mysql*/
?>
<head>
    <title>Contact</title>
</head>

<!-- ống icon nha
<i class="far fa-user-circle"></i> Username
<i class="fas fa-address-card"></i> Name
<i class="fas fa-envelope"></i> Email
<i class="fas fa-phone"></i> Phone
<i class="fas fa-home"></i> Address
<i class="fas fa-user"></i> Gender
<i class="fas fa-birthday-cake"></i> Birthday -->

<?php
    if(isset($_SESSION['CustomerLogin'])){
        foreach($resultCategory as $row){
?>
    
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <?php
                                if ($row['Gender'] == 'male'){
                            ?>
                                <img src="../img/ProfilePics/Placeholder_PFP_Male.jpg" class="rounded-circle img-fluid"
                                    style="width: 273px;">
                            <?php
                                }
                                elseif ($row['Gender'] == 'female'){
                            ?>
                                <img src="../img/ProfilePics/Placeholder_PFP_Female.jpg" class="rounded-circle img-fluid"
                                    style="width: 273px;">
                            <?php
                                }
                                else{
                            ?>
                                <img src="../img/ProfilePics/Placeholder_PFP_Other.png" class="rounded-circle img-fluid"
                                    style="width: 273px;">
                            <?php
                                }
                            ?>
                            <h2 class="my-3"><?php echo $row['Account_Name'] ;?></h2>
                            <h3 class="text-muted mb-1"><?php echo $row['User_Name'] ;?></h3>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <a class="btn btn-primary" href="{{ url('editProfile') }}">Update information</a>
                            <!-- @if (session()->get('loggedWith') !== 'google')
                                <a class="btn btn-primary" href="{{ url('customerEditPassword') }}">Change password</a>
                            @endif -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body" style="font-size:20px;">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><i class="fas fa-address-card"></i> | Full Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $row['Account_Name'] ;?></p>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><i class="fas fa-phone"></i> | Phone</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $row['Phone'] ;?></p>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><i class="fas fa-home"></i> | Address</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $row['Account_Address'] ;?></p>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><i class="fas fa-user"></i> | Gender</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $row['Gender'] ;?></p>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><i class="fas fa-birthday-cake"></i> | Birthday</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo date('d/m/Y', strtotime($row['Date_Of_Birth'])) ;?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
<?php
        }
    }else{
?>
    <p>Looks like you have not logged in yet! To see your own profile you need to
        <a href="{{ url('customerLogin') }}" style="color: #23B35A">Login here</a> or
        <a href="{{ url('customerRegister') }}"style="color: #23B35A">Sign up here</a>.
    </p>
<?php
    }
?>



 <!-- Start Contact -->
<div class="container py-5">
</div>
<!-- End Contact --> 

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
</body>

</html>
