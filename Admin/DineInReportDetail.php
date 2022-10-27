<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$pageTitle = 'DineInReport';


if (isset($_SESSION['custname']) && isset($_SESSION['custtype'])) {

    if ($_SESSION['custtype'] == 'SuperAdmin' || $_SESSION['custtype'] == 'Admin') {
    } else {
        header("location:../login.php");
    }
} else {

    header("location:../login.php");
}

$OrderId = $_GET['OrderId'];

?>




<?php include '../MAIN/Header.php'; ?>





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




<!-- Cancel order Modal -->
<div class="modal deleteModal fade" id="delModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body py-5 px-4">
                <div class="text-center deleteImg mb-5">
                    <img src="./error.jpg" class="img-fluid" alt="">
                </div>
                <h5 class="text-center">Cancel Order</h5>
                <p class="text-center mt-3 px-3">Are you sure you want to cancel this order?</p>
                <div class="text-center mt-5">
                    <button type="button" id="confirmYes" class="btn btn_save w-100">Yes , Cancel Order</button>
                    <button type="button" id="confirmNo" class="btn btn_deleteCancel w-100 mt-3" data-bs-dismiss="modal">No , Cancel Deleting</button>
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

        <?php
        $findOrderDetails = mysqli_query($con, "SELECT * FROM order_main om INNER JOIN table_master t ON om.orderTable = t.tId INNER JOIN branch_master b ON om.orderBranch = b.brId WHERE om.oId = '$OrderId'");
        foreach ($findOrderDetails as $findOrderResults) {
            $OrderMainId = $findOrderResults['orderId'];
            $OrderStatus = $findOrderResults['orderStatus'];
        }

        ?>

        <main id="adminmain">

            <div class="mainContents">
                <div class="container-lg">
                    <div class="Adminheading">
                        <h3>DineIn Report</h3>
                    </div>
                    <div class="admintoolbar">
                        <div class="card card-body">
                            <div class="row justify-content-between">
                                <div class="col-lg-4 col-4">
                                    <button class="btn add_master px-5" id="OrderCancelButton" type="button" value="<?= $OrderMainId; ?>" <?php echo ($OrderStatus == 'CANCELLED') ? "disabled" : "" ?>> <span>Cancel Order</span></button>
                                </div>
                                <div class="col-lg-4 text-end col-4">

                                    <!-- <button class="btn add_master px-5"> <span> <i class="material-icons">print</i> </span> <span>Print Invoice</span></button> -->
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">

                        <div class="col-4">

                            <div class="12">
                                <div class="card card-body HistoryCard shadow p-0">
                                    <h5 class="CardHead">Order</h5>
                                    <div class="CardDiv">
                                        <div class="row mt-3">
                                            <div class="col-6 text-muted">
                                                <h6>Order Id :</h6>
                                            </div>
                                            <div class="col-6 text-start">
                                                <h6> <?= $findOrderResults['orderId'] ?> </h6>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6 text-muted">
                                                <h6>Branch :</h6>
                                            </div>
                                            <div class="col-6 text-start">
                                                <h6> <?= $findOrderResults['branchName'] ?> </h6>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6 text-muted">
                                                <h6>Table :</h6>
                                            </div>
                                            <div class="col-6 text-start">
                                                <h6> <?= $findOrderResults['tableName'] ?> </h6>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6 text-muted">
                                                <h6>Order Status :</h6>
                                            </div>
                                            <div class="col-6 text-start">
                                                <h6> <?= $findOrderResults['orderStatus'] ?> </h6>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6 text-muted">
                                                <h6>Order Date :</h6>
                                            </div>
                                            <div class="col-6 text-start">
                                                <h6> <?= date('H:i A , d M , Y', strtotime($findOrderResults['createdDate']))  ?> </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="12 mt-3">
                                <div class="card card-body HistoryCard shadow p-0">
                                    <h5 class="CardHead">Payment</h5>
                                    <div class="CardDiv">

                                        <div class="row mt-3">
                                            <div class="col-6 text-muted">
                                                <h6>Payment Status :</h6>
                                            </div>
                                            <div class="col-6 text-start">
                                                <h6> <?= $findOrderResults['orderPayment'] ?> </h6>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6 text-muted">
                                                <h6>Razorpay OrderID :</h6>
                                            </div>
                                            <div class="col-6 text-start">
                                                <h6> <?= $findOrderResults['razorpay_orderid'] ?> </h6>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6 text-muted">
                                                <h6>RazorpayPaymentID :</h6>
                                            </div>
                                            <div class="col-6 text-start">
                                                <h6> <?= $findOrderResults['razorpay_paymentid'] ?> </h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-8">
                            <div class="row">

                                <div class="col-12">
                                    <div class="card card-body shadow HistoryCard p-0">
                                        <h5 class="CardHead">Order Summary</h5>

                                        <div class="">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>PRODUCT</th>
                                                        <th>QUANTITY</th>
                                                        <th>AMOUNT</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $FindOrderSummary = mysqli_query($con, "SELECT * FROM order_sub os INNER JOIN product_master p ON os.product_id = p.prId WHERE os.order_id = '$OrderMainId'");
                                                    foreach ($FindOrderSummary as $FindOrderSummaryResults) {
                                                        echo '
                                                        <tr>
                                                    <td> ' . $FindOrderSummaryResults["productName"] . ' </td>
                                                    <td> ' . intval($FindOrderSummaryResults["product_qty"]) . ' </td>
                                                    <td> ₹ ' . intval($FindOrderSummaryResults["product_amount"]) . ' </td>
                                                    </tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <?php
                                                    $FindTotal = mysqli_query($con, "SELECT SUM(product_qty * product_amount) AS totalSum FROM `order_sub` WHERE order_id = '$OrderMainId'");
                                                    foreach ($FindTotal as $FindTotalResult) {
                                                        $total = $FindTotalResult['totalSum'];
                                                    }
                                                    ?>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th></th>
                                                        <th> ₹ <?= intval($total); ?> </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>
                                </div>





                            </div>
                        </div>

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
    $(document).ready(function() {

        $('#btnConfirm').click(function() {
            location.reload();
        });

        $('#OrderCancelButton').click(function() {
            var CancelId = $(this).val();
            $('#delModal').modal('show');
            $('#confirmYes').click(function() {
                $.ajax({
                    type: "POST",
                    url: "OrderOperations.php",
                    data: {
                        CancelId: CancelId
                    },
                    beforeSend: function() {
                        $('#loading').show();
                        $('#delModal').modal('hide');
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.OrderCancel == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Cancelled This Order");
                                $('#confirmModal').modal('show');
                                $('#btnConfirm').show();
                                $('#btnClose').hide();
                            } else if (response.OrderCancel == "2") {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Cancelling Order");
                                $('#confirmModal').modal('show');

                            }
                            CancelId = undefined;
                            delete window.CancelId;
                        } else {
                            $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Some Error Occured, Please refresh the page (ERROR : 12ENJ)");
                            $('#confirmModal').modal('show');
                        }
                    },
                    error: function() {
                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                        $('#ResponseText').text("Please refresh the page to continue (ERROR : 12EFF)");
                        $('#confirmModal').modal('show');
                    }
                });
            });
            $('#confirmNo').click(function() {
                CancelId = undefined;
                delete window.CancelId;
            });
        });




    });
</script>


<!-- footer -->

<?php

include '../MAIN/Footer.php';

?>