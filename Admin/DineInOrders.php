<?php  session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$pageTitle = 'DineInOrder';

if(isset($_SESSION['custname']) && isset($_SESSION['custtype'])){

    if($_SESSION['custtype'] == 'SuperAdmin' || $_SESSION['custtype'] == 'Admin'){

    }
    else{
        header("location:../login.php");
    }
    
}
else{

header("location:../login.php");

}

?>


<?php include '../MAIN/Header.php'; ?>


<!-- Modal -->
<div class="modal modal-lg fade" id="OrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body master_modal p-0">
                <div class="modalmainDiv">
                    <div class="d-flex justify-content-between px-3 py-3">
                        <h4>TABLE 1</h4>
                        <button type="button" class="btn-close CloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <div class="" id="tableorderdetails">


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>





<!-- Confirm Modal -->
<div class="modal fade ResponseModal" id="confirmModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-3 py-5">
                <div class="text-center mb-4" id="ResponseImage">

                </div>
                <h4 id="ResponseText" class="text-center mb-3"></h4>
                <div class="text-center">
                    <button type="button" id="btnConfirm" style="display: none;" class="btn btn_save mt-4 px-5 py-2" data-bs-dismiss="modal">Proceed</button>
                    <button type="button" id="btnClose" class="btn btn_save mt-4 px-5 py-2" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Confirm Payment Modal -->
<div class="modal deleteModal fade" id="payModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body py-5 px-4">
                <div class="text-center deleteImg mb-5">
                    <img src="./confirm.png" class="img-fluid" alt="">
                </div>
                <h5 class="text-center">Confirm Payment</h5>
                <p class="text-center mt-3 px-3">Do you recieved this payment?</p>
                <div class="text-center mt-5">
                    <button type="button" id="confirmPayYes" class="btn btn_save w-100">Yes , Confirm Payment</button>
                    <button type="button" id="confirmPayNo" class="btn btn_deleteCancel w-100 mt-3" data-bs-dismiss="modal">No , Cancel Payment</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Confirm Order Completed Modal -->
<div class="modal deleteModal fade" id="ConfirmOrderModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body py-5 px-4">
                <div class="text-center deleteImg mb-5">
                    <img src="./confirm.png" class="img-fluid" alt="">
                </div>
                <h5 class="text-center">Order Completed</h5>
                <p class="text-center mt-3 px-3">Are you sure, customer had paid for this order and mark this order as completed?</p>
                <div class="text-center mt-5">
                    <button type="button" id="confirmOrderYes" class="btn btn_save w-100">Yes , Mark As Completed</button>
                    <button type="button" id="confirmOrderNo" class="btn btn_deleteCancel w-100 mt-3" data-bs-dismiss="modal">No , Cancel Operation</button>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Cancel Order  Modal -->
<div class="modal deleteModal fade" id="CancelOrderModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body py-5 px-4">
                <div class="text-center deleteImg mb-5">
                    <img src="./confirm.png" class="img-fluid" alt="">
                </div>
                <h5 class="text-center">Cancel Order</h5>
                <p class="text-center mt-3 px-3">Are you sure, you want to cancel this order?</p>
                <div class="text-center mt-5">
                    <button type="button" id="cancelOrderYes" class="btn btn_save w-100">Yes , Cancel This Order</button>
                    <button type="button" id="cancelOrderNo" class="btn btn_deleteCancel w-100 mt-3" data-bs-dismiss="modal">No , Cancel Operation</button>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="SidebarMenu" aria-labelledby="offcanvasExampleLabel">

    <div class="offcanvas-body p-0">
        <div class="py-3">
            <h5 class="menu_heading">THE MUFFIN HOUSE</h5>
        </div>

        <div>
            <?php include '../MAIN/Sidebar.php'; ?>
        </div>
    </div>

</div>







<main class="">

    <aside id="aside">
        <div class="innerAside">
            <div class="InnerContent">
                <div class="py-3">
                    <h5 class=" menu_heading">THE MUFFIN HOUSE</h5>
                </div>
                <?php include '../MAIN/Sidebar.php'; ?>
            </div>
        </div>
    </aside>


    <section id="newmain">

        <!--NAVBAR-->
        <?php include '../MAIN/Navbar.php'; ?>

        <main id="adminmain">

            <div class="mainContents">
                <div class="container-lg">
                    <div class="Adminheading">
                        <h3>Table Orders</h3>
                    </div>
                    <div class="card card-body TableMaincard" id="LoadTableData">



                    </div>
                </div>
            </div>

        </main>

    </section>

</main>

<main id="loading">
    <div id="loadingDiv">
        <img class="img-fluid loaderGif" src="./loader.svg" alt="">
    </div>
</main>




<script>

    $(document).ready(function(){
        LoadTableOrders();
        setInterval(LoadTableOrders, 3000);
    });
    

    

    function LoadTableOrders() {
        var tableorders = 'fetch_data';
        $.ajax({
            method: "POST",
            url: "OrdertableData.php",
            data: {
                tableorders: tableorders
            },
            beforeSend: function() {
                //$('#loading').show();
            },
            success: function(data) {
                //console.log(data);
                //$('#loading').hide();
                $('#LoadTableData').html(data);
            }
        });
    }
</script>


<!-- footer -->

<?php

include '../MAIN/Footer.php';

?>