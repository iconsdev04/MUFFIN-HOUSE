

<?php

/* 

if (isset($_COOKIE['custtypecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin') {
    } else {
        header("location:../login.php");
    }
} else {

    header("location:../login.php");
}
 */
include '../MAIN/Dbconfig.php';


$find_data = mysqli_query($con, "SELECT om.oId,om.orderId,b.branchName,t.tableName,om.orderTotal,om.orderStatus,om.orderPayment,om.createdDate FROM order_main om INNER JOIN table_master t ON om.orderTable = t.tId INNER JOIN branch_master b ON om.orderBranch = b.brId");
if(mysqli_num_rows($find_data) > 0){
    while ($dataRow = mysqli_fetch_assoc($find_data)) {
        $rows[] = $dataRow;
    }
}
else{
    $rows = array();
}
$dataset = array(
    "data" => $rows
);

echo json_encode($dataset);
