<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'AgencyMaster';


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
                    <h4 class="text-center">Do you want to delete this Agency?</h4>
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
        </nav><?php include '../MAIN/Navbar.php'; ?>




        <!--CONTENTS-->
        <div class="container mainContents">
            <div class="card card-body main_card mt-5 shadow-lg p-3 mb-5">
                <div class="main_heading d-flex justify-content-between mb-2 shadow p-2">
                    <div>
                        <h3 class="pt-3">AGENCY</h3>
                    </div>
                    <div class="">
                        <button class="btn AddBtn mt-1" data-bs-toggle="modal" data-bs-target="#SupplierModal">Add
                            Agency</button>
                    </div>
                </div>

                <div class="admintoolbar">
                    <div class="card card-body">
                        <div class="row justify-content-between">
                            <div class="col-lg-4 col-4">
                                <input type="text" class="form-control" id="SearchBar" placeholder="Search by Name,Phone,location,GST">
                            </div>
                        </div>
                    </div>
                </div>




                <div class="">
                    <table class="table table-hover mastertable" id="MasterTable" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th class="all">Sl NO</th>
                                <th class="all">NAME</th>
                                <th class="d-none">NAME</th>
                                <th class="d-none">NAME</th>
                                <th class="all">PHONE</th>
                                <th class="none">EMAIL</th>
                                <th class="none">GST</th>
                                <th class="all">LOCATION</th>
                                <th class="none">ADDRESS</th>
                                <th class="all">OPENING</th>
                                <th class="all">TYPE</th>
                                <th class="text-center all">ACTIONS</th>
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
        const AddModal = document.getElementById('SupplierModal')
        const myInput = document.getElementById('sup_first')
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


        //data Table
        var MasterTable = $('#MasterTable').DataTable({
            "processing": true,
            "responsive": true,
            "ajax": "SupplierMasterData.php",
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
                        data = '<div class="ps-3">' + (meta.row + meta.settings._iDisplayStart +
                            1) + '</div>'
                        //return meta.row + meta.settings._iDisplayStart + 1;
                        return data;
                    }
                },
                {
                    data: null,
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            data = '<div>' + data.firstName + ' ' + data.lastName + '</div>'
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
                {
                    data: 'phone'
                },
                {
                    data: 'email'
                },
                {
                    data: 'GST'
                },
                {
                    data: 'location'
                },
                {
                    data: 'address'
                },
                {
                    data: 'opening'
                },
                {
                    data: 'openingType'
                },
                {
                    data: 'Aid',
                    searchable: false,
                    orderable: false,
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            data =
                                '<div class="d-flex justify-content-center me-3">  <button class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' +
                                data +
                                '"><i class="material-icons">edit</i> </button> <button class="btn btn_actions btn_delete" data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="Delete" value="' +
                                data +
                                '"><i class="material-icons">delete</i> </button>  </div>'
                        }
                        return data;
                    }
                }
            ]
        });


        //tooltip on table
        MasterTable.on('draw', function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
                tooltipTriggerEl));
        });


        //Searchbar
        $('#SearchBar').keyup(function() {
            MasterTable.search($(this).val()).draw();
        });


        // /* Add master Start */
        // $(function() {

        //     let validator = $('#AddSupplier').jbvalidator({
        //         language: 'dist/lang/en.json',
        //         successClass: false,
        //         html5BrowserDefault: true
        //     });

        //     validator.validator.custom = function(el, event) {
        //         /* if ($(el).is('#country_name') && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]+/)) {
        //             return 'Only allowed alphabets';
        //         } else if ($(el).is('#country_name') && $(el).val().trim().length == 0) {
        //             return 'Cannot be empty';
        //         } */
        //         if ($(el).is('#sup_first,#sup_phone,#sup_gst,#sup_location') && $(el).val().trim().length == 0) {
        //             return 'Cannot be empty';
        //         }
        //     }

        //     $(document).on('submit', '#AddSupplier', (function(e) {
        //         e.preventDefault();
        //         var SupplierData = new FormData(this);
        //         console.log(SupplierData);
        //         $.ajax({
        //             type: "POST",
        //             url: "MasterOperations.php",
        //             data: SupplierData,
        //             beforeSend: function() {
        //                 $('#loading').show();
        //                 $('#AddSupplier').addClass("disable");
        //                 $('#SupplierModal').modal('hide');
        //                 $('#ResponseImage').html("");
        //                 $('#ResponseText').text("");
        //             },
        //             success: function(data) {
        //                 $('#loading').hide();
        //                 console.log(data);
        //                 $('#AddSupplier').removeClass("disable");
        //                 if (TestJson(data) == true) {
        //                     var response = JSON.parse(data);
        //                     if (response.addSupplier == "0") {
        //                         $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
        //                         $('#ResponseText').text("Agency is Already Present");
        //                         $('#confirmModal').modal('show');
        //                     } else if (response.addSupplier == "1") {
        //                         $('#ResponseImage').html(
        //                             '<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
        //                         );
        //                         $('#ResponseText').text(
        //                             "Successfully Added Agency");
        //                         $('#confirmModal').modal('show');
        //                         ResetForms();
        //                         MasterTable.ajax.reload();
        //                     } else if (response.addSupplier == "2") {
        //                         //$('#BranchModal').modal('hide');
        //                         $('#ResponseImage').html(
        //                             '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
        //                         );
        //                         $('#ResponseText').text(
        //                             "Failed Adding Supplier");
        //                         $('#confirmModal').modal('show');
        //                     } else if (response.addSupplier == "4") {
        //                         //$('#BranchModal').modal('hide');
        //                         $('#ResponseImage').html(
        //                             '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
        //                         );
        //                         $('#ResponseText').text(
        //                             "Please Choose Opening Type First");
        //                         $('#confirmModal').modal('show');
        //                     }
        //                 } else {
        //                     $('#ResponseImage').html(
        //                         '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
        //                     );
        //                     $('#ResponseText').text(
        //                         "Some Error Occured, Please refresh the page (ERROR : 12ENJ)"
        //                     );
        //                     $('#confirmModal').modal('show');
        //                 }
        //             },
        //             error: function() {
        //                 $('#ResponseImage').html(
        //                     '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
        //                 );
        //                 $('#ResponseText').text(
        //                     "Please refresh the page to continue (ERROR : 12EFF)"
        //                 );
        //                 $('#confirmModal').modal('show');
        //             },
        //             cache: false,
        //             contentType: false,
        //             processData: false
        //         });
        //     }));

        // });
        // /* Add master  End */


        /* update master Start */
        $(function() {

            let validator = $('#UpdateSupplier').jbvalidator({
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

                if ($(el).is('#update_sup_first') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#UpdateSupplier', (function(e) {
                e.preventDefault();
                var UpdateSuppliertData = new FormData(this);
                console.log(UpdateSuppliertData);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: UpdateSuppliertData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#UpdateSupplier').addClass("disable");
                        $('#SupplierModal').modal('hide');
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#UpdateSupplier').removeClass("disable");
                        //console.log(TestJson(data));
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.UpdateSupplier == "0") {
                                $('#ResponseImage').html(
                                    '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                                $('#ResponseText').text(
                                    "Agency is Already Present");
                                $('#confirmModal').modal('show');
                            } else if (response.UpdateSupplier == "1") {
                                $('#ResponseImage').html(
                                    '<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                                $('#ResponseText').text(
                                    "Successfully Updated Agency");
                                $('#confirmModal').modal('show');
                                ResetForms();
                                MasterTable.ajax.reload();
                            } else if (response.UpdateSupplier == "2") {
                                //$('#BranchModal').modal('hide');
                                $('#ResponseImage').html(
                                    '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                                $('#ResponseText').text(
                                    "Failed Updating Agency");
                                $('#confirmModal').modal('show');
                            } else if (response.UpdateSupplier == "4") {
                                //$('#BranchModal').modal('hide');
                                $('#ResponseImage').html(
                                    '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                                $('#ResponseText').text(
                                    "Cannot Update Opening Balance Without Opening Type");
                                $('#confirmModal').modal('show');
                            }
                        } else {
                            $('#ResponseImage').html(
                                '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                            );
                            $('#ResponseText').text(
                                "Some Error Occured, Please refresh the page (ERROR : 12ENJ)"
                            );
                            $('#confirmModal').modal('show');
                        }
                    },
                    error: function() {
                        $('#ResponseImage').html(
                            '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $('#ResponseText').text(
                            "Please refresh the page to continue (ERROR : 12EFF)"
                        );
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
                    editSupplier: editValue
                },
                beforeSend: function() {
                    //$('#delModal').modal('hide');
                    $('.UpdateForm').show();
                    $('.AddForm').hide();
                },
                success: function(data) {
                    $('#SupplierModal').modal('show');
                    console.log(data);
                    var EditResponse = JSON.parse(data);
                    //console.log(EditResponse);
                    if (EditResponse.SupplierValue == 'Error') {
                        toastr.error("some error occured");
                    } else {
                        $('#update_sup_first').val(EditResponse.SupplierFirst);
                        $('#update_sup_last').val(EditResponse.SupplierLast);
                        $('#update_sup_phone').val(EditResponse.SupplierPhone);
                        $('#update_sup_email').val(EditResponse.SupplierEmail);
                        $('#update_sup_gst').val(EditResponse.SupplierGST);
                        $('#update_sup_location').val(EditResponse.SupplierLocation);
                        $('#update_sup_address').val(EditResponse.SupplierAddress);
                        $('#update_sup_open_type').val(EditResponse.SupplierOpenType)
                            .change();
                        $('#update_sup_open').val(EditResponse.SupplierOpening);
                        $('#edit_supplier_id').val(editValue);
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
                            delSupplier: delValue
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
                                if (delResponse.deleteSupplier == 0) {
                                    $('#ResponseImage').html(
                                        '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                    );
                                    $('#ResponseText').text(
                                        "This Agency is Already in Use");
                                    $('#confirmModal').modal('show');
                                } else if (delResponse.deleteSupplier == 1) {
                                    $('#ResponseImage').html(
                                        '<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                    );
                                    $('#ResponseText').text(
                                        "Successfully Deleted Agency");
                                    $('#confirmModal').modal('show');
                                    ResetForms();
                                    MasterTable.ajax.reload();
                                } else if (delResponse.deleteSupplier == 2) {
                                    $('#ResponseImage').html(
                                        '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                    );
                                    $('#ResponseText').text("Failed Deleting Agency");
                                    $('#confirmModal').modal('show');
                                }
                                delValue = undefined;
                                delete window.delValue;
                            } else {
                                $('#ResponseImage').html(
                                    '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                );
                                $('#ResponseText').text(
                                    "Some Error Occured, Please refresh the page (ERROR : 12ENJ)"
                                );
                                $('#confirmModal').modal('show');
                            }
                        },
                        error: function() {
                            $('#ResponseImage').html(
                                '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                            );
                            $('#ResponseText').text(
                                "Please refresh the page to continue (ERROR : 12EFF)"
                            );
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