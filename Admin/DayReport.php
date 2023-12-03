<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'DayReport';

$dateToday = date('Y-m-d');


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

    <!-- SELECTIZE  CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/css/selectize.bootstrap5.css" integrity="sha512-QomP/COM7vFCHcVHpDh/dW9oDyg44VWNzgrg9cG8T2cYSXPtqkQK54WRpbqttfo0MYlwlLUz3EUR+78/aSbEIw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/js/selectize.min.js" integrity="sha512-VReIIr1tJEzBye8Elk8Dw/B2dAUZFRfxnV2wbpJ0qOvk57xupH+bZRVHVngdV04WVrjaMeR1HfYlMLCiFENoKw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <?php



    $fetchDayReport = mysqli_query($con, "SELECT dayStartupCapital,dayCashInHand FROM dayreport WHERE DATE(dayDate) = '$dateToday'");
    if (mysqli_num_rows($fetchDayReport) > 0) {
        foreach ($fetchDayReport as $fetchDayReportResult) {
            $StartupCapital = $fetchDayReportResult['dayStartupCapital'];
            $CashinHand = $fetchDayReportResult['dayCashInHand'];
        }
    } else {
        $fetchStartupCapital = mysqli_query($con, "SELECT dayStartupCapital,dayCashInHand FROM dayreport ORDER BY dayId DESC LIMIT 1");
        if (mysqli_num_rows($fetchStartupCapital) > 0) {
            foreach ($fetchStartupCapital as $fetchStartupCapitalResult) {
                $StartupCapital = $fetchStartupCapitalResult['dayStartupCapital'];
            }
            $CashinHand = 0;
        } else {
            $StartupCapital = 0;
            $CashinHand = 0;
        }
    }



    ?>


</head>

<body>


    <!-- Confirm Modal -->
    <div class="modal fade ResponseModal" id="confirmModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-3 py-5">
                    <div class="text-center mb-4" id="ResponseImage">

                    </div>
                    <h4 id="ResponseText" class="text-center mb-3"></h4>
                    <div class="text-center">
                        <button type="button" id="btnConfirm" style="display: none;" class="btn btn_save mt-4 px-5 py-2" data-bs-dismiss="modal">Proceed</button>
                        <button type="button" id="btnClose" class="btn btn_save mt-4 px-5 py-2" data-bs-dismiss="modal">Okay</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="delModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancel Confirmation</h5>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">Do you want to cancel this Ticket Booking?</h4>
                    <div class="text-center mt-3">
                        <button type="button" id="confirmYes" class="btn btn-primary me-5">Yes</button>
                        <button type="button" id="confirmNo" class="btn btn-secondary ms-5" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include('../MAIN/Sidebar.php');  ?>

    <div class="wrapper">

        <!--NAVBAR-->
        <?php include '../MAIN/Navbar.php'; ?>

        <!--CONTENTS-->
        <div class="container mainContents">
            <div class="card card-body main_card mt-5 shadow-lg p-3 mb-5">
                <div class="main_heading d-flex justify-content-between mb-2 shadow p-2">

                    <h3 class="pt-3">DAY REPORT</h3>

                    <div class="mt-3 me-2">
                        <a class="btn btn-secondary" id="DayReportPdf" target="_blank" href="DayReportPrint.php?DTDAY=<?= date('Y-m-d') ?>">PDF EXPORT</a>
                    </div>

                </div>

                <div class="admintoolbar">
                    <div class="card card-body">
                        <form id="DayForm">

                            <div class="row">
                                <div class="col-lg-3 col-4">
                                    <label for="min" class="d-flex m-0">
                                        <span class="mt-1">Date</span>
                                        <input type="date" value="<?= date('Y-m-d'); ?>" class="form-control ms-2 w-75 dateSelect" name="FromDate">
                                    </label>
                                    <input type="number" id="startup_form" class="form-control ms-2 w-75 StartupCapital" name="StartupCapital" value="<?= $StartupCapital ?>" hidden>
                                    <input type="number" id="cash_form" class="form-control ms-2 w-75 CashInHand" name="CashInHand" value="<?= $CashinHand ?>" hidden>
                                </div>

                                <div class="col-lg-9 col-8 text-end">
                                    <button class="btn btn_reset submit_btn px-5"><span>Search</span></button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>



                <div class="row" id="DayReportDetails">

                    <div class="col-lg-8">
                        <div class="table-responsive mt-2" style="max-height: 600px;">
                            <table class="table table-bordered table-hover  text-nowrap" id="LedgerTable2" style="width: 100%;">
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
                                <tbody id="ViewledgerDetails">

                                </tbody>
                            </table>
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
                                    <input type="number" id="start_up_capital" class="form-control StartCapital" value="<?= $StartupCapital ?>">
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
                                    <!-- <input type="number" id="cash_in_hand" class="form-control CashHand" value="<?= $CashinHand ?>"> -->
                                    <h6 class=""> <strong>0</strong> </h6>
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
                                    <h6 class=""> <strong>0</strong> </h6>
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
                                    <h6 class=""> <strong>0</strong> </h6>
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
                                    <h6 class=""> <strong>0</strong> </h6>
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
                                    <h6 class=""> <strong>0</strong> </h6>
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
                                    <h6 class=""> <strong>0</strong> </h6>
                                </div>
                            </div>
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
                                    <h6 class=""> <strong>0</strong> </h6>
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
                                    <h6 class=""> <strong>0</strong> </h6>
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
                                    <input type="number" id="adjusted_profit" min="0" value="0" name="AdjustedProfit" value="" class="form-control AdjustedProfit">
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
                                        <option value="0">Profit Ledger</option>
                                        <?php
                                            $ShowProfitLedgers = mysqli_query($con, "SELECT Aid,firstName FROM accounts WHERE isProfitLedger = 1");
                                            foreach($ShowProfitLedgers as $ShowProfitLedgersResults){
                                                echo '<option value="'.$ShowProfitLedgersResults["Aid"].'">'.$ShowProfitLedgersResults["firstName"].'</option>';
                                            }   
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-between mb-2 mt-2 px-3">
                            <button class="btn SaveBtn AddBtn px-5">SAVE</button>
                            <button class="btn UpdateBtn AddBtn px-4">UPDATE</button>
                        </div>

                    </div>

                </div>

            </div>
        </div>





    </div>



    <main id="loading">
        <div id="loadingDiv">
            <img class="img-fluid loaderGif" src="./loader.svg" alt="">
        </div>
    </main>





    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

    <script src="../JS/main.js"></script>


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


        $('.dateSelect').change(function() {
            var DayReportDate = $(this).val();
            $('#DayReportPdf').attr('href', 'DayReportPrint.php?DTDAY=' + DayReportDate + '');
            console.log(DayReportDate);
            $.ajax({
                type: "POST",
                url: "MasterExtras.php",
                data: {
                    DayReportDate: DayReportDate
                },
                beforeSend: function() {
                    $('#loading').show();
                    $('#DayForm').addClass("disable");
                },
                success: function(data) {
                    $('#loading').hide();
                    console.log(data);
                    $('#DayForm').removeClass("disable");
                    var DayReportResult = JSON.parse(data);
                    if (DayReportResult.Status == 1) {
                        $('.StartCapital').val(DayReportResult.Startup);
                        $('.StartupCapital').val(DayReportResult.Startup);
                        $('.CashHand').val(DayReportResult.CashInHand);
                        $('.CashInHand').val(DayReportResult.CashInHand);
                        $('#DayForm').submit();
                    } else {
                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                        $('#ResponseText').text("Please refresh the page to continue (ERROR : 12EFF)");
                        $('#confirmModal').modal('show');
                    }
                },
                error: function() {
                    $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                    $('#ResponseText').text("Please refresh the page to continue (ERROR : 12EFF)");
                    $('#confirmModal').modal('show');
                }

            });
        });


        //save button
        $(document).on('click', '.SaveBtn', function() {
            var DrDate = $('.dateSelect').val();
            var DrStartup = $('.StartupCapital').val();
            var DrCash = $('.CashInHand').val();
            var DrProfitAdjustment = $('.AdjustedProfit').val();
            var DrProfitAdjustmentLedger = $('.ProfitAdjustmentLedger').val();
            console.log(DrProfitAdjustment);

            if (parseInt(DrProfitAdjustment) > 0 && DrProfitAdjustmentLedger != 0) {

                if (confirm("Are You Sure You Want To Transfer The Profit?") == true) {
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: {
                            DrDate: DrDate,
                            DrStartup: DrStartup,
                            DrCash: DrCash,
                            DrProfitAdjustment: DrProfitAdjustment,
                            DrProfitAdjustmentLedger:DrProfitAdjustmentLedger
                        },
                        beforeSend: function() {
                            $('#loading').show();
                            $('#DayForm').addClass("disable");
                            $('#ResponseImage').html("");
                            $('#ResponseText').text("");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#loading').hide();
                            $('#DayForm').removeClass("disable");
                            var DayReportSave = JSON.parse(data);
                            if (DayReportSave.DayReport == 'Success') {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Saved Day Report");
                                $('#confirmModal').modal('show');
                                $('.AdjustedProfit').val('0');
                            } else if (DayReportSave.DayReport == 'Failed') {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Saving Day Report");
                                $('#confirmModal').modal('show');
                            }
                        },
                        error: function() {
                            $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Please refresh the page to continue (ERROR : 12EFF)");
                            $('#confirmModal').modal('show');
                        }
                    });
                } else {
                    console.log("Cancelled");
                }

            } else {

                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: {
                        DrDate: DrDate,
                        DrStartup: DrStartup,
                        DrCash: DrCash,
                        DrProfitAdjustment: 0,
                        DrProfitAdjustmentLedger:0
                    },
                    beforeSend: function() {
                        $('#loading').show();
                        $('#DayForm').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#loading').hide();
                        $('#DayForm').removeClass("disable");
                        var DayReportSave = JSON.parse(data);
                        if (DayReportSave.DayReport == 'Success') {
                            $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Successfully Saved Day Report");
                            $('#confirmModal').modal('show');
                            $('.AdjustedProfit').val(0);
                            $('.ProfitAdjustmentLedger').val(0).change();
                        } else if (DayReportSave.DayReport == 'Failed') {
                            $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Failed Saving Day Report");
                            $('#confirmModal').modal('show');
                        }
                    },
                    error: function() {
                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                        $('#ResponseText').text("Please refresh the page to continue (ERROR : 12EFF)");
                        $('#confirmModal').modal('show');
                    }
                });

            }
        });


        //update button
        $(document).on('click', '.UpdateBtn', function() {
            var DrDate = $('.dateSelect').val();
            var DrStartup = $('.StartupCapital').val();
            var DrCash = $('.CashInHand').val();

            $.ajax({
                type: "POST",
                url: "MasterOperations.php",
                data: {
                    DrDate: DrDate,
                    DrStartup: DrStartup,
                    DrCash: DrCash
                },
                beforeSend: function() {
                    $('#loading').show();
                    $('#DayForm').addClass("disable");
                    $('#ResponseImage').html("");
                    $('#ResponseText').text("");
                },
                success: function(data) {
                    console.log(data);
                    $('#loading').hide();
                    $('#DayForm').removeClass("disable");
                    var DayReportSave = JSON.parse(data);
                    if (DayReportSave.DayReport == 'Success') {
                        $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                        $('#ResponseText').text("Successfully Updated Day Report");
                        $('#confirmModal').modal('show');
                    } else if (DayReportSave.DayReport == 'Failed') {
                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                        $('#ResponseText').text("Failed Updating Day Report");
                        $('#confirmModal').modal('show');
                    }
                },
                error: function() {
                    $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                    $('#ResponseText').text("Please refresh the page to continue (ERROR : 12EFF)");
                    $('#confirmModal').modal('show');
                }
            });
        });


        //view day report
        $(document).on('submit', '#DayForm', function(e) {
            e.preventDefault();
            var DayReportData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "DayReportData.php",
                data: DayReportData,
                beforeSend: function() {
                    //console.log("before send");
                },
                success: function(data) {
                    $('#DayReportDetails').html(data);
                },
                error: function() {

                },
                cache: false,
                contentType: false,
                processData: false

            });

        });


    </script>


</body>

</html>