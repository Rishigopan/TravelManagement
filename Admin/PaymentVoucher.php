<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'PaymentVoucher';


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

    $findMaxVoucherNo = mysqli_query($con, "SELECT MAX(voucherNo) FROM account_transactions WHERE voucherType = 'PV'");
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
                        <h3 class="pt-3"> PAYMENT VOUCHER </h3>
                    </div>
                </div>


                <?php

                if (isset($_GET['PVID'])) {
                    $PVID = $_GET['PVID'];


                    $getPaymentVoucherDetails = mysqli_query($con, "SELECT ATT.acctId,ATT.voucherNo,ATT.voucherDate,ATT.toAmount,ATT.receivedBy,ATT.remarks,ATT.voucherType,ATO.Aid AS TOID,ATO.firstName AS ToFirst,ATO.lastName AS ToLast,ABY.firstName AS ByFirst,ABY.lastName AS ByLast,ABY.Aid AS BYID FROM `account_transactions` ATT INNER JOIN accounts ATO ON ATT.toId = ATO.Aid INNER JOIN accounts ABY ON ATT.byId = ABY.Aid  WHERE ATT.acctid = '$PVID'");
                    foreach ($getPaymentVoucherDetails as $getPaymentVoucherDetailResults) {
                    }


                ?>

                    <form id="UpdatePaymentVoucherForm" action="" class="UpdateForm px-5">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h5>VOUCHER NO - <?= $getPaymentVoucherDetailResults['voucherNo'] ?></h5>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <input name="UpdatePVId" id="" value="<?= $PVID ?>" hidden></input>
                                <input name="UpdatePVNo" id="" value="<?= $getPaymentVoucherDetailResults['voucherNo'] ?>" hidden></input>
                                <label for="update_pa_to" class="TktcommonFont">To</label>
                                <select class="form-select SelectLedger" name="UpdatePaTo" id="update_pa_to" required readonly>

                                    <option hidden value="<?= $getPaymentVoucherDetailResults['TOID']; ?>"> <?= $getPaymentVoucherDetailResults['ToFirst'] . ' ' . $getPaymentVoucherDetailResults['ToLast']; ?> </option>
                                    <!-- <?php
                                            foreach ($FindAccountBy as $FindAccountByResults) {
                                                echo '
                                        <option value="' . $FindAccountByResults["Aid"] . '">' . $FindAccountByResults["firstName"] . ' ' . $FindAccountByResults["lastName"] . ' - ' . $FindAccountByResults["accountType"] . '</option>
                                        ';
                                            }
                                            ?> -->
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="update_pa_by" class="TktcommonFont">By</label>
                                <select class="form-select" name="UpdatePaBy" id="update_pa_by" required>
                                    <option hidden value="<?= $getPaymentVoucherDetailResults['BYID']; ?>"> <?= $getPaymentVoucherDetailResults['ByFirst'] . ' ' . $getPaymentVoucherDetailResults['ByLast']; ?> </option>
                                    <?php
                                    $PaymentBy = mysqli_query($con, "SELECT * FROM accounts WHERE accntGroupId IN(17,19)");
                                    foreach ($PaymentBy as $PaymentByResult) {
                                        echo '
                                        <option value="' . $PaymentByResult["Aid"] . '">' . $PaymentByResult["firstName"] . ' ' . $PaymentByResult["lastName"] .'</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="update_pa_amount" class="TktcommonFont">Amount</label>
                                <input type="number" class="form-control" name="UpdatePaAmount" id="update_pa_amount" value="<?= $getPaymentVoucherDetailResults['toAmount']; ?>" required>
                            </div>
                            <div class="col-6">
                                <label for="update_pa_date" class="TktcommonFont">Date</label>
                                <input type="date" value="<?= date('Y-m-d', strtotime($getPaymentVoucherDetailResults['voucherDate'])); ?>" class="form-control" name="UpdatePaDate" id="update_pa_date" required>
                            </div>
                            <!-- <div class="col-6">
                            <label for="pa_receivedby" class="TktcommonFont">Recieved By</label>
                            <input type="text" name="PaReceivedby" id="pa_receivedby" class="form-control" placeholder="Receiving person">
                        </div> -->
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="update_pa_remarks" class="TktcommonFont">Remarks</label>
                                <textarea class="form-control" rows="5" name="UpdatePaRemarks" id="update_pa_remarks"><?= $getPaymentVoucherDetailResults['remarks']; ?></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">UPDATE</button>
                        </div>
                    </form>




                <?php
                } else {

                ?>

                    <form id="PaymentVoucherForm" class="AddForm px-5" novalidate>
                        <div class="row">
                            <div class="col-12 text-center">
                                <h5>VOUCHER NO - <?= $MaxVoucherNo ?></h5>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="pa_to" class="TktcommonFont">To</label>
                                <select class="form-select SelectLedger" name="PaTo" id="pa_to" required readonly>
                                    <option hidden value="">Ledger</option>
                                    
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="pa_by" class="TktcommonFont">By</label>
                                <select class="form-select" name="PaBy" id="pa_by" required>
                                    <!-- <option hidden value="">Ledger</option> -->
                                    <?php
                                    $PaymentBy = mysqli_query($con, "SELECT * FROM accounts WHERE accntGroupId IN(17,19)");
                                    foreach ($PaymentBy as $PaymentByResult) {
                                        echo '
                                        <option value="' . $PaymentByResult["Aid"] . '">' . $PaymentByResult["firstName"] . ' ' . $PaymentByResult["lastName"] .'</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="pa_amount" class="TktcommonFont">Amount</label>
                                <input type="number" class="form-control" name="PaAmount" id="pa_amount" required>
                            </div>
                            <div class="col-6">
                                <label for="pa_date" class="TktcommonFont">Date</label>
                                <input type="date" value="<?= date('Y-m-d'); ?>" class="form-control" name="PaDate" id="pa_date" required>
                            </div>
                            <!-- <div class="col-6">
                            <label for="pa_receivedby" class="TktcommonFont">Recieved By</label>
                            <input type="text" name="PaReceivedby" id="pa_receivedby" class="form-control" placeholder="Receiving person">
                        </div> -->
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="pa_remarks" class="TktcommonFont">Remarks</label>
                                <textarea class="form-control" rows="5" name="PaRemarks" id="pa_remarks"></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">SUBMIT</button>
                        </div>
                    </form>

                <?php
                }



                ?>



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
        $('#pa_to').focus();

        $('#btnConfirm').click(function() {
            location.replace('PaymentVoucher.php');
        });


        /* Add master Start */
        $(function() {

            let validator = $('#PaymentVoucherForm').jbvalidator({
                language: 'dist/lang/en.json',
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

            $(document).on('submit', '#PaymentVoucherForm', (function(e) {
                e.preventDefault();
                var RVData = new FormData(this);
                console.log(RVData);
                $.ajax({
                    type: "POST",
                    url: "VoucherOperations.php",
                    data: RVData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#PaymentVoucherForm').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                        $('#btnConfirm').hide();
                        $('#btnClose').show();
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#PaymentVoucherForm').removeClass("disable");
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.addPaymentVoucher == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Checklist is Already Present");
                                $('#confirmModal').modal('show');
                            } else if (response.addPaymentVoucher == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Added PaymentVoucher ");
                                $('#confirmModal').modal('show');
                                $('#btnConfirm').show();
                                $('#btnClose').hide();
                                ResetForms();
                            } else if (response.addPaymentVoucher == "2") {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Adding PaymentVoucher ");
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

            let validator = $('#UpdatePaymentVoucherForm').jbvalidator({
                language: 'dist/lang/en.json',
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

            $(document).on('submit', '#UpdatePaymentVoucherForm', (function(e) {
                e.preventDefault();
                var RVData = new FormData(this);
                console.log(RVData);
                $.ajax({
                    type: "POST",
                    url: "VoucherOperations.php",
                    data: RVData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#UpdatePaymentVoucherForm').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                        $('#btnConfirm').hide();
                        $('#btnClose').show();
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#UpdatePaymentVoucherForm').removeClass("disable");
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.UpdatePaymentVoucher == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Checklist is Already Present");
                                $('#confirmModal').modal('show');
                            } else if (response.UpdatePaymentVoucher == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Updated PaymentVoucher ");
                                $('#confirmModal').modal('show');
                                $('#btnConfirm').show();
                                $('#btnClose').hide();
                                ResetForms();
                            } else if (response.UpdatePaymentVoucher == "2") {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Updating PaymentVoucher ");
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