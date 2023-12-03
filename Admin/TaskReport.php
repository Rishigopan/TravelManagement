<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'TaskReport';


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
                    <h4 class="text-center">Do you want to delete this Task Reminder?</h4>
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


        <?php 
        
            if(isset($_GET['TNID'])){
                $TNID = $_GET['TNID'];
            }
            else{
                $TNID = '';
            }
        
        
        ?>


        <!--CONTENTS-->
        <div class="container mainContents">
            <div class="card card-body main_card mt-5 shadow-lg p-3 mb-5">
                <div class="main_heading d-flex justify-content-between mb-2 shadow p-2">
                    <div>
                        <h3 class="pt-3">TASK REMINDER REPORT</h3>
                    </div>
                    <div class="">
                        <a class="btn AddBtn mt-1" href="./TaskReminder.php" >Add
                            Task</a>
                    </div>
                </div>

                <div class="admintoolbar">
                    <div class="card card-body">
                        <div class="row justify-content-between">
                            <div class="col-lg-4 col-4">
                                <input type="text" class="form-control" id="SearchBar" placeholder="Search by Task Name">
                            </div>
                        </div>
                    </div>
                </div>


                

                <div class="">
                    <table class="table table-hover mastertable" id="MasterTable" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th class="all">ID</th>
                                <th class="all">TASK NAME</th>
                                <th class="all">DATE</th>
                                <th class="all">REMARKS</th>
                                <th class="all">STATUS</th>
                                <th class="all">PHONE</th>
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


        //data Table
        var MasterTable = $('#MasterTable').DataTable({
            "processing": true,
            "responsive": true,
            "ajax": "TaskReportData.php",
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
                    data: 'taskName',
                },
                {
                    data: 'taskDate',
                    render: function(data, type, row, meta) {
                        if (type === 'sort') {
                            return data;
                        }
                        return moment(data).format("MMM D , YYYY");
                    },
                    searchable: false
                },
                {
                    data: 'taskRemark',
                },
                {
                    data: 'taskStatus',
                },
                {
                    data: 'taskReminderPhone',
                },
                {
                    data: 'taskId',
                    // searchable: false,
                    orderable: false,
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            data =
                                '<div class="d-flex justify-content-center me-3">  <a class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" href="TaskReminder.php?TRID=' +
                                data +
                                '"><i class="material-icons">edit</i> </a> <button class="btn btn_actions btn_delete" data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="Delete" value="' +
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


        

        function ShowTaskResult(searchvalue){
            var SearchValue = searchvalue;
            MasterTable.column(6).search(SearchValue).draw();
        }


        var TNID = '<?php echo $TNID; ?>';
        if(TNID == ''){
            //console.log(TNID);
        }
        else{
            ShowTaskResult(TNID);
            //console.log(TNID);
        }


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
                            delTask: delValue
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
                                if (delResponse.deleteTask == 0) {
                                    $('#ResponseImage').html(
                                        '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                    );
                                    $('#ResponseText').text(
                                        "This Task Reminder is Already in Use");
                                    $('#confirmModal').modal('show');
                                } else if (delResponse.deleteTask == 1) {
                                    $('#ResponseImage').html(
                                        '<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                    );
                                    $('#ResponseText').text(
                                        "Successfully Deleted Task Reminder");
                                    $('#confirmModal').modal('show');
                                    ResetForms();
                                    MasterTable.ajax.reload();
                                } else if (delResponse.deleteTask == 2) {
                                    $('#ResponseImage').html(
                                        '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                                    );
                                    $('#ResponseText').text("Failed Deleting Task Reminder");
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