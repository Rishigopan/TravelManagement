<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'DummyTicket';


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

    <?php include('../MAIN/Header.php'); ?>

</head>

<body>



    <?php include('../MAIN/Modals.php'); ?>

    <?php include('../MAIN/Sidebar.php'); ?>


    <!-- Mode Of Pay Modal -->
    <div class="modal fade ModeofPayModal" id="MOPModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-3 py-5">

                    <form id="DummyPaymentForm" action="">

                        <input type="number" name="DummyTBookingId" id="booking_id" class="form-control" hidden>
                        <input type="number" name="DummyTBookingAmount" id="booking_amount" class="form-control" hidden>
                        <input type="number" name="DummyTBookingCareoff" id="booking_careoff" class="form-control" hidden>

                        <div class="text-center">
                            <h4> <strong>Amount - <span class="BookingAmount"></span></strong> </h4>
                        </div>

                        <div class="px-5">
                            <div class="mb-2 row">
                                <div class="form-check col-sm-6 col-form-label">
                                    <input class="form-check-input" type="checkbox" value="6" name="DummyModePay[]" id="upicheck">
                                    <label class="form-check-label" for="upicheck">UPI</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" value="0" id="upi_amount" name="DummyUpiAmount">
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <div class="form-check col-sm-6 col-form-label">
                                    <input class="form-check-input" type="checkbox" value="10" name="DummyModePay[]" id="bankcheck">
                                    <label class="form-check-label" for="bankcheck">Bank</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" value="0" id="bank_amount" name="DummyBankAmount">
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <div class="form-check col-sm-6 col-form-label">
                                    <input class="form-check-input" type="checkbox" value="2" name="DummyModePay[]" id="cashcheck" checked>
                                    <label class="form-check-label" for="cashcheck">Cash</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" value="0" id="cash_amount" name="DummyCashAmount">
                                </div>
                            </div>

                        </div>

                        <h4 class="text-center mb-2"> Do you want to collect Payment?</h4>
                        <div class="text-center">
                            <button type="sumbit" class="btn btn_save mt-4 px-5 py-2 me-5" data-bs-dismiss="modal">Collect</button>
                            <button type="button" id="btnClose" class="btn btn-secondary mt-4 px-5 py-2" data-bs-dismiss="modal">Cancel</button>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>





    <div class="wrapper">

        <!--NAVBAR-->
        <?php include '../MAIN/Navbar.php'; ?>


        <!--CONTENTS-->
        <div class="container mainContents">

            <div class="card card-body main_card mt-5 shadow-lg p-3 mb-5">

                <div class="main_heading d-flex justify-content-between mb-2 shadow p-2">
                    <div>
                        <h3 class="pt-3"> DUMMY TICKET BOOKING </h3>
                    </div>
                </div>

                <form id="DummyTicketBookingForm" class="AddForm px-3" novalidate>
                    <div class="row">
                        <div class="col-12">
                            <label class="TktcommonFont">Passenger Name</label>
                            <input type="text" name="DummyTicketPassengerName" id="dummy_passenger_name" class="form-control" placeholder="Please type your fullname" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-5">
                            <label class="TktcommonFont">From</label>
                            <select class="form-select SelectFromCountry" name="DummyTicketPassengerFrom" id="dummy_passenger_from" required>
                                <option hidden value="">Country</option>
                            </select>
                        </div>
                        <div class="col-2 mt-4 pt-2 text-center">
                            <i class="ri-arrow-left-right-line"></i>
                        </div>
                        <div class="col-5">
                            <label class="TktcommonFont">To</label>
                            <select class="form-select SelectToCountry" name="DummyTicketPassengerTo" id="dummy_passenger_to" required>
                                <option hidden value="">Country</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label class="TktcommonFont">Depature Date</label>
                            <input type="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" name="DummyTicketDepartureDate" id="dummy_departure_date">
                        </div>
                        <div class="col-6">
                            <label class="TktcommonFont">Phone</label>
                            <input type="number" name="DummyTicketPassengerPhone" id="dummy_passenger_phone" class="form-control" placeholder="Please enter phone number">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label class="TktcommonFont">ID Proof</label>
                            <select class="form-select" name="DummyTicketIDProof" id="visa_type">
                                <option hidden value="">Choose Type</option>
                                <option value="Aadhaar">Aadhaar</option>
                                <option value="Passport">Passport</option>
                                <option value="Driving License">Driving License</option>
                                <option value="PAN Card">PAN Card</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="TktcommonFont">ID Proof No</label>
                            <input type="text" class="form-control" name="DummyTicketIDProofNo" id="dummy_passenger_proof" placeholder="Please enter passport number">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="TktcommonFont">Care Of</label>
                            <select class="form-select SelectCustomer" name="DummyTicketPassengerCareof" id="dummy_passenger_careof" required>
                                <option hidden value="">Select Customer</option>
                                <!-- <?php
                                        foreach ($FindCustomer as $FindCustomerResults) {
                                            echo '
                                        <option value="' . $FindCustomerResults["Aid"] . '">' . $FindCustomerResults["firstName"] . ' ' . $FindCustomerResults["lastName"] . '</option>
                                        ';
                                        }
                                        ?> -->
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="TktcommonFont">AO Number</label>
                            <input class="form-control" type="number" name="DummyTicketAONumber" id="dummy_ticket_aonumber" placeholder="Please enter AO number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" hidden>
                            <label class="TktcommonFont">Status</label>
                            <select class="form-select" name="DummyTicketApproval" id="dummy_visa_approval">
                                <option selected value="Processing">Processing</option>
                                <option value="Approved">Approved</option>
                                <option value="Approved">Rejected</option>
                            </select>
                        </div>

                        <?php  
                        
                            if($Branch == 'TEZZA'){
                                ?>
                                <div class="col-6">
                                    <label class="TktcommonFont">Agency</label>
                                    <select class="form-select SelectAgency" name="DummyTicketBookingAgency" id="dummy_ticket_agency">
                                        <option hidden value="">Choose Agency</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="TktcommonFont">Agency Rate</label><br>
                                    <input type="number" name="DummyTicketAgencyRate" id="dummy_agency_rate" class="form-control" placeholder="&#8377;">
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class="col-6">
                                    <label class="TktcommonFont">Agency</label>
                                    <select class="form-select SelectAgency" name="DummyTicketBookingAgency" id="dummy_ticket_agency" required>
                                        <option hidden value="">Choose Agency</option>
                                       
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="TktcommonFont">Agency Rate</label><br>
                                    <input type="number" name="DummyTicketAgencyRate" id="dummy_agency_rate" class="form-control" placeholder="&#8377;" required>
                                </div>
                                <?php
                            }
                        
                        ?>

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="TktcommonFont">Customer Rate</label><br>
                            <input type="number" name="DummyTicketOurRate" id="dummy_our_rate" class="form-control" placeholder="&#8377;" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="TktcommonFont" for="">Remarks</label>
                            <textarea name="DummyRemarks" id="dummy_remarks" class="form-control"></textarea>
                            <!-- <input type="number" name="DummyRemarks" id="dummy_remarks" class="form-control" placeholder="&#8377;" required> -->
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-info">SUBMIT</button>
                    </div>
                </form>


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




    <?php include('../MAIN/Footer.php');  ?>


    <script>
        $('#passenger_name').focus();

        const ConfirmModal = document.getElementById('confirmModal')
        const ConfirmBtn = document.getElementById('btnClose')

        ConfirmModal.addEventListener('shown.bs.modal', () => {
            ConfirmBtn.focus();
        });


        /* Add master Start */
        $(function() {

            let validator = $('#DummyTicketBookingForm').jbvalidator({
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
                if ($(el).is('#dummy_passenger_name,#dummy_our_rate') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#DummyTicketBookingForm', (function(e) {
                e.preventDefault();
                var TicketData = new FormData(this);
                console.log(TicketData);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: TicketData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#DummyTicketBookingForm').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#DummyTicketBookingForm').removeClass("disable");
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.addTicketBooking == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("FROM and TO countries cannot be same");
                                $('#confirmModal').modal('show');
                            } else if (response.addTicketBooking == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Booked Ticket");
                                $('#confirmModal').modal('show');
                                ResetForms();
                                $('#DummyTicketBookingForm')[0].reset();
                                $('#booking_id').val(response.BookingId);
                                $('.BookingAmount').text(response.BookingAmount);
                                $('#cash_amount').val(response.BookingAmount);
                                $('#booking_amount').val(response.BookingAmount);
                                $('#booking_careoff').val(response.BookingCareoff);
                                $('#MOPModal').modal('show');
                            } else if (response.addTicketBooking == "2") {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Booking Ticket");
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



        /* Add payment master Start */
        $(function() {

            let validator = $('#DummyPaymentForm').jbvalidator({
                //language: 'dist/lang/en.json',
                successClass: false,
                html5BrowserDefault: true
            });

            validator.validator.custom = function(el, event) {
                
                if ($(el).is('#upi_amount,#bank_amount,#cash_amount') && (Number($('#upi_amount').val()) + Number($('#bank_amount').val()) + Number($('#cash_amount').val()) ) > Number($('#booking_amount').val())) {
                    return 'Cannot be greater than the amount to pay';
                }
            }

            $(document).on('submit', '#DummyPaymentForm', (function(e) {
                e.preventDefault();
                var PaymentData = new FormData(this);
                console.log(PaymentData);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: PaymentData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#DummyPaymentForm').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                        $('#confirmModal').modal('show');
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#DummyPaymentForm').removeClass("disable");
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.addMOPVoucher == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("FROM and TO countries cannot be same");
                                $('#confirmModal').modal('show');
                            } else if (response.addMOPVoucher == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Made Payment");
                                $('#confirmModal').modal('show');
                                console.log('test');
                                ResetForms();
                                $('#DummyPaymentForm')[0].reset();
                                $('#MOPModal').modal('hide');
                            } else if (response.addMOPVoucher == "2") {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Making Payment");
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
        /* Add payment master  End */
    </script>


</body>

</html>