<?php session_start(); ?>
<?php
require('config.php');
include '../MAIN/Dbconfig.php';
$dateToday = date('Ymd');

$timeToday = date('Y-m-d h:i:s');
$user = '1';

require('../razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

if(isset($_SESSION['TableId']) && isset($_SESSION['BranchId'])){

}

else{

header("location:https://www.google.com/");

}

/* 
if(isset($_COOKIE['custtypecookie']) && isset($_COOKIE['custidcookie'])){

    if($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin'){

    }
    else{
        header("location:../login.php");
    }
    
}
else{

header("location:../login.php");

}
 */


?>

<?php include '../MAIN/CustHeader.php'; ?>



<!-- <nav class="navbar fixed-bottom navbar-expand-lg ">

        <div class="container-fluid">
            <a class="navbar-brand p-0" href="https://www.facebook.com/themuffinhouseambalathara/" target="_blank"> <i class="lni lni-facebook-filled"></i> </a>
            <a class="navbar-brand p-0" href="https://www.instagram.com/themuffinhouseindia/" target="_blank"> <i class="lni lni-instagram-original"></i> </a>
            <div class="nav-main">
                <div class="mini-div">
                    <img src="./assets/img/Muffin House_Brand Book_New-16.jpg" alt="" class="img-fluid">
                    <button id="myBtn" onclick="play()" class="p-2" data-type="mario" style="opacity: 0;position:absolute;"> </button>
                </div>
            </div>
            <a class="navbar-brand p-0" href="https://wa.me/919544209000" target="_blank"><i class="lni lni-whatsapp"></i> </a>
            <a class="navbar-brand p-0" href="https://twitter.com/themuffinhouse2" target="_blank"> <i class="lni lni-twitter-original"></i> </a>

        </div>

        <audio id="audio" src="./assets/confetti.mp3"></audio>

    </nav> -->



<div class="container  py-2">
    <div class=" d-flex ">
        <a href="./DineInMenu.php" class="me-auto my-auto text-black">
            <i class='bx-md bx bx-left-arrow-alt'></i>
        </a>
        <h3 class="me-auto my-auto"> <strong>Confirmation</strong> </h3>
    </div>
</div>

<main id="main" class="container px-4 d-flex align-items-center justify-content-center" style="height: 90vh;">

    <div class="card card-body d-flex align-items-center justify-content-center" style="border-radius: 20px;">



        <?php

        if (isset($_GET['VerifyMode']) == 'Shop') {
            echo '<img src="../succcess.gif" class="img-fluid" alt="">
            <h3 class="mt-3 ">Order is Placed Successfully.</h3>
            <h6 class="mt-3 ">Your food will arrive at your table.</h6>
            <a href="./DineInMenu.php" class="mt-4">Click here to go back to menu</a>';
        } else {

            $success = true;
            $error = "Payment Failed";

            $razorpaymentid = $_POST['razorpay_payment_id'];
            $razorpayorderid = $_SESSION['razorpay_order_id'];
            $OrderId = $_SESSION['customer_order_id'];

            if (empty($_POST['razorpay_payment_id']) === false) {
                $api = new Api($keyId, $keySecret);

                try {
                    // Please note that the razorpay order ID must
                    // come from a trusted source (session here, but
                    // could be database or something else)
                    $attributes = array(
                        'razorpay_order_id' => $_SESSION['razorpay_order_id'],
                        'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                        'razorpay_signature' => $_POST['razorpay_signature']
                    );

                    $api->utility->verifyPaymentSignature($attributes);
                } catch (SignatureVerificationError $e) {
                    $success = false;
                    $error = 'Razorpay Error : ' . $e->getMessage();
                }
            }


            if ($success === true) {
                $UpdatePayment = mysqli_query($con, "UPDATE order_main SET orderpayment = 'SUCCESS', razorpay_orderid = '$razorpayorderid', razorpay_paymentid = '$razorpaymentid' WHERE orderId = '$OrderId'");
                if ($UpdatePayment) {
                    echo '<img src="../succcess.gif" class="img-fluid" alt=""> 
                <h3 class="mt-3 ">Your Payment Was Successfull & Order is Placed.</h3>
                <h6>Your Payment Id is : ' . $_POST['razorpay_payment_id'] . '</h6>
                <h6 class="mt-3 ">Your food will arrive at your table.</h6>
                <a href="./DineInMenu.php" class="mt-4">Click here to go back to menu</a>';
                   
                } else {
                    echo '<h5>Some Error Occured </h5>';
                }
            } else {
                $UpdatePayment = mysqli_query($con, "UPDATE order_main SET orderpayment = 'FAILED', razorpay_orderid = '$razorpayorderid', razorpay_paymentid = '$razorpaymentid' WHERE orderId = '$OrderId'");
                if ($UpdatePayment) {
                    echo '<img src="../error.gif" alt="">
                    <h3 class="mt-3">Your Payment Failed</h3>
                    <h6 class="mt-3 ">Please try again.</h6>';
                    
                } else {
                    echo '<h5>Some Error Occured </h5>';
                }
            }
        }

        ?>

    </div>
</main>
<!-- End #main -->





<?php

include '../MAIN/Footer.php';

?>