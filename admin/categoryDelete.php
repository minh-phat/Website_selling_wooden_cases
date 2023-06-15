<?php
    require_once('conn.php'); //connect to database infile conn.php
    session_start();//to run $_SESSION;
   
    $_SESSION["Category_ID"] = $_GET['id']; //$_SESSION is variable is save forever , only when ussing session_destroy() command will it to lost $_SESSION

    $Category_ID = $_SESSION["Category_ID"];
    $query ="DELETE FROM categories WHERE Category_ID=$Category_ID";

    $result = mysqli_query($link,$query);

    if ($link->query($query) === TRUE) {
  			
		
        $_SESSION["notification"] = "Record deleted successfully";	
        header("location: categoryList.php");//go to listAdmin.php page 
        

    } 
    else {
        echo "Error deleting record: " . $link->error;
    }

?>