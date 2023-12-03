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

    <?php
    $VisaId = $_GET['visId'];
    $FindBookingDetails = mysqli_query($con, "SELECT AC.Aid AS CAREID,AC.firstName AS CAREFIRST,AC.lastName AS CARELAST, v.vId,v.passengerName,c.cId AS FID, c.countryName AS F,cm.cId AS TID, cm.countryName AS T,v.passengerDate,v.passengerProof,v.passengerVisa,v.passengerValidity,A.firstName,A.lastName,A.Aid AS AID,v.agencyRate,v.ourRate,v.passengerStatus,v.passengerPhone  FROM visa_booking v INNER JOIN country_master c ON v.passengerFrom = c.cId INNER JOIN accounts A ON v.passengerAgency = A.Aid INNER JOIN country_master cm ON v.passengerTo = cm.cId INNER JOIN accounts AC ON v.passengerCareof = AC.Aid WHERE A.accountType = 'SUPPLIER' AND v.vId = '$VisaId'")
    ?>


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


                <form id="UpdateVisaBookingForm" class="UpdateForm" novalidate>

                    <?php

                    foreach ($FindBookingDetails as $FindBookingDetailResults) {
                    }

                    ?>

                    <div class="row">
                        <div class="col-12">
                            <input type="text" name="UpdateVisaId" value="<?= $FindBookingDetailResults['vId'] ?>" hidden>
                            <label class="TktcommonFont">Passenger Name</label>
                            <input type="text" name="UpdatePassengerName" id="passenger_name" value="<?= $FindBookingDetailResults['passengerName'] ?>" class="form-control" placeholder="Please type your fullname" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-5">
                            <label class="TktcommonFont">From</label>
                            <select class="form-select SelectFromCountry" name="UpdatePassengerFrom" id="passenger_from" required>
                                <option hidden value="<?= $FindBookingDetailResults['FID'] ?>"><?= $FindBookingDetailResults['F'] ?></option>
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
                            <select class="form-select SelectToCountry" name="UpdatePassengerTo" id="passenger_to" required>
                                <option hidden value="<?= $FindBookingDetailResults['TID'] ?>"><?= $FindBookingDetailResults['T'] ?></option>
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
                            <input type="date" class="form-control" value="<?= date('Y-m-d', strtotime($FindBookingDetailResults['passengerDate']));  ?>" name="UpdateDepartureDate" id="departure_date" >
                        </div>
                        <div class="col-6">
                            <label class="TktcommonFont">Phone</label>
                            <input type="text" name="UpdatePassengerPhone" value="<?= $FindBookingDetailResults['passengerPhone'] ?>" id="passenger_phone" class="form-control" placeholder="Please enter your phoneno" >
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label class="TktcommonFont">Passport No</label>
                            <input type="text" class="form-control" value="<?= $FindBookingDetailResults['passengerProof'] ?>" name="UpdatePassengerProof" id="passenger_proof" placeholder="Please enter your ID proofno" >
                        </div>
                        <div class="col-6 ">
                            <label class="TktcommonFont">Care Of</label>
                            <select class="form-select SelectCustomer" name="UpdatePassengerCareof" id="passenger_careof" required>
                                <option hidden value="<?= $FindBookingDetailResults['CAREID'] ?>"><?= $FindBookingDetailResults['CAREFIRST'] . ' ' . $FindBookingDetailResults['CARELAST'] ?></option>
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
                            <select class="form-select" name="UpdateVisaType" id="visa_type" >
                                <option hidden value="<?= $FindBookingDetailResults['passengerVisa'] ?>"><?= $FindBookingDetailResults['passengerVisa'] ?></option>
                                <option value="Dubai Visa">Dubai Visa</option>
                                <option value="UK Visa">UK Visa</option>
                                <option value="US Visa">US Visa</option>
                                <option value="Qatar visa">Qatar visa</option>
                                <option value="Saudi Visa">Saudi Visa</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="TktcommonFont">Validity</label>
                            <input class="form-control" type="text" name="UpdateVisaValidity" value="<?= $FindBookingDetailResults['passengerValidity'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="TktcommonFont">Agency</label>
                            <select class="form-select SelectAgency" name="UpdateVisaAgency" id="visa_agency" required>
                                <option hidden value="<?= $FindBookingDetailResults['AID'] ?>"><?= $FindBookingDetailResults['firstName'] . ' ' . $FindBookingDetailResults['lastName'] ?></option>
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
                            <select class="form-select" name="UpdateVisaApproval" id="visa_approval">
                                <option hidden value="<?= $FindBookingDetailResults['passengerStatus'] ?>"><?= $FindBookingDetailResults['passengerStatus'] ?></option>
                                <option selected value="Processing">Processing</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-6">
                            <label class="TktcommonFont">Agency Rate</label><br>
                            <input type="number" class="form-control" step="any" value="<?= $FindBookingDetailResults['agencyRate'] ?>" name="UpdateAgencyRate" id="agency_rate" placeholder="&#8377;" required>
                        </div>
                        <div class="col-6">
                            <label class="TktcommonFont">Customer Rate</label><br>
                            <input type="number" name="UpdateOurRate" id="our_rate" step="any" value="<?= $FindBookingDetailResults['ourRate'] ?>" class="form-control" placeholder="&#8377;" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-info">UPDATE</button>
                    </div>
                </form>


                <form action="" class="AddForm" hidden>

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


        $('#passenger_name').focus();

        /* Update master Start */
        $(function() {

            let validator = $('#UpdateVisaBookingForm').jbvalidator({
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
                if ($(el).is('#update_passenger_name,#update_agency_rate,#update_our_rate') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#UpdateVisaBookingForm', (function(e) {
                e.preventDefault();
                var UpdateVisaBooking = new FormData(this);
                console.log(UpdateVisaBooking);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: UpdateVisaBooking,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#UpdateVisaBookingForm').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#UpdateVisaBookingForm').removeClass("disable");
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.UpdateVisaBooking == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("FROM and TO countries cannot be same");
                                $('#confirmModal').modal('show');
                            } else if (response.UpdateVisaBooking == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Updated Visa");
                                $('#confirmModal').modal('show');
                                ResetForms();
                                location.replace('ViewVisa.php');
                            } else if (response.UpdateVisaBooking == "2") {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Updating Visa");
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