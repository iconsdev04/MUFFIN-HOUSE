<?php

include '../MAIN/Dbconfig.php';


if (isset($_POST['TableId'])) {
    $Tableid = $_POST['TableId'];
?>


    <ul class="nav nav-pills mb-3 px-3" id="pills-tab" role="tablist">
        <?php
        $FindAllOrders = mysqli_query($con, "SELECT * FROM order_main WHERE orderTable = '$Tableid' AND orderStatus = 'PENDING'");
        $order = 0;
        foreach ($FindAllOrders as $FindAllOrderResult) {
            $order++;
        ?>
            <li class="nav-item " role="presentation">
                <button class="nav-link <?php if ($order == 1) {
                                            echo 'active';
                                        } ?> " id="pills-<?= $FindAllOrderResult['orderId']; ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?= $FindAllOrderResult['orderId']; ?>" type="button" role="tab">Order <?= $order; ?> </button>
            </li>

        <?php
        }
        ?>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <?php
        $FindAllOrders = mysqli_query($con, "SELECT * FROM order_main WHERE orderTable = '$Tableid' AND orderStatus = 'PENDING'");
        $neworder = 0;
        foreach ($FindAllOrders as $FindAllOrderResult) {
            $oId = $FindAllOrderResult['oId'];
            $orderId = $FindAllOrderResult['orderId'];
            $neworder++;
        ?>

            <div class="tab-pane fade show  <?php if ($neworder == 1) {echo 'active';} ?>" id="pills-<?= $orderId; ?>" role="tabpanel" tabindex="0">
                <div class="px-3">
                    <div class="OrderSubheading">
                        <p>Order Items</p>
                    </div>

                    <div class="px-3 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <strong>Product</strong>
                            </div>
                            <div class="col-4 text-center">
                                <strong>Amount</strong>
                            </div>
                            <div class="col-4 text-end">
                                <strong>Total</strong>
                            </div>
                        </div>
                        <?php
                        $findOrderItems = mysqli_query($con, "SELECT * FROM order_sub os INNER JOIN product_master p ON os.product_id = p.prId WHERE os.order_id = '$orderId'");
                        foreach ($findOrderItems as $orderItemDetails) {
                        ?>

                            <div class="row mt-2">
                                <div class="col-4">
                                    <?= $orderItemDetails['productName']; ?> x <?= $orderItemDetails['product_qty']; ?>
                                </div>
                                <div class="col-4 text-center">
                                    ₹ <?= $orderItemDetails['product_amount']; ?>
                                </div>
                                <div class="col-4 text-end">
                                    ₹ <?= $orderItemDetails['product_amount'] * $orderItemDetails['product_qty']; ?>
                                </div>
                            </div>

                        <?php
                        }
                        ?>
                        <hr>
                        <div class="row mt-2">
                            <div class="col-4">
                                <strong class="fs-3">Total</strong>
                            </div>
                            <div class="col-4">
                                <strong></strong>
                            </div>
                            <div class="col-4 text-end">
                                <strong class="fs-3" >₹ <?= intval($FindAllOrderResult['orderTotal']); ?></strong>
                            </div>
                        </div>
                    </div>

                    <div class="OrderSubheading">
                        <p>Order Details</p>
                    </div>

                    <div class="d-flex justify-content-between my-4">
                        <div class="rounded-pill orderDetails">
                            <h6 class="m-0 p-0 ">ID : #<?= $FindAllOrderResult['orderId']; ?></h6>
                        </div>
                        <div class="rounded-pill orderDetails">
                            <h6 class="m-0 p-0">Time : <?= date('h:i A, d M', strtotime($FindAllOrderResult['createdDate']) ); ?></h6>
                        </div>
                        <div class="rounded-pill orderDetails ">
                            <h6 class="m-0 p-0">Payment : <?= $FindAllOrderResult['orderPayment']; ?></h6>
                        </div>
                        <div class="rounded-pill orderDetails ">
                            <h6 class="m-0 p-0">Amount : <strong><?= intval($FindAllOrderResult['orderTotal']); ?></strong> </h6>
                        </div>
                    </div>

                </div>
                <div class="modalFootDiv">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <button type="button" value="<?= $orderId; ?>" class="btn btn_reset btn_cancelorder py-2 px-5" > <span>Cancel Order</span> </button>
                        </div>
                        <div class="d-flex">
                            <button type="button" value="<?= $oId; ?>" class="btn btn_save btn_payment me-3" <?php echo ($FindAllOrderResult['orderPayment'] == 'SUCCESS') ? "disabled" : "" ?>> <span>Recieved Payment</span> </button>
                            <button type="button" value="<?= $oId; ?>" class="btn btn_save btn_complete"> <span>Order Completed</span> </button>
                            <a href="Invoice.php?OrderId=<?= $oId ?>" target="_blank" class="btn btn_save ms-3 px-3 py-2" > <i style="vertical-align: middle;" class="material-icons">print</i>  </a>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        }
        ?>
    </div>





<?php

}

?>



<script>
    var TableMainId = '<?php echo $Tableid; ?>';

    
    //payment operation
    $('.btn_payment').click(function() {
        var PaymentOrderId = $(this).val();
        console.log(PaymentOrderId);
        $('#payModal').modal('show');
        $('#confirmPayYes').click(function() {
            $.ajax({
                method: "POST",
                url: "OrderOperations.php",
                data: {
                    PaymentOrderId: PaymentOrderId
                },
                beforeSend: function() {
                    $('#payModal').modal('hide');
                    $('#ResponseImage').html("");
                    $('#ResponseText').text("");
                },
                success: function(data) {
                    console.log(data);
                    if (TestJson(data) == true) {
                        var response = JSON.parse(data);
                        if (response.PaymentSuccess == "0") {
                            $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Branch is Already Present");
                            $('#confirmModal').modal('show');
                        } else if (response.PaymentSuccess == "1") {
                            $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Paid Successfully, please complete the order");
                            $('#confirmModal').modal('show');
                            GetorderDetails(TableMainId);
                        } else if (response.PaymentSuccess == "2") {
                            //$('#BranchModal').modal('hide');
                            $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Payment Failed");
                            $('#confirmModal').modal('show');
                        }
                        PaymentOrderId = undefined;
                        delete window.PaymentOrderId;
                    } else {
                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                        $('#ResponseText').text("Some Error Occured, Please refresh the page (ERROR : 12ENJ)");
                        $('#confirmModal').modal('show');
                    }
                }
            });
        });
        $('#confirmPayNo').click(function() {
            PaymentOrderId = undefined;
            delete window.PaymentOrderId;
        });
    });


    //complete operation
    $('.btn_complete').click(function() {
        var CompleteOrderId = $(this).val();
        console.log(CompleteOrderId);
        $('#ConfirmOrderModal').modal('show');
        $('#confirmOrderYes').click(function() {
            $.ajax({
                method: "POST",
                url: "OrderOperations.php",
                data: {
                    CompleteOrderId: CompleteOrderId
                },
                beforeSend: function() {
                    $('#ConfirmOrderModal').modal('hide');
                    $('#ResponseImage').html("");
                    $('#ResponseText').text("");
                },
                success: function(data) {
                    if (TestJson(data) == true) {
                        var response = JSON.parse(data);
                        if (response.OrderComplete == "0") {
                            $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Please make payment first");
                            $('#confirmModal').modal('show');
                        } else if (response.OrderComplete == "1") {
                            $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Order completed successfully");
                            $('#confirmModal').modal('show');
                            GetorderDetails(TableMainId);
                        } else if (response.OrderComplete == "2") {
                            //$('#BranchModal').modal('hide');
                            $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Order updation failed");
                            $('#confirmModal').modal('show');
                        }
                        CompleteOrderId = undefined;
                        delete window.CompleteOrderId;
                    } else {
                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                        $('#ResponseText').text("Some Error Occured, Please refresh the page (ERROR : 12ENJ)");
                        $('#confirmModal').modal('show');
                    }
                }
            });
        });
        $('#cconfirmOrderNo').click(function() {
            CompleteOrderId = undefined;
            delete window.CompleteOrderId;
        });
    });



    //cancel operation
    $('.btn_cancelorder').click(function() {
        var CancelOrderId = $(this).val();
        console.log(CancelOrderId);
        $('#CancelOrderModal').modal('show');
        $('#cancelOrderYes').click(function() {
            $.ajax({
                method: "POST",
                url: "OrderOperations.php",
                data: {
                    CancelId: CancelOrderId
                },
                beforeSend: function() {
                    $('#CancelOrderModal').modal('hide');
                    $('#ResponseImage').html("");
                    $('#ResponseText').text("");
                },
                success: function(data) {
                    if (TestJson(data) == true) {
                        var response = JSON.parse(data);
                        if (response.OrderCancel == "1") {
                            $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Order Cancelled successfully");
                            $('#confirmModal').modal('show');
                            GetorderDetails(TableMainId);
                        } else if (response.OrderCancel == "2") {
                            //$('#BranchModal').modal('hide');
                            $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Order Cancellation failed");
                            $('#confirmModal').modal('show');
                        }
                        CompleteOrderId = undefined;
                        delete window.CompleteOrderId;
                    } else {
                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                        $('#ResponseText').text("Some Error Occured, Please refresh the page (ERROR : 12ENJ)");
                        $('#confirmModal').modal('show');
                    }
                }
            });
        });
        $('#cancelOrderNo').click(function() {
            CancelOrderId = undefined;
            delete window.CancelOrderId;
        });
    });


    
</script>