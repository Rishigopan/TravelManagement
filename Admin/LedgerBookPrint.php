<?php session_start(); ?>
<?php

//$LogoBranch = 'Cochin';
$LogoBranch = 'Tezza';

include '../MAIN/Dbconfig.php';
include './CommonFunctions.php';


if (isset($_SESSION['custname']) && isset($_SESSION['custtype'])) {

    if ($_SESSION['custtype'] == 'SuperAdmin' || $_SESSION['custtype'] == 'Admin') {
    } else {
        header("location:../login.php");
    }
} else {

    header("location:../login.php");
}
?>

<!doctype html>
<html lang="en">

<head>




    <?php


    include '../MAIN/Header.php';

    ?>

    <style>
        body {
            background: none !important;
        }
    </style>

    <?php

    if (isset($_POST['LedgerId'])) {
        $LegderId = $_POST['LedgerId'];
        $FindLedger = mysqli_query($con, "SELECT firstName,lastName FROM accounts WHERE Aid = '$LegderId'");
        foreach ($FindLedger as $FindLedgerResult) {
            $LedgerName = $FindLedgerResult['firstName'] . ' ' . $FindLedgerResult['lastName'];
        }
    } else {
        $LedgerName = '';
    }



    ?>


</head>

<body>

    <div class="">


        <!--CONTENTS-->
        <div class="container-fluid mainContents">


            <div class="text-center">
                <?php
                if ($LogoBranch == 'Cochin') {
                    echo '<img class="img-fuid" height="70px" src="../IMAGES/cochinLogo.png">';
                } else {
                    echo '<img class="img-fuid" height="70px" src="../IMAGES/tezzaLogo.jpg">';
                }
                ?>
                <h4>Ledger - <?= $LedgerName ?></h4>
            </div>


            <div class=" mt-3">
                <table class="table table-bordered table-hover  text-nowrap" id="LedgerTable2" style="width: 100%;">
                    <thead class="table-light">
                        <tr>
                            <th class="">Sl No</th>
                            <th class="">Type</th>
                            <th class="">Date</th>
                            <th class="">Voucher No</th>
                            <th class="">Particular</th>
                            <th class="">Narration</th>
                            <th class="">Debit</th>
                            <th class="">Credit</th>
                            <th class="">Balance</th>
                            <th class="">Dr/Cr</th>
                        </tr>
                    </thead>
                    <tbody id="">

                        <?php

                        if (isset($_POST['LedgerId'])) {

                            $CustomerId = SanitizeInt($_POST['LedgerId']);

                            $BeforeDateFrmPost = $_POST['LedgerStart'] . ' 00:00:00';
                            $AfterDateFrmPost = $_POST['LedgerEnd'] . ' 23:59:59';
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


                            //echo json_encode(array('LedgerName' => 'Ledger'));




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


                            $FindSumofToAmount = mysqli_query($con, "SELECT SUM(toAmount) FROM account_transactions WHERE toId = '$CustomerId' AND hiddenStatus <> '1' AND voucherDate < '$DayBeforeDate'"); //Sum of debitAmount
                            foreach ($FindSumofToAmount as $FindSumofToAmountResults) {
                                $SumDr += $FindSumofToAmountResults['SUM(toAmount)'];
                            }

                            $FindSumofByAmount = mysqli_query($con, "SELECT SUM(byAmount) FROM account_transactions WHERE byId = '$CustomerId' AND hiddenStatus <> '1' AND voucherDate < '$DayBeforeDate'"); //Sum of creditAmount
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
                                <td> </td>
                                <td> </td>
                                <td></td>
                                <td></td>
                                <td>To Opening Balance</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?php echo number_format($OpeningBalance, 2, '.', ','); ?></td>
                                <td><?php echo ($OpeningBalance > 0) ? $CRDR : ""; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <?php

                            $FindTransactions = mysqli_query($con, "SELECT ATT.voucherNo,ATT.toId AS ATOID,ATT.byId AS ABYID,ATO.firstName AS ATONAME,ABY.firstName AS ABYNAME,ATT.voucherDate,ATT.toAmount,ATT.byAmount,ATT.voucherType,ATT.remarks FROM account_transactions ATT INNER JOIN accounts ATO ON ATT.toId = ATO.Aid INNER JOIN accounts ABY ON ATT.byId = ABY.Aid WHERE (ATT.toId = '$CustomerId' OR  ATT.byId = '$CustomerId') AND ATT.hiddenStatus <> '1' AND ATT.voucherDate BETWEEN '$BeforeDate' AND '$Afterdate'");
                            $NEWSUMDR = 0;
                            $NEWSUMCR = 0;
                            $RowNumber = 0;
                            foreach ($FindTransactions as $FindTransactionsResults) {
                                $RowNumber++;
                            ?>
                                <tr>
                                    <td> <?= $RowNumber ?> </td>
                                    <td>
                                        <?php
                                        if ($FindTransactionsResults['voucherType'] == 'VB') {
                                            echo "VISA BOOKING";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'RV') {
                                            echo "RECEIPT";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'PV') {
                                            echo "PAYMENT";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'TB') {
                                            echo "TICKET BOOKING";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'VBA') {
                                            echo "VISA BOOKING AGENCY";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'TBA') {
                                            echo "TICKET BOOKING AGENCY";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'PR') {
                                            echo "PORTAL RECHARGE";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'PD') {
                                            echo "PORTAL DEDUCTION";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'BO') {
                                            echo "PORTAL BONUS";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'GRP') {
                                            echo "GROUP TICKET";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'TBE') {
                                            echo "TICKET EXTENDED";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'PDE') {
                                            echo "PORTAL DEDUCTION EXTENDED";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'TBR') {
                                            echo "TICKET BOOKING REFUND";
                                        } elseif ($FindTransactionsResults['voucherType'] == 'RF') {
                                            echo "CUSTOMER REFUND";
                                        }elseif($FindTransactionsResults['voucherType'] == 'DT'){
                                            echo "DUMMY TICKET";
                                        }  elseif($FindTransactionsResults['voucherType'] == 'PRAD'){
                                            echo "PROFIT ADJUSTMENT";
                                        }  

                                        ?>
                                    </td>
                                    <td><?= $FindTransactionsResults['voucherDate'] ?></td>
                                    <td><?= $FindTransactionsResults['voucherNo'] ?></td>
                                    <td>
                                        <?php
                                        if ($FindTransactionsResults['ATOID'] == $CustomerId) {
                                            echo $FindTransactionsResults['ABYNAME'];
                                        } else {
                                            echo $FindTransactionsResults['ATONAME'];
                                        }
                                        ?>
                                    </td>
                                    <td class="" style="font-size: 14px;">
                                        <?php
                                        $RemarkArray = explode(',', $FindTransactionsResults['remarks']);
                                        foreach ($RemarkArray as $RemarkArrayResult) {
                                            echo $RemarkArrayResult . '</br>';
                                        }
                                        ?>
                                    </td>
                                    <td>

                                        <?php
                                        if ($FindTransactionsResults['ATOID'] == $CustomerId) {
                                            echo number_format($FindTransactionsResults['toAmount'], 2, '.', ','); //debit
                                            $SumDr += $FindTransactionsResults['toAmount'];
                                            $NEWSUMDR += $FindTransactionsResults['toAmount'];
                                        } else {
                                            echo '';
                                        }
                                        ?>

                                    </td>
                                    <td>
                                        <?php
                                        if ($FindTransactionsResults['ABYID'] == $CustomerId) {
                                            echo  number_format($FindTransactionsResults['byAmount'], 2, '.', ','); //credit
                                            $SumCr += $FindTransactionsResults['toAmount'];
                                            $NEWSUMCR += $FindTransactionsResults['toAmount'];
                                        } else {
                                            echo '';
                                        }
                                        ?>

                                    </td>
                                    <td>
                                        <?php
                                        echo number_format(($OpeningBalance = abs($SumDr - $SumCr)), 2, '.', ',');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($SumDr > $SumCr) {

                                            echo 'DR';
                                        } else {

                                            echo 'CR';
                                        }

                                        ?>
                                    </td>
                                </tr>


                            <?php

                            }

                            ?>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>---------</td>
                                <td>---------</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><?= number_format($NEWSUMDR, 2, '.', ',') ?></td>
                                <td><?= number_format($NEWSUMCR, 2, '.', ',') ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>---------</td>
                                <td>---------</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>By Closing Balance</th>
                                <td></td>
                                <td></td>
                                <td></td>
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

                        }




                        ?>


                    </tbody>
                </table>
            </div>



        </div>





    </div>





    <script>
        $(document).ready(function() {
            window.print();
        });
    </script>




</body>

</html>