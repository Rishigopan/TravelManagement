<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'AccountTransactions';


if(isset($_SESSION['custname']) && isset($_SESSION['custtype'])){

    if($_SESSION['custtype'] == 'SuperAdmin' || $_SESSION['custtype'] == 'Admin'){

    }
    else{
        header("location:../login.php");
    }

}
else{

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
    $FindCareOf = mysqli_query($con, "SELECT atId,firstName,lastName FROM accounts WHERE accountType = 'CUSTOMER'");
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
        <nav class="navbar fixed-top navbar-expand-lg bg-light p-1">
            <div class="container-fluid px-xl-5">
                <button class="btn btn-menu rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"> <i class="material-icons">menu</i> <span class="d-md-inline-block d-none"> Menu </span></button>
                <a class="navbar-brand" href="#"> <strong>BETA</strong> </a>
                <button class="btn btn-menu  rounded-pill"> <span class="d-md-inline-block d-none"> <?php echo $_SESSION['custname']; ?> </span> <i class="material-icons">account_circle</i> </button>

            </div>
        </nav>






        <!--CONTENTS-->
        <div class="container mainContents">
            <div class="card card-body main_card mt-5 shadow-lg p-3 mb-5">
                <div class="main_heading d-flex justify-content-between mb-2 shadow p-2">
                    <div>
                        <h3 class="pt-3">ACCOUNT TRANSACTIONS</h3>
                    </div>

                </div>

                




                <div class="">
                    <table class="table table-hover mastertable text-nowrap" id="MasterTable" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th class="all">Sl No</th>
                                <th class="all">Transaction Id</th>
                                <th class="all">Voucher No</th>
                                <th class="all">Date</th>
                                <th class="all">TO</th>
                                <th class="all">BY</th>
                                <th class="all">Amount</th>
                                <th class="all">Remark</th>
                                <th class="all">Voucher Type</th>
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
      


        $(document).ready(function() {


            //data Table
            var MasterTable = $('#MasterTable').DataTable({
                "processing": true,
                "responsive": true,
                "ajax": "AccountTransactionData.php",
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
                        data: 'acctId'
                    },
                    {
                        data: 'voucherNo'
                    },
                    {
                        data: 'voucherDate',
                        render: function(data, type, row, meta) {
                            if (type === 'sort') {
                                return data;
                            }
                            return moment(data).format("MMM D , YYYY");
                        }
                    },
                    {
                        data: 'ATO'
                    },
                    {
                        data: 'ABY'
                    },
                    {
                        data: 'toAmount'
                    },
                    {
                        data: 'remarks'
                    },
                    {
                        data: 'voucherType'
                    },
                    
                ]
            });


          


           
        });
    </script>


</body>

</html>