<?php


// Include config file
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
        $Admin_Password = trim($_POST["password"]);
    }
    
    //take name of admin when admin login account
    $query = "SELECT Admin_Name FROM admins Where Admin_Username = '$Admin_Username' and Admin_Password = '$Admin_Password';";
    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_array($result);
    $Admin_Name = $row;

    // Validate credentials
    if(empty($Admin_Username_err) && empty($Admin_Password_err)){
        // Prepare a select statement
        $sql = "SELECT Admin_Username, Admin_Name, Admin_Password FROM admins WHERE Admin_Username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $Admin_Username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $Admin_Username, $Admin_Name, $hashed_password); 
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($Admin_Password, $hashed_password)){ //$hased_pasword use to hashed passowrd when enter data password
                            // Password is correct, so start a new session
                            
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["Admin_Username"] = $Admin_Username;
                            //$_SESSION["Admin_Name"] = $Admin_Name;

                            // Redirect user to welcome page
                            
                            //header("location: listAdmin.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($link);

    // Initialize the session
    session_start();

    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $_SESSION["Admin_Name"] = $Admin_Name;
        header("location: adminList.php"); // go to listAdmin.php and set name $Admin_Name
        exit; //use to exit current page
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!--link boostrap for class="inavalid-deedback"-->

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" style="margin-top: 20px">
                <h4>Admin Login</h4>
                <hr>
                <?php
                    //notification error
                    if(!empty($login_err)){
                        echo '<div class="alert alert-success" role="alert">' .$login_err. '</div>';
                    }
                ?>
                

                <!-- admin signin form -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">                
                    <div class="form-group">
                        <label for="username">Admin username</label>
                        <input type="text" 
                                class="form-control <?php echo (!empty($Admin_Username_err)) ? 'is-invalid' : ''; ?>" 
                                value="<?php echo $Admin_Username; ?>" 
                                placeholder="Enter admin username" 
                                name="username">
                        <span class="invalid-feedback"><?php echo $Admin_Username_err; ?></span>                       
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control <?php echo (!empty($Admin_Password_err)) ? 'is-invalid' : ''; ?>" 
                                placeholder="Enter password" 
                                name="password">
                        <span class="invalid-feedback"><?php echo $Admin_Password_err; ?></span>                     
                    </div>

                    <button class="btn btn-block btn-primary" type="submit" style="margin-top: 10px">Login</button>
                </form>
                <!-- end of admin sign in form -->
                <br>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

</html>
