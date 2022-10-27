<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';
$tableId = $_SESSION['TableId'];
$TempTable = 'table_temp';


function CartClear(){
    include '../MAIN/Dbconfig.php';
    $TempTable = 'table_temp';
    $ClearCart = mysqli_query($con, "DELETE FROM $TempTable WHERE quantity = '0'");
    if($ClearCart){
        //echo 'Success';
    }
}



if(isset($_POST['ArrayData'])){

    foreach ($_POST['ArrayData'] as  $key => $value){
        $product = $value["0"];
        $quantity = $value["2"];
        $price = $value["1"];
        if($quantity > 0){
            $findProductDetails = mysqli_query($con, "SELECT * FROM product_master WHERE productName = '$product'");
            foreach($findProductDetails as $productResults){
                $productPrice = $productResults['productPrice'];
            }
            $checkifexists = mysqli_query($con, "SELECT * FROM $TempTable WHERE product = '$product'");
            if(mysqli_num_rows($checkifexists) > 0){

                $insertIntotable = mysqli_query($con, "UPDATE $TempTable SET quantity = quantity + $quantity WHERE product = '$product'");
            }
            else{
                $find_MaxId = mysqli_query($con,"SELECT MAX(temp_id) FROM $TempTable");
                foreach($find_MaxId  as $maxResult){
                    $TempId = $maxResult['MAX(temp_id)'] + 1;
                }
                $insertIntotable = mysqli_query($con, "INSERT INTO  $TempTable (temp_id,tableId,product,quantity,Price) 
                VALUES ('$TempId','$tableId','$product','$quantity','$productPrice')");
            }        
        }
        //echo 'The product  = '.$value["0"].' and the quantity = '.$value["2"];
    }

    if($insertIntotable){
        echo json_encode(array('AddCart' => '1'));
    }
    else{
        echo json_encode(array('AddCart' => '2'));
    }

}



if(isset($_POST['QtyIncrementId'])){

    $IncrementId = $_POST['QtyIncrementId'];

    $incrementQty = mysqli_query($con, "UPDATE $TempTable SET quantity = quantity + 1 WHERE product = '$IncrementId' AND tableId = '$tableId'");
    if($incrementQty){
        echo json_encode(array('IncrementDone' => '1'));
        CartClear();
    }
    else{
        echo json_encode(array('IncrementDone' => '2'));
    }
}


if(isset($_POST['QtyDecrementId'])){

    $DecrementId = $_POST['QtyDecrementId'];

    $decrementQty = mysqli_query($con, "UPDATE $TempTable SET quantity = quantity - 1 WHERE product = '$DecrementId' AND tableId = '$tableId'");
    if($decrementQty){
        echo json_encode(array('DecrementDone' => '1'));
        CartClear();
    }
    else{
        echo json_encode(array('DecrementDone' => '2'));
    }
}


?>