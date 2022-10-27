<?php session_start(); ?>
<?php
include '../MAIN/Dbconfig.php';

$empId = $_SESSION['custid'];
$findBranch = mysqli_query($con, "SELECT empBranch FROM employee_master WHERE empId = '$empId'");
foreach ($findBranch as $findBranchResult) {
    $Branch = $findBranchResult['empBranch'];
}




if (isset($_POST['tableorders'])) {

?>

    <div class="row">


        <?php
        $findorders = mysqli_query($con, "SELECT * FROM table_master WHERE brId = '$Branch'");
        $number = 0;
        foreach ($findorders as $OrderResults) {
            $TableId = $OrderResults['tId'];
            $number++;
        ?>
            <div class="col-3 mb-3">
                <div class="card card-body tablecard p-0 <?= strtolower($OrderResults['tableStatus']); ?>">
                    <a href="" class="GetOrders" data-table="<?php echo $TableId ?>">
                        <div class="d-flex justify-content-between pt-2 px-3">
                            <h5 class="tableName"> <strong> <?= $OrderResults['tableName']; ?> </strong> </h5>
                        </div>
                        <div class="mt-2 mx-3 d-flex TableStatus">
                            <div class="tablenumber me-3"> <span><?= $number ?></span> </div>
                            <div>
                                <h4 class="m-0 mt-2 tableStatusText"> <strong> <?= $OrderResults['tableStatus']; ?> </strong> </h4>
                                
                            </div>
                        </div>
                        <div class="mx-3 mt-3 mb-2 text-end">
                            <?php
                            $findOrderTotal = mysqli_query($con, "SELECT SUM(om.orderQty) AS OrderTotal FROM table_master t LEFT JOIN order_main om ON t.tId = om.orderTable WHERE t.brId = '$Branch' AND t.tId = '$TableId' AND om.orderStatus = 'PENDING'");
                            foreach ($findOrderTotal as $OrderTotalResult) {
                                $orderTotal = intval($OrderTotalResult['OrderTotal']);
                            }
                            ?>
                            <p class="m-0"> <strong> Ordered <?= ($orderTotal > 0) ? $orderTotal : '0'  ?> Items</strong> </p>
                        </div>
                    </a>
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
    function GetorderDetails(TableId) {
        $.ajax({
            method: "POST",
            url: "OrdertableDetailData.php",
            data: {
                TableId: TableId
            },
            beforeSend: function() {
                //$('#loading').show();
            },
            success: function(data) {
                $('#OrderModal').modal('show');
                //$('#OrderModal #pills-tab li:first').addClass('bg-info');
                //console.log(data);
                $('#tableorderdetails').html(data);
            }
        });
    }


    $('.GetOrders').click(function(f) {
        f.preventDefault();
        var TableId = $(this).data('table');
        console.log(TableId);
        GetorderDetails(TableId);
    });
</script>