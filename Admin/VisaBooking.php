<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'VisaBooking';


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
                        <h3 class="pt-3"> VISA BOOKING </h3>
                    </div>

                </div>


                <form id="VisaBookingForm" class="AddForm px-3" novalidate>
                    <div class="row">
                        <div class="col-12">
                            <label class="TktcommonFont">Passenger Name</label>
                            <input type="text" name="PassengerName" id="passenger_name" class="form-control" placeholder="Please type your fullname" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-5">
                            <label class="TktcommonFont">From</label>
                            <select class="form-select SelectFromCountry" name="PassengerFrom" id="passenger_from" required>
                                <option hidden value="">Country</option>
                                <!-- <?php
                                foreach ($FindCountry as $FindCountryResults) {
                                    echo '
                                        <option value="' . $FindCountryResults["cId"] . '">' . $FindCountryResults["countryName"] . '</option>
                                        ';
                                }
                                ?> -->
                            </select>
                        </div>
                        <div class="col-2 mt-4 pt-2 text-center">
                            <i class="ri-arrow-left-right-line"></i>
                        </div>
                        <div class="col-5">
                            <label class="TktcommonFont">To</label>
                            <select class="form-select SelectToCountry" name="PassengerTo" id="passenger_to" required>
                                <option hidden value="">To Country</option>
                                <!-- <?php
                                foreach ($FindCountry as $FindCountryResults) {
                                    echo '
                                        <option value="' . $FindCountryResults["cId"] . '">' . $FindCountryResults["countryName"] . '</option>
                                        ';
                                }
                                ?> -->
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label class="TktcommonFont">Application Date</label>
                            <input type="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" name="DepartureDate" id="departure_date">
                        </div>
                        <div class="col-6">
                            <label class="TktcommonFont">Phone</label>
                            <input type="number" name="PassengerPhone" id="passenger_phone" class="form-control" placeholder="Please enter phone number">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label class="TktcommonFont">Passport No</label>
                            <input type="text" class="form-control" name="PassengerProof" id="passenger_proof" placeholder="Please enter passport number">
                        </div>
                        <div class="col-6">
                            <label class="TktcommonFont">Care Of</label>
                            <select class="form-select SelectCustomer" name="PassengerCareof" id="passenger_careof" required>
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
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="TktcommonFont">Visa Type</label>
                            <select class="form-select" name="VisaType" id="visa_type">
                                <option hidden value="">Choose Type</option>
                                <option value="Dubai Visa">Dubai Visa</option>
                                <option value="UK Visa">UK Visa</option>
                                <option value="US Visa">US Visa</option>
                                <option value="Qatar visa">Qatar visa</option>
                                <option value="Saudi Visa">Saudi Visa</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="TktcommonFont">Validity</label>
                            <input class="form-control" type="text" name="VisaValidity" id="visa_validity">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="TktcommonFont">Agency</label>
                            <select class="form-select SelectAgency" name="VisaAgency" id="visa_agency" required>
                                <option hidden value="">Choose Agency</option>
                                <!-- <?php
                                foreach ($FindAgency as $FindAgencyResults) {
                                    echo '
                                        <option value="' . $FindAgencyResults["Aid"] . '">' . $FindAgencyResults["firstName"] . ' ' . $FindAgencyResults["lastName"] . '</option>
                                        ';
                                }
                                ?> -->
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="TktcommonFont">Status</label>
                            <select class="form-select" name="VisaApproval" id="visa_approval">
                                <option selected value="Processing">Processing</option>
                                <option value="Approved">Approved</option>
                                <option value="Approved">Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-6">
                            <label class="TktcommonFont">Agency Rate</label><br>
                            <input type="number" class="form-control" name="AgencyRate" id="agency_rate" placeholder="&#8377;" required>
                        </div>
                        <div class="col-6">
                            <label class="TktcommonFont">Customer Rate</label><br>
                            <input type="number" name="OurRate" id="our_rate" class="form-control" placeholder="&#8377;" required>
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


    <?php include ('../MAIN/Footer.php'); ?>

    <script>
        $('#passenger_name').focus();

        const ConfirmModal = document.getElementById('confirmModal')
        const ConfirmBtn = document.getElementById('btnClose')

        ConfirmModal.addEventListener('shown.bs.modal', () => {
            ConfirmBtn.focus();
        });


        /* Add master Start */
        $(function() {

            let validator = $('#VisaBookingForm').jbvalidator({
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
                if ($(el).is('#passenger_name,#agency_rate,#our_rate') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#VisaBookingForm', (function(e) {
                e.preventDefault();
                var ChecklistData = new FormData(this);
                console.log(ChecklistData);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: ChecklistData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#VisaBookingForm').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#VisaBookingForm').removeClass("disable");
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.addVisaBooking == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("FROM and TO countries cannot be same");
                                $('#confirmModal').modal('show');
                            } else if (response.addVisaBooking == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Booked Visa");
                                $('#confirmModal').modal('show');
                                ResetForms();
                                $('#VisaBookingForm')[0].reset();
                            } else if (response.addVisaBooking == "2") {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Booking Visa");
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


    </script>


</body>

</html>