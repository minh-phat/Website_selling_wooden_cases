<?php

    // Define variables and initialize with empty values
    $Product_ID = $Product_Name = $Category = $ProductImage = $Thickness = $Width = $Length = $Details = $Price ="";
    $ProductImage_err = $Product_Name_err = $Category_err = $Details_err = $Price_err = "";

    require_once('conn.php'); //connect to database infile conn.php

    session_start();

    // Check if the admin is logged in, if not then redirect him to login page
    if(!isset($_SESSION["AdminLogin"]) || $_SESSION["AdminLogin"] !== true){
        header("location: ../index.php");
        exit;
    }

    if(isset($_GET['id'])){
        $_SESSION["ProducID"] = $_GET['id'];
    }
    

    $Product_ID = $_SESSION["ProducID"];

    //show data product old in <input>
    $queryShowProduct = "SELECT Product_Name FROM products WHERE Product_ID = '$Product_ID'";
    $resultShowProduct = mysqli_query($link,$queryShowProduct);/* dùng để chạy câu lệnh đó trong mysql*/

    //show price of prodcuct
    $queryShowPrice = "SELECT Price FROM products WHERE Product_ID = '$Product_ID'";
    $resultShowPrice = mysqli_query($link,$queryShowPrice);/* dùng để chạy câu lệnh đó trong mysql*/

    //show price of product
    $queryShowDetails = "SELECT Details FROM products WHERE Product_ID = '$Product_ID'";
    $resultShowDetails = mysqli_query($link,$queryShowDetails);/* dùng để chạy câu lệnh đó trong mysql*/

    //show Category_ID of product
    $queryShowCategory = "SELECT Category_ID FROM products WHERE Product_ID = '$Product_ID'";
    $resultShowCategory = mysqli_query($link,$queryShowCategory);/* dùng để chạy câu lệnh đó trong mysql*/
    $rowCategory = mysqli_fetch_array($resultShowCategory);  
    $CategoryIDOld = $rowCategory['Category_ID'];

    //show Category_Name of product
    $queryCategoryName =   "SELECT Category_Name 
                            from `products` 
                            inner join categories 
                            on products.Category_ID=categories.Category_ID 
                            where products.Product_ID =  '$Product_ID'";
    $resultCategoryName = mysqli_query($link,$queryCategoryName);
    $rowCategoryName = mysqli_fetch_array($resultCategoryName) ;
    $CategoryNameOld = $rowCategoryName['Category_Name'];

    //show data category in <input>
    $query = "SELECT Category_Name,Category_ID FROM categories Where Category_ID <> '$CategoryIDOld' ORDER BY Category_ID ASC;";
    $result = mysqli_query($link,$query);/* dùng để chạy câu lệnh đó trong mysql*/

    //show thickness current of product
    $queryShowThickness = "SELECT Thickness FROM products WHERE Product_ID = '$Product_ID'";
    $resultShowThickness1 = mysqli_query($link,$queryShowThickness);/* dùng để chạy câu lệnh đó trong mysql*/
    $rowShowThickness= mysqli_fetch_array($resultShowThickness1 ) ;
    $ThicknessOld  = $rowShowThickness['Thickness'];

    //show width current of product
    $queryShowWidth = "SELECT Width FROM products WHERE Product_ID = '$Product_ID'";
    $resultShowWidth = mysqli_query($link,$queryShowWidth);/* dùng để chạy câu lệnh đó trong mysql*/
    $rowWidth = mysqli_fetch_array($resultShowWidth);
    $WidthOld  = $rowWidth['Width'];

    //show Length current of product
    $queryShowLength = "SELECT Longs FROM products WHERE Product_ID = '$Product_ID'";
    $resultShowLength = mysqli_query($link,$queryShowLength);/* dùng để chạy câu lệnh đó trong mysql*/
    $rowLength = mysqli_fetch_array($resultShowLength);
    $LengthOld  = $rowLength['Longs'];

    // after submit command run
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

            //update data into database 
            $queryUpdate=  "UPDATE products 
                            SET Product_Name='" . $Product_Name . "', 
                                Images='" . $ImplodeImgArr. "', 
                                Category_ID='" . $Category. "', 
                                Images='" . $ImplodeImgArr. "', 
                                Details='" . $Details. "', 
                                Price='" . $Price. "',  
                                Thickness='" . $Thickness. "', 
                                Width='" . $Width. "', 
                                Longs='" . $Length. "'
                            Where Product_ID=$Product_ID ";
            if (mysqli_query($link, $queryUpdate)){
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
    include('header.php')
?>
<head>
    <title>Add product </title>
</head>
    <div class="layout-page">
        <div class="container" style="margin-top: 20px;">
            <div class="row">
                <div class="col-md-12">
                    <h2>Update product <?php echo $Product_ID ;?></h2>
                    
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
                            <input type="text" name="name" 
                                    class="form-control <?php echo (!empty($Product_Name_err)) ? 'is-invalid' : ''; ?>" 
                                    placeholder="Enter product name" 
                                    value="<?php $rowProduct = mysqli_fetch_array($resultShowProduct); echo $rowProduct['Product_Name'];?>">
                            <span class="invalid-feedback"><?php echo $Product_Name_err; ?></span>
                        </div>               

                        <div class="md-3">
                            <label for="category" class="form-label">Brand</label>
                            <select name="category" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $rowProduct['Category_ID'];?>">
                            <span class="invalid-feedback"><?php echo $Category_err; ?></span>
                            <?php
                                
                            ?>
                                <option value="<?php echo $CategoryIDOld; ?>"><?php echo  $CategoryNameOld; ?></option>
                            <?php
                            
                            ?>
                            <?php 
                                //show category  has in database
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
                            <input type="number" name="price" class="form-control <?php echo (!empty($Price_err)) ? 'is-invalid' : ''; ?>" 
                                    placeholder="Enter product price" 
                                    value="<?php $rowPrice = mysqli_fetch_array($resultShowPrice); echo $rowPrice['Price'];?>">
                            <span class="invalid-feedback"><?php echo $Price_err; ?></span>
                        </div>

                        <div class="md-3">
                            <label for="details" class="form-label">Details</label>
                            <textarea type="text" name="details" class="form-control <?php echo (!empty($Details_err)) ? 'is-invalid' : ''; ?>" 
                                        placeholder="Enter product details" 
                                        id="details">
                            </textarea>

                            <!------------------<<script set value for type text----------------->
                            <script>
                                document.getElementById("details").value += '<?php $rowDetails = mysqli_fetch_array($resultShowDetails); echo $rowDetails['Details'];?>';
                            </script>
                            <!------------------script set value for type text>>----------------->
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
                            <input type="number" name="thickness" class="form-control" placeholder="Enter available" value="<?php echo $ThicknessOld;?>">
                        </div>

                        <div class="md-3">
                            <label for="available" class="form-label">Width</label>
                            <input type="number" name="width" class="form-control" placeholder="Enter available" value="<?php echo $WidthOld;?>">
                        </div>

                        <div class="md-3">
                            <label for="available" class="form-label">Length</label>
                            <input type="number" name="length" class="form-control" placeholder="Enter available" value="<?php echo $LengthOld;?>">
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
