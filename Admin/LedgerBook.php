<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'LedgerBook';


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


    <style>
        .colvisbtn {
            margin-left: 10px;
            margin-right: 10px;
            margin-top: 15px;
        }
    </style>
    <?php

    $FindLedger = mysqli_query($con, "SELECT Aid,firstName,lastName FROM accounts");
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

                    <h3 class="pt-3">LEDGER BOOK</h3>

                    <form class="ms-auto me-2 pt-3" id="LedgerPrint" target="_blank" method="POST" action="LedgerBookPrint.php">
                        <input type="number" id="ledger_id" name="LedgerId" hidden>
                        <input type="date" id="ledger_start_date" name="LedgerStart" value="<?= date('Y-m-d'); ?>" hidden>
                        <input type="date" id="ledger_end_date" name="LedgerEnd" value="<?= date('Y-m-d'); ?>" hidden>
                        <button class="btn btn-secondary" name="LedgerPrint" type="submit">PDF EXPORT</button>

                    </form>

                    <div id="new-controls"> </div>


                </div>

                <div class="admintoolbar">
                    <div class="card card-body">

                        <form id="LedgerForm">

                            <div class="row">
                                <div class="col-lg-4 col-6">
                                    <select name="LedgerName" class="SelectPlugin" id="LedgerSelect">
                                        <option hidden value="">Choose Ledger</option>
                                        <?php
                                        foreach ($FindLedger as $FindLedgerResults) {
                                            echo '
                                            <option value="' . $FindLedgerResults["Aid"] . '">' . $FindLedgerResults["firstName"] . ' ' . $FindLedgerResults["lastName"] . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-4">
                                    <label for="min" class="d-flex m-0">
                                        <span class="mt-1">From</span>
                                        <input id="start_date" type="date" value="<?= date('Y-m-d'); ?>" class="form-control ms-2 w-75 dateSelect" name="FromDate">
                                    </label>
                                </div>
                                <div class="col-lg-3 col-4">
                                    <label for="max" class="d-flex m-0">
                                        <span class="mt-1">To</span>
                                        <input id="end_date" type="date" value="<?= date('Y-m-d'); ?>" class="form-control ms-2 w-75 dateSelect" name="ToDate">
                                    </label>
                                </div>
                                <div class="col-lg-2 col-6 text-end">
                                    <button class="btn btn_reset submit_btn px-5"><span>Search</span></button>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>




                <div class="table-responsive mt-2" style="max-height: 600px;">
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
                        <tbody id="ViewledgerDetails">

                        </tbody>
                    </table>
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
        $(document).ready(function() {


            $('#LedgerSelect').change(function() {
                var LedgerId = $(this).val();
                $('#ledger_id').val(LedgerId);
            });

            $('#start_date').change(function() {
                var LedgerDateStart = $(this).val();
                $('#ledger_start_date').val(LedgerDateStart);
            });

            $('#end_date').change(function() {
                var LedgerDateEnd = $(this).val();
                $('#ledger_end_date').val(LedgerDateEnd);
            });


            $.fn.dataTable.ext.errMode = 'none';

            var LedgerSelect = $("#LedgerSelect").selectize({
                sortField: "text",
                //openOnFocus: false
            });

            $(document).on('submit', '#LedgerForm', function(e) {
                e.preventDefault();
                var LedgerData = new FormData(this);
                var MasterTable = $('#LedgerTable').DataTable({
                    "dom": 'rt<"bottom">',
                    "ordering": false,
                    "pagination": false,
                    "scrollY": "200px",
                });

                MasterTable.destroy();
                $.ajax({
                    type: "POST",
                    url: "LedgerBookData.php",
                    data: LedgerData,
                    beforeSend: function() {
                        //console.log("before send");
                    },
                    success: function(data) {
                        $('#ViewledgerDetails').html(data);
                        var MasterTable = $('#LedgerTable').DataTable({
                            "destroy": true,
                            "dom": 'rt<"bottom">',
                            "ordering": false,
                            "pagination": false,
                            "scrollY": "200px",



                        });
                        

                        // new $.fn.dataTable.Buttons(MasterTable, {
                        //     buttons: [{
                        //         className: 'colvisbtn',
                        //         extend: 'excel',
                        //         text: '<i class = "material-icons" style="vertical-align:middle;">table_view</i> ',
                        //         text: 'EXCEL'
                        //     }]
                        // }).container().appendTo(".sub-controls");





                    },
                    error: function() {

                    },
                    cache: false,
                    contentType: false,
                    processData: false

                });




            });


        });
    </script>


</body>

</html>