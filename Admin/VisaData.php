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


$find_data = mysqli_query($con, "SELECT v.vId,v.passengerName,c.countryName AS F,cm.countryName AS T,v.passengerDate,v.passengerProof,v.passengerVisa,v.passengerValidity,A.firstName,A.lastName,v.agencyRate,v.ourRate,v.passengerStatus,v.passengerPhone,AC.Aid AS CAREID,AC.firstName AS CareFirst,AC.lastName AS CareLast  FROM visa_booking v INNER JOIN country_master c ON v.passengerFrom = c.cId INNER JOIN accounts A ON v.passengerAgency = A.Aid INNER JOIN country_master cm ON v.passengerTo = cm.cId INNER JOIN accounts AC ON v.passengerCareof = AC.Aid WHERE A.accountType = 'SUPPLIER' AND v.cancelStatus <> 1");
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
