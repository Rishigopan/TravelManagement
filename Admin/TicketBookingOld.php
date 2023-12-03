<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'TicketBooking';
$userid = '1';


// if(isset($_SESSION['custname']) && isset($_SESSION['custtype'])){

//     if($_SESSION['custtype'] == 'SuperAdmin' || $_SESSION['custtype'] == 'Admin'){

//     }
//     else{
//         header("location:../login.php");
//     }

// }
// else{

// header("location:../login.php");

// }
?>

<!doctype html>
<html lang="en">

<head>




    <?php


    include '../MAIN/Header.php';

    ?>

    <style>
        .ticketTable {
            max-height: 350px;
            min-height: 350px;
        }

        .Bookticketdiv {
            position: absolute;
            left: 0;
            bottom: 0;
            background-color: lightgray;
            border-radius: 0px 0px 30px 30px;
            width: 100%;
        }
    </style>



</head>

<body>

    <?php
    $FindCountry = mysqli_query($con, "SELECT cId,countryName FROM country_master");
    $FindAgency = mysqli_query($con, "SELECT Aid,firstName,lastName FROM accounts WHERE accountType = 'SUPPLIER'");
    $FindCustomer = mysqli_query($con, "SELECT Aid,firstName,lastName FROM accounts WHERE accountType = 'CUSTOMER'");
    ?>



    <!-- add / update modal -->
    <div class="modal fade addUpdateModal" id="TicketModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content cntrymodalbg">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ADD TICKET</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form class="AddForm" id="AddTicket" novalidate>

                        <div class="row">
                            <div class="col-5">
                                <label TktcommonFont>From</label>
                                <select class="form-select" name="TicketFrom" id="ticket_from" aria-label="Default select example" required>
                                    <option hidden value="">From Country</option>
                                    <?php
                                    foreach ($FindCountry as $FindCountryResults) {
                                        echo '
                                        <option value="' . $FindCountryResults["cId"] . '">' . $FindCountryResults["countryName"] . '</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-2 mt-4 pt-2 ps-5">
                                <i class="ri-arrow-left-right-line"></i>
                            </div>
                            <div class="col-5">
                                <label>To</label>
                                <select class="form-select" name="TicketTo" id="ticket_to" aria-label="Default select example" required>
                                    <option hidden value="">From Country</option>
                                    <?php
                                    foreach ($FindCountry as $FindCountryResults) {
                                        echo '
                                        <option value="' . $FindCountryResults["cId"] . '">' . $FindCountryResults["countryName"] . '</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <label class="">Passenger Name</label>
                                <input type="text" class="form-control" name="TicketPassenger"  id="ticket_passenger" placeholder="Please type your fullname" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <label>Depature Date</label>
                                <input type="datetime-local" name="TicketDeparture" min="<?php echo date('Y-m-d').'T'.date('H:i'); ?>" id="ticket_departure" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label>Phone</label>
                                <input type="number" class="form-control" name="TicketPhone" id="ticket_phone" placeholder="Please enter your phoneno" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <label>ID Proof</label>
                                <select class="form-select" name="TicketProof" id="ticket_proof" aria-label="Default select example" required>
                                    <option hidden value="">Please select</option>
                                    <option value="Passport">Passport</option>
                                    <option value="Aadhaar">Aadhaar</option>
                                    <option value="Voter ID">Voter ID</option>
                                    <option value="Driving License">Driving License</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label>ID Proof No</label><br>
                                <input type="text" name="TicketProofNo" id="ticket_proof_no" class="form-control" placeholder="Enter your ID Proof No" required>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-6">
                                <label>Class</label>
                                <select class="form-select" name="TicketClass" id="ticket_class" aria-label="Default select example" required>
                                    <option hidden value="">Please select</option>
                                    <option value="Economy">Economy</option>
                                    <option value="Premium">Premium</option>
                                    <option value="Business">Business</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label>Amount</label><br>
                                <input type="number" name="TicketAmount" id="ticket_amount" class="form-control" placeholder="&#8377;" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label class=" mb-2">Gender</label>
                                <div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" value="male" name="TicketGender" id="ticket_male" required>
                                        <label class="form-check-label" for="ticket_male">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" value="female" name="TicketGender" id="ticket_female">
                                        <label class="form-check-label" for="ticket_female">
                                            Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label>Age</label>
                                <input type="number" name="TicketAge" id="ticket_age" class="form-control" placeholder="Enter your age" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">SUBMIT</button>
                        </div>

                    </form>

                    <form action="" class="UpdateForm" hidden></form>


                </div>
            </div>
        </div>
    </div>





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


    <?php include('../MAIN/Sidebar.php');  ?>



    <div class="wrapper">

        <!--NAVBAR-->
        <?php include '../MAIN/Navbar.php'; ?>






        <!--CONTENTS-->
        <div class="container mainContents">
            <div class="card card-body main_card mt-5 shadow-lg p-3 mb-5">


                <div class="main_heading d-flex justify-content-between mb-2 shadow p-2">
                    <div>
                        <h3 class="pt-3"> TICKET BOOKING </h3>
                    </div>

                    <div class="">
                        <button class="btn AddBtn mt-1" data-bs-toggle="modal" data-bs-target="#TicketModal">Add
                            Ticket</button>
                    </div>

                </div>


                <div class="table-responsive ticketTable">
                    <table class="table table-hover mastertable" id="MasterTable" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th class="">Sl No</th>
                                <th class="">Passenger</th>
                                <th class="">From</th>
                                <th class="">To</th>
                                <th class="">Departure</th>
                                <th class="">Phone</th>
                                <th class="">ID Proof</th>
                                <th class="">ID No</th>
                                <th class="">Gender</th>
                                <th class="">Age</th>
                                <th class="">Class</th>
                                <th class="">Amount</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="TicketTable">

                        </tbody>
                    </table>
                </div>



                <div class="Bookticketdiv">
                    <form action="" id="BookTicket">

                        <div class="d-flex justify-content-between">
                            <div class="col-3 ms-4">
                                <input type="text" name="UserId" id="userid" value="<?= $userid; ?>" hidden>
                                <label for="ticket_careof" class="form-label"> &nbsp; </label>
                                <select name="TicketCareof" id="ticket_careof" class="form-select mt-2" required>
                                    <option hidden value="">Select Care of</option>
                                    <?php
                                    foreach ($FindCustomer as $FindCustomerResults) {
                                        echo '
                                        <option value="' . $FindCustomerResults["atId"] . '">' . $FindCustomerResults["firstName"] . ' ' . $FindCustomerResults["lastName"] . '</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-3 d-flex justify-content-end">
                                <button class="btn btn-info">Book Tickets</button>
                            </div>
                        </div>

                    </form>
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

    <script src="../JS/cart.js"></script>


    <script>
        const AddModal = document.getElementById('TicketModal')
        const myInput = document.getElementById('ticket_from')
        const ConfirmModal = document.getElementById('confirmModal')
        const ConfirmBtn = document.getElementById('btnClose')

        AddModal.addEventListener('shown.bs.modal', () => {
            myInput.focus();
        });

        ConfirmModal.addEventListener('shown.bs.modal', () => {
            ConfirmBtn.focus();
        });

        


        function clearcart() {
            var clearcart = 'fetch_data';
            $.ajax({
                method: "POST",
                url: "MasterOperations.php",
                data: {
                    clearcart: clearcart
                },
                success: function(data) {
                    //console.log(data);
                }
            });
        }



        $(document).ready(function() {


            clearcart();

            getcartData();

            /* Add tickets */
            $(function() {

                let validator = $('#AddTicket').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                $(document).on('submit', '#AddTicket', (function(g) {
                    g.preventDefault();
                    var tempticketData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: tempticketData,
                        beforeSend: function() {
                            $('#DisplayItems').addClass("d-none");
                            $('#loadCard').removeClass("d-none");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#DisplayItems').removeClass("d-none");
                            $('#loadCard').addClass("d-none");
                            var response = JSON.parse(data);
                            if (response.addTicket == "1") {
                                toastr.success("Ticket Added Successfully");
                                getcartData();
                                $('#TicketModal').modal('hide');
                                $('#AddTicket')[0].reset();
                            } else if (response.addTicket == "2") {
                                toastr.error("Failed Adding Ticket");
                                getcartData();
                            } else if (response.addTicket == "3") {
                                toastr.success("Ticket already Exists");
                                getcartData();
                                $('#TicketModal').modal('hide');
                                $('#AddTicket')[0].reset();
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });
            /* Add tickets */




            //delete ticket
            $('#MasterTable tbody').on('click', '.btn_delete', function() {
                var delValue = $(this).val();
                console.log(delValue);

                if (confirm("Are you sure, you want to delete this ticket?") == true) {
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: {
                            delTicketTemp: delValue
                        },
                        beforeSend: function() {
                            $('#loading').show();
                            $('#delModal').modal('hide');
                            $('#ResponseImage').html("");
                            $('#ResponseText').text("");
                        },
                        success: function(data) {
                            $('#loading').hide();
                            console.log(data);
                            var delResponse = JSON.parse(data);
                            if (delResponse.deleteTicketTemp == 2) {
                                getcartData();
                                toastr.warning("Failed Deleting Ticket");
                            } else if (delResponse.deleteTicketTemp == 1) {
                                getcartData();
                                toastr.success("Ticket Deleted Successfully");
                            }
                        },
                        error: function() {
                            $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Please refresh the page to continue (ERROR : 12EFF)");
                            $('#confirmModal').modal('show');
                        },
                    });
                } else {}

            });



            /* Book tickets */
            $(function() {

                let validator = $('#BookTicket').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                $(document).on('submit', '#BookTicket', (function(g) {
                    g.preventDefault();
                    var BookTicketData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: BookTicketData,
                        beforeSend: function() {
                            $('#DisplayItems').addClass("d-none");
                            $('#loadCard').removeClass("d-none");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#DisplayItems').removeClass("d-none");
                            $('#loadCard').addClass("d-none");
                            clearcart();
                            if (TestJson(data) == true) {
                                var BookResponse = JSON.parse(data);
                                if (BookResponse.BookTicket == 1) {
                                    $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Successfully Booked Tickets");
                                    $('#confirmModal').modal('show');
                                    ResetForms();
                                    
                                    getcartData();
                                } else if (BookResponse.BookTicket == 2) {
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
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });
            /* Book tickets */







        });
    </script>


</body>

</html>