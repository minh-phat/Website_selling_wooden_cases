<?php
        $link = mysqli_connect('localhost','crud_username','crud_password','selling_woods_web');
        // Check connection
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
?>