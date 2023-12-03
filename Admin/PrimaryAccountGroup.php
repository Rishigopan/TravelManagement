<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'PrimaryAccountGroup';


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





</head>

<body>

    <!-- add / update modal -->
    <div class="modal fade addUpdateModal" id="AccountGroupModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content cntrymodalbg">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ADD PRIMARY ACCOUNT GROUP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="AddForm" id="AddPrimAccntGroup" novalidate>
                        <div>
                            <label for="prim_accnt_name">Primary Account Group Name</label><br>
                            <input type="text" class="form-control mt-3" id="prim_accnt_name" name="PrimAccntName" placeholder="Please enter the primary account group" autofocus required>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">ADD ACCOUNT</button>
                        </div>
                    </form>

                    <form class="UpdateForm" id="UpdatePrimAccntGroup" style="display: none;" novalidate>
                        <div>
                            <label for="update_prim_accnt_name">Primary Account Group Name</label><br>
                            <input type="text" name="UpdatePrimAccntId" id="edit_prim_accnt_id" hidden>
                            <input type="text" class="form-control mt-3" id="update_prim_accnt_name" name="UpdatePrimAccntName" placeholder="Please enter the primary account group" required>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">UPDATE ACCOUNT</button>
                        </div>
                    </form>
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


    <!-- Modal -->
    <div class="modal fade" id="delModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="exampleModalLabel">Delete Confirmation</h5>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">Do you want to delete this primary account group?</h4>
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
                        <h3 class="pt-3">PRIMARY ACCOUNT GROUP</h3>
                    </div>
                    <div class="">
                        <button class="btn AddBtn mt-1" data-bs-toggle="modal" data-bs-target="#AccountGroupModal">Add Primary Account Group</button>
                    </div>
                </div>

                <div class="admintoolbar">
                    <div class="card card-body">
                        <div class="row justify-content-between">
                            <div class="col-lg-4 col-4">
                                <input type="text" class="form-control" id="SearchBar" placeholder="Search by account group">
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
                                <th class="">Primary Account Group</th>
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





    </div>]



    <main id="loading">
        <div id="loadingDiv">
            <img class="img-fluid loaderGif" src="./loader.svg" alt="">
        </div>
    </main>





    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

    <script src="../JS/main.js"></script>


    <script>
        const AddModal = document.getElementById('AccountGroupModal')
        const myInput = document.getElementById('prim_accnt_name')
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


        $(document).ready(function() {


            //data Table
            var MasterTable = $('#MasterTable').DataTable({
                "processing": true,
                //"responsive": true,
                "ajax": "PrimaryAccountGroupData.php",
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
                        data: 'accountgroupName'
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
                        data: 'accountgroupid',
                        searchable: false,
                        orderable: false,
                        "render": function(data, type, row, meta) {
                            if (type == 'display') {
                                //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                                data = '<div class="d-flex justify-content-center me-3">  <button class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"><i class="material-icons">edit</i> </button> <button class="btn btn_actions btn_delete" data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="Delete" value="' + data + '"><i class="material-icons">delete</i> </button>  </div>'
                            }
                            return data;
                        }
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


            /* Add master Start */
            $(function() {

                let validator = $('#AddPrimAccntGroup').jbvalidator({
                    language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#prim_accnt_name') && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]+/)) {
                        return 'Only allowed alphabets';
                    } else if ($(el).is('#prim_accnt_name') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#AddPrimAccntGroup', (function(e) {
                    e.preventDefault();
                    var PrimaryAccountGroupData = new FormData(this);
                    console.log(PrimaryAccountGroupData);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: PrimaryAccountGroupData,
                        beforeSend: function() {
                            $('#loading').show();
                            $('#updatebranch_form').addClass("disable");
                            $('#AccountGroupModal').modal('hide');
                            $('#ResponseImage').html("");
                            $('#ResponseText').text("");
                        },
                        success: function(data) {
                            $('#loading').hide();
                            console.log(data);
                            if (TestJson(data) == true) {
                                var response = JSON.parse(data);
                                if (response.addPrimaryAccountGroup == "0") {
                                    $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Primary Account Group is Already Present");
                                    $('#confirmModal').modal('show');
                                } else if (response.addPrimaryAccountGroup == "1") {
                                    $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Successfully Added Primary Account Group");
                                    $('#confirmModal').modal('show');
                                    $('#testbtn').focus();
                                    ResetForms();
                                    MasterTable.ajax.reload();
                                } else if (response.addPrimaryAccountGroup == "2") {
                                    //$('#BranchModal').modal('hide');
                                    $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Failed Adding Primary Account Group");
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


            /* update master Start */
            $(function() {

                let validator = $('#UpdatePrimAccntGroup').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#update_prim_accnt_name') && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]+/)) {
                        return 'Only allowed alphabets';
                    } else if ($(el).is('#update_prim_accnt_name') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#UpdatePrimAccntGroup', (function(e) {
                    e.preventDefault();
                    var UpdatePrimAccntGroupData = new FormData(this);
                    console.log(UpdatePrimAccntGroupData);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: UpdatePrimAccntGroupData,
                        beforeSend: function() {
                            $('#loading').show();
                            $('#UpdatePrimAccntGroup').addClass("disable");
                            $('#AccountGroupModal').modal('hide');
                            $('#ResponseImage').html("");
                            $('#ResponseText').text("");
                        },
                        success: function(data) {
                            $('#loading').hide();
                            console.log(data);
                            $('#UpdatePrimAccntGroup').removeClass("disable");
                            //console.log(TestJson(data));
                            if (TestJson(data) == true) {
                                var response = JSON.parse(data);
                                if (response.UpdatePrimAccntGroup == "0") {
                                    $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Primary Account Group is Already Present");
                                    $('#confirmModal').modal('show');
                                } else if (response.UpdatePrimAccntGroup == "1") {
                                    $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Successfully Updated Primary Account Group");
                                    $('#confirmModal').modal('show');
                                    ResetForms();
                                    MasterTable.ajax.reload();
                                } else if (response.UpdatePrimAccntGroup == "2") {
                                    //$('#BranchModal').modal('hide');
                                    $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Failed Updating Primary Account Group");
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
                        editPrimaryAccountGroup: editValue
                    },
                    beforeSend: function() {
                        //$('#delModal').modal('hide');
                        $('.UpdateForm').show();
                        $('.AddForm').hide();
                        
                    },
                    success: function(data) {
                        $('#AccountGroupModal').modal('show');
                        console.log(data);
                        var EditResponse = JSON.parse(data);
                        //console.log(EditResponse);
                        if (EditResponse.PrimaryAccountGroupValue == 'Error') {
                            toastr.error("some error occured");
                        } else {
                            $('#update_prim_accnt_name').val(EditResponse.PrimaryAccountGroupName);
                            $('#edit_prim_accnt_id').val(editValue);
                           
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
                                delPrimAccntGroupId: delValue
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
                                    if (delResponse.DeletePrimAccntGroup == 0) {
                                        $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                        $('#ResponseText').text("Primary Account Group is Already in Use");
                                        $('#confirmModal').modal('show');
                                    } else if (delResponse.DeletePrimAccntGroup == 1) {
                                        $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                        $('#ResponseText').text("Successfully Deleted Primary Account Group");
                                        $('#confirmModal').modal('show');
                                        ResetForms();
                                        MasterTable.ajax.reload();
                                    } else if (delResponse.DeletePrimAccntGroup == 2) {
                                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                        $('#ResponseText').text("Failed Deleting Primary Account Group");
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