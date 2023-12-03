<?php session_start(); ?>
<?php


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

include '../MAIN/Dbconfig.php';


$find_data = mysqli_query($con, "SELECT T.acctId,T.voucherNo,T.voucherDate,AT.firstName AS ATO,AB.firstName AS ABY,T.toAmount,T.remarks,T.voucherType,T.createdBy,T.createdDate FROM `account_transactions` T INNER JOIN accounts AT ON T.toId = AT.Aid INNER JOIN accounts AB ON T.byId = AB.Aid");
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
