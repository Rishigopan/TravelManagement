<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'CountryMaster';


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

    <?php include '../MAIN/Header.php'; ?>

</head>

<body>

    <?php
    $ticketID = $_GET['ticId'];
    $FindBookingDetails = mysqli_query($con, "SELECT tb.tbId,tb.tPassenger,tb.tDeparture,tb.tPhone,tb.tProof,tb.tProofNo,tb.tAoNumber,tb.tAmount,tb.tStatus,tb.tAgencyamount, tb.createdBy,tb.createdDate,A.Aid AS CAREID,A.firstName AS CAREFIRST,A.lastName AS CARELAST,CF.cId AS CFID,CF.countryName AS CFNAME,CT.cId AS CTID,CT.countryName AS CTNAME,Agency.Aid AS AGENCYID,Agency.firstName AS AGENCYFIRST, Agency.lastName AS AGENCYLAST FROM ticket_booking_table tb INNER JOIN accounts A ON tb.tbCareoff = A.Aid INNER JOIN country_master CF ON tb.tFrom = CF.cId INNER JOIN country_master CT ON tb.tTo = CT.cId INNER JOIN accounts Agency ON tb.tAgency = Agency.Aid WHERE tb.tbId = '$ticketID'");
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

    <?php include ('../MAIN/Modals.php'); ?>
    <?php include('../MAIN/Sidebar.php');  ?>


    <div class="wrapper">

        <!--NAVBAR-->
        <?php include '../MAIN/Navbar.php'; ?>


        <!--CONTENTS-->
        <div class="container mainContents mb-5">
            <div class="card card-body main_card shadow-lg p-3 mb-5">

                <div class="main_heading d-flex justify-content-between mb-2 shadow p-2">
                    <div>
                        <h3 class="pt-3"> TICKET BOOKING UPDATE</h3>
                    </div>
                </div>

                <form id="UpdateTicketBookingForm" class="AddForm" novalidate>

                    <?php
                    foreach ($FindBookingDetails as $FindBookingDetailResults) {
                    }
                    ?>

                    <div class="px-3 py-4">
                        <input class="form-control" name="UpdateTicketId" type="text" value="<?= $ticketID; ?>" hidden>
                        <div class="row">
                            <div class="col-12">
                                <label class="TktcommonFont">Passenger Name</label>
                                <input type="text" class="form-control" name="UpdateTicketPassenger" id="ticket_passenger" placeholder="Please type your fullname" value="<?= $FindBookingDetailResults['tPassenger']  ?>" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-5">
                                <label class="TktcommonFont">From</label>
                                <select class="form-select SelectFromCountry" name="UpdateTicketFrom" id="ticket_from" aria-label="Default select example" required>
                                    <option hidden value=" <?= $FindBookingDetailResults['CFID'] ?> "> <?= $FindBookingDetailResults['CFNAME']  ?> </option>
                                    <!-- <?php
                                            foreach ($FindCountry as $FindCountryResults) {
                                                echo '
                                        <option value="' . $FindCountryResults["cId"] . '">' . $FindCountryResults["countryName"] . '</option>
                                        ';
                                            }
                                            ?> -->
                                </select>
                            </div>
                            <div class="col-2 mt-4 text-center pt-2">
                                <i class="ri-arrow-left-right-line"></i>
                            </div>
                            <div class="col-5">
                                <label class="TktcommonFont">To</label>
                                <select class="form-select SelectToCountry" name="UpdateTicketTo" id="ticket_to" aria-label="Default select example" required>
                                    <option hidden value=" <?= $FindBookingDetailResults['CTID'] ?> "> <?= $FindBookingDetailResults['CTNAME']  ?> </option>
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
                                <label class="TktcommonFont">Depature Date</label>
                                <input type="date" name="UpdateTicketDeparture" value="<?= date('Y-m-d', strtotime($FindBookingDetailResults['tDeparture'])) ?>" id="ticket_departure" class="form-control" >
                            </div>
                            <div class="col-6">
                                <label class="TktcommonFont">Phone</label>
                                <input type="text" class="form-control" value="<?= $FindBookingDetailResults['tPhone']  ?>" name="UpdateTicketPhone" id="ticket_phone" placeholder="Please enter your phoneno" >
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <label class="TktcommonFont">ID Proof</label>
                                <select class="form-select" name="UpdateTicketProof" id="ticket_proof" aria-label="Default select example" >
                                    <option hidden value=" <?= $FindBookingDetailResults['tProof'] ?> "> <?= $FindBookingDetailResults['tProof']  ?> </option>
                                    <option value="Passport">Passport</option>
                                    <option value="Aadhaar">Aadhaar</option>
                                    <option value="Voter ID">Voter ID</option>
                                    <option value="Driving License">Driving License</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="TktcommonFont">ID Proof No</label><br>
                                <input type="text" name="UpdateTicketProofNo" value="<?= $FindBookingDetailResults['tProofNo']  ?>" id="ticket_proof_no" class="form-control" placeholder="Enter your ID Proof No" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="TktcommonFont">Care Of</label>
                                <select class="form-select SelectCustomer" name="UpdateTicketCareof" id="passenger_careof" required>
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
                            <div class="col-6">
                                <label class="TktcommonFont">AO Number</label>
                                <input class="form-control" type="number" value="<?= $FindBookingDetailResults['tAoNumber'] ?>" name="UpdateTicketAONumber" id="ticket_aonumber" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6" hidden>
                                <label for="ticket_status" class="TktcommonFont"> Status </label>
                                <select name="UpdateTicketStatus" id="ticket_status" class="form-select ">
                                    <option hidden value="<?= $FindBookingDetailResults['tStatus'] ?>"><?= $FindBookingDetailResults['tStatus'] ?></option>
                                    <option selected value="Processing">Processing</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="TktcommonFont">Agency</label>
                                <select class="form-select SelectAgency" name="UpdateTicketBookingAgency" id="ticket_agency" required>
                                    <option hidden value="<?= $FindBookingDetailResults['AGENCYID'] ?>"><?= $FindBookingDetailResults['AGENCYFIRST'] . ' ' . $FindBookingDetailResults['AGENCYLAST']  ?></option>
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
                                <label class="TktcommonFont">Agency Rate</label><br>
                                <input type="number" name="UpdateTicketAgencyRate" value="<?= $FindBookingDetailResults['tAgencyamount']  ?>" id="agency_rate" class="form-control" placeholder="&#8377;" required>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-6">
                                <label class="TktcommonFont">Customer Rate</label><br>
                                <input type="number" name="UpdateTicketAmount" value="<?= $FindBookingDetailResults['tAmount'] ?>" id="ticket_amount" class="form-control" placeholder="&#8377;" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-info">UPDATE</button>
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
        

        $('#ticket_passenger').focus();


        /* Update master Start */
        $(function() {

            let validator = $('#UpdateTicketBookingForm').jbvalidator({
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
                if ($(el).is('#update_passenger_name,#agency_rate,#ticket_amount') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#UpdateTicketBookingForm', (function(e) {
                e.preventDefault();
                var UpdateTicketBooking = new FormData(this);
                console.log(UpdateTicketBooking);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: UpdateTicketBooking,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#UpdateTicketBookingForm').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#UpdateTicketBookingForm').removeClass("disable");
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.UpdateTicketBooking == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("FROM and TO countries cannot be same");
                                $('#confirmModal').modal('show');
                            } else if (response.UpdateTicketBooking == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Updated Ticket");
                                $('#confirmModal').modal('show');
                                ResetForms();
                                location.replace('TicketBookingReport.php');
                            } else if (response.UpdateTicketBooking == "2") {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Updating Ticket");
                                $('#confirmModal').modal('show');
                            }else if (response.UpdateTicketBooking == "3") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Cannot Change Group Ticket to Normal and Vice Versa");
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