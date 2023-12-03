<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'ChecklistMaster';


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



<body>

    <!-- add / update modal -->
    <div class="modal fade addUpdateModal" id="ChecklistModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content cntrymodalbg">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ADD CHECKLIST</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="AddForm" id="AddChecklist" novalidate>
                        <div>
                            <label>Country Name</label><br>
                            <select name="CheckCountry" id="checkcountry" class="form-select" required>
                                <option hidden value="">Choose Country</option>
                                <?php
                                $FindCountry = mysqli_query($con, "SELECT cId,countryName FROM country_master");
                                foreach ($FindCountry as $FindCountryResults) {
                                    echo '
                                        <option value="' . $FindCountryResults["cId"] . '">' . $FindCountryResults["countryName"] . '</option>
                                        ';
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="pt-4">Task Name</label><br>
                            <input type="text" class="form-control mt-3" name="ChecklistName" id="chechklist_name" placeholder="Please enter the task name" required>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">SAVE CHECKLIST</button>
                        </div>
                    </form>

                    <form class="UpdateForm" id="UpdateChecklist" style="display: none;" novalidate>
                        <div>
                            <label>Country Name</label><br>
                            <input type="text" name="UpdateChechklistId" id="edit_chechklist_id" hidden>
                            <select name="UpdateCheckCountry" id="update_checkcountry" class="form-select" required>
                                <option hidden value="">Choose Country</option>
                                <?php
                                $FindCountry = mysqli_query($con, "SELECT cId,countryName FROM country_master");
                                foreach ($FindCountry as $FindCountryResults) {
                                    echo '
                                        <option value="' . $FindCountryResults["cId"] . '">' . $FindCountryResults["countryName"] . '</option>
                                        ';
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="pt-4">Task Name</label><br>
                            <input type="text" class="form-control mt-3" name="UpdateChecklistName" id="update_chechklist_name" placeholder="Please enter the task name" required>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">UPDATE CHECKLIST</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">Do you want to delete this checklist?</h4>
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
                        <h3 class="pt-3">CHECKLISTS</h3>
                    </div>
                    <div class="">
                        <button class="btn AddBtn mt-1" data-bs-toggle="modal" data-bs-target="#ChecklistModal">Add Checklist</button>
                    </div>
                </div>

                <div class="admintoolbar">
                    <div class="card card-body">
                        <div class="row justify-content-between">
                            <div class="col-lg-4 col-4">
                                <input type="text" class="form-control" id="SearchBar" placeholder="Search by Country,Task name">
                            </div>
                            <div class="col-lg-4 col-6">
                                <select name="" class="form-select" id="FilterCountry">
                                    <option hidden value="">Country</option>
                                    <?php
                                    foreach ($FindCountry as $FindCountryResults) {
                                        echo '
                                            <option value="' . $FindCountryResults["countryName"] . '">' . $FindCountryResults["countryName"] . '</option>
                                            ';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-4 col-6 text-end">
                                <button class="btn btn_reset px-5"><span>Clear</span></button>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="">
                    <table class="table table-hover mastertable" id="MasterTable" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th class="">Sl No</th>
                                <th class="">Country Name</th>
                                <th class="">Task Name</th>
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





    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

    <script src="../JS/main.js"></script>


    <script>
        const AddModal = document.getElementById('ChecklistModal')
        const myInput = document.getElementById('checkcountry')
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

            $('#FilterCountry').change(function() {
                var CountryFilter = $(this).val();
                //console.log(BranchFilter);
                MasterTable.column(1).search(CountryFilter).draw();
            });

            //reset form function
            $('.btn_reset').click(function() {
                $('.UpdateForm')[0].reset();
                $('.AddForm')[0].reset();
                MasterTable.search('').draw();
                MasterTable.column(1).search('').draw();
                $('#SearchBar').val('');
                $('#FilterCountry').val('').change();
            });


            //data Table
            var MasterTable = $('#MasterTable').DataTable({
                "processing": true,
                //"responsive": true,
                "ajax": "ChecklistMasterData.php",
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
                        data: 'countryName'
                    },
                    {
                        data: 'checklistName'
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
                        data: 'ckId',
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

                let validator = $('#AddChecklist').jbvalidator({
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
                    if ($(el).is('#chechklist_name') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#AddChecklist', (function(e) {
                    e.preventDefault();
                    var ChecklistData = new FormData(this);
                    console.log(ChecklistData);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: ChecklistData,
                        beforeSend: function() {
                            $('#loading').show();
                            $('#AddChecklist').addClass("disable");
                            $('#ChecklistModal').modal('hide');
                            $('#ResponseImage').html("");
                            $('#ResponseText').text("");
                        },
                        success: function(data) {
                            $('#loading').hide();
                            console.log(data);
                            $('#AddChecklist').removeClass("disable");
                            if (TestJson(data) == true) {
                                var response = JSON.parse(data);
                                if (response.addChecklist == "0") {
                                    $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Checklist is Already Present");
                                    $('#confirmModal').modal('show');

                                } else if (response.addChecklist == "1") {
                                    $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Successfully Added Checklist");
                                    $('#confirmModal').modal('show');

                                    ResetForms();
                                    MasterTable.ajax.reload();
                                } else if (response.addChecklist == "2") {
                                    //$('#BranchModal').modal('hide');
                                    $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Failed Adding Checklist");
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

                let validator = $('#UpdateChecklist').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    // if ($(el).is('#update_country_name') && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]+/)) {
                    //     return 'Only allowed alphabets';
                    // } else if ($(el).is('#update_country_name') && $(el).val().trim().length == 0) {
                    //     return 'Cannot be empty';
                    // }

                    if ($(el).is('#update_chechklist_name') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#UpdateChecklist', (function(e) {
                    e.preventDefault();
                    var UpdateChecklistData = new FormData(this);
                    console.log(UpdateChecklistData);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: UpdateChecklistData,
                        beforeSend: function() {
                            $('#loading').show();
                            $('#UpdateChecklist').addClass("disable");
                            $('#ChecklistModal').modal('hide');
                            $('#ResponseImage').html("");
                            $('#ResponseText').text("");
                        },
                        success: function(data) {
                            $('#loading').hide();
                            console.log(data);
                            $('#UpdateChecklist').removeClass("disable");
                            //console.log(TestJson(data));
                            if (TestJson(data) == true) {
                                var response = JSON.parse(data);
                                if (response.UpdateChecklist == "0") {
                                    $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Checklist is Already Present");
                                    $('#confirmModal').modal('show');
                                } else if (response.UpdateChecklist == "1") {
                                    $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Successfully Updated Checklist");
                                    $('#confirmModal').modal('show');
                                    ResetForms();
                                    MasterTable.ajax.reload();
                                } else if (response.UpdateChecklist == "2") {
                                    //$('#BranchModal').modal('hide');
                                    $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                    $('#ResponseText').text("Failed Updating Checklist");
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
                        editChecklist: editValue
                    },
                    beforeSend: function() {
                        //$('#delModal').modal('hide');
                        $('.UpdateForm').show();
                        $('.AddForm').hide();
                    },
                    success: function(data) {
                        $('#ChecklistModal').modal('show');
                        console.log(data);
                        var EditResponse = JSON.parse(data);
                        //console.log(EditResponse);
                        if (EditResponse.CountryValue == 'Error') {
                            toastr.error("some error occured");
                        } else {
                            $('#update_checkcountry').val(EditResponse.CheckCountryId).change();
                            $('#update_chechklist_name').val(EditResponse.ChecklistName);
                            $('#edit_chechklist_id').val(editValue);
                        }
                    }
                });
            });



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
                            url: "MasterOperations.php",
                            data: {
                                delChecklist: delValue
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
                                    if (delResponse.deleteChecklist == 0) {
                                        $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                        $('#ResponseText').text("Checklist is Already in Use");
                                        $('#confirmModal').modal('show');
                                    } else if (delResponse.deleteChecklist == 1) {
                                        $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                        $('#ResponseText').text("Successfully Deleted Checklist");
                                        $('#confirmModal').modal('show');
                                        ResetForms();
                                        MasterTable.ajax.reload();
                                    } else if (delResponse.deleteChecklist == 2) {
                                        $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                        $('#ResponseText').text("Failed Deleting Checklist");
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