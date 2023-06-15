<?php
//must start session to session can take data from session
session_start();



// Check if the admin is logged in, if not then redirect him to login page
if(!isset($_SESSION["AdminLogin"]) || $_SESSION["AdminLogin"] !== true){
    header("location: ../index.php");
    exit;
}
    
require_once "conn.php";//connect database

$categoryName = $categoryImage = ""; //set variable empty value
$categoryName_err = $categoryImage_err = $Notification = ""; //set variable empty value

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_SESSION["success"] = null ;
    $_SESSION["failed"] = null;

    //check if empty category will require enter again 
    if (empty(trim($_POST["name"]))) {
        $categoryName_err = "Please enter a category name.";
    }else {      
        
        // if have username in databse require enter againt
        $sql = "SELECT Category_Name FROM categories WHERE Category_Name = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $categoryNameCheck);

            // Set parameters
            $categoryNameCheck = trim($_POST["name"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $categoryName_err = "This username is already taken.";
                } else {
                    $categoryName = $_POST["name"]; 
                }
            }
        }
    } 

    //check if empty image will require enter again 
    if (!empty($_FILES["categoryImage"]["tmp_name"])){       

        $target_dir = "../img/categories/";
        $target_file = $target_dir . basename($_FILES["categoryImage"]["name"]);

        // add file image into file which hope
        if (move_uploaded_file($_FILES["categoryImage"]["tmp_name"], $target_file)) 
        {
            //take value frome name=categoryImage in form action
            $categoryImage =  basename($_FILES["categoryImage"]["name"]); 
        } 

    }else {
        $categoryImage_err = "Please enter a category name.";     
    }

        //check if empty image will require notification failed else notification succsfull add insert data into database 
    if (!empty($categoryName  && $categoryImage )){
        $query2 = "INSERT INTO categories (`Category_Name`,`Category_Image`) VALUES ('".$categoryName."','".$categoryImage ."')";
            
        if (mysqli_query($link, $query2)){
            
            $_SESSION["success"] = "Successfully inserted category is $categoryName";
            
        } 
    }else{
        $_SESSION['failed'] = "Add data Failed";
    }          
    // Close connection
    mysqli_close($link);
}    
?>
<?php
    //run Navigation_bar page for header of web
    include('header.php');
?>
    <div class="layout-page">
        <div class="container" style="margin-top: 20px;">
            <div class="row">
                <div class="col-md-12">
                    <h2>Add a new Brand</h2>

                    <!-- print notification when add data -->
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

                    <!-- Start Form -->
                    <!--  echo htmlspecialchars($_SERVER["PHP_SELF"]); use to run file itself-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">                    
                        <!-- Enter category -->
                        <div class="md-3">
                            <label for="name" class="form-label">Brand Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($categoryName_err)) ? 'is-invalid' : ''; ?>"  placeholder="Enter category name">
                            <span class="invalid-feedback"><?php echo $categoryName_err; ?></span>
                        </div>
                    

                        <div class="md-3">
                            <label for="image" class="form-label">Brand Image</label>
                            <input type="file" name="categoryImage"  class="form-control <?php echo (!empty($categoryImage_err)) ? 'is-invalid' : ''; ?>" value="">
                            <span class="invalid-feedback"><?php echo $categoryImage_err; ?></span>
                        </div>
                    
                        <br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="categoryList.php" class="btn btn-danger">Back</a>
                    </form>
                    <!-- End form -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>
