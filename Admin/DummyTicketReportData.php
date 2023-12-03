<?php session_start(); ?>
<?php


if (isset($_SESSION['custname']) && isset($_SESSION['custtype'])) {

    if ($_SESSION['custtype'] == 'SuperAdmin' || $_SESSION['custtype'] == 'Admin') {
    } else {
        header("location:../login.php");
    }
} else {

    header("location:../login.php");
}

include '../MAIN/Dbconfig.php';


if (isset($_GET['DummyTicket'])) {

    $find_data = mysqli_query($con, "SELECT tb.tbId,tb.tPassenger,tb.tDeparture,tb.tPhone,tb.tProof,tb.tType,tb.tProofNo,tb.tAoNumber,tb.tAmount,tb.tStatus,tb.tAgencyamount, tb.createdBy,tb.createdDate,A.Aid AS CAREID,A.firstName AS CAREFIRST,A.lastName AS CARELAST,CF.countryName AS CFNAME,CT.countryName AS CTNAME,Agency.firstName AS AGENCYFIRST, Agency.lastName AS AGENCYLAST FROM ticket_booking_table tb INNER JOIN accounts A ON tb.tbCareoff = A.Aid INNER JOIN country_master CF ON tb.tFrom = CF.cId INNER JOIN country_master CT ON tb.tTo = CT.cId LEFT JOIN accounts Agency ON tb.tAgency = Agency.Aid WHERE tb.cancelStatus <> '1' AND tb.bookingStatus = 1 AND tb.tType = ('Dummy Normal' OR 'Dummy Group')");
    if (mysqli_num_rows($find_data) > 0) {
        while ($dataRow = mysqli_fetch_assoc($find_data)) {
            $rows[] = $dataRow;
        }
    } else {
        $rows = array();
    }
    $dataset = array(
        "data" => $rows
    );

    echo json_encode($dataset);
}


if (isset($_GET['DummyEnquiry'])) {

    $find_data = mysqli_query($con, "SELECT tb.tbId,tb.tPassenger,tb.tDeparture,tb.tPhone,tb.tProof,tb.tType,tb.tProofNo,tb.tAoNumber,tb.tAmount,tb.tStatus,tb.tAgencyamount, tb.createdBy,tb.createdDate,A.Aid AS CAREID,A.firstName AS CAREFIRST,A.lastName AS CARELAST,CF.countryName AS CFNAME,CT.countryName AS CTNAME,Agency.firstName AS AGENCYFIRST, Agency.lastName AS AGENCYLAST FROM ticket_booking_table tb INNER JOIN accounts A ON tb.tbCareoff = A.Aid INNER JOIN country_master CF ON tb.tFrom = CF.cId INNER JOIN country_master CT ON tb.tTo = CT.cId LEFT JOIN accounts Agency ON tb.tAgency = Agency.Aid WHERE tb.cancelStatus <> '1' AND tb.bookingStatus = 0 AND tb.tType = ('Dummy Normal' OR 'Dummy Group')");
    if (mysqli_num_rows($find_data) > 0) {
        while ($dataRow = mysqli_fetch_assoc($find_data)) {
            $rows[] = $dataRow;
        }
    } else {
        $rows = array();
    }
    $dataset = array(
        "data" => $rows
    );

    echo json_encode($dataset);
}
