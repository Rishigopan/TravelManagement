<?php

include '../MAIN/Dbconfig.php';
include './CommonFunctions.php';

$DateStart = date('Y-m-d').' 00:00:00';
$DateEnd =  date('Y-m-d'). ' 23:59:59';

$DateToday = date('Y-m-d');

//total Ticket Amount
if (isset($_POST["Ticket"])) {

    $fetchTicketAmount = mysqli_query($con, "SELECT SUM(tAmount) FROM ticket_booking_table WHERE DATE(createdDate) = '$DateToday' AND cancelStatus <> '1'");
    if (mysqli_num_rows($fetchTicketAmount) > 0) {
        foreach ($fetchTicketAmount as $TicketAmountResult) {
            if($TicketAmountResult['SUM(tAmount)'] != ''){
                $TicketAmount = $TicketAmountResult['SUM(tAmount)'];
            }
            else{
                $TicketAmount = 0;
            }
        }
    } else {
        $TicketAmount = 0;
    }

    echo json_encode(array('Status' => 1,'TicketAmount' => $TicketAmount));
}


//total Visa Amount
if (isset($_POST["Visa"])) {

    $fetchVisaAmount = mysqli_query($con, "SELECT SUM(ourRate) FROM visa_booking WHERE DATE(createdDate) = '$DateToday' AND cancelStatus <> '1'");
    if (mysqli_num_rows($fetchVisaAmount) > 0) {
        foreach ($fetchVisaAmount as $VisaAmountResult) {
            if($VisaAmountResult['SUM(ourRate)'] != ''){
                $VisaAmount = $VisaAmountResult['SUM(ourRate)'];
            }
            else{
                $VisaAmount = 0;
            }
        }
    } else {
        $VisaAmount = 0;
    }

    echo json_encode(array('Status' => 1,'VisaAmount' => $VisaAmount));
}



//total Portal Amount
if (isset($_POST["Portal"])) {

    $connString = $con; 
    $beforePostDate = $DateStart;
    $afterPostDate = $DateEnd;
    $customerId = '7';

    $fetchPortalAmount = json_decode(GetClosingBalance($connString, $beforePostDate, $afterPostDate, $customerId));
    $PortalAmount = $fetchPortalAmount -> Closing;

    echo json_encode(array('Status' => 1,'PortalAmount' => $PortalAmount));
}


//total Profit Amount
if (isset($_POST["Profit"])) {

    $connString = $con; 
    $StartDate = $DateStart;
    $EndDate = $DateEnd;
    
    $fetchProfitAmount = json_decode(FindTotalProfit($StartDate,$EndDate,$connString));
    $ProfitAmount = $fetchProfitAmount -> TotalProfit;

    echo json_encode(array('Status' => 1,'ProfitAmount' => $ProfitAmount));
}




//Custom Range Profit
if (isset($_POST["StartDate"])) {

    $StartDate = $_POST['StartDate'];

    $EndDate = $_POST['EndDate'];

    $findProfitDateWise = json_decode(FindDayWiseProfit($StartDate,$EndDate,$con));

    $Dates = $findProfitDateWise -> Dates;
    $Profits = $findProfitDateWise -> Profits;

    echo json_encode(array('Status' => 1, 'Dates' => $Dates, 'Profits' => $Profits));
}


//Custom Range FullDate
if (isset($_POST["FullDataStartDate"])) {

    $FullDataStartDate = $_POST['FullDataStartDate'];
    $FullDataEndDate = $_POST['FullDataEndDate'];

    $findFullDataDateWise = json_decode(FindTotalProfit($FullDataStartDate,$FullDataEndDate,$con));

    //$Dates = $findFullDataDateWise -> Dates;
    $FullTicket = $findFullDataDateWise -> TotalTicket;
    $FullVisa = $findFullDataDateWise -> TotalVisa;
    $FullProfit = $findFullDataDateWise -> TotalProfit;

    echo json_encode(array('Status' => 1, 'FullProfit' => $FullProfit, 'FullTicket' => $FullTicket, 'FullVisa' => $FullVisa));
}





