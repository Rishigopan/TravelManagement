<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'VoucherReport';


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
                    <h4 class="text-center">Do you want to Delete this Voucher?</h4>
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
                    <div>
                        <h3 class="pt-3">VOUCHER REPORT</h3>
                    </div>

                </div>


                <div class="admintoolbar">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-lg-4 col-4">
                                <input type="text" class="form-control" id="SearchBar" placeholder="Search by To,By,Remarks">
                            </div>
                            <div class="col-lg-4 col-6">
                                <select name="" class="form-select" id="FilterVoucher">
                                    <option value="PV">Payment Voucher</option>
                                    <option value="RV">Receipt Voucher</option>
                                </select>
                            </div>


                            <div class="col-lg-4 col-6 text-end">
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
                                <th class="all">Voucher No</th>
                                <th class="all">Date</th>
                                <th class="all">TO</th>
                                <th class="all">BY</th>
                                <th class="all">Amount</th>
                                <th class="all">Remark</th>
                                <th class="all">Voucher Type</th>
                                <th class="all">Actions</th>
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

            //reset form function
            $('.btn_reset').click(function() {
                MasterTable.search('').draw();
                MasterTable.column(7).search('PV').draw();
                $('#SearchBar').val('');
                $('#FilterVoucher').val('PV').change();
            });



            $('#FilterVoucher').change(function() {
                var VoucherFilter = $(this).val();
                // //console.log(VoucherFilter);
                MasterTable.column(7).search(VoucherFilter).draw();
            });


            //data Table
            var MasterTable = $('#MasterTable').DataTable({
                "processing": true,
                "responsive": true,
                "ajax": "VoucherReportData.php",
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
                        data: 'toAmount',
                        searchable: false,
                        render: function (data, type, row, meta) { 
                            return parseFloat(data).toLocaleString('en-IN');
                        }
                    },
                    {
                        data: 'remarks'
                    },
                    {
                        data: 'voucherType'
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        "render": function(data, type, row, meta) {

                            if (data.voucherType == 'PV') {
                                data = '<div class="d-flex justify-content-center me-3">  <a class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" href="PaymentVoucher.php?PVID=' + data.acctId + '" "><i class="material-icons">edit</i> </a> <button class="btn btn_actions btn_delete" data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="Delete" value="' + data.voucherNo + '"><i class="material-icons">delete</i> </button>  </div>'
                            } else {
                                data = '<div class="d-flex justify-content-center me-3">  <a class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" href="ReceiptVoucher.php?RVID=' + data.acctId + '" "><i class="material-icons">edit</i> </a> <button class="btn btn_actions btn_delete" data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="Delete" value="' + data.voucherNo + '"><i class="material-icons">delete</i> </button>  </div>'
                            }
                            return data;
                        }
                    },

                ]
            });


            //Searchbar
            $('#SearchBar').keyup(function() {
                MasterTable.search($(this).val()).draw();
            });


            //Load Payment voucher on start
            MasterTable.column(7).search('PV').draw();

            //delete master
            $('#MasterTable tbody').on('click', '.btn_delete', function() {
                var delValue = $(this).val();
                console.log(delValue);
                $('#delModal').modal('show');
                $('#confirmYes').focus();
                $('#confirmYes').click(function() {
                    if (delValue != null) {
                        $.ajax({
                            type: "POST",
                            url: "VoucherOperations.php",
                            data: {
                                VoucherDelete: delValue
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
                                    var delResponse = JSON.parse(data);
                                    if (delResponse.DeletePaymentVoucher == 0) {
                                        $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                        $('#ResponseText').text("Voucher is Already in Use");
                                        $('#confirmModal').modal('show');
                                    } else if (delResponse.DeletePaymentVoucher == 1) {
                                        $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                        $('#ResponseText').text("Successfully Deleted Voucher");
                                        $('#confirmModal').modal('show');
                                        MasterTable.ajax.reload();
                                    } else if (delResponse.DeletePaymentVoucher == 2) {
                                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                        $('#ResponseText').text("Failed Deleting Voucher");
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
                    } else {

                    }
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