
<?php
// Include config file
require_once "admin/conn.php";

// Define variables and initialize with empty values
$Admin_Name_Add = $Admin_Username = $Admin_Password = $confirm_password = "";
$Admin_Name_Add_err = $Admin_Username_err = $Admin_Password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $Phone = $_POST["phone"];
    $Address = $_POST["address"];
    if(!empty($_POST['gender'])) {
        $gender = $_POST["gender"];
    }else{
        $gender ="";
    }
    
    $DoB = $_POST["DoB"];
    // Validate username
    if (empty(trim($_POST["userName"]))) {
        $Admin_Username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["userName"]))) {
        $Admin_Username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        // Prepare a select statement
        $sql = "SELECT User_name FROM account WHERE User_name = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["userName"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $Admin_Username_err = "This username is already taken.";
                } else {
                    $Admin_Username = trim($_POST["userName"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $Admin_Name_Add_err = "Please enter a name.";
    }
    else {
        $Admin_Name_Add = trim($_POST["name"]); // save name of admin into $Admin_Name_Add
    }    

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $Admin_Password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $Admin_Password_err = "Password must have atleast 6 characters.";
    } else {
        $Admin_Password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirmPassword"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirmPassword"]);
        if (empty($Admin_Password_err) && ($Admin_Password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    
    // Check input errors before inserting in database
    if (empty($Admin_Username_err) && empty($Admin_Password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO account (User_Name, Account_Name, Account_Password,Phone,Account_Address,Date_Of_Birth,Gender,Account_Role) VALUES (?, ?, ?,'".$Phone ."','".$Address ."','".$DoB ."','".$gender ."','customer')";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_name, $param_password);

            // Set parameters
            $param_username = $Admin_Username;
            $param_name = $Admin_Name_Add;
            $param_password = password_hash($Admin_Password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {              
                $_SESSION['success'] = "Register Successful";
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Male Fashion - Sign in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/logoWebsite.ico">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js"
        integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous">
    </script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css'>
    <link rel="stylesheet" href='css/login_style.css'>
    <link rel="stylesheet" href='css/button_style.css'>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="container">
        <div id="login-form">
            <div class="row" style="justify-content: center;">
                <div class="col-lg-7">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">                     
                       
                        <?php /*if (Session::has('data')) {
                            $data = Session::get('data');
                            $_SESSION['social'] = 'You seem to have a new account, please add in your details first!';
                        } */?>
                        <h3 class="login-header" style="text-align: center; font-size:40px">Create a new account</h3>
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
                        <!-- ----------------print notification when add data>>-------------- -->
`
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input id="username" type="text" class="form-control <?php echo (!empty($Admin_Username_err)) ? 'is-invalid' : ''; ?>" placeholder="Username"
                                name="userName">
                            <span class="invalid-feedback"><?php echo $Admin_Username_err; ?></span>
                        </div>
                    

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input id="password" type="password" class="form-control <?php echo (!empty($Admin_Password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password"
                                name="password">
                            <span class="invalid-feedback"><?php echo $Admin_Password_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="confPass">Confirm password:</label>
                            <input id="confPass" type="password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" placeholder="Confirm Password"
                                name="confirmPassword">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input id="name" type="text" class="form-control <?php echo (!empty($Admin_Name_Add_err)) ? 'is-invalid' : ''; ?>" placeholder="Name" name="name"
                                value="">
                            <span class="invalid-feedback"><?php echo $Admin_Name_Add_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone number:</label>
                            <input id="phone" type="text" class="form-control" placeholder="0123456789"
                                name="phone" value="">
                        </div>

                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input id="address"type="text" class="form-control" placeholder="Address"
                                name="address" value="">
                        </div>

                        <p>Gender :
                            <input type="radio" name="gender" value="male">
                            <label>Male</label>
                            <input type="radio" name="gender" value="female">
                            <label>Female</label>
                            <input type="radio" name="gender" value="other">
                            <label>Other</label>
                        </p>
                        <div class="form-group">
                            <label for="dob">Date of birth:</label>
                            <input id="dob" type="date" class="form-control" placeholder="Birth Day"
                                name="DoB" value="">
                        </div>         

                        <button class="btn btn-primary btn-lg btn-block submit custom-btn btn-3"><span>Sign
                                up</span></button>
                    </form>
                    <div class="row">
                        <div class="col text-center ">
                            <a href="login.php" class="home">
                                <button class="custom-btn btn-1" style="text-decoration: none">Login now</button>
                            </a>
                            <!-- {{-- <a class="register" href="#">Register now</a> --}} -->
                        </div>
                        <div class="col text-center">
                            <!-- {{-- <a href="#" class="forgot-pass">Forgot password?</a> --}} -->
                            <a href="index.php" class="home" style="text-decoration: none">
                                <button class="custom-btn btn-1">To home
                                    page</button>
                            </a>
                        </div>
                    </div>

                </div>
                <!-- {{-- <div class="col-lg-5">
				<button class="btn btn-block social-login facebook">
					<span class="social-icons">
						<i class="fab fa-facebook-square fa-lg">
						</i>
					</span>
					<span class="align-middle">Login with Facebook</span>
				</button>
				<button class="btn btn-block social-login google">
					<span class="social-icons">
						<i class="fab fa-google fa-lg">
						</i>
					</span>
					<span class="align-middle">Login with Google</span>
				</button>
			</div> --}} -->
            </div>
        </div>
    </div>
    <!-- partial -->

</body>

</html>
