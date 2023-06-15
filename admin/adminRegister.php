<?php

//must start session to session can take data from session
session_start();

//check if admin login is alow add a new admin
if(isset($_SESSION["loggedin"]))
{

    // Include config file
    require_once "conn.php";

    // Define variables and initialize with empty values
    $Admin_Name_Add = $Admin_Username = $Admin_Password = $confirm_password = "";
    $Admin_Name_Add_err = $Admin_Username_err = $Admin_Password_err = $confirm_password_err = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Validate username
        if (empty(trim($_POST["username"]))) {
            $Admin_Username_err = "Please enter a username.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
            $Admin_Username_err = "Username can only contain letters, numbers, and underscores.";
        } else {
            // Prepare a select statement
            $sql = "SELECT Admin_Username FROM admins WHERE Admin_Username = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Set parameters
                $param_username = trim($_POST["username"]);

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    /* store result */
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $Admin_Username_err = "This username is already taken.";
                    } else {
                        $Admin_Username = trim($_POST["username"]);
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
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Please confirm password.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($Admin_Password_err) && ($Admin_Password != $confirm_password)) {
                $confirm_password_err = "Password did not match.";
            }
        }
        
        // Check input errors before inserting in database
        if (empty($Admin_Username_err) && empty($Admin_Password_err) && empty($confirm_password_err)) {

            // Prepare an insert statement
            $sql = "INSERT INTO admins (Admin_Username, Admin_Name, Admin_Password) VALUES (?, ?, ?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_name, $param_password);

                // Set parameters
                $param_username = $Admin_Username;
                $param_name = $Admin_Name_Add;
                $param_password = password_hash($Admin_Password, PASSWORD_DEFAULT); // Creates a password hash

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Redirect to login page
                    header("location: index.php");
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

        <?php
        include('Navigation_bar.php');
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4" style="margin-top: 20px">
                    <h4>Add new admin</h4>
                    <hr>
                    <!-- Notification -->
                
                    <!-- End notification -->
                    <!-- Start form -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <!-- Enter name -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control <?php echo (!empty($Admin_Name_Add_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Admin_Name_Add; ?>" placeholder="Enter Admin Name" name="name">
                            <span class="invalid-feedback"><?php echo $Admin_Name_Add_err; ?></span>
                            <!--print notification if don't have name -->
                        </div>

                        <!-- Enter username -->
                        <div class="form-group">
                            <label for="username">Admin username</label>
                            <input type="text" class="form-control<?php echo (!empty($Admin_Username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Admin_Username; ?>" placeholder="Enter admin username" name="username">
                            <span class="invalid-feedback"><?php echo $Admin_Username_err; ?></span>
                            <!--print notification if don't have name -->
                        </div>


                        <!-- Enter password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control <?php echo (!empty($Admin_Password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Admin_Password; ?>" placeholder="Enter password" name="password">
                            <span class="invalid-feedback"><?php echo $Admin_Password_err; ?></span>
                        </div>

                        <!-- Confirm password -->
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Confirm password" name="confirm_password">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>

                        <br>
                        <button class="btn btn-block btn-primary" type="submit" style="margin-top: 10px">Add</button>
                        <a href="{{ url('listAdmin') }}" class="btn btn-danger" style="margin-top: 10px">Back</a>
                    </form>
                    <!-- end form -->
                    <br>
                    <a href="loginAdmin" class="btn btn-success">Login Admin</a>
                </div>
            </div>
        </div>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    </html>
<?php
}
else{
    header("location: listAdmin.php");
}
?>
