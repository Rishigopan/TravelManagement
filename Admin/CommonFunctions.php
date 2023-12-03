<?php

include '../MAIN/Dbconfig.php';


//Santize the the string
function SanitizeInput($input)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    //$input = strtoupper($input);
    return $input;
}


//sanitize the input integer
function SanitizeInt($intinput)
{
    $intinput = trim($intinput);
    $intinput = preg_replace('/[+-]/', '', $intinput);
    $intinput = filter_var($intinput, FILTER_SANITIZE_NUMBER_INT);
    return $intinput;
}



//sanitize the decimal integer
function SanitizeDecimal($decinput)
{
    $decinput = trim($decinput);
    $decinput = preg_replace('/[+-]/', '', $decinput);
    $decinput = filter_var($decinput, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    return $decinput;
}





//Make Account Posting
function ledgerTransactions($vType, $toId, $byId, $amount, $userid, $action, $remarks, $voucherNo, $voucherDate, $receivedby, $bookingid, $connString,$hiddenStatus = 0)
{

    //include '../MAIN/Dbconfig.php';
    $con = $connString;
    $VoucherNo  = $voucherNo;
    $Action = $action;
    $userId = $userid;
    $voucherType = $vType;
    $ToId = $toId;
    $ById = $byId;
    $Amount = $amount;
    $dateToday = date('Y-m-d h:i:s');
    $Remark = $remarks;
    $VoucherDate = $voucherDate;
    $ReceivedBy = $receivedby;
    $BookingId = $bookingid;
    $HiddenStatus = $hiddenStatus;

    $findMaxAccountId = mysqli_query($con, "SELECT MAX(acctId) FROM account_transactions");
    foreach ($findMaxAccountId as $findMaxAccountIdResult) {
        $maxAccountId = $findMaxAccountIdResult['MAX(acctId)'] + 1;
    }


    if ($Action == 'ADD') {
        $InsertTransaction = mysqli_query($con, "INSERT INTO `account_transactions`(`acctId`, `voucherNo`, `voucherDate`, `toId`, `byId`, `toAmount`, `byAmount`,`receivedBy`, `remarks`, `voucherType`,`bookingId`,`hiddenStatus`,`createdBy`, `createdDate`) 
            VALUES ('$maxAccountId','$VoucherNo','$VoucherDate','$ToId','$ById','$Amount','$Amount','$ReceivedBy','$Remark','$voucherType','$BookingId','$HiddenStatus','$userId','$dateToday')");
        if ($InsertTransaction) {
            return 'Success';
        } else {
            return 'Failed';
        }
    }


    if ($Action == 'EDIT') {
        $InsertTransaction = mysqli_query($con, "UPDATE `account_transactions` SET `voucherDate`='$VoucherDate',`toId`='$ToId',`byId`='$ById',`toAmount`='$Amount',`byAmount`='$Amount',`receivedBy`='$ReceivedBy',`remarks`='$Remark',`updatedBy`='$userId',`updatedDate`='$dateToday' WHERE `voucherNo`='$VoucherNo'");
        if ($InsertTransaction) {
            return 'Success';
        } else {
            return 'Failed';
        }
    }

    if ($Action == 'EDITBOOKING') {
        $InsertTransaction = mysqli_query($con, "UPDATE `account_transactions` SET `voucherDate`='$VoucherDate',`toId`='$ToId',`byId`='$ById',`toAmount`='$Amount',`byAmount`='$Amount',`receivedBy`='$ReceivedBy',`updatedBy`='$userId',`updatedDate`='$dateToday', remarks = '$Remark' WHERE `voucherNo`='$VoucherNo' AND `voucherType` = '$vType'");
        if ($InsertTransaction) {
            return 'Success';
        } else {
            return 'Failed';
        }
    }



    if ($Action == 'REMOVE') {
        $InsertTransaction = mysqli_query($con, "DELETE FROM `account_transactions` WHERE `voucherNo`='$VoucherNo'");
        if ($InsertTransaction) {
            return 'Success';
        } else {
            return 'Failed';
        }
    }


    if ($Action == 'CANCEL') {
        $InsertTransaction = mysqli_query($con, "UPDATE `account_transactions` SET hiddenStatus = '1', updatedBy = '$userId',updatedDate = '$dateToday' WHERE `voucherNo`='$VoucherNo' AND voucherType = '$vType'");
        if ($InsertTransaction) {
            return 'Success';
        } else {
            return 'Failed';
        }
    }
}


//Make Transactions in Portal
function PortalTransactions($connString, $action, $amount, $incentive, $from, $transactionDate, $userid, $particularId, $particularName)
{

    $Con = $connString;
    $Action = $action;
    $UserId = $userid;
    $Amount = $amount;
    $Incentive = $incentive;
    $From = $from;
    $ParticularId = $particularId;
    $ParticularName = $particularName;
    $TransactionDate = $transactionDate;

    if ($Action == 'RECHARGE') {

        $TotalAmount = $Amount + $Incentive;

        //mysqli_autocommit($Con, FALSE);
        $FetchMaxTransactionId = mysqli_query($Con, "SELECT MAX(transactionId) FROM extratransactions");
        foreach ($FetchMaxTransactionId  as $FetchMaxTransactionIdResult) {
            $MaxTransactionId  = $FetchMaxTransactionIdResult['MAX(transactionId)'] + 1;
        }

        $InsertIntoTransaction = mysqli_query($Con, "INSERT INTO `extratransactions`
        (`transactionId`,`transactionDate`,`fromId`,`particularId`,`particularName`,`incentiveAmount`,`amount`,`totalAmount`,`createdBy`,`createdDate`) VALUES('$MaxTransactionId','$TransactionDate','$From','$ParticularId','$ParticularName','$Incentive','$Amount','$TotalAmount','$UserId','$TransactionDate')");

        if ($InsertIntoTransaction) {

            $UpdateLedgerExtra = mysqli_query($Con, "UPDATE ledgerextra SET  `totalAdded` = `totalAdded` + '$Amount', `totalIncentive` = `totalIncentive` + '$Incentive',`totalRedeemable` = `totalRedeemable` + '$TotalAmount',`updatedBy` = '$UserId' ,`updatedDate` = '$TransactionDate' WHERE `partId` = '$ParticularId'");

            if ($UpdateLedgerExtra) {
                return 'Success';
            }
        }
    }
}


//Find Closing Balance of Accounts
function GetClosingBalance($connString, $beforePostDate, $afterPostDate, $customerId)
{

    $Con = $connString;
    $BeforeDateFrmPost = $beforePostDate;
    $AfterDateFrmPost = $afterPostDate;
    $CustomerId = $customerId;

    $BeforeDate = $BeforeDateFrmPost;
    $Afterdate = $AfterDateFrmPost;
    $OpeningBalance = 0;
    $SumDr = 0;
    $SumCr = 0;
    $SumCrOpening = 0;
    $SumDrOpening = 0;
    $BeforeTestDate = new DateTime($BeforeDate);
    $BeforeTestDate->modify('-1 day');
    $DayBeforeDate =  $BeforeTestDate->format('Y-m-d g:i:s');

    $findCustomerOpening = mysqli_query($Con, "SELECT openingType,opening FROM accounts WHERE Aid = '$CustomerId'");
    foreach ($findCustomerOpening as $findCustomerOpeningResults) {
        if ($findCustomerOpeningResults['openingType'] == 'Cr') {
            $SumCr += $findCustomerOpeningResults['opening'];
            $SumCrOpening += $findCustomerOpeningResults['opening'];
        } else {
            $SumDr += $findCustomerOpeningResults['opening'];
            $SumDrOpening += $findCustomerOpeningResults['opening'];
        }
    }


    $FindSumofToAmount = mysqli_query($Con, "SELECT SUM(toAmount) FROM account_transactions WHERE toId = '$CustomerId' AND hiddenStatus <> '1' AND voucherDate < '$DayBeforeDate'"); //Sum of debitAmount
    foreach ($FindSumofToAmount as $FindSumofToAmountResults) {
        $SumDr += $FindSumofToAmountResults['SUM(toAmount)'];
    }

    $FindSumofByAmount = mysqli_query($Con, "SELECT SUM(byAmount) FROM account_transactions WHERE byId = '$CustomerId' AND hiddenStatus <> '1' AND voucherDate < '$DayBeforeDate'"); //Sum of creditAmount
    foreach ($FindSumofByAmount as $FindSumofByAmountResults) {
        $SumCr += $FindSumofByAmountResults['SUM(byAmount)'];
    }


    if ($SumDr > $SumCr) {
        $OpeningBalance += $SumDr - $SumCr;
    } else {
        $OpeningBalance += $SumCr - $SumDr;
    }


    $NewOpening = $OpeningBalance;

    $FindTransactions = mysqli_query($Con, "SELECT ATT.toId AS ATOID,ATT.byId AS ABYID,ATO.firstName AS ATONAME,ABY.firstName AS ABYNAME,ATT.voucherDate,ATT.toAmount,ATT.byAmount,ATT.voucherType,ATT.remarks FROM account_transactions ATT INNER JOIN accounts ATO ON ATT.toId = ATO.Aid INNER JOIN accounts ABY ON ATT.byId = ABY.Aid WHERE (ATT.toId = '$CustomerId' OR  ATT.byId = '$CustomerId') AND ATT.hiddenStatus <> '1' AND ATT.voucherDate BETWEEN '$BeforeDate' AND '$Afterdate'");
    $NEWSUMDR = 0;
    $NEWSUMCR = 0;
    foreach ($FindTransactions as $FindTransactionsResults) {

        if ($FindTransactionsResults['ATOID'] == $CustomerId) {
            $SumDr += $FindTransactionsResults['toAmount'];
            $NEWSUMDR += $FindTransactionsResults['toAmount'];
        } else {
        }

        if ($FindTransactionsResults['ABYID'] == $CustomerId) {
            $SumCr += $FindTransactionsResults['toAmount'];
            $NEWSUMCR += $FindTransactionsResults['toAmount'];
        } else {
        }

        $OpeningBalance = $SumDr - $SumCr;
    }


    return json_encode(array('Opening' => $NewOpening, 'Inward' => $NEWSUMCR, 'Outward' => $NEWSUMDR, 'Closing' => $OpeningBalance));
}


//Find Total Profit,Receivable,Payable etc
function FindTotalProfit($StartDate, $EndDate, $connString)
{


    $StartDateVar = new DateTime($StartDate);
    $EndDateVar = new DateTime($EndDate);


    $TotalProfit = 0;
    $TotalStartup = 0;
    $TotalCashInHand = 0;
    $TotalPayabale = 0;
    $TotalReceivable = 0;
    $TotalBankBalance = 0;
    $TotalPortal = 0;
    $TotalTicketBooking = 0;
    $TotalVisaBooking = 0;


    for ($var = $StartDateVar; $var <= $EndDateVar; $var->modify('+1 day')) {


        $GivenDate = $var->format('Y-m-d');

        $FindStartupandCash = mysqli_query($connString, "SELECT * FROM dayreport WHERE  DATE(dayDate) = '$GivenDate'");
        if (mysqli_num_rows($FindStartupandCash) > 0) {
            foreach ($FindStartupandCash as $FindStartupandCashResult) {
                $StartUpCapital = $FindStartupandCashResult['dayStartupCapital'];
                $CashInHand = $FindStartupandCashResult['dayCashInHand'];
            }
            $BeforeDateFrmPost = $GivenDate . ' 00:00:00';
            $AfterDateFrmPost = $GivenDate . ' 23:59:59';
            $Receivable  = 0;
            $Payabale  = 0;

            $findCustomers = mysqli_query($connString, "SELECT * FROM accounts WHERE accountType IN ('CUSTOMER','SUPPLIER')");
            foreach ($findCustomers as $findCustomerResults) {

                $CustomerId = $findCustomerResults['Aid'];
                $BeforeDate = $BeforeDateFrmPost;
                $Afterdate = $AfterDateFrmPost;
                $NEWSUMDR = 0;
                $NEWSUMCR = 0;


                $FindTransactions = mysqli_query($connString, "SELECT ATT.voucherNo,ATT.toId AS ATOID,ATT.byId AS ABYID,ATO.firstName AS ATONAME,ABY.firstName AS ABYNAME,ATT.voucherDate,ATT.toAmount,ATT.byAmount,ATT.voucherType,ATT.remarks FROM account_transactions ATT INNER JOIN accounts ATO ON ATT.toId = ATO.Aid INNER JOIN accounts ABY ON ATT.byId = ABY.Aid WHERE (ATT.toId = '$CustomerId' OR  ATT.byId = '$CustomerId') AND ATT.hiddenStatus <> '1' AND ATT.voucherType IN ('PV','RV') AND ATT.voucherDate BETWEEN '$BeforeDate' AND '$Afterdate'");

                foreach ($FindTransactions as $FindTransactionsResults) {

                    if ($FindTransactionsResults['ATOID'] == $CustomerId) {

                        $NEWSUMDR += $FindTransactionsResults['toAmount'];
                    } else {
                        //echo '';
                    }

                    if ($FindTransactionsResults['ABYID'] == $CustomerId) {

                        $NEWSUMCR += $FindTransactionsResults['toAmount'];
                    } else {
                        //echo '';
                    }
                }

                $Receivable  +=  $NEWSUMCR;

                $Payabale  += $NEWSUMDR;
            }


            //Get Portal Closing
            $GetPortalClosing = json_decode(GetClosingBalance($connString, $BeforeDateFrmPost, $AfterDateFrmPost, '7'));
            $PortalBalance = $GetPortalClosing->Closing;

            //Get Bank Closing
            $GetClosing = json_decode(GetClosingBalance($connString, $BeforeDateFrmPost, $AfterDateFrmPost, '10'));
            $BankBalance = $GetClosing->Closing;

            //Cash in hand
            $CashTotal = $PortalBalance + $BankBalance + $CashInHand;

            //Calculate Profit
            $Profit =  $Receivable + $CashTotal - $Payabale - $StartUpCapital;

            //Total Ticket Booking
            $findTotalTicketBooking  = mysqli_query($connString, "SELECT SUM(tAmount) FROM ticket_booking_table WHERE cancelStatus <> 1 AND DATE(createdDate) = '$GivenDate'");
            foreach ($findTotalTicketBooking as $findTotalTicketBookingResult) {
                $TicketBooking = $findTotalTicketBookingResult['SUM(tAmount)'];
            }

            //Total Visa Booking
            $findTotalVisaBooking  = mysqli_query($connString, "SELECT SUM(ourRate) FROM visa_booking WHERE cancelStatus <> 1 AND DATE(createdDate) = '$GivenDate'");
            foreach ($findTotalVisaBooking as $findTotalVisaBookingResult) {
                $VisaBooking = $findTotalVisaBookingResult['SUM(ourRate)'];
            }


            $TotalProfit += $Profit;
            $TotalStartup += $StartUpCapital;
            $TotalCashInHand += $CashInHand;
            $TotalPayabale += $Payabale;
            $TotalReceivable += $Receivable;
            $TotalBankBalance += $BankBalance;
            $TotalPortal += $PortalBalance;
            $TotalTicketBooking += $TicketBooking;
            $TotalVisaBooking += $VisaBooking;

        } else {
            $StartUpCapital = 0;
            $CashInHand = 0;
            $BeforeDateFrmPost = $GivenDate . ' 00:00:00';
            $AfterDateFrmPost = $GivenDate . ' 23:59:59';
            $Receivable  = 0;
            $Payabale  = 0;

            $findCustomers = mysqli_query($connString, "SELECT * FROM accounts WHERE accountType IN ('CUSTOMER','SUPPLIER')");
            foreach ($findCustomers as $findCustomerResults) {

                $CustomerId = $findCustomerResults['Aid'];
                $BeforeDate = $BeforeDateFrmPost;
                $Afterdate = $AfterDateFrmPost;
                $NEWSUMDR = 0;
                $NEWSUMCR = 0;


                $FindTransactions = mysqli_query($connString, "SELECT ATT.voucherNo,ATT.toId AS ATOID,ATT.byId AS ABYID,ATO.firstName AS ATONAME,ABY.firstName AS ABYNAME,ATT.voucherDate,ATT.toAmount,ATT.byAmount,ATT.voucherType,ATT.remarks FROM account_transactions ATT INNER JOIN accounts ATO ON ATT.toId = ATO.Aid INNER JOIN accounts ABY ON ATT.byId = ABY.Aid WHERE (ATT.toId = '$CustomerId' OR  ATT.byId = '$CustomerId') AND ATT.hiddenStatus <> '1' AND ATT.voucherType IN ('PV','RV') AND ATT.voucherDate BETWEEN '$BeforeDate' AND '$Afterdate'");

                foreach ($FindTransactions as $FindTransactionsResults) {

                    if ($FindTransactionsResults['ATOID'] == $CustomerId) {

                        $NEWSUMDR += $FindTransactionsResults['toAmount'];
                    } else {
                        //echo '';
                    }

                    if ($FindTransactionsResults['ABYID'] == $CustomerId) {

                        $NEWSUMCR += $FindTransactionsResults['toAmount'];
                    } else {
                        //echo '';
                    }
                }

                $Receivable  +=  $NEWSUMCR;

                $Payabale  += $NEWSUMDR;
            }

            //Get Portal Closing
            $GetPortalClosing = json_decode(GetClosingBalance($connString, $BeforeDateFrmPost, $AfterDateFrmPost, '7'));
            $PortalBalance = $GetPortalClosing->Closing;

            //Get Bank Closing
            $GetClosing = json_decode(GetClosingBalance($connString, $BeforeDateFrmPost, $AfterDateFrmPost, '10'));
            $BankBalance = $GetClosing->Closing;

            //Cash in hand
            $CashTotal = 0;

            //Calculate Profit
            $Profit =  0;

            //Total Ticket Booking
            $findTotalTicketBooking  = mysqli_query($connString, "SELECT SUM(tAmount) FROM ticket_booking_table WHERE cancelStatus <> 1 AND DATE(createdDate) = '$GivenDate'");
            foreach ($findTotalTicketBooking as $findTotalTicketBookingResult) {
                $TicketBooking = $findTotalTicketBookingResult['SUM(tAmount)'];
            }

            //Total Visa Booking
            $findTotalVisaBooking  = mysqli_query($connString, "SELECT SUM(ourRate) FROM visa_booking WHERE cancelStatus <> 1 AND DATE(createdDate) = '$GivenDate'");
            foreach ($findTotalVisaBooking as $findTotalVisaBookingResult) {
                $VisaBooking = $findTotalVisaBookingResult['SUM(ourRate)'];
            }


            $TotalProfit += $Profit;
            $TotalStartup += $StartUpCapital;
            $TotalCashInHand += $CashInHand;
            $TotalPayabale += $Payabale;
            $TotalReceivable += $Receivable;
            $TotalBankBalance += $BankBalance;
            $TotalPortal += $PortalBalance;
            $TotalTicketBooking += $TicketBooking;
            $TotalVisaBooking += $VisaBooking;
        }


    }


    // echo $TotalProfit ;
    // echo $TotalStartup ;
    // echo $TotalCashInHand ;
    // echo $TotalPayabale ;
    // echo $TotalReceivable ;
    // echo $TotalBankBalance ;
    // echo $TotalPortal ;
    // echo $TotalTicketBooking; 
    // echo $TotalVisaBooking ;


    return json_encode(array('TotalProfit' => $TotalProfit, 'TotalPayable' => $TotalPayabale, 'TotalReceivable' => $TotalReceivable, 'TotalStartup' => $TotalStartup, 'TotalCash' => $TotalCashInHand, 'TotalBank' => $TotalBankBalance, 'TotalPortal' => $TotalPortal, 'TotalTicket' => $TotalTicketBooking, 'TotalVisa' => $TotalVisaBooking));
}


//Find Day Summary
function FindDayWiseProfit($StartDate, $EndDate, $connString)
{


    $StartDateVar = new DateTime($StartDate);
    $EndDateVar = new DateTime($EndDate);


    $TotalProfit = array();
    $TotalStartup = array();
    $TotalCashInHand = array();
    $TotalPayabale = array();
    $TotalReceivable = array();
    $TotalBankBalance = array();
    $TotalPortal = array();
    $Dates = array();


    for ($var = $StartDateVar; $var <= $EndDateVar; $var->modify('+1 day')) {


        $GivenDate = $var->format('Y-m-d');

        $FindStartupandCash = mysqli_query($connString, "SELECT * FROM dayreport WHERE  DATE(dayDate) = '$GivenDate'");
        if (mysqli_num_rows($FindStartupandCash) > 0) {
            foreach ($FindStartupandCash as $FindStartupandCashResult) {
                $StartUpCapital = $FindStartupandCashResult['dayStartupCapital'];
                $CashInHand = $FindStartupandCashResult['dayCashInHand'];
            }

            $BeforeDateFrmPost = $GivenDate . ' 00:00:00';
            $AfterDateFrmPost = $GivenDate . ' 23:59:59';
            $Receivable  = 0;
            $Payabale  = 0;

            $findCustomers = mysqli_query($connString, "SELECT * FROM accounts WHERE accountType IN ('CUSTOMER','SUPPLIER')");
            foreach ($findCustomers as $findCustomerResults) {

                $CustomerId = $findCustomerResults['Aid'];
                $BeforeDate = $BeforeDateFrmPost;
                $Afterdate = $AfterDateFrmPost;
                $NEWSUMDR = 0;
                $NEWSUMCR = 0;


                $FindTransactions = mysqli_query($connString, "SELECT ATT.voucherNo,ATT.toId AS ATOID,ATT.byId AS ABYID,ATO.firstName AS ATONAME,ABY.firstName AS ABYNAME,ATT.voucherDate,ATT.toAmount,ATT.byAmount,ATT.voucherType,ATT.remarks FROM account_transactions ATT INNER JOIN accounts ATO ON ATT.toId = ATO.Aid INNER JOIN accounts ABY ON ATT.byId = ABY.Aid WHERE (ATT.toId = '$CustomerId' OR  ATT.byId = '$CustomerId') AND ATT.hiddenStatus <> '1' AND ATT.voucherType IN ('PV','RV') AND ATT.voucherDate BETWEEN '$BeforeDate' AND '$Afterdate'");

                foreach ($FindTransactions as $FindTransactionsResults) {

                    if ($FindTransactionsResults['ATOID'] == $CustomerId) {

                        $NEWSUMDR += $FindTransactionsResults['toAmount'];
                    } else {
                        //echo '';
                    }

                    if ($FindTransactionsResults['ABYID'] == $CustomerId) {

                        $NEWSUMCR += $FindTransactionsResults['toAmount'];
                    } else {
                        //echo '';
                    }
                }

                $Receivable  +=  $NEWSUMCR;

                $Payabale  += $NEWSUMDR;
            }


            //Get Portal Closing
            $GetPortalClosing = json_decode(GetClosingBalance($connString, $BeforeDateFrmPost, $AfterDateFrmPost, '7'));
            $PortalBalance = $GetPortalClosing->Closing;

            //Get Bank Closing
            $GetClosing = json_decode(GetClosingBalance($connString, $BeforeDateFrmPost, $AfterDateFrmPost, '10'));
            $BankBalance = $GetClosing->Closing;

            //Total
            $CashTotal = $PortalBalance + $BankBalance + $CashInHand;

            //Calculate Profit
            $Profit =  $Receivable + $CashTotal - $Payabale - $StartUpCapital;

            //Total Ticket Booking
            $findTotalTicketBooking  = mysqli_query($connString, "SELECT SUM(tAmount) FROM ticket_booking_table WHERE cancelStatus <> 1 AND DATE(createdDate) = '$GivenDate'");
            foreach ($findTotalTicketBooking as $findTotalTicketBookingResult) {
                $TicketBooking = $findTotalTicketBookingResult['SUM(tAmount)'];
            }

            //Total Visa Booking
            $findTotalVisaBooking  = mysqli_query($connString, "SELECT SUM(ourRate) FROM visa_booking WHERE cancelStatus <> 1 AND DATE(createdDate) = '$GivenDate'");
            foreach ($findTotalVisaBooking as $findTotalVisaBookingResult) {
                $VisaBooking = $findTotalVisaBookingResult['SUM(ourRate)'];
            }
        } else {
            $Profit = 0;
            $StartUpCapital = 0;
            $CashInHand = 0;
            $Payabale = 0;
            $Receivable = 0;
            $BankBalance = 0;
            $PortalBalance = 0;
            $GivenDate = $GivenDate;
        }




        array_push($TotalProfit, $Profit);
        array_push($TotalStartup, $StartUpCapital);
        array_push($TotalCashInHand, $CashInHand);
        array_push($TotalPayabale, $Payabale);
        array_push($TotalReceivable, $Receivable);
        array_push($TotalBankBalance, $BankBalance);
        array_push($TotalPortal, $PortalBalance);
        array_push($Dates, $GivenDate);
    }

    return json_encode(array('Profits' => $TotalProfit, 'Startups' => $TotalStartup, 'CashinHands' => $TotalCashInHand, 'Payables' => $TotalPayabale, 'Receivables' => $TotalReceivable, 'BankBalances' => $TotalBankBalance, 'Portals' => $TotalPortal, 'Dates' => $Dates));
}


//Task Reminder CRUD Operations
function TaskReminder($connString,$taskid,$taskname,$taskdate,$taskstatus,$taskremindbefore,$taskphone,$taskreminder,$taskaction,$taskremindsend,$taskassigned,$bookingId,$userid){

    $ConnString  = $connString;
    $TaskId = $taskid;
    $TaskName = $taskname;
    $TaskDate = $taskdate;
    $TaskStatus = $taskstatus;
    $TaskRemindBefore = $taskremindbefore;
    $TaskPhone = $taskphone;
    $TaskRemark = $taskreminder;
    $TaskAction = $taskaction;
    $TaskAssigned = $taskassigned;
    $DateToday = date('Y-m-d h:i:s');
    $UserId = $userid; 
    $BookingId = $bookingId;
    $TaskRemindSend = $taskremindsend;

    if($TaskAction == 'ADD'){

        $FindMaxTaskId = mysqli_query($ConnString, "SELECT MAX(taskId) FROM taskreminder");
        foreach($FindMaxTaskId as $FindMaxTaskIdResult){
            $TaskId = $FindMaxTaskIdResult['MAX(taskId)'] + 1;
        }

        $TaskExecute = mysqli_query($ConnString ,"INSERT INTO taskreminder (`taskId`,`taskName`,`taskDate`,`taskRemark`,`taskStatus`,`taskReminderPhone`,`taskRemindBefore`,`taskAssignedTo`,`taskRemindSend`,`taskBookingId`,`createdBy`,`createdDate`) VALUES ('$TaskId', '$TaskName', '$TaskDate', '$TaskRemark', '$TaskStatus', '$TaskPhone', '$TaskRemindBefore', $TaskAssigned, '$TaskRemindSend', '$BookingId', '$UserId', '$DateToday')");

        if($TaskExecute){
            return 'Success';
        }
        else{
            return 'Failed';
        }
        
    }
    elseif($TaskAction == 'EDIT'){

        $TaskExecute = mysqli_query($ConnString ,"UPDATE `taskreminder` SET `taskName` = '$TaskName', `taskDate` = '$TaskDate', `taskRemark` = '$TaskRemark', `taskStatus` = '$TaskStatus', `taskReminderPhone` = '$TaskPhone', `taskRemindBefore` = '$TaskRemindBefore', `taskAssignedTo` = '$TaskAssigned', `taskRemindSend` = '$TaskRemindSend', `updatedBy` = '$UserId', `updatedDate` = '$DateToday'  WHERE `taskId` = '$TaskId'");

        if($TaskExecute){
            return 'Success';
        }
        else{
            return 'Failed';
        }


    }elseif($TaskAction == 'EDITBOOKING'){

        $TaskExecute = mysqli_query($ConnString ,"UPDATE `taskreminder` SET `taskName` = '$TaskName', `taskDate` = '$TaskDate', `taskRemark` = '$TaskRemark', `taskStatus` = '$TaskStatus', `taskReminderPhone` = '$TaskPhone', `taskRemindBefore` = '$TaskRemindBefore', `taskAssignedTo` = '$TaskAssigned', `taskRemindSend` = '$TaskRemindSend', `updatedBy` = '$UserId', `updatedDate` = '$DateToday'  WHERE `taskBookingId` = '$BookingId'");

        if($TaskExecute){
            return 'Success';
        }
        else{
            return 'Failed';
        }

    }elseif($TaskAction == 'REMOVE'){

        $TaskExecute = mysqli_query($ConnString ,"DELETE FROM taskreminder WHERE taskId = '$TaskId'");

        if($TaskExecute){
            return 'Success';
        }
        else{
            return 'Failed';
        }

    }elseif($TaskAction == 'REMOVEBOOKING'){

        $TaskExecute = mysqli_query($ConnString ,"DELETE FROM taskreminder WHERE taskBookingId = '$BookingId'");

        if($TaskExecute){
            return 'Success';
        }
        else{
            return 'Failed';
        }

    }

}



/* 
function FindTotalProfit($StartDate,$EndDate,$connString){

        
    $StartDateVar = new DateTime($StartDate);
    $EndDateVar = new DateTime($EndDate);


    $TotalProfit = 0;
    $TotalStartup = 0;
    $TotalCashInHand = 0;
    $TotalPayabale = 0;
    $TotalReceivable = 0;
    $TotalBankBalance = 0;
    $TotalPortal = 0;
    $TotalTicketBooking = 0;
    $TotalVisaBooking = 0;


    for ($var = $StartDateVar; $var <= $EndDateVar; $var->modify('+1 day')) {


        $GivenDate = $var->format('Y-m-d');

        $FindStartupandCash = mysqli_query($connString, "SELECT * FROM dayreport WHERE  DATE(dayDate) = '$GivenDate'");
        if(mysqli_num_rows($FindStartupandCash) > 0){
            foreach ($FindStartupandCash as $FindStartupandCashResult) {
                $StartUpCapital = $FindStartupandCashResult['dayStartupCapital'];
                $CashInHand = $FindStartupandCashResult['dayCashInHand'];
            }
        }
        else{
            $StartUpCapital = 600000;
            $CashInHand = 0;
        }
        
        $BeforeDateFrmPost = $GivenDate . ' 00:00:00';
        $AfterDateFrmPost = $GivenDate . ' 23:59:59';
        $Receivable  = 0;
        $Payabale  = 0;

        $findCustomers = mysqli_query($connString, "SELECT * FROM accounts WHERE accountType IN ('CUSTOMER','SUPPLIER')");
        foreach ($findCustomers as $findCustomerResults) {

            $CustomerId = $findCustomerResults['Aid'];
            $BeforeDate = $BeforeDateFrmPost;
            $Afterdate = $AfterDateFrmPost;
            $NEWSUMDR = 0;
            $NEWSUMCR = 0;


            $FindTransactions = mysqli_query($connString, "SELECT ATT.newVoucherDate,ATT.voucherNo,ATT.toId AS ATOID,ATT.byId AS ABYID,ATO.firstName AS ATONAME,ABY.firstName AS ABYNAME,ATT.voucherDate,ATT.toAmount,ATT.byAmount,ATT.voucherType,ATT.remarks FROM account_transactions ATT INNER JOIN accounts ATO ON ATT.toId = ATO.Aid INNER JOIN accounts ABY ON ATT.byId = ABY.Aid WHERE (ATT.toId = '$CustomerId' OR  ATT.byId = '$CustomerId') AND ATT.hiddenStatus <> '1' AND ATT.voucherType IN ('PV','RV') AND ATT.voucherDate BETWEEN '$BeforeDate' AND '$Afterdate'");

            foreach ($FindTransactions as $FindTransactionsResults) {

                if ($FindTransactionsResults['ATOID'] == $CustomerId) {

                    $NEWSUMDR += $FindTransactionsResults['toAmount'];
                } else {
                    //echo '';
                }

                if ($FindTransactionsResults['ABYID'] == $CustomerId) {

                    $NEWSUMCR += $FindTransactionsResults['toAmount'];
                } else {
                    //echo '';
                }
            }

            $Receivable  +=  $NEWSUMCR;

            $Payabale  += $NEWSUMDR;
        }


        //Get Portal Closing
        $GetPortalClosing = json_decode(GetClosingBalance($connString, $BeforeDateFrmPost, $AfterDateFrmPost, '7'));
        $PortalBalance = $GetPortalClosing->Closing;

        //Get Bank Closing
        $GetClosing = json_decode(GetClosingBalance($connString, $BeforeDateFrmPost, $AfterDateFrmPost, '10'));
        $BankBalance = $GetClosing->Closing;

        //Cash in hand
        $CashTotal = $PortalBalance + $BankBalance + $CashInHand;

        //Calculate Profit
        $Profit =  $Receivable + $CashTotal - $Payabale - $StartUpCapital;

        //Total Ticket Booking
        $findTotalTicketBooking  = mysqli_query($connString, "SELECT SUM(tAmount) FROM ticket_booking_table WHERE cancelStatus <> 1 AND DATE(createdDate) = '$GivenDate'");
        foreach ($findTotalTicketBooking as $findTotalTicketBookingResult) {
            $TicketBooking = $findTotalTicketBookingResult['SUM(tAmount)'];
        }

        //Total Visa Booking
        $findTotalVisaBooking  = mysqli_query($connString, "SELECT SUM(ourRate) FROM visa_booking WHERE cancelStatus <> 1 AND DATE(createdDate) = '$GivenDate'");
        foreach ($findTotalVisaBooking as $findTotalVisaBookingResult) {
            $VisaBooking = $findTotalVisaBookingResult['SUM(ourRate)'];
        }


        $TotalProfit += $Profit;
        $TotalStartup += $StartUpCapital;
        $TotalCashInHand += $CashInHand;
        $TotalPayabale += $Payabale;
        $TotalReceivable += $Receivable;
        $TotalBankBalance += $BankBalance;
        $TotalPortal += $PortalBalance;
        $TotalTicketBooking += $TicketBooking;
        $TotalVisaBooking += $VisaBooking;
    }

    return json_encode(array('TotalProfit' => $TotalProfit, 'TotalPayable' => $TotalPayabale, 'TotalReceivable' => $TotalReceivable, 'TotalStartup' => $TotalStartup, 'TotalCash' => $TotalCashInHand, 'TotalBank' => $TotalBankBalance, 'TotalPortal' => $TotalPortal, 'TotalTicket' => $TotalTicketBooking, 'TotalVisa' => $TotalVisaBooking));
    

} */


//echo TaskReminder($con,'1','tess','2023-01-10','dqwd','3','13323','1223','ADD','4','0','2');