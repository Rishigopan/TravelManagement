<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';
include './CommonFunctions.php';


?>






<?php

if (isset($_POST['FromDate'])) {


    $GivenDate = $_POST['FromDate'];
    //$StartUpCapital = $_POST['StartupCapital'];
    $BeforeDateFrmPost = $_POST['FromDate'] . ' 00:00:00';
    $AfterDateFrmPost = $_POST['FromDate'] . ' 23:59:59';
    $BeforeTillDate = '1800-01-01 00:00:00';

    $AfterTillDate = new DateTime($AfterDateFrmPost);
    $AfterTillDate->modify('-1 day');
    $AfterTillDate = $AfterTillDate->format('Y-m-d');
    //echo $AfterTillDate;
    $TotalReceivableTill = 0;
    $TotalPayableTill = 0;

    //&& $_POST['CashInHand'] > 0
    if (isset($_POST['StartupCapital'])) {

        $StartUpCapital = !empty($_POST['StartupCapital']) ? $_POST['StartupCapital']  : 0;


        //$CashInHand = !empty($_POST['CashInHand']) ? $_POST['CashInHand'] : 0;

        $FindFirstDate = mysqli_query($con, "SELECT dayDate FROM dayreport ORDER BY dayId ASC LIMIT 1 ");
        foreach ($FindFirstDate as $FindFirstDateResult) {
            $FirstDate = $FindFirstDateResult['dayDate'];
        }

        ?>

        <div class="col-lg-8">
            <div class="table-responsive mt-2" style="max-height: 600px;">
                <table class="table table-bordered table-hover  text-nowrap" style="width: 100%;">
                    <thead class="table-light">
                        <tr>
                            <th class="">No</th>
                            <th class="">Particular</th>
                            <th class="">Opening</th>
                            <th class="">Cr/Dr</th>
                            <th class="">Outward</th>
                            <th class="">Inward</th>
                            <th class="">Closing</th>
                            <th class="">Cr/Dr</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php

                        $TotalReceivable  = 0;
                        $TotalPayabale  = 0;
                        $OpeningCR = 0;
                        $OpeningDR = 0;
                        $RowNumber = 0;

                        $findCustomers = mysqli_query($con, "SELECT * FROM accounts WHERE accountType IN ('CUSTOMER','SUPPLIER')");
                        foreach ($findCustomers as $findCustomerResults) {

                            $RowNumber++;

                            $CustomerId = $findCustomerResults['Aid'];
                            //$BeforeDateFrmPost = '202-12-31 00:00:00';
                            //$AfterDateFrmPost = '2022-12-31 23:59:59';
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
                            //echo $DayBeforeDate;


                            $findCustomerOpening = mysqli_query($con, "SELECT openingType,opening FROM accounts WHERE Aid = '$CustomerId'");
                            foreach ($findCustomerOpening as $findCustomerOpeningResults) {
                                if ($findCustomerOpeningResults['openingType'] == 'Cr') {
                                    $SumCr += $findCustomerOpeningResults['opening'];
                                    $SumCrOpening += $findCustomerOpeningResults['opening'];
                                } else {
                                    $SumDr += $findCustomerOpeningResults['opening'];
                                    $SumDrOpening += $findCustomerOpeningResults['opening'];
                                }
                            }


                            $FindSumofToAmount = mysqli_query($con, "SELECT SUM(toAmount) FROM account_transactions WHERE toId = '$CustomerId' AND hiddenStatus <> '1' AND voucherType IN ('PV','RV') AND voucherDate < '$DayBeforeDate'"); //Sum of debitAmount
                            foreach ($FindSumofToAmount as $FindSumofToAmountResults) {
                                $SumDr += $FindSumofToAmountResults['SUM(toAmount)'];
                            }

                            $FindSumofByAmount = mysqli_query($con, "SELECT SUM(byAmount) FROM account_transactions WHERE byId = '$CustomerId' AND hiddenStatus <> '1' AND voucherType IN ('PV','RV') AND voucherDate < '$DayBeforeDate'"); //Sum of creditAmount
                            foreach ($FindSumofByAmount as $FindSumofByAmountResults) {
                                $SumCr += $FindSumofByAmountResults['SUM(byAmount)'];
                            }


                            if ($SumDr > $SumCr) {
                                $OpeningBalance = $SumDr - $SumCr;
                                $CRDR = 'DR';
                                $OpeningDR += $OpeningBalance;
                                //echo "Opening = " . $OpeningBalance . " - DR";
                            } else {
                                $OpeningBalance = $SumCr - $SumDr;
                                $CRDR = 'CR';
                                $OpeningCR += $OpeningBalance;
                                ///echo "Opening = " . $OpeningBalance . " - CR";
                            }


                            ?>
                            <tr>
                                <td> <?= $RowNumber; ?> </td>
                                <td> <?php echo $findCustomerResults['firstName'] ?> </td>
                                <td> <?php echo number_format($OpeningBalance, 2, '.', ','); ?> </td>
                                <td> <?php echo ($OpeningBalance > 0) ? $CRDR : ""; ?> </td>
                                <?php

                                // $FindTransactions = mysqli_query($con, "SELECT ATT.voucherNo,ATT.toId AS ATOID,ATT.byId AS ABYID,ATO.firstName AS ATONAME,ABY.firstName AS ABYNAME,ATT.voucherDate,ATT.toAmount,ATT.byAmount,ATT.voucherType,ATT.remarks FROM account_transactions ATT INNER JOIN accounts ATO ON ATT.toId = ATO.Aid INNER JOIN accounts ABY ON ATT.byId = ABY.Aid WHERE (ATT.toId = '$CustomerId' OR  ATT.byId = '$CustomerId') AND ATT.hiddenStatus <> '1' AND ATT.voucherType IN ('PV','RV') AND ATT.voucherDate BETWEEN '$BeforeDate' AND '$Afterdate'");

                                $FindTransactions = mysqli_query($con, "SELECT ATT.voucherNo,ATT.toId AS ATOID,ATT.byId AS ABYID,ATO.firstName AS ATONAME,ABY.firstName AS ABYNAME,ATT.voucherDate,ATT.toAmount,ATT.byAmount,ATT.voucherType,ATT.remarks FROM account_transactions ATT INNER JOIN accounts ATO ON ATT.toId = ATO.Aid INNER JOIN accounts ABY ON ATT.byId = ABY.Aid WHERE (ATT.toId = '$CustomerId' OR  ATT.byId = '$CustomerId') AND ATT.hiddenStatus <> '1' AND ATT.voucherDate BETWEEN '$BeforeDate' AND '$Afterdate'");
                                $NEWSUMDR = 0;
                                $NEWSUMCR = 0;
                                foreach ($FindTransactions as $FindTransactionsResults) {

                                    if ($FindTransactionsResults['ATOID'] == $CustomerId) {
                                        //echo number_format($FindTransactionsResults['toAmount'],2,'.',','); //debit
                                        $SumDr += $FindTransactionsResults['toAmount'];
                                        $NEWSUMDR += $FindTransactionsResults['toAmount'];
                                    } else {
                                        //echo '';
                                    }

                                    if ($FindTransactionsResults['ABYID'] == $CustomerId) {
                                        //echo  number_format($FindTransactionsResults['byAmount'],2,'.',','); //credit
                                        $SumCr += $FindTransactionsResults['toAmount'];
                                        $NEWSUMCR += $FindTransactionsResults['toAmount'];
                                    } else {
                                        //echo '';
                                    }

                                    $OpeningBalance = abs($SumDr - $SumCr);
                                }

                                ?>

                                <td><?= number_format($NEWSUMDR, 2, '.', ',') ?></td>
                                <td><?= number_format($NEWSUMCR, 2, '.', ',') ?></td>

                                <td><?php echo number_format($OpeningBalance, 2, '.', ','); ?></td>
                                <td>
                                    <?php
                                    if ($SumDr > $SumCr) {
                                        echo 'DR';
                                    } elseif ($SumCr > $SumDr) {
                                        echo 'CR';
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </td>

                            </tr>

                            <?php

                            //$TotalReceivable  +=  $NEWSUMCR;

                            //$TotalPayabale  += $NEWSUMDR;

                            $TotalReceivable  += $NEWSUMCR;

                            $TotalPayabale  += $NEWSUMDR;
                        }

                        $TotalReceivable += $OpeningCR;
                        $TotalPayabale += $OpeningDR;

                        //echo $OpeningCR;
                        //echo $OpeningDR;

                        ?>

                    </tbody>

                </table>

                <?php

                // $findPortalBalance = mysqli_query($con, "SELECT totalRedeemable FROM ledgerextra WHERE partId = '1'");
                // foreach ($findPortalBalance as $findPortalBalanceResult) {
                //     $PortalBalance = $findPortalBalanceResult['totalRedeemable'];
                // }

                $ProfitLedgersSum = 0;
                $FindProfitLedgers = mysqli_query($con ,"SELECT Aid FROM accounts WHERE isProfitLedger = 1");
                foreach($FindProfitLedgers as $FindProfitLedgersResult){
                    $AccountId = $FindProfitLedgersResult['Aid'];

                    $GetProfitLegerClosing = json_decode(GetClosingBalance($con, $BeforeDateFrmPost, $AfterDateFrmPost, $AccountId));
                    //print_r($GetProfitLegerClosing);
                    $ProfitLegerClosing = $GetProfitLegerClosing->Closing;
                    $ProfitLedgersSum += $ProfitLegerClosing;
                }

                // echo $ProfitLedgersSum;

                //Get Portal Closing
                $GetPortalClosing = json_decode(GetClosingBalance($con, $BeforeDateFrmPost, $AfterDateFrmPost, '7'));
                $PortalBalance = $GetPortalClosing->Closing;

                //Get Bank Closing
                $GetClosing = json_decode(GetClosingBalance($con, $BeforeDateFrmPost, $AfterDateFrmPost, '10'));
                $BankBalance = $GetClosing->Closing;
                $BankBalance += $ProfitLedgersSum;

                //Get Cash Closing
                $GetCashClosing = json_decode(GetClosingBalance($con, $BeforeDateFrmPost, $AfterDateFrmPost, '2'));
                $CashInHand = $GetCashClosing->Closing;

                //Get Profit Adjusted Closing
                $GetProfitAdjustedClosing = json_decode(GetClosingBalance($con, $BeforeDateFrmPost, $AfterDateFrmPost, '12'));
                $ProfitAdjusted = $GetProfitAdjustedClosing->Closing;

                //Cash in hand
                $CashTotal = $PortalBalance + $BankBalance + $CashInHand;

                //Calculate Profit
                $Profit =  ($TotalReceivable + $CashTotal - $TotalPayabale - $StartUpCapital) - $ProfitAdjusted;

                //Total Ticket Booking
                $findTotalTicketBooking  = mysqli_query($con, "SELECT SUM(tAmount) FROM ticket_booking_table WHERE cancelStatus <> 1 AND DATE(createdDate) = '$GivenDate'");
                foreach ($findTotalTicketBooking as $findTotalTicketBookingResult) {
                    $TotalTicketBooking = $findTotalTicketBookingResult['SUM(tAmount)'];
                }

                //Total Visa Booking
                $findTotalVisaBooking  = mysqli_query($con, "SELECT SUM(ourRate) FROM visa_booking WHERE cancelStatus <> 1 AND DATE(createdDate) = '$GivenDate'");
                foreach ($findTotalVisaBooking as $findTotalVisaBookingResult) {
                    $TotalVisaBooking = $findTotalVisaBookingResult['SUM(ourRate)'];
                }



                //$TotalProfitCalculation = json_decode(FindTotalProfit($FirstDate, $GivenDate, $con));

                //print_r($TotalProfitCalculation);

                //$AddedProfit = $TotalProfitCalculation->TotalProfit;

                ?>
            </div>
        </div>

        <div class="col-lg-4">

            <div class="border border-1 mt-1 p-2">

                <div class="row">
                    <div class="col-6">
                        <h6 class="mt-2"> <strong>Startup Capital</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class="mt-2"> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-end">
                        <input type="number" id="startup_capital" min="0" name="StartupCapital" value="<?= $StartUpCapital ?>" class="form-control StartCapital">
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-6">
                        <h6 class=""> <strong>Cash in Hand</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class=""> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class=""> <strong> <?= $CashInHand ?> </strong> </h6>
                        <!-- <input type="number" id="cash_in_hand" name="CashInHand" value="<?= $CashInHand ?>" class="form-control CashHand"> -->
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-6">
                        <h6 class=""> <strong>Portal balance</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class=""> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class=""> <strong> <?= $PortalBalance ?> </strong> </h6>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-6">
                        <h6 class=""> <strong>Bank balance</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class=""> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class=""> <strong><?= $BankBalance ?></strong> </h6>
                    </div>
                </div>

            </div>

            <div class="border border-1 mt-1 p-2">

                <div class="row mt-1">
                    <div class="col-6">
                        <h6 class=""> <strong>Total Receivable</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class=""> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class=""> <strong><?= $TotalReceivable; ?></strong> </h6>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-6">
                        <h6 class=""> <strong>Total Payable</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class=""> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class=""> <strong> <?= $TotalPayabale ?></strong> </h6>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-6">
                        <h6 class=""> <strong>Profit</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class=""> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class=""> <strong> <?= $Profit ?> </strong> </h6>
                    </div>
                </div>

                <!-- <div class="row mt-1">
                    <div class="col-6">
                        <h6 class=""> <strong>Added Profit</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class=""> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class=""> <strong> <?= $AddedProfit; ?> </strong> </h6>
                    </div>
                </div> -->

            </div>

            <div class="border border-1 mt-1 p-2">

                <div class="row mt-1">
                    <div class="col-6">
                        <h6 class=""> <strong>Total Visa booking</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class=""> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class=""> <strong><?php echo ($TotalVisaBooking > 0) ? $TotalVisaBooking : '0'; ?></strong> </h6>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-6">
                        <h6 class=""> <strong>Total Ticket Booking</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class=""> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class=""> <strong><?php echo ($TotalTicketBooking > 0) ? $TotalTicketBooking : '0'; ?></strong> </h6>
                    </div>
                </div>

            </div>

            <div class="border border-1 mt-1 p-2">

                <div class="row">
                    <div class="col-6">
                        <h6 class="mt-2"> <strong>Adjusted Profit</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class="mt-2"> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-end">
                        <input type="number" id="adjusted_profit" min="0" name="AdjustedProfit" value="0" class="form-control AdjustedProfit">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <h6 class="mt-2"> <strong>To Ledger</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class="mt-2"> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-end">
                        <select class="form-select ProfitAdjustmentLedger" name="ProfitAdjustmentLedger" id="profit_adjustment_ledger">
                            <option value="">Profit Ledger</option>
                            <?php
                            $ShowProfitLedgers = mysqli_query($con, "SELECT Aid,firstName FROM accounts WHERE isProfitLedger = 1");
                            foreach ($ShowProfitLedgers as $ShowProfitLedgersResults) {
                                echo '<option value="' . $ShowProfitLedgersResults["Aid"] . '">' . $ShowProfitLedgersResults["firstName"] . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>

            </div>



            <div class="d-flex justify-content-between mb-3 mt-2 px-3">
                <button class="btn SaveBtn AddBtn px-5">SAVE</button>
                <button class="btn UpdateBtn AddBtn px-4">UPDATE</button>
            </div>

        </div>

        <?php

    } else {


        ?>

        <div class="col-lg-8">
            <div class="table-responsive mt-2" style="max-height: 600px;">
                <table class="table table-bordered table-hover  text-nowrap" style="width: 100%;">
                    <thead class="table-light">
                        <tr>
                            <th class="">No</th>
                            <th class="">Particular</th>
                            <th class="">Opening</th>
                            <th class="">Cr/Dr</th>
                            <th class="">Outward</th>
                            <th class="">Inward</th>
                            <th class="">Closing</th>
                            <th class="">Cr/Dr</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php

                        $BeforeDateFrmPost = $_POST['FromDate'] . ' 00:00:00';
                        $AfterDateFrmPost = $_POST['FromDate'] . ' 23:59:59';


                        $TotalReceivable  = 0;
                        $TotalPayabale  = 0;

                        $RowNumber = 0;

                        $findCustomers = mysqli_query($con, "SELECT * FROM accounts WHERE accountType IN ('CUSTOMER','SUPPLIER')");
                        foreach ($findCustomers as $findCustomerResults) {
                            $RowNumber++;

                            $CustomerId = $findCustomerResults['Aid'];
                            //$BeforeDateFrmPost = '202-12-31 00:00:00';
                            //$AfterDateFrmPost = '2022-12-31 23:59:59';
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
                            //echo $DayBeforeDate;


                            $findCustomerOpening = mysqli_query($con, "SELECT openingType,opening FROM accounts WHERE Aid = '$CustomerId'");
                            foreach ($findCustomerOpening as $findCustomerOpeningResults) {
                                if ($findCustomerOpeningResults['openingType'] == 'Cr') {
                                    $SumCr += $findCustomerOpeningResults['opening'];
                                    $SumCrOpening += $findCustomerOpeningResults['opening'];
                                } else {
                                    $SumDr += $findCustomerOpeningResults['opening'];
                                    $SumDrOpening += $findCustomerOpeningResults['opening'];
                                }
                            }


                            $FindSumofToAmount = mysqli_query($con, "SELECT SUM(toAmount) FROM account_transactions WHERE toId = '$CustomerId' AND hiddenStatus <> '1' AND voucherType IN ('PV','RV') AND voucherDate < '$DayBeforeDate'"); //Sum of debitAmount
                            foreach ($FindSumofToAmount as $FindSumofToAmountResults) {
                                $SumDr += $FindSumofToAmountResults['SUM(toAmount)'];
                            }

                            $FindSumofByAmount = mysqli_query($con, "SELECT SUM(byAmount) FROM account_transactions WHERE byId = '$CustomerId' AND hiddenStatus <> '1' AND voucherType IN ('PV','RV') AND voucherDate < '$DayBeforeDate'"); //Sum of creditAmount
                            foreach ($FindSumofByAmount as $FindSumofByAmountResults) {
                                $SumCr += $FindSumofByAmountResults['SUM(byAmount)'];
                            }


                            if ($SumDr > $SumCr) {
                                $OpeningBalance = $SumDr - $SumCr;
                                $CRDR = 'DR';
                                // echo "Opening = " . $OpeningBalance . " - DR";
                            } else {
                                $OpeningBalance = $SumCr - $SumDr;
                                $CRDR = 'CR';
                                // echo "Opening = " . $OpeningBalance . " - CR";
                            }


                        ?>
                            <tr>
                                <td> <?= $RowNumber; ?> </td>
                                <td> <?php echo $findCustomerResults['firstName'] ?> </td>
                                <td> <?php echo number_format($OpeningBalance, 2, '.', ','); ?> </td>
                                <td> <?php echo ($OpeningBalance > 0) ? $CRDR : ""; ?> </td>
                                <?php

                                $FindTransactions = mysqli_query($con, "SELECT ATT.voucherNo,ATT.toId AS ATOID,ATT.byId AS ABYID,ATO.firstName AS ATONAME,ABY.firstName AS ABYNAME,ATT.voucherDate,ATT.toAmount,ATT.byAmount,ATT.voucherType,ATT.remarks FROM account_transactions ATT INNER JOIN accounts ATO ON ATT.toId = ATO.Aid INNER JOIN accounts ABY ON ATT.byId = ABY.Aid WHERE (ATT.toId = '$CustomerId' OR  ATT.byId = '$CustomerId') AND ATT.hiddenStatus <> '1' AND ATT.voucherType IN ('PV','RV') AND ATT.voucherDate BETWEEN '$BeforeDate' AND '$Afterdate'");
                                $NEWSUMDR = 0;
                                $NEWSUMCR = 0;
                                foreach ($FindTransactions as $FindTransactionsResults) {

                                    if ($FindTransactionsResults['ATOID'] == $CustomerId) {
                                        //echo number_format($FindTransactionsResults['toAmount'],2,'.',','); //debit
                                        $SumDr += $FindTransactionsResults['toAmount'];
                                        $NEWSUMDR += $FindTransactionsResults['toAmount'];
                                    } else {
                                        //echo '';
                                    }
                                ?>


                                <?php
                                    if ($FindTransactionsResults['ABYID'] == $CustomerId) {
                                        //echo  number_format($FindTransactionsResults['byAmount'],2,'.',','); //credit
                                        $SumCr += $FindTransactionsResults['toAmount'];
                                        $NEWSUMCR += $FindTransactionsResults['toAmount'];
                                    } else {
                                        //echo '';
                                    }

                                    $OpeningBalance = abs($SumDr - $SumCr);
                                }

                                ?>

                                <td><?= number_format($NEWSUMDR, 2, '.', ',') ?></td>
                                <td><?= number_format($NEWSUMCR, 2, '.', ',') ?></td>

                                <td><?php echo number_format($OpeningBalance, 2, '.', ','); ?></td>
                                <td>
                                    <?php
                                    if ($SumDr > $SumCr) {
                                        echo 'DR';
                                    } elseif ($SumCr > $SumDr) {
                                        echo 'CR';
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </td>

                            </tr>

                        <?php

                            $TotalReceivable  +=  $NEWSUMCR;

                            $TotalPayabale  += $NEWSUMDR;
                        }

                        ?>

                    </tbody>
                </table>

                <?php

                $findPortalBalance = mysqli_query($con, "SELECT totalRedeemable FROM ledgerextra WHERE partId = '1'");
                foreach ($findPortalBalance as $findPortalBalanceResult) {
                    $PortalBalance = $findPortalBalanceResult['totalRedeemable'];
                }

                $GetClosing = json_decode(GetClosingBalance($con, $BeforeDateFrmPost, $AfterDateFrmPost, '10'));

                $BankBalance = $GetClosing->Closing;

                //$CashTotal = $PortalBalance + $BankBalance + $CashInHand;

                //$Profit =  $TotalReceivable + $CashTotal - $TotalPayabale - $StartUpCapital;

                $findTotalTicketBooking  = mysqli_query($con, "SELECT SUM(tAmount) FROM ticket_booking_table WHERE cancelStatus <> 1 AND DATE(createdDate) = '$GivenDate'");
                foreach ($findTotalTicketBooking as $findTotalTicketBookingResult) {
                    $TotalTicketBooking = $findTotalTicketBookingResult['SUM(tAmount)'];
                }

                $findTotalVisaBooking  = mysqli_query($con, "SELECT SUM(ourRate) FROM visa_booking WHERE cancelStatus <> 1 AND DATE(createdDate) = '$GivenDate'");
                foreach ($findTotalVisaBooking as $findTotalVisaBookingResult) {
                    $TotalVisaBooking = $findTotalVisaBookingResult['SUM(ourRate)'];
                }

                ?>

            </div>
        </div>

        <div class="col-lg-4">

            <div class="border border-1 mt-2 p-2">

                <div class="row">
                    <div class="col-6">
                        <h6 class="mt-2"> <strong>Startup Capital</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class="mt-2"> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-end">
                        <input type="number" id="startup_capital" name="StartupCapital" value="<?= $StartUpCapital ?>" class="form-control StartCapital">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <h6 class="mt-2"> <strong>Cash in Hand</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class="mt-2"> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-end">
                        <input type="number" id="cash_in_hand" name="CashInHand" value="<?= $CashInHand ?>" class="form-control CashHand">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <h6 class="mt-2"> <strong>Portal balance</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class="mt-2"> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class="mt-2"> <strong> <?= $PortalBalance ?> </strong> </h6>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <h6 class="mt-2"> <strong>Bank balance</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class="mt-2"> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class="mt-2"> <strong><?= $BankBalance ?></strong> </h6>
                    </div>
                </div>

            </div>

            <div class="border border-1 mt-2 p-2">

                <div class="row mt-2">
                    <div class="col-6">
                        <h6 class="mt-2"> <strong>Total Receivable</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class="mt-2"> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class="mt-2"> <strong><?= $TotalReceivable; ?></strong> </h6>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <h6 class="mt-2"> <strong>Total Payable</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class="mt-2"> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class="mt-2"> <strong> <?= $TotalPayabale ?></strong> </h6>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <h6 class="mt-2"> <strong>Profit</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class="mt-2"> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class="mt-2"> <strong> 0 </strong> </h6>
                    </div>
                </div>

            </div>

            <div class="border border-1 mt-2 p-2">

                <div class="row mt-2">
                    <div class="col-6">
                        <h6 class="mt-2"> <strong>Total Visa booking</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class="mt-2"> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class="mt-2"> <strong><?php echo ($TotalVisaBooking > 0) ? $TotalVisaBooking : '0'; ?></strong> </h6>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <h6 class="mt-2"> <strong>Total Ticket Booking</strong> </h6>
                    </div>
                    <div class="col-1 text-center">
                        <h6 class="mt-2"> <strong>:</strong> </h6>
                    </div>
                    <div class="col-5 text-start">
                        <h6 class="mt-2"> <strong><?php echo ($TotalTicketBooking > 0) ? $TotalTicketBooking : '0'; ?></strong> </h6>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between mb-3 mt-2 px-3">
                <button class="btn SaveBtn AddBtn px-5">SAVE</button>
                <button class="btn UpdateBtn AddBtn px-4">UPDATE</button>
            </div>

        </div>

        <?php


    }
}

?>




<script>
    $('.StartCapital').keyup(function() {
        var Startup = $(this).val();
        console.log(Startup);
        $('.StartupCapital').val(Startup);
    });

    $('.CashHand').keyup(function() {
        var CashInHand = $(this).val();
        console.log(CashInHand);
        $('.CashInHand').val(CashInHand);
    });
</script>