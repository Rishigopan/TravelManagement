<?php

include('../MAIN/Dbconfig.php');
include './CommonFunctions.php';


//Country fetch
if (isset($_POST['selectCountry'])) {
    $FindCountry = mysqli_query($con, "SELECT cId,countryName FROM country_master");
    echo '<option hidden value="">Country</option>';
    foreach ($FindCountry as $FindCountryResults) {
        echo '
                <option value="' . $FindCountryResults["cId"] . '">' . $FindCountryResults["countryName"] . '</option>
                ';
    }
}


//Agency Fetch
if (isset($_POST['selectAgency'])) {
    $FindAgency = mysqli_query($con, "SELECT Aid,firstName,lastName FROM accounts WHERE accountType = 'SUPPLIER'");
    echo '
            <option hidden value="">Choose Agency</option>
            <option value="7">PORTAL</option>
            ';
    foreach ($FindAgency as $FindAgencyResults) {
        echo '
                <option value="' . $FindAgencyResults["Aid"] . '">' . $FindAgencyResults["firstName"] . ' ' . $FindAgencyResults["lastName"] . '</option>
                ';
    }
}


//Customer Fetch
if (isset($_POST['selectCustomer'])) {
    $FindCustomer = mysqli_query($con, "SELECT Aid,firstName,lastName FROM accounts WHERE accountType = 'CUSTOMER'");
    echo '<option hidden value="">Select Customer</option>';
    foreach ($FindCustomer as $FindCustomerResults) {
        echo '
                <option value="' . $FindCustomerResults["Aid"] . '">' . $FindCustomerResults["firstName"] . ' ' . $FindCustomerResults["lastName"] . '</option>
                ';
    }
}


//Ledger Fetch
if (isset($_POST['selectLedger'])) {
    $FindAccountBy = mysqli_query($con, "SELECT Aid,firstName,lastName,accountType FROM accounts WHERE deletePermission <> 'NO'");
    echo '<option hidden value="">Ledger</option>';
    foreach ($FindAccountBy as $FindAccountByResults) {
        echo '<option value="' . $FindAccountByResults["Aid"] . '">' . $FindAccountByResults["firstName"] . ' ' . $FindAccountByResults["lastName"] . ' - ' . $FindAccountByResults["accountType"] . '</option>';
    }
}


//Portal Balance
if (isset($_POST['fetchBalance'])) {

    $BeforeDateFrmPost = date('Y-m-d') . ' 00:00:00';
    $AfterDateFrmPost = date('Y-m-d') . ' 23:59:59';

    $GetPortalClosing = json_decode(GetClosingBalance($con, $BeforeDateFrmPost, $AfterDateFrmPost, '7'));
    $PortalBalance = $GetPortalClosing->Closing;
    echo json_encode(array('Status' => '1', 'PortalBalance' => $PortalBalance));
}


//Cash in hand and startup capital
if (isset($_POST['DayReportDate'])) {

    $DayReportDate = $_POST['DayReportDate'];


    $findCashAndStartup = mysqli_query($con, "SELECT dayCashInHand,dayStartupCapital FROM dayreport WHERE dayDate = '$DayReportDate'");
    if (mysqli_num_rows($findCashAndStartup) > 0) {
        foreach ($findCashAndStartup as $findCashAndStartupResult) {
            $Startup = $findCashAndStartupResult['dayStartupCapital'];
            $CashInHand = $findCashAndStartupResult['dayCashInHand'];
        }
        $ResultArray = array('Status' => '1', 'Startup' => $Startup, 'CashInHand' => $CashInHand);
    } else {

        $FindLastDayReport = mysqli_query($con, "SELECT dayStartupCapital,dayCashInHand FROM dayreport ORDER BY dayDate DESC LIMIT 1");
        if(mysqli_num_rows($FindLastDayReport) > 0){
            foreach ($FindLastDayReport as $FindLastDayReportResult) {
                $Startup = $FindLastDayReportResult['dayStartupCapital'];
                $CashInHand = $FindLastDayReportResult['dayCashInHand'];
            }
        }else{
            $Startup = 600000;
            $CashInHand = 0;
        }
        $ResultArray = array('Status' => '1', 'Startup' => $Startup, 'CashInHand' => $CashInHand);
    }

    echo json_encode($ResultArray);
}
