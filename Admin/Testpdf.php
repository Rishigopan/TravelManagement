<?php

require_once '../vendor/autoload.php';

include '../MAIN/Dbconfig.php';
include './CommonFunctions.php';

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

    <div class="container">


        <table class="table table-hover table-bordered">

            <thead>
                <tr>
                    <th class="">Sl No</th>
                    <th class="">Type</th>
                    <th class="">Date</th>
                    <th class="">Voucher No</th>
                    <th class="">Particular</th>
                    <th class="">Debit</th>
                    <th class="">Credit</th>
                    <th class="">Balance</th>
                    <th class="">Dr/Cr</th>
                </tr>
            </thead>


            <tbody>
            
           
            <?php






            $CustomerId = '17';

            $BeforeDateFrmPost = '2023-01-10 00:00:00';
            $AfterDateFrmPost = '2023-01-10 23:59:59';
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
            } else {
                $OpeningBalance = $SumCr - $SumDr;
                $CRDR = 'CR';
            }

            




?>


<tr>
    <td> </td>
    <td> </td>
    <td> </td>
    <td>  </td>
    <td> To Opening Balance </td>
    <td> </td>
    <td> </td>
    <td> </td>
    <td> </td>
</tr>



</tbody>


</table>

</div>













<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>




