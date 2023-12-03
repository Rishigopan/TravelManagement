<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'ReceiptVoucher';


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



</head>

<body>

    <?php


    $findMaxVoucherNo = mysqli_query($con, "SELECT MAX(voucherNo) FROM account_transactions WHERE voucherType = 'RV'");
    foreach ($findMaxVoucherNo as $findMaxVoucherNoResult) {
        $MaxVoucherNo = $findMaxVoucherNoResult['MAX(voucherNo)'] + 1;
    }

    ?>


    <?php include('../MAIN/Modals.php'); ?>
    <?php include('../MAIN/Sidebar.php'); ?>



    <div class="wrapper">

        <!--NAVBAR-->
        <?php include '../MAIN/Navbar.php'; ?>






        <!--CONTENTS-->
        <div class="container mainContents">
            <div class="card card-body main_card mt-5 shadow-lg p-3 mb-5">


                <div class="main_heading d-flex justify-content-between mb-2 shadow p-2">
                    <div>
                        <h3 class="pt-3"> RECEIPT VOUCHER </h3>
                    </div>
                </div>

                <?php

                if (isset($_GET['RVID'])) {
                    $RVID = $_GET['RVID'];
                    $getPaymentVoucherDetails = mysqli_query($con, "SELECT ATT.acctId,ATT.voucherNo,ATT.voucherDate,ATT.toAmount,ATT.receivedBy,ATT.remarks,ATT.voucherType,ATO.Aid AS TOID,ATO.firstName AS ToFirst,ATO.lastName AS ToLast,ABY.firstName AS ByFirst,ABY.lastName AS ByLast,ABY.Aid AS BYID FROM `account_transactions` ATT INNER JOIN accounts ATO ON ATT.toId = ATO.Aid INNER JOIN accounts ABY ON ATT.byId = ABY.Aid  WHERE ATT.acctid = '$RVID'");
                    foreach ($getPaymentVoucherDetails as $getPaymentVoucherDetailResults) {
                    }
                ?>

                    <form id="UpdateReceiptVoucherForm" class="UpdateForm px-5" novalidate>
                        <div class="row">
                            <div class="col-12 text-center">
                                <h5>VOUCHER NO - <?= $getPaymentVoucherDetailResults['voucherNo'] ?></h5>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <input name="UpdateRVId" id="" value="<?= $RVID ?>" hidden></input>
                                <input name="UpdateRVNo" id="" value="<?= $getPaymentVoucherDetailResults['voucherNo'] ?>" hidden></input>
                                <label for="update_re_to" class="TktcommonFont">To</label>
                                <select class="form-select" name="UpdateReTo" id="update_re_to" required>
                                <option hidden value="<?= $getPaymentVoucherDetailResults['TOID']; ?>"> <?= $getPaymentVoucherDetailResults['ToFirst'] . ' ' . $getPaymentVoucherDetailResults['ToLast']; ?> </option>
                                    
                                    <?php
                                    $ReceiptTo = mysqli_query($con, "SELECT * FROM accounts WHERE accntGroupId IN(17,19)");
                                    foreach ($ReceiptTo as $ReceiptToResult) {
                                        echo '
                                        <option value="' . $ReceiptToResult["Aid"] . '">' . $ReceiptToResult["firstName"] . ' ' . $ReceiptToResult["lastName"] .'</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="update_re_by" class="TktcommonFont">By</label>
                                <select class="form-select SelectLedger" name="UpdateReBy" id="update_re_by" required>
                                    <option hidden value="<?= $getPaymentVoucherDetailResults['BYID']; ?>"> <?= $getPaymentVoucherDetailResults['ByFirst'] . ' ' . $getPaymentVoucherDetailResults['ByLast']; ?> </option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="update_re_amount" class="TktcommonFont">Amount</label>
                                <input type="number" class="form-control" value="<?= $getPaymentVoucherDetailResults['toAmount']; ?>" name="UpdateReAmount" id="update_re_amount" required>
                            </div>
                            <div class="col-6">
                                <label for="update_re_date" class="TktcommonFont">Date</label>
                                <input type="date" value="<?= date('Y-m-d', strtotime($getPaymentVoucherDetailResults['voucherDate'])); ?>" class="form-control" name="UpdateReDate" id="update_re_date" required>
                            </div>

                            <!-- <div class="col-6">
                            <label for="re_receivedby" class="TktcommonFont">Recieved By</label>
                            <input type="text" name="ReReceivedby" id="re_receivedby" class="form-control" placeholder="Receiving person">
                        </div> -->
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="update_re_remarks" class="TktcommonFont">Remarks</label>
                                <textarea class="form-control" rows="5" name="UpdateReRemarks" id="update_re_remarks"><?= $getPaymentVoucherDetailResults['remarks']; ?></textarea>
                            </div>
                        </div>


                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">UPDATE</button>
                        </div>
                    </form>

                <?php

                } else {
                ?>

                    <form id="ReceiptVoucherForm" class="AddForm px-5" novalidate>
                        <div class="row">
                            <div class="col-12 text-center">
                                <h5>VOUCHER NO - <?= $MaxVoucherNo ?></h5>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="re_to" class="TktcommonFont">To</label>
                                <select class="form-select" name="ReTo" id="re_to" required readonly>
                                    <!-- <option hidden value="">Ledger</option> -->
                                    <?php
                                    $ReceiptTo = mysqli_query($con, "SELECT * FROM accounts WHERE accntGroupId IN(17,19)");
                                    foreach ($ReceiptTo as $ReceiptToResult) {
                                        echo '
                                        <option value="' . $ReceiptToResult["Aid"] . '">' . $ReceiptToResult["firstName"] . ' ' . $ReceiptToResult["lastName"] .'</option>
                                        ';
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="col-6">
                                <label for="re_by" class="TktcommonFont">By</label>
                                <select class="form-select SelectLedger" name="ReBy" id="re_by" required>
                                    <option hidden value="">Ledger</option>

                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="re_amount" class="TktcommonFont">Amount</label>
                                <input type="number" class="form-control" name="ReAmount" id="re_amount" required>
                            </div>
                            <div class="col-6">
                                <label for="re_date" class="TktcommonFont">Date</label>
                                <input type="date" value="<?= date('Y-m-d'); ?>" class="form-control" name="ReDate" id="re_date" required>
                            </div>

                            <!-- <div class="col-6">
                            <label for="re_receivedby" class="TktcommonFont">Recieved By</label>
                            <input type="text" name="ReReceivedby" id="re_receivedby" class="form-control" placeholder="Receiving person">
                        </div> -->
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="re_remarks" class="TktcommonFont">Remarks</label>
                                <textarea class="form-control" rows="5" name="ReRemarks" id="re_remarks"></textarea>
                            </div>
                        </div>


                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">SUBMIT</button>
                        </div>
                    </form>

                <?php
                }

                ?>


                <form action="" class="UpdateForm" hidden>

                </form>


            </div>
        </div>


        <?php include('../MAIN/FloatingDock.php'); ?>


    </div>



    <main id="loading">
        <div id="loadingDiv">
            <img class="img-fluid loaderGif" src="./loader.svg" alt="">
        </div>
    </main>

    <?php include('../MAIN/Footer.php'); ?>


    <script>
        $('#re_by').focus();

        $('#btnConfirm').click(function() {
            location.replace('ReceiptVoucher.php');
        });



        /* Add master Start */
        $(function() {

            let validator = $('#ReceiptVoucherForm').jbvalidator({
                //language: 'dist/lang/en.json',
                successClass: false,
                html5BrowserDefault: true
            });

            validator.validator.custom = function(el, event) {
                /* if ($(el).is('#country_name') && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]+/)) {
                    return 'Only allowed alphabets';
                } else if ($(el).is('#country_name') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                } */
                if ($(el).is('') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#ReceiptVoucherForm', (function(e) {
                e.preventDefault();
                var RVData = new FormData(this);
                console.log(RVData);
                $.ajax({
                    type: "POST",
                    url: "VoucherOperations.php",
                    data: RVData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#ReceiptVoucherForm').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                        $('#btnConfirm').hide();
                        $('#btnClose').show();
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#ReceiptVoucherForm').removeClass("disable");
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.addReceiptVoucher == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Checklist is Already Present");
                                $('#confirmModal').modal('show');
                            } else if (response.addReceiptVoucher == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Added ReceiptVoucher ");
                                $('#confirmModal').modal('show');
                                $('#btnConfirm').show();
                                $('#btnClose').hide();
                                ResetForms();
                            } else if (response.addReceiptVoucher == "2") {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Adding ReceiptVoucher ");
                                $('#confirmModal').modal('show');
                            }
                        } else {
                            $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Some Error Occured, Please refresh the page (ERROR : 12ENJ)");
                            $('#confirmModal').modal('show');
                        }
                    },
                    error: function() {
                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                        $('#ResponseText').text("Please refresh the page to continue (ERROR : 12EFF)");
                        $('#confirmModal').modal('show');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }));

        });
        /* Add master  End */



        /* Update master Start */
        $(function() {

            let validator = $('#UpdateReceiptVoucherForm').jbvalidator({
                //language: 'dist/lang/en.json',
                successClass: false,
                html5BrowserDefault: true
            });

            validator.validator.custom = function(el, event) {
                /* if ($(el).is('#country_name') && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]+/)) {
                    return 'Only allowed alphabets';
                } else if ($(el).is('#country_name') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                } */
                if ($(el).is('') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#UpdateReceiptVoucherForm', (function(e) {
                e.preventDefault();
                var RVData = new FormData(this);
                console.log(RVData);
                $.ajax({
                    type: "POST",
                    url: "VoucherOperations.php",
                    data: RVData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#UpdateReceiptVoucherForm').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                        $('#btnConfirm').hide();
                        $('#btnClose').show();
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#UpdateReceiptVoucherForm').removeClass("disable");
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.UpdateReceiptVoucher == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Checklist is Already Present");
                                $('#confirmModal').modal('show');
                            } else if (response.UpdateReceiptVoucher == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Updated ReceiptVoucher ");
                                $('#confirmModal').modal('show');
                                $('#btnConfirm').show();
                                $('#btnClose').hide();
                                ResetForms();
                            } else if (response.UpdateReceiptVoucher == "2") {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Updating ReceiptVoucher ");
                                $('#confirmModal').modal('show');
                            }
                        } else {
                            $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Some Error Occured, Please refresh the page (ERROR : 12ENJ)");
                            $('#confirmModal').modal('show');
                        }
                    },
                    error: function() {
                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                        $('#ResponseText').text("Please refresh the page to continue (ERROR : 12EFF)");
                        $('#confirmModal').modal('show');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }));

        });
        /* Update master  End */
    </script>


</body>

</html>