<?php session_start(); ?>
<?php

if(isset($_SESSION['TableId']) && isset($_SESSION['BranchId'])){

}

else{

header("location:https://www.google.com/");

}


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




<main id="main">


    <div class="container  py-2">
        <div class=" d-flex ">
            <a href="./DineInMenu.php" class="me-auto my-auto text-black">
                <i class='bx-md bx bx-left-arrow-alt'></i>
            </a>
            <h3 class="me-auto my-auto"> <strong>Checkout</strong> </h3>
        </div>
    </div>


    <div id="CartData">

    </div>


</main>
<!-- End #main -->

    

<script>

    $(document).ready(function(){
        LoadData();
    });


    function LoadData() {
        var cart = 'fetch_data';
        $.ajax({
            method: "POST",
            url: "DineInCartData.php",
            data: {
                cart: cart
            },
            success: function(data) {
                console.log(data);
                $('#CartData').html(data);
            }
        });
    }
</script>




<?php

include '../MAIN/Footer.php';

?>