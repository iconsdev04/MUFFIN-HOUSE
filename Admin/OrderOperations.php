<?php


include '../MAIN/Dbconfig.php';
include '../Admin/CommonFunctions.php';

//Update Order payment as Success
if (isset($_POST['PaymentOrderId'])) {

    $PaymentOrderId = $_POST['PaymentOrderId'];

    $MakePayment = mysqli_query($con, "UPDATE order_main SET orderPayment = 'SUCCESS' WHERE oId = '$PaymentOrderId'");
    if($MakePayment){
        echo json_encode(array('PaymentSuccess' => 1));
    }
    else{
        echo json_encode(array('PaymentSuccess' => 2));
    }

}


//Update order completion status
if (isset($_POST['CompleteOrderId'])) {

    $CompleteOrderId = $_POST['CompleteOrderId'];

    $findPaymentInfo = mysqli_query($con, "SELECT orderPayment,orderTable FROM order_main WHERE oId = '$CompleteOrderId'");
    foreach($findPaymentInfo as $findPaymentInfoResult){
        $paymentInfo = $findPaymentInfoResult['orderPayment'];
        $tableId = $findPaymentInfoResult['orderTable'];
    }

    if($paymentInfo == 'PENDING'){
        echo json_encode(array('OrderComplete' => 0));
    }
    else{
        $CompleteOrder = mysqli_query($con, "UPDATE order_main SET orderStatus = 'COMPLETED' WHERE oId = '$CompleteOrderId'");
        if($CompleteOrder){
            SetTableStatus($tableId);
            echo json_encode(array('OrderComplete' => 1));
        }
        else{
            echo json_encode(array('OrderComplete' => 2));
        }
    }
}


//Cancel Order
if (isset($_POST['CancelId'])) {

    $CancelOrderId = $_POST['CancelId'];

    $findTableId = mysqli_query($con, "SELECT orderTable FROM order_main WHERE orderId = '$CancelOrderId'");
    foreach($findTableId as $findTableResult){
        $CancelTableId = $findTableResult['orderTable'];
    }

    $CancelOrder = mysqli_query($con, "UPDATE order_main SET orderStatus = 'CANCELLED' WHERE orderId = '$CancelOrderId'");
    if($CancelOrder){
        echo json_encode(array('OrderCancel' => 1));

        SetTableStatus($CancelTableId);

    }
    else{
        echo json_encode(array('OrderCancel' => 2));
    }

}


