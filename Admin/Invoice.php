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
// $OrderId = '1';
?>




<?php include '../MAIN/Header.php'; ?>



<style>
    body {
        margin: 10px;
        padding: 0;
        font-family: 'PT Sans', sans-serif;
        background: white !important;
    }

    @page {
        size: 3in 11in;
        margin-top: 0cm;
        margin-left: 0cm;
        margin-right: 0cm;
    }

    table {
        width: 100%;
    }

    tr {
        width: 100%;

    }

    h1 {
        text-align: center;
        vertical-align: middle;
    }

    #logo {
        width: 60%;
        text-align: center;
        -webkit-align-content: center;
        align-content: center;
        padding: 5px;
        margin: 2px;
        display: block;
        margin: 0 auto;
    }

    header {
        width: 100%;
        text-align: center;
        -webkit-align-content: center;
        align-content: center;
        vertical-align: middle;
    }

    .items thead {
        text-align: center;
    }

    .center-align {
        text-align: center;
    }

    .bill-details td {
        font-size: 12px;
    }

    .receipt {
        font-size: medium;
    }

    .items .heading {
        font-size: 12.5px;
        text-transform: uppercase;
        border-top: 1px solid black;
        margin-bottom: 4px;
        border-bottom: 1px solid black;
        vertical-align: middle;
    }

    .items thead tr th:first-child,
    .items tbody tr td:first-child {
        width: 47%;
        min-width: 47%;
        max-width: 47%;
        word-break: break-all;
        text-align: left;
    }

    .items td {
        font-size: 12px;
        text-align: right;
        vertical-align: bottom;
    }

    .price::before {
        content: "\20B9";
        font-family: Arial;
        text-align: right;
    }

    .sum-up {
        text-align: right !important;
    }

    .total {
        font-size: 13px;
        border-top: 1px dashed black !important;
        border-bottom: 1px dashed black !important;
    }

    .total.text,
    .total.price {
        text-align: right;
    }

    .total.price::before {
        content: "\20B9";
    }

    .line {
        border-top: 1px solid black !important;
    }

    .heading.rate {
        width: 20%;
    }

    .heading.amount {
        width: 25%;
    }

    .heading.qty {
        width: 5%
    }

    p {
        padding: 1px;
        margin: 0;
    }

    section,
    footer {
        font-size: 12px;
    }
</style>






<?php
$findOrderDetails = mysqli_query($con, "SELECT *,om.createdDate AS OrderDate FROM order_main om INNER JOIN table_master t ON om.orderTable = t.tId INNER JOIN branch_master b ON om.orderBranch = b.brId WHERE om.oId = '$OrderId'");
foreach ($findOrderDetails as $findOrderResults) {
    $OrderMainId = $findOrderResults['orderId'];
    $OrderTotal = $findOrderResults['orderTotal'];
    $OrderDate = $findOrderResults['OrderDate'];
}

?>


<header>
    <div id="logo" class="media" data-src="logo.png" src="./logo.png"></div>

</header>
<!-- <p>GST Number : 4910487129047124</p> -->
<table class="bill-details">
    <tbody>
        <tr>
            <td>Date : <span> <?= date('d,M Y', strtotime($OrderDate)); ?> </span></td>
            <td class="text-end">Time : <span><?= date('h:i A', strtotime($OrderDate)) ?></span></td>
        </tr>
        <tr>
            <td>Table #: <span> <?= $findOrderResults['tableName']; ?> </span></td>
            <td class="text-end">Bill # : <span> <?= $findOrderResults['orderId']; ?> </span></td>
        </tr>
        <tr>
            <th class="center-align" colspan="2"><span class="receipt">Original Receipt</span></th>
        </tr>
    </tbody>
</table>

<table class="items">
    <thead>
        <tr>
            <th class="heading name">Item</th>
            <th class="heading qty">Qty</th>
            <th class="heading rate">Rate</th>
            <th class="heading amount">Amount</th>
        </tr>
    </thead>

    <tbody>


        <?php
        $FindOrderSummary = mysqli_query($con, "SELECT * FROM order_sub os INNER JOIN product_master p ON os.product_id = p.prId WHERE os.order_id = '$OrderMainId'");
        foreach ($FindOrderSummary as $FindOrderSummaryResults) {
            echo '
                <tr>
            <td> ' . $FindOrderSummaryResults["productName"] . ' </td>
            <td> ' . number_format($FindOrderSummaryResults["product_qty"],2,'.',',') . ' </td>
            <td> ₹ ' . number_format($FindOrderSummaryResults["product_amount"],2,'.',',') . ' </td>
            <td> ₹ ' . number_format(($FindOrderSummaryResults["product_amount"] * $FindOrderSummaryResults["product_qty"]),2,'.',',') . ' </td>
            </tr>';
        }
        ?>

        <tr>
            <td colspan="3" class="sum-up line">Subtotal</td>
            <td class="line price"> <?= number_format($OrderTotal,2,'.',',') ?>   </td>
        </tr>
        <!-- <tr>
                    <td colspan="3" class="sum-up">CGST</td>
                    <td class="price">10.00</td>
                </tr>
                <tr>
                    <td colspan="3" class="sum-up">SGST</td>
                    <td class="price">10.00</td>
                </tr> -->
        <tr>
            <th colspan="3" class="total text">Total</th>
            <th class="total price"><?= number_format($OrderTotal,2,'.',',') ?></th>
        </tr>
    </tbody>
</table>
<section>
    <p>
        Payment Status : <span> <?= $findOrderResults['orderPayment'] ?> </span>
    </p>
    <p style="text-align:center">
        Thank you for your visit!
    </p>
</section>
<footer style="text-align:center">
    <p>THE MUFFIN HOUSE</p>

</footer>



<script>
    $(document).ready(function() {

        window.print();

    });
</script>


<!-- footer -->

<?php

include '../MAIN/Footer.php';

?>