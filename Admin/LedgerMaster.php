<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'LedgerMaster';


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



    <!-- Modal -->
    <div class="modal fade" id="delModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">Do you want to delete this item?</h4>
                    <div class="text-center mt-3">
                        <button type="button" id="confirmYes" class="btn btn-primary me-5">Yes</button>
                        <button type="button" id="confirmNo" class="btn btn-secondary ms-5" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include('../MAIN/Modals.php'); ?>
    <?php include('../MAIN/Sidebar.php');  ?>


    <div class="wrapper">

        <!--NAVBAR-->
        <?php include '../MAIN/Navbar.php'; ?>



        <!--CONTENTS-->
        <div class="container mainContents">
            <div class="card card-body main_card mt-5 shadow-lg p-3 mb-5">
                <div class="main_heading d-flex justify-content-between mb-2 shadow p-2">
                    <div>
                        <h3 class="pt-3">LEDGER</h3>
                    </div>
                    <div class="">
                        <button class="btn AddBtn mt-1" data-bs-toggle="modal" data-bs-target="#LedgerModal">Add Ledger</button>
                    </div>
                </div>

                <div class="admintoolbar">
                    <div class="card card-body">
                        <div class="row justify-content-between">
                            <div class="col-lg-4 col-4">
                                <input type="text" class="form-control" id="SearchBar" placeholder="Search by Ledger Name">
                            </div>
                            <div class="col-lg-4 text-end col-4">

                            </div>
                        </div>
                    </div>
                </div>




                <div class="">
                    <table class="table table-hover mastertable" id="MasterTable" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th class="">Sl No</th>
                                <th class="">Ledger Name</th>
                                <th class="">Opening</th>
                                <th class="">Amount</th>
                                <th class="">Created Date</th>
                                <th class="text-center">Actions</th>
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


    <?php include('../MAIN/Footer.php'); ?>



    <script>
        const AddModal = document.getElementById('LedgerModal')
        const myInput = document.getElementById('ledger_name')
        const ConfirmModal = document.getElementById('confirmModal')
        const ConfirmBtn = document.getElementById('btnClose')
        const DeleteModal = document.getElementById('delModal')
        const DeleteBtn = document.getElementById('confirmYes')

        AddModal.addEventListener('shown.bs.modal', () => {
            myInput.focus();
        });

        ConfirmModal.addEventListener('shown.bs.modal', () => {
            ConfirmBtn.focus();
        });

        DeleteModal.addEventListener('shown.bs.modal', () => {
            DeleteBtn.focus();
        });





        //Fetch Primary Account Group
        $('.AccountGroupChange').change(function() {
            var AccountGroupValue = $(this).val();
            $.ajax({
                type: "POST",
                url: "MasterOperations.php",
                data: {
                    AccountGroupValue: AccountGroupValue
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    console.log(data);
                    var FetchAccountIdResponse = JSON.parse(data);
                    //console.log(EditResponse);
                    if (FetchAccountIdResponse.FindPrimaryAccountValue == 'Error') {
                        toastr.error("some error occured");
                    } else {
                        $('.AccountGroupChangeResultID').val(FetchAccountIdResponse.FindPrimaryAccountId);
                        $('.AccountGroupChangeResultName').val(FetchAccountIdResponse.FindPrimaryAccountName);
                    }
                },
                error: function() {
                    $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                    $('#ResponseText').text("Please refresh the page to continue (ERROR : 12EFF)");
                    $('#confirmModal').modal('show');
                }
            });
        });


        //data Table
        var MasterTable = $('#MasterTable').DataTable({
            "processing": true,
            //"responsive": true,
            "ajax": "LedgerMasterData.php",
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
                    data: null,
                    searchable: false,
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            data = '<div> ' + data.firstName + ' ' + data.lastName + ' </div>'
                        }
                        return data;
                    }
                },
                {
                    data: 'openingType'
                },
                {
                    data: 'opening'
                },
                {
                    data: 'createdDate',
                    render: function(data, type, row, meta) {
                        if (type === 'sort') {
                            return data;
                        }
                        return moment(data).format("MMM D , YYYY");
                    },
                    searchable: false
                },
                {
                    data: 'Aid',
                    searchable: false,
                    orderable: false,
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            data = '<div class="d-flex justify-content-center me-3">  <button class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"><i class="material-icons">edit</i> </button> <button class="btn btn_actions btn_delete " data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="Delete" value="' + data + '"><i class="material-icons">delete</i> </button>  </div>'
                        }
                        return data;
                    }
                },
                {
                    data: 'firstName',
                    visible: false
                },
                {
                    data: 'lastName',
                    visible: false
                },
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


      
        /* update master Start */
        $(function() {

            let validator = $('#UpdateLedger').jbvalidator({
                //language: 'dist/lang/en.json',
                successClass: false,
                html5BrowserDefault: true
            });

            validator.validator.custom = function(el, event) {
                if ($(el).is('#update_ledger_name') && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]+/)) {
                    return 'Only allowed alphabets';
                } else if ($(el).is('#update_ledger_name') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#UpdateLedger', (function(e) {
                e.preventDefault();
                var UpdateLedgerData = new FormData(this);
                console.log(UpdateLedgerData);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: UpdateLedgerData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#UpdateLedger').addClass("disable");
                        $('#LedgerModal').modal('hide');
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#UpdateLedger').removeClass("disable");
                        //console.log(TestJson(data));
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.UpdateLedger == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Ledger is Already Present");
                                $('#confirmModal').modal('show');
                            } else if (response.UpdateLedger == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Updated Ledger");
                                $('#confirmModal').modal('show');
                                ReloadTable();
                                ResetForms();
                            } else if (response.UpdateLedger == "2") {
                                //$('#BranchModal').modal('hide');
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Updating Ledger");
                                $('#confirmModal').modal('show');
                            } else if (response.UpdateLedger == "4") {
                                //$('#BranchModal').modal('hide');
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Cannot Update Opening Balance Without Opening Type");
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
        /* update master End */



        //edit master
        $('#MasterTable tbody').on('click', '.btn_edit', function() {
            var editValue = $(this).val();
            console.log(editValue);
            $.ajax({
                type: "POST",
                url: "MasterOperations.php",
                data: {
                    editLedger: editValue
                },
                beforeSend: function() {
                    //$('#delModal').modal('hide');
                    $('.UpdateForm').show();
                    $('.AddForm').hide();
                },
                success: function(data) {
                    $('#LedgerModal').modal('show');
                    console.log(data);
                    var EditResponse = JSON.parse(data);
                    console.log(EditResponse);
                    if (EditResponse.LedgerValue == 'Error') {
                        toastr.error("some error occured");
                    } else {
                        if(EditResponse.DeletePermission == 'NO' || editValue == '10'){
                            $('#update_ledger_name').prop("readonly", true);
                            $('#edit_ledger_account_group').css('pointer-events','none');
                            $('#edit_ledger_account_group').css('background-color', 'lightgrey');
                            //$('#edit_ledger_account_group').prop("readonly", true);
                        }else{
                            $('#update_ledger_name').prop("readonly", false);
                            $('#edit_ledger_account_group').css('pointer-events','');
                            $('#edit_ledger_account_group').css('background-color', 'white');
                            //$('#edit_ledger_account_group').prop("readonly", false);
                        }
                        $('#update_ledger_name').val(EditResponse.LedgerName);
                        $('#update_ledger_open_type').val(EditResponse.LedgerOpenType).change();

                        $('#edit_ledger_account_group').val(EditResponse.LedgerAccountGroupId).change();
                        $('#update_ledger_amount').val(EditResponse.LedgerBalance);
                        $('#update_ledger_primary_account').val(EditResponse.LedgerPrimaryAccountGroupId);
                        $('#update_ledger_primary_account_name').val(EditResponse.LedgerPrimaryAccountGroupName);
                        if(EditResponse.IsProfitLedger == 1){
                            $('#update_is_profit_ledger').prop('checked', true);
                        }else{
                            $('#update_is_profit_ledger').prop('checked', false);
                        }
                        $('#edit_ledger_id').val(editValue);
                    }
                }
            });
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
                            delLedger: delValue
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
                                if (delResponse.deleteLedger == 0) {
                                    $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Ledger is Already in Use");
                                    $('#confirmModal').modal('show');
                                } else if (delResponse.deleteLedger == 1) {
                                    $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Successfully Deleted Ledger");
                                    $('#confirmModal').modal('show');
                                    ReloadTable();
                                    ResetForms();
                                } else if (delResponse.deleteLedger == 2) {
                                    $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Failed Deleting Ledger");
                                    $('#confirmModal').modal('show');
                                }else if (delResponse.deleteLedger == 3) {
                                    $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Cannot Delete this Ledger");
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
    </script>


</body>

</html>