<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'DummyTicketBookingReport';


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


    <?php
    $FindCountry = mysqli_query($con, "SELECT countryName FROM country_master");
    $FindCareOf = mysqli_query($con, "SELECT Aid,firstName,lastName FROM accounts WHERE accountType = 'CUSTOMER'");
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
                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">Do you want to Delete this Ticket Booking?</h4>
                    <div class="text-center mt-3">
                        <button type="button" id="confirmYes" class="btn btn-primary me-5">Yes</button>
                        <button type="button" id="confirmNo" class="btn btn-secondary ms-5" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Cancellation Modal -->
    <div class="modal fade" id="delModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancel Ticket</h5>
                </div>
                <div class="modal-body">
                    <form id="TicketCancelForm py-5">
                        <h5 class="text-center">Do you want to cancel this Ticket Booking?</h5>
                        <div class="row mt-5 mx-3">
                            <div class="col-md-6">
                                <label for="agency_penalty" class="form-label">Agency Penalty</label>
                                <input class="form-control" id="agency_penalty" name="AgencyPenalty">
                            </div>
                            <div class="col-md-6">
                                <label for="our_penalty" class="form-label">Our Penalty</label>
                                <input class="form-control" id="our_penalty" name="OurPenalty">
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <button type="submit" id="confirmYes" class="btn btn-primary me-5">Confirm Cancel</button>
                        </div>
                    </form>
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
                        <h3 class="pt-3">DUMMY TICKET REPORT </h3>
                    </div>

                </div>

                <div class="admintoolbar">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-lg-6 col-4">
                                <input type="text" class="form-control" id="SearchBar" placeholder="Search by Passenger name,gender">
                            </div>
                            <div class="col-lg-3 col-6">
                                <select name="" class="form-select" id="FilterCareOf">
                                    <option hidden value="">Care Of</option>
                                    <?php
                                    foreach ($FindCareOf as $FindCareOfResults) {
                                        echo '
                                            <option value="' . $FindCareOfResults["Aid"] . '">' . $FindCareOfResults["firstName"] . ' ' . $FindCareOfResults["lastName"] . '</option>
                                            ';
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- <div class="col-lg-3 col-6">
                                <select name="" class="form-select" id="FilterType">
                                    <option hidden value="">Type</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Group">Group</option>
                                </select>
                            </div> -->
                            <div class="col-lg-3 col-6">
                                <select name="" class="form-select" id="FilterCountry">
                                    <option hidden value="">Destination</option>
                                    <?php
                                    foreach ($FindCountry as $FindCountryResults) {
                                        echo '
                                            <option value="' . $FindCountryResults["countryName"] . '">' . $FindCountryResults["countryName"] . '</option>
                                            ';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-4 mt-2">
                                <label for="min" class="d-flex m-0">
                                    <!-- <span class="mt-1">From</span> -->
                                    <input type="text" class="form-control dateSelect" id="min" name="min" readonly placeholder="Date From">
                                </label>
                            </div>
                            <div class="col-lg-3 col-4 mt-2">
                                <label for="max" class="d-flex m-0">
                                    <!-- <span class="mt-1">To</span> -->
                                    <input type="text" class="form-control dateSelect" id="max" name="max" readonly placeholder="Date To">
                                </label>
                            </div>
                            <div class="col-lg-6 col-6 mt-2 text-end">
                                <button class="btn btn_reset px-5"><span>Clear</span></button>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="">
                    <table class="table table-hover mastertable text-nowrap" id="MasterTable" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th class="all">Sl No</th>
                                <th class="all">Passenger</th>
                                <th class="all">From</th>
                                <th class="all">To</th>
                                <th class="all">Departure</th>
                                <th class="all">Care of</th>
                                <th class="none">Phone</th>
                                <th class="none">ID Proof</th>
                                <th class="none">ID Proof No</th>
                                <th class="none">AO No</th>
                                <th class="none">Agency</th>
                                <th class="none">Agency Amount</th>
                                <th class="all">Amount</th>
                                <!-- <th class="text-center all">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>

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
        const ConfirmModal = document.getElementById('confirmModal')
        const ConfirmBtn = document.getElementById('btnClose')
        const DeleteModal = document.getElementById('delModal')
        const DeleteBtn = document.getElementById('confirmYes')


        ConfirmModal.addEventListener('shown.bs.modal', () => {
            ConfirmBtn.focus();
        });

        DeleteModal.addEventListener('shown.bs.modal', () => {
            DeleteBtn.focus();
        });




        $(document).ready(function() {

            $('#FilterCountry').change(function() {
                var CountryFilter = $(this).val();
                //console.log(CountryFilter);
                MasterTable.column(3).search(CountryFilter).draw();
            });

            $('#FilterCareOf').change(function() {
                var CareOfFilter = $(this).val();
                //console.log(CareOfFilter);
                MasterTable.column(14).search(CareOfFilter).draw();
            });

            //reset form function
            $('.btn_reset').click(function() {
                location.reload();
            });



            var minDate, maxDate;

            // Custom filtering function which will search data in column four between two values
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min_date = document.getElementById("min").value;
                    var min = new Date(min_date);
                    //console.log(min);
                    var max_date = document.getElementById("max").value;
                    var max = new Date(max_date);

                    var startDate = new Date(data[4]);
                    //window.confirm(startDate);
                    if (!min_date && !max_date) {
                        return true;
                    }
                    if (!min_date && startDate <= max) {
                        return true;
                    }
                    if (!max_date && startDate >= min) {
                        return true;
                    }
                    if (startDate <= max && startDate >= min) {
                        return true;
                    }
                    return false;
                }
            );


            // Create date inputs
            minDate = new DateTime($('#min'), {
                format: 'M/D/YYYY'
            });
            maxDate = new DateTime($('#max'), {
                format: 'M/D/YYYY'
            });


            // Refilter the table
            $('#min, #max').on('change', function() {
                MasterTable.draw();
            });



            //data Table
            var MasterTable = $('#MasterTable').DataTable({
                "processing": true,
                "responsive": true,
                "ajax": "DummyTicketReportData.php?DummyTicket",
                "scrollY": "600px",
                "scrollX": true,
                "scrollCollapse": true,
                "fixedHeader": true,
                "dom": 'rt<"bottom"ip>',
                "pageLength": 10,
                "pagingType": 'simple_numbers',
                "language": {
                    "paginate": {
                        "previous": "<i class='bi bi-caret-left-fill'></i>",
                        "next": "<i class='bi bi-caret-right-fill'></i>"
                    }
                },
                "columns": [{
                        data: null,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            data = '<div class="ps-3">' + (meta.row + meta.settings._iDisplayStart + 1) + '</div>'
                            //return meta.row + meta.settings._iDisplayStart + 1;
                            return data;
                        }
                    },
                    {
                        data: 'tPassenger'
                    },
                    {
                        data: 'CFNAME'
                    },
                    {
                        data: 'CTNAME'
                    },
                    {
                        data: 'tDeparture',
                        render: function(data, type, row, meta) {
                            if (type === 'sort') {
                                return data;
                            }
                            return moment(data).format("MMM D , YYYY");
                        }
                    },
                    {
                        data: null,
                        "render": function(data, type, row, meta) {
                            if (type == 'display') {

                                data = '<div> ' + data.CAREFIRST + ' ' + data.CARELAST + ' </div>'
                            }
                            return data;
                        }
                    },
                    {
                        data: 'tPhone'
                    },
                    {
                        data: 'tProof'
                    },
                    {
                        data: 'tProofNo'
                    },
                    {
                        data: 'tAoNumber'
                    },
                    {
                        data: null,
                        "render": function(data, type, row, meta) {
                            if (type == 'display') {
                                if(data.AGENCYFIRST == null){
                                    data = 'SELF'
                                }else{
                                    data = '<span> ' + data.AGENCYFIRST + ' ' + data.AGENCYLAST + ' </span>'
                                }
                            }else{
                                data = 'SELF'
                            }
                            return data;
                        }
                    },
                    {
                        data: 'tAgencyamount',
                        "searchable": false,
                        render: function(data, type, row, meta) {
                            return parseFloat(data).toLocaleString('en-IN');
                        }
                    },
                    {
                        data: 'tAmount',
                        "searchable": false,
                        render: function(data, type, row, meta) {
                            return parseFloat(data).toLocaleString('en-IN');
                        }
                    },
                    // {
                    //     data: 'tbId',
                    //     searchable: false,
                    //     orderable: false,
                    //     "render": function(data, type, row, meta) {
                    //         if (type == 'display') {
                    //             //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                    //             // data = '<div class="d-flex justify-content-center me-3">  <a class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" href="DummyTicketUpdate.php?ticId=' + data + '"><i class="material-icons">edit</i> </a> <button class="btn btn_actions btn_delete" data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="Delete" value="' + data + '"><i class="material-icons">delete</i> </button>  </div>'

                    //             // data = '<div class="d-flex justify-content-center me-3">  <a class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" href="DummyTicketUpdate.php?ticId=' + data + '"><i class="material-icons">edit</i> </a>  </div>'
                    //         }
                    //         return data;
                    //     }
                    // },
                    {
                        data: 'CAREID',
                        visible: false
                    }
                ]
            });


            //tooltip on table
            MasterTable.on('draw', function() {
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
            });


            //Searchbar
            $('#SearchBar').keyup(function() {
                MasterTable.search($(this).val()).draw();
            });



            //delete master
            $('#MasterTable tbody').on('click', '.btn_delete', function() {
                var delValue = $(this).val();
                console.log(delValue);
                $('#delModal').modal('show');
                $('#confirmYes').click(function() {
                    if (delValue != null) {
                        $.ajax({
                            type: "POST",
                            url: "MasterOperations.php",
                            data: {
                                CDummyTicket: delValue
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
                                if (TestJson(data) == true) {
                                    var CancelReponse = JSON.parse(data);
                                    if (CancelReponse.CancelTicket == 0) {
                                        $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                        $('#ResponseText').text("Time Limit For This Ticket Expired");
                                        $('#confirmModal').modal('show');
                                    } else if (CancelReponse.CancelTicket == 1) {
                                        $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                        $('#ResponseText').text("Successfully Cancelled Ticket");
                                        $('#confirmModal').modal('show');
                                        MasterTable.ajax.reload();
                                    } else if (CancelReponse.CancelTicket == 2) {
                                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                        $('#ResponseText').text("Failed Cancelling Ticket");
                                        $('#confirmModal').modal('show');
                                    }
                                    delValue = undefined;
                                    delete window.delValue;
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
                        });
                    } else {}
                });
                $('#confirmNo').click(function() {
                    delValue = undefined;
                    delete window.delValue;
                });
            });


        });
    </script>


</body>

</html>