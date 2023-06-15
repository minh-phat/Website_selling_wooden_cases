<?php
//must start session to session can take data from session
session_start();

// Check if the admin is logged in, if not then redirect him to login page
if(!isset($_SESSION["AdminLogin"]) || $_SESSION["AdminLogin"] !== true){
    header("location: ../index.php");
    exit;
}
require_once "conn.php";//connect database

$GetName = $categoryName = $categoryImage = ""; //set variable empty value
$categoryName_err = $categoryImage_err = $Notification = ""; //set variable empty value

//take value from id into $_SESSION["Category_ID"]
if(isset($_GET['id'])){
    $_SESSION['Category_ID'] = $_GET['id'];
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //check if empty category will require enter again 
    if (empty(trim($_POST["name"]))) {
        $categoryName_err = "Please enter a category name.";
    }else {
         // Prepare a select statement
         $sql = "SELECT Category_Name FROM categories WHERE Category_Name = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $categoryName);

            // Set parameters
            $categoryName = trim($_POST["name"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $categoryName_err = "This username is already taken.";
                } else {
                    $categoryName = $_POST["name"]; 

                    $target_dir = "../img/categories/";
                    $target_file = $target_dir . basename($_FILES["categoryImage"]["name"]);

                    if (move_uploaded_file($_FILES["categoryImage"]["tmp_name"], $target_file)) 
                    {
                        //echo "The file has been successfully uploaded $target_file";
                        $categoryImage =  basename($_FILES["categoryImage"]["name"]); 
                    } 
                    else
                    {
                        echo "File not uploaded. Something is Wrong";
                    }
                    
                        $Category_ID = $_SESSION['Category_ID'];
                
                    $query="UPDATE categories SET Category_Name='" . $categoryName . "', Category_Image='" . $categoryImage . "' where Category_ID=$Category_ID ";
                    
                        
                    if (mysqli_query($link, $query)){
                        
                        $Notification = "Successfully edited category is $categoryName" ;
                    } 

                }
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
   include('header.php')
?>
    <div class="layout-page">
        <div class="container" style="margin-top: 20px;">
            <div class="row">
                <div class="col-md-12">
                    <h2>Edit Brand <!-- echo htmlspecialchars($_SESSION["Category_ID"]); // use to check $_SESSION["Category_ID"]?> --></h2>
                    <?php
                    if(!empty($Notification)){
                    ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $Notification;?>
                            
                        </div>
                    <?php
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
                            <input type="file" name="categoryImage"  class="form-control <?php echo (!empty($categoryImage_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $categoryImage_err; ?></span>
                        </div>
                    
                        <br>
                        
                        <button type="submit" class="btn btn-primary">submit</button>
                        <a href="categoryList.php" class="btn btn-danger">Back</a>
                    </form>
                    <!-- End form -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>
