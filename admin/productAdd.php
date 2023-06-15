<?php

    // Define variables and initialize with empty values
    $Product_Name = $Category = $ProductImage = $Thickness = $Width = $Length = $Details = $Price ="";
    $ProductImage_err = $Product_Name_err = $Category_err = $Details_err = $Price_err = "";

    //show data category in <input>
    require_once('conn.php'); //connect to database infile conn.php
    $query = "SELECT * FROM categories ORDER BY Category_ID ASC;";
    $result = mysqli_query($link,$query);/* dùng để chạy câu lệnh đó trong mysql*/

    session_start();



    // Check if the admin is logged in, if not then redirect him to login page
    if(!isset($_SESSION["AdminLogin"]) || $_SESSION["AdminLogin"] !== true){
        header("location: ../index.php");
        exit;

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // don't need validate
        $Thickness = $_POST["thickness"];
        $Width= $_POST["width"];
        $Length = $_POST["length"];

        //check if empty category will require enter again 
        $imgArr = [] ;
        if (empty(trim($_POST["name"]))) {
            $Product_Name_err = "Please enter a product name.";
        }else {
            $Product_Name = $_POST["name"];
        }
            //take value frome name=categoryImage in form action
            
        //-----------------------------------<<Validation---------------------/
        if (!isset($_FILES["images"]["name"])) {
            $ProductImage_err = "Please choose image.";
        }else {    

            // Count total images
            $count_files = count($_FILES['images']['name']);

            $imgArr = [];
            // Looping all images
            for($i=0;$i<$count_files;$i++){
                $filename = $_FILES['images']['name'][$i];
                // Upload images
                move_uploaded_file($_FILES['images']['tmp_name'][$i],'../img/products/' .$filename);

                array_push($imgArr, $filename);

                // add @@@ into array to know the array components 
                $ImplodeImgArr = implode("@@@", $imgArr ); 
            }
                     
        }

        if (empty(trim($_POST["category"]))) {
            $Category_err = "Please choose a category.";
        }else {
            $Category = $_POST["category"];
        }
        if (empty(trim($_POST["price"]))) {
            $Price_err = "Please choose a category.";
        }else {
            $Price = $_POST["price"];
        }

        if (empty(trim($_POST["details"]))) {
            $Details_err = "Please enter available.";
        }else {
            $Details = $_POST["details"];
        }



        //-----------------------------------Validation>>---------------------/

        
        if(!empty($Product_Name &&  $ImplodeImgArr && $Category && $Price && $Details)){

            //insert data into database 
            $query2 = "INSERT INTO products (`Product_Name`,`Images`,`Category_ID`, `Details`, `Price`,`Thickness` ,`Width` ,`Longs`) VALUES ('".$Product_Name."','".$ImplodeImgArr ."','".$Category ."','".$Details ."','".$Price ."','".$Thickness ."','".$Width ."','".$Length ."')";    

            if (mysqli_query($link, $query2)){
                $_SESSION['success'] = "Add Successful";
            }
        }
        else{
            $_SESSION['failed'] = "Add failed";
        }


        // Close connection
        mysqli_close($link);
    }
?>


<?php
    //run Navigation_bar page for header of web
    include('header.php');
?>
<head>
    <title>Add product</title>
</head>
    <div class="layout-page">
        <div class="container" style="margin-top: 20px;">
            <div class="row">
                <div class="col-md-12">
                    <h2>Add a new product</h2>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        
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

                        <div class="md-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($Product_Name_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter product name" value="">
                            <span class="invalid-feedback"><?php echo $Product_Name_err; ?></span>
                        </div>               

                        <div class="md-3">
                            <label for="category" class="form-label">Brand</label>
                            <select name="category" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>" value="">
                            <span class="invalid-feedback"><?php echo $Category_err; ?></span>
                            <?php 
                                while ($row = mysqli_fetch_array($result)){
                            ?>
                                    <option value="<?php echo $row['Category_ID']; ?>"><?php echo  $row['Category_Name']; ?></option>
                            <?php
                                }
                            ?>
                            </select>
                        </div>               

                        <div class="md-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" class="form-control <?php echo (!empty($Price_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter product price" value="{{old('price')}}">
                            <span class="invalid-feedback"><?php echo $Price_err; ?></span>
                        </div>

                        <div class="md-3">
                            <label for="details" class="form-label">Details</label>
                            <textarea type="text" name="details" class="form-control <?php echo (!empty($Details_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter product details"></textarea>
                            <span class="invalid-feedback"><?php echo $Details_err; ?></span>
                        </div>

                        <div class="md-3">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" name="images[]" class="form-control <?php echo (!empty($ProductImage_err)) ? 'is-invalid' : ''; ?>" multiple="" style="width: 350px" id="file-input">
                            <span class="invalid-feedback"><?php echo $ProductImage_err; ?></span>

                            <br>
                            <label for="preview">Previews</label>
                            <div id="preview" style="width:220px;height:220px" class="form-control" ></div> <!--preview area-->
                            <br>
                            <!-- Script to preview multiple uploaded images -->

                            <script>
                                function previewImages() {
                                    var preview = document.querySelector('#preview');
                                    preview.innerHTML = '';     //clear previous previews
                                    preview.style = "width:fit-content";    //change the preview <div> style to fit the new childs (images in this case)
                                    if (this.files) {
                                        [].forEach.call(this.files, readAndPreview);
                                    }
                                    function readAndPreview(file) {
                                        // Make sure `file.name` matches our extensions criteria
                                        if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
                                            return alert(file.name + " is not an image");
                                        }
                                        var reader = new FileReader();
                                        reader.addEventListener("load", function() {
                                            var image = new Image();
                                            image.height = 210;
                                            image.width = 210;
                                            image.title = file.name;
                                            image.style = "border-radius: 10px; margin: 5px"    //image attributes
                                            image.src = this.result;
                                            preview.appendChild(image);
                                        });
                                        reader.readAsDataURL(file);
                                    }
                                }
                                document.querySelector('#file-input').addEventListener("change", previewImages);
                            </script>

                        </div>            

                        <div class="md-3">
                            <label for="available" class="form-label">Thickness</label>
                            <input type="number" name="thickness" class="form-control" placeholder="Enter available" value="">
                        </div>

                        <div class="md-3">
                            <label for="available" class="form-label">Width</label>
                            <input type="number" name="width" class="form-control" placeholder="Enter available" value="">
                        </div>

                        <div class="md-3">
                            <label for="available" class="form-label">Length</label>
                            <input type="number" name="length" class="form-control" placeholder="Enter available" value="">
                        </div>

                        <br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="productList.php" class="btn btn-danger">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>


</html>
