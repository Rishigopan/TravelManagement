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


$find_data = mysqli_query($con, "SELECT c.countryName,ck.checklistName,ck.ckId,ck.createdDate FROM checklist_master ck INNER JOIN country_master c ON ck.cId = c.cId");
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
