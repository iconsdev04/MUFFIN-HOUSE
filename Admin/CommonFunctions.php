<?php


//Santize the the string
function SanitizeInput($input){
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    //$input = strtoupper($input);
    return $input;
}


//sanitize the input integer
function SanitizeInt($intinput){
    $intinput = trim($intinput);
    $intinput = preg_replace('/[+-]/','',$intinput);
    $intinput = filter_var($intinput, FILTER_SANITIZE_NUMBER_INT);
    return $intinput;
}



//sanitize the decimal integer
function SanitizeDecimal($decinput){
    $decinput = trim($decinput);
    $decinput = preg_replace('/[+-]/','',$decinput);
    $decinput = filter_var($decinput, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    return $decinput;
}



function SetTableStatus($tableId){
    include '../MAIN/Dbconfig.php';
    $tableid = $tableId;
    $CheckOrders = mysqli_query($con, "SELECT * FROM order_main WHERE orderStatus = 'PENDING' AND orderTable = '$tableid'");
    if(mysqli_num_rows($CheckOrders) > 0){
        
    }
    else{
        $updateTable = mysqli_query($con, "UPDATE table_master SET tableStatus = 'EMPTY' WHERE tId = '$tableid'");
        if($updateTable){

        }
    }
}


function SetTableStatusOrdering($tableId){
    include '../MAIN/Dbconfig.php';
    $tableid = $tableId;
    $updateTable = mysqli_query($con, "UPDATE table_master SET tableStatus = 'OCCUPIED' WHERE tId = '$tableid'");
    if($updateTable){

    }
}

