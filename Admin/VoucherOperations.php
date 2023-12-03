<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';
include './CommonFunctions.php';


// $user_id = $_SESSION['custid'];
$user_id = '1';
$dateToday = date('Y-m-d h:i:s');
$dayToday = date('Ymd');




///////////////////////////////////////////////////////Receipt Voucher//////////////////////////////////////////////////////////


    //Add Receipt Voucher
    if (isset($_POST['ReTo'])) {

        mysqli_autocommit($con, FALSE);
        $FetchRVvoucherNo = mysqli_query($con, "SELECT MAX(voucherNo) FROM account_transactions WHERE voucherType = 'RV'");
        foreach ($FetchRVvoucherNo as $FetchRVvoucherNoResult) {
            $RVvoucherNo = $FetchRVvoucherNoResult['MAX(voucherNo)'] + 1;
        }


        $connString = $con;
        $RVvType = 'RV';
        //$RVtoId = '2'; //cash id
        $RVtoId =  SanitizeInt($_POST['ReTo']);//cash or ledger
        $RVbyId =  SanitizeInt($_POST['ReBy']);
        $RVaction = 'ADD';
        $RVamount = SanitizeDecimal($_POST['ReAmount']);
        $RVremarks = SanitizeInput($_POST['ReRemarks']);
        $RVDate = SanitizeInput($_POST['ReDate']);
        $RVReceivedBy = '';
        $RVBookingId = 0;



        $RVResult = ledgerTransactions($RVvType, $RVtoId, $RVbyId, $RVamount, $user_id, $RVaction, $RVremarks, $RVvoucherNo, $RVDate, $RVReceivedBy,$RVBookingId,$connString);

        if ($RVResult == 'Success') {
            mysqli_commit($con);
            echo json_encode(array('addReceiptVoucher' => '1'));
        } else {
            mysqli_rollback($con);
            echo json_encode(array('addReceiptVoucher' => '2'));
        }
    }


    //Update Receipt Voucher
    if (isset($_POST['UpdateRVId'])) {

        mysqli_autocommit($con, FALSE);

        $connString = $con;
        $UpdateRVType = 'RV';
        //$UpdateRVtoId = '2'; //cash id
        $UpdateRVtoId = SanitizeInt($_POST['UpdateReTo']); //cash or ledger
        $UpdateRVbyId = SanitizeInt($_POST['UpdateReBy']);
        $UpdateRVaction = 'EDITBOOKING';
        $UpdateRVamount = SanitizeDecimal($_POST['UpdateReAmount']);
        $UpdateRVremarks = SanitizeInput($_POST['UpdateReRemarks']);
        $UpdateRVDate = SanitizeInput($_POST['UpdateReDate']);
        $UpdateRVvoucherNo = SanitizeInt($_POST['UpdateRVNo']);
        $UpdateRVReceivedBy = '';
        $UpdateRVBookingId = 0;


        $UpdateRVResult = ledgerTransactions($UpdateRVType, $UpdateRVtoId, $UpdateRVbyId, $UpdateRVamount, $user_id, $UpdateRVaction, $UpdateRVremarks, $UpdateRVvoucherNo, $UpdateRVDate, $UpdateRVReceivedBy, $UpdateRVBookingId,$connString);

        if ($UpdateRVResult == 'Success') {
            mysqli_commit($con);
            echo json_encode(array('UpdateReceiptVoucher' => '1'));
        } else {
            mysqli_rollback($con);
            echo json_encode(array('UpdateReceiptVoucher' => '2'));
        }
    }



///////////////////////////////Receipt Voucher//////////////////////////////////////////////////////////



////////////////////////////Payment Voucher//////////////////////////////////////////////////////////



    //Add Payment Voucher
    if (isset($_POST['PaTo'])) {

        mysqli_autocommit($con, FALSE);

        $FetchPVvoucherNo = mysqli_query($con, "SELECT MAX(voucherNo) FROM account_transactions WHERE voucherType = 'PV'");
        foreach ($FetchPVvoucherNo as $FetchPVvoucherNoResult) {
            $PVvoucherNo = $FetchPVvoucherNoResult['MAX(voucherNo)'] + 1;
        }


        $connString = $con;
        $PVvType = 'PV';
        $PVtoId = SanitizeInt($_POST['PaTo']);
        //$PVbyId = '2'; //cash id
        $PVbyId = SanitizeInt($_POST['PaBy']); //cash or bank
        $PVaction = 'ADD';
        $PVamount = SanitizeDecimal($_POST['PaAmount']);
        $PVremarks = SanitizeInput($_POST['PaRemarks']);
        $PVDate = SanitizeInput($_POST['PaDate']);
        $PVReceivedBy = '';
        $PVBookingId = 0;


        $PVResult = ledgerTransactions($PVvType, $PVtoId, $PVbyId, $PVamount, $user_id, $PVaction, $PVremarks, $PVvoucherNo, $PVDate, $PVReceivedBy,$PVBookingId,$connString);

        if ($PVResult == 'Success') {
            mysqli_commit($con);
            echo json_encode(array('addPaymentVoucher' => '1'));
        } else {
            mysqli_rollback($con);
            echo json_encode(array('addPaymentVoucher' => '2'));
        }
    }




    //Update Payment Voucher
    if (isset($_POST['UpdatePVId'])) {

        mysqli_autocommit($con, FALSE);

        $connString = $con;
        $UpdatePVvType = 'PV';
        $UpdatePVtoId = SanitizeInt($_POST['UpdatePaTo']);
        //$UpdatePVbyId = '2'; //cash id
        $UpdatePVbyId = SanitizeInt($_POST['UpdatePaBy']);; //cash or bank
        $UpdatePVaction = 'EDITBOOKING';
        $UpdatePVamount = SanitizeDecimal($_POST['UpdatePaAmount']);
        $UpdatePVremarks = SanitizeInput($_POST['UpdatePaRemarks']);
        $UpdatePVDate = SanitizeInput($_POST['UpdatePaDate']);
        $UpdatePVvoucherNo = SanitizeInt($_POST['UpdatePVNo']);
        $UpdatePVReceivedBy = '';
        $UpdatePVBookingId = 0;


        $UpdatePVResult = ledgerTransactions($UpdatePVvType, $UpdatePVtoId, $UpdatePVbyId, $UpdatePVamount, $user_id, $UpdatePVaction, $UpdatePVremarks, $UpdatePVvoucherNo, $UpdatePVDate, $UpdatePVReceivedBy,$UpdatePVBookingId,$connString);

        if ($UpdatePVResult == 'Success') {
            mysqli_commit($con);
            echo json_encode(array('UpdatePaymentVoucher' => '1'));
        } else {
            mysqli_rollback($con);
            echo json_encode(array('UpdatePaymentVoucher' => '2'));
        }
    }



//////////////////////////////Payment Voucher//////////////////////////////////////////////////////////




//////////////////////////////Delete Voucher///////////////////////////////////////////////////////////


    if(isset($_POST['VoucherDelete'])){
        
        mysqli_autocommit($con, FALSE);

        $connString = $con;
        $DvoucherNo = SanitizeInt($_POST['VoucherDelete']);
        $DType = '';
        $DtoId = '';
        $DbyId = '';
        $Damount = '';
        $Duserid = '';
        $Daction = 'REMOVE';
        $Dremarks = '';
        $DvoucherDate = '';
        $Dreceivedby = '';
        $DBookingId = 0;

        $DeleteVoucherResult = ledgerTransactions($DType, $DtoId, $DbyId, $Damount, $Duserid, $Daction, $Dremarks, $DvoucherNo, $DvoucherDate, $Dreceivedby,$DBookingId,$connString);
        if ($DeleteVoucherResult == 'Success') {
            mysqli_commit($con);
            echo json_encode(array('DeletePaymentVoucher' => '1'));
        } else {
            mysqli_rollback($con);
            echo json_encode(array('DeletePaymentVoucher' => '2'));
        }

    }

//////////////////////////////Delete Voucher///////////////////////////////////////////////////////////



/////////////////////////////Portal Operations///////////////////////////////////////////////////////////

    if(isset($_POST['PortalTo'])){
            
        mysqli_autocommit($con, FALSE);

        $connString = $con;
        $action = 'RECHARGE';
        $amount = SanitizeDecimal($_POST['PoAmount']);
        $bonus = ($_POST['PoBonus'] == '') ? 0 : SanitizeDecimal($_POST['PoBonus']);
        $from = SanitizeInt($_POST['PortalBy']);
        $transactionDate = SanitizeInput($_POST['PoDate']);;
        $userid = $user_id; 
        $particularId = '1';
        $particularName = 'PORTAL BALANCE';

       

        $AddPortalRecharge =  PortalTransactions($connString,$action,$amount,$bonus,$from,$transactionDate,$userid,$particularId,$particularName);
        if ($AddPortalRecharge == 'Success') {

            $FetchPRvoucherNo = mysqli_query($con, "SELECT MAX(voucherNo) FROM account_transactions WHERE voucherType = 'PR'");
            foreach ($FetchPRvoucherNo as $FetchPRvoucherNoResult) {
                $PRvoucherNo = $FetchPRvoucherNoResult['MAX(voucherNo)'] + 1;
            }

            $PRvType = 'PR';
            $PRtoId = '7'; //PORTAL ID
            $PRbyId =  $from;
            $PRaction = 'ADD';
            $PRamount = $amount;
            $PRremarks = 'portal recharge transaction';
            $PRDate = $transactionDate;
            $PRReceivedBy = '';
            $PRBookingId = 0;
    
    
    
            $PRResult = ledgerTransactions($PRvType, $PRtoId, $PRbyId, $PRamount, $user_id, $PRaction, $PRremarks, $PRvoucherNo, $PRDate, $PRReceivedBy,$PRBookingId,$connString);
    
            if ($PRResult == 'Success') {

                $BOvType = 'BO';
                $BOtoId = '7'; //PORTAL ID
                $BObyId =  '8'; // BONUS ID
                $BOaction = 'ADD';
                $BOamount = $bonus;
                $BOremarks = 'portal recharge bonus';
                $BODate = $transactionDate;
                $BOReceivedBy = '';
                $BOvoucherNo = $PRvoucherNo;
                $BOBookingId = 0;

                $BOResult = ledgerTransactions($BOvType, $BOtoId, $BObyId, $BOamount, $user_id, $BOaction, $BOremarks, $BOvoucherNo, $BODate, $BOReceivedBy,$BOBookingId,$connString);

                if ($BOResult == 'Success') {
                    mysqli_commit($con);
                    echo json_encode(array('addPortalRecharge' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('addPortalRecharge' => '2'));
                }

            } else {
                mysqli_rollback($con);
                echo json_encode(array('addPortalRecharge' => '2'));
            }

        } else {
            mysqli_rollback($con);
            echo json_encode(array('addPortalRecharge' => '2'));
        }

    }


/////////////////////////////Portal Operations///////////////////////////////////////////////////////////


?>