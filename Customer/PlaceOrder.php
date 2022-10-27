<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

include '../Admin/CommonFunctions.php';

$user_id = '1';
$DateToday = date('Y-m-d h:i:s');
$DayToday  = date('mdY');
$TempTable = 'table_temp';
$TableId = $_SESSION['TableId'];
$BranchId = $_SESSION['BranchId'];
$OrderTotal = $_SESSION['TotalSum'];
$OrderQty = $_SESSION['TotalQty'];



require('config.php');
require('../razorpay-php/Razorpay.php');

use Razorpay\Api\Api;


if (isset($_POST['PaymentMode'])) {


    $PaymentMode = $_POST['PaymentMode'];
    mysqli_autocommit($con, FALSE);

    $FindMaxOrder = mysqli_query($con, "SELECT MAX(oId) FROM order_main");
    foreach ($FindMaxOrder as $FindMaxResult) {
        $MaxOId = $FindMaxResult['MAX(oId)'] +  1;
    }

    $MaxOrderId = 'DINE-' . $MaxOId . '-' . $DayToday;

    $FindItems = mysqli_query($con, "SELECT p.prId,temp.quantity,temp.price FROM $TempTable temp INNER JOIN product_master p ON temp.product = p.productName WHERE temp.tableId = '$TableId'");
    foreach ($FindItems as $FindItemResult) {

        $ProductId = $FindItemResult['prId'];
        $ProductQty = $FindItemResult['quantity'];
        $ProductAmount = $FindItemResult['price'];

        $FindMaxSubId = mysqli_query($con, "SELECT MAX(sId) FROM order_sub");
        foreach ($FindMaxSubId as $FindMaxSubResult) {
            $MaxSubId = $FindMaxSubResult['MAX(sId)'] + 1;
        }

        $InsertIntoSub = mysqli_query($con, "INSERT INTO `order_sub`(`sId`, `order_id`, `product_id`, `product_qty`, `product_amount`, `cook_status`, `delivery_status`) 
            VALUES ('$MaxSubId','$MaxOrderId','$ProductId','$ProductQty','$ProductAmount','NILL','NILL')");
    }

    if ($InsertIntoSub) {
        $InsertIntoMain = mysqli_query($con, "INSERT INTO `order_main`(`oId`, `orderId`, `orderTable`, `orderBranch`, `orderTotal`, `orderQty`, `orderStatus`, `orderPayment`,`createdBy`, `createdDate`) 
        VALUES ('$MaxOId','$MaxOrderId','$TableId','$BranchId','$OrderTotal','$OrderQty','PENDING','PENDING','$user_id','$DateToday')");
        if ($InsertIntoMain) {

            $ClearCart = mysqli_query($con, "DELETE FROM $TempTable WHERE tableId = '$TableId'");

            SetTableStatusOrdering($TableId);
            if ($PaymentMode == 'PayShop') {
                mysqli_commit($con);
                header('location:Verify.php?VerifyMode=Shop');
            } elseif ($PaymentMode == 'PayOnline') {
                mysqli_commit($con);

                $api = new Api($keyId, $keySecret);
                $orderData = [
                    'receipt'         => 52146,
                    'amount'          => $OrderTotal * 100,
                    'currency'        => $displayCurrency,
                    'payment_capture' => 1
                ];
                $razorpayOrder = $api->order->create($orderData);
                $razorpayOrderId = $razorpayOrder['id'];
                $_SESSION['razorpay_order_id'] = $razorpayOrderId;
                $_SESSION['customer_order_id'] = $MaxOrderId;
                $displayAmount = $amount = $orderData['amount'];
                if ($displayCurrency !== 'INR') {
                    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
                    $exchange = json_decode(file_get_contents($url), true);

                    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
                }
                $data = [
                    "key"               => $keyId,
                    "amount"            => $amount,
                    "name"              => 'Akhila Bhasha Bhagavadh Geetha Prachara Sabha',
                    "description"       => 'Member Registration',
                    "image"             => "",
                    "prefill"           => [
                        "name"              => 'Test',
                        "email"             => 'Test@gmail.com',
                        "contact"           => '78541524789',
                    ],
                    "notes"             => [
                        "address"           => 'The Muffin House',
                        "merchant_order_id" => $MaxOrderId,
                    ],
                    "theme"             => [
                        "color"             => "#FFA500"
                    ],
                    "order_id"          => $razorpayOrderId,
                ];

                if ($displayCurrency !== 'INR') {
                    $data['display_currency']  = $displayCurrency;
                    $data['display_amount']    = $displayAmount;
                }

                $json = json_encode($data);

            
                require("Manual.php");
                       

            } else {
                echo "none";
                mysqli_rollback($con);
            }
        } else {
            mysqli_rollback($con);
        }
    } else {
        mysqli_rollback($con);
    }
}

?>