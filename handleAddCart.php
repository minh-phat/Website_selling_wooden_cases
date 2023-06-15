
<?php
session_start();

require_once "conn.php";

$getProductID = $_GET['productID'];

$quantity = $_POST['quantity'];

$queryProduct = "SELECT  * from products INNER JOIN categories on products.Category_ID = categories.Category_ID where Product_ID= '$getProductID'";
$resultProduct = mysqli_query($link,$queryProduct);/* dùng để chạy câu lệnh đó trong mysql*/
if(isset($_SESSION['cart'])){
    
}else{
    $_SESSION['cart']=array(); // only declare 1 time
}
foreach($resultProduct as $row){
    $arr=array("name"=>$row['Product_Name'],
                "productID" =>$row['Product_ID'],
                "quantity"=>$quantity,
                "img"=>$row['Images'],
                "price" => $row['Price']
            ); 
}
array_push($_SESSION['cart'],$arr); // Items added to cart

header("location: shop.php");//go to listAdmin.php page 



?>