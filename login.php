<?php
// Initialize the session
session_start();
require_once "conn.php";

// Define variables and initialize with empty values
$Admin_Username = $Admin_Password = "";
$Admin_Username_err = $Admin_Password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

   
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $Admin_Username_err = "Please enter username.";
    } else{
        $Admin_Username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $Admin_Password_err = "Please enter your password.";
    } else{
        $Account_Password= trim($_POST["password"]);
        $_SESSION['password']= $Account_Password;
    }
    
    $sqlCustomerLogin = "SELECT User_name, Account_Password,Account_Role,Account_Name,AccountID FROM account WHERE User_name = '$Admin_Username' and Account_Role= 'customer'";
    $rsCustomerLogin = mysqli_query($link,$sqlCustomerLogin);
    $numRows = mysqli_num_rows($rsCustomerLogin);

    if ($numRows == 1){

        //get data from databse throught query command 
        $row = mysqli_fetch_assoc($rsCustomerLogin);
        $_SESSION['Name'] = $row['Account_Name']; // take name from database 
        $_SESSION['CustomerID'] = $row['AccountID'];
        if(password_verify($Account_Password,$row['Account_Password'])){
            
            $_SESSION['failed']= null;//destroy a session
            $_SESSION['CustomerLogin'] = true;
            

        }else{
            $_SESSION['failed']= "Invalid username or password";
        }
    }else{
        $_SESSION['failed']= "Invalid username or password.";
    }

    $sqlAdminLogin = "SELECT User_name, Account_Password,Account_Role,Account_Name FROM account WHERE User_name = '$Admin_Username' and Account_Role= 'admin'";
    $rsAdminLogin = mysqli_query($link,$sqlAdminLogin);
    $numRows = mysqli_num_rows($rsAdminLogin);

    if ($numRows == 1){
        $row = mysqli_fetch_assoc($rsAdminLogin);
        $_SESSION['Name'] = $row['Account_Name'];
        if(password_verify($Account_Password,$row['Account_Password'])){
            
            $_SESSION['failed']= null;//destroy a session
            $_SESSION['AdminLogin'] = true;
        }else{
            $_SESSION['failed']= "Invalid username or password";
        }
    }else{
        $_SESSION['failed']= "Invalid username or password.";
    }
   


    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["AdminLogin"]) && $_SESSION["AdminLogin"] === true){
        //header("location: adminList.php"); // go to listAdmin.php and set name $Admin_Name
        header("location: admin/adminList.php");
        exit; //use to exit current page
    }
    if(isset($_SESSION["CustomerLogin"]) && $_SESSION["CustomerLogin"] === true){
        header("location: index.php"); // go to listAdmin.php and set name $Admin_Name
        exit; //use to exit current page
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/logoWebsite.ico">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js"
        integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous">
    </script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css'>
    <link rel="stylesheet" href="css/login_style.css">
    <link rel="stylesheet" href="css/button_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="container">
        <div id="login-form">
            <a href="index.php" class="btn"
                style="margin-top: -60px;margin-left: -45px; font-size:1.2rem; color:#59ab6e; border:none;">
                <i class="fa fa-angle-double-left"></i> Back
            </a>
            <div class="row" style="align-items: center;">
                <div class="col-lg-7">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                        <h3 class="login-header">Sign in</h3>

                        <!-- check for session message -->
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
                        <!-- end of session message -->

                        <div class="form-group">
                            <input type="text" class="form-control <?php echo (!empty($Admin_Username_err)) ? 'is-invalid' : ''; ?>" placeholder="Username or Email" name="username">
                            <span class="invalid-feedback"><?php echo $Admin_Username_err; ?></span>
                        </div>
                        

                        <div class="form-group">
                            <input type="password" class="form-control <?php echo (!empty($Admin_Password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password" name="password">
                            <span class="invalid-feedback"><?php echo $Admin_Password_err;?></span>
                            
                        </div>
                        
                        <button class="btn btn-primary btn-lg btn-block submit custom-btn btn-3"><span>Sign
                                in</span></button>
                    </form>
                    <div class="row">
                        <div class="col text-center ">
                            <p style="text-align: center">OR</p>
                            <button class="btn btn-primary btn-lg btn-block submit custom-btn btn-3"><a
                                    href="signup.php" class="home"
                                    style="text-decoration: none"><span>Register
                                        now</span></a></button>
                            <!-- {{-- <a class="register" href="#">Register now</a> --}} -->
                        </div>
                        <!-- {{-- <div class="col text-center">
                        <a href="#" class="forgot-pass">Forgot password?</a>
                    </div> --}} -->
                    </div>
                </div>
                <div class="col-lg-5">
                    <a class="btn btn-block social-login google" href="signup.php">
                        <span class="social-icons">
                            <i class="fab fa-google fa-lg">
                            </i>
                        </span>
                        <span class="align-middle">Login with Google</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- partial -->

</body>

</html>
