<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';
$tableId = $_SESSION['TableId'];
$TempTable = 'table_temp';

if (isset($_POST['cart'])) {

?>

    <form action="PlaceOrder.php" method="POST">
        <!-- ======= Menu Section ======= -->
        <section id="menu" class="menu">
            <div class="container-fluid p-3">

                <div class="row menu-container pb-4 p-0 ">

                    <?php

                    $findAllProducts = mysqli_query($con, "SELECT * FROM table_temp temp INNER JOIN product_master p ON temp.product = p.productName WHERE temp.tableId = '$tableId'");

                    foreach ($findAllProducts as $ProductResults) {

                    ?>

                        <div class="col-lg-6 menu-item cart-item mt-3">
                            <div class="cart-single-item  d-flex px-3 py-2 justify-content-between align-items-center">
                                <div class="contentside">
                                    <div class="menu-content mb-2">
                                        <h5>
                                            <?= $ProductResults['productName'] ?>
                                        </h5>
                                    </div>
                                    <div class="amount_details">
                                        <h6>
                                            &#8377;
                                            <?= number_format($ProductResults['productPrice']); ?>
                                        </h6>
                                    </div>
                                </div>
                                <div class="buttonside">
                                    <div class="d-flex justify-content-end AddButtonCart">
                                        <button type="button" class="btn btnRemoveItem" value="<?= $ProductResults['productName'] ?>">-</button>
                                        <input type="text" id="<?= $ProductResults['productName'] ?>" class="form-control qtyvalue text-center px-0" value=" <?php echo number_format($ProductResults['quantity']) ?> ">
                                        <button type="button" class="btn btnAddItem" value="<?= $ProductResults['productName'] ?>">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <?php
                    }

                    ?>

                </div>

                <hr>

                <div class="">

                    <?php

                    $find_sum = mysqli_query($con, "SELECT SUM(quantity) AS TotalQty , SUM(quantity * Price) AS TotalSum FROM $TempTable WHERE tableId = '$tableId'");
                    foreach ($find_sum as $find_result) {
                       $_SESSION['TotalQty'] = $TotalQty = $find_result["TotalQty"];
                       $_SESSION['TotalSum'] = $TotalSum  = $find_result["TotalSum"];
                    }

                    ?>

                    <h5> <strong>Payment Summary</strong> </h5>
                    <div class="card paycard card-body border-0 p-0 py-3 ">
                        <div class="d-flex justify-content-between mx-3">
                            <h6 class="text-muted"> Sub Total </h6>
                            <h6 class=""> <strong> ₹ <?= number_format($TotalSum) ?> </strong> </h6>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mx-3">
                            <h6 class=""> <strong>Total Price</strong> </h6>
                            <h4 class=""> <strong> ₹ <?= number_format($TotalSum) ?> </strong> </h4>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h5> <strong>Payment Method</strong> </h5>
                    <div class="card paycard card-body border-0 p-0 px-3 py-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PaymentMode" id="PayShop" value="PayShop" checked>
                            <label class="form-check-label" for="PayShop">Pay In Shop</label>
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="radio" name="PaymentMode" id="PayOnline" value="PayOnline">
                            <label class="form-check-label" for="PayOnline">Pay Online (Razorpay)</label>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- End Menu Section -->


        <footer id="footer">
            <div class="container">

                <div class="footer-img text-center mb-5">
                    <img src="../muffinhouse.jpg " class="img-fluid " alt=" ">
                </div>

                <p class="">Baking You Happy is just not an idea but a commitment to what Muffin House stands for - its values, its brand personality and its brand promise. It sums up the essence of our existance.</p>

                <div class="copyright">
                    Designed By <strong><span>Techstas Info Solutions</span></strong>. All Rights Reserved
                </div>


            </div>
        </footer>


        <div class="bottomDivCart">
            <div class="AddtoCart">
                <div class="d-flex justify-content-between">
                    <div>
                        <p> <span id="Totalqty"> <?= number_format($TotalQty) ?> </span> items</p>
                        <h6>₹ <span id="TotalSum"> <?= number_format($TotalSum) ?> </span> </h6>
                    </div>
                    <div class="">
                        <button id="ButtonOrder" <?php echo ($TotalQty == 0)? "disabled" : ""  ?> class="btn text-white" type="submit">  <strong>Order Now <i style="vertical-align: middle;" class='bx bxs-right-arrow'></i> </strong> </button>
                    </div>
                </div>
            </div>
        </div>

    </form>


<?php

}

?>


<script>
    $('.btnAddItem').click(function() {
        var QtyIncrementId = $(this).val();
        console.log(QtyIncrementId);
        $.ajax({
            type: "POST",
            url: "DineInOperations.php",
            data: {
                QtyIncrementId: QtyIncrementId
            },
            success: function(data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.IncrementDone == "1") {
                    LoadData();
                } else if (response.IncrementDone == "0") {

                }
            },
        });
    });



    $('.btnRemoveItem').click(function() {
        var QtyDecrementId = $(this).val();
        console.log(QtyDecrementId);
        $.ajax({
            type: "POST",
            url: "DineInOperations.php",
            data: {
                QtyDecrementId: QtyDecrementId
            },
            success: function(data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.DecrementDone == "1") {
                    LoadData();
                } else if (response.DecrementDone == "0") {

                }
            },
        });
    });
</script>