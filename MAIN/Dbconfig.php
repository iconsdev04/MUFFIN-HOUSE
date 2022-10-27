


<?php


    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "muffin_db";


    $con = mysqli_connect($servername,$username,$password,$database);


    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }

    

    date_default_timezone_set('Asia/Kolkata');

    //echo date('Y-m-d h:i:s a');
?>