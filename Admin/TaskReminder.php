<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'TaskReminder';


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

    <?php


    $findMaxVoucherNo = mysqli_query($con, "SELECT MAX(voucherNo) FROM account_transactions WHERE voucherType = 'RV'");
    foreach ($findMaxVoucherNo as $findMaxVoucherNoResult) {
        $MaxVoucherNo = $findMaxVoucherNoResult['MAX(voucherNo)'] + 1;
    }

    ?>


    <?php include('../MAIN/Modals.php'); ?>
    <?php include('../MAIN/Sidebar.php'); ?>



    <div class="wrapper">

        <!--NAVBAR-->
        <?php include '../MAIN/Navbar.php'; ?>






        <!--CONTENTS-->
        <div class="container mainContents">
            <div class="card card-body main_card mt-5 shadow-lg p-3 mb-5">


                <div class="main_heading d-flex justify-content-between mb-2 shadow p-2">
                    <div>
                        <h3 class="pt-3"> TASK REMINDER </h3>
                    </div>
                </div>

                <?php

                if (isset($_GET['TRID'])) {
                    $TRID = $_GET['TRID'];
                    $getTaskReminderDetails = mysqli_query($con, "SELECT * FROM taskreminder WHERE taskId = '$TRID'");
                    foreach ($getTaskReminderDetails as $getTaskReminderDetailResults) {
                    }
                ?>

                    <form id="UpdateTaskForm" class="UpdateForm px-5" novalidate>
                        <input type="text" id="update_task_id" name="UpdateTaskId" value="<?= $TRID ?>" hidden>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="update_task_name" class="TktcommonFont">Task Name</label>
                                <input type="text" class="form-control" name="UpdateTaskName" id="update_task_name" value="<?= $getTaskReminderDetailResults['taskName'] ?>" required>
                            </div>
                            <div class="col-6">
                                <label for="update_task_date" class="TktcommonFont">Date</label>
                                <input type="date" class="form-control" name="UpdateTaskDate" id="update_task_date" value="<?=  date('Y-m-d', strtotime( $getTaskReminderDetailResults['taskDate'])) ?>" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="update_task_status" class="TktcommonFont">Status</label>
                                <select class="form-select" name="UpdateTaskStatus" id="update_task_status">
                                    <option hidden value="<?= $getTaskReminderDetailResults['taskStatus'] ?>"> <?= $getTaskReminderDetailResults['taskStatus'] ?> </option>
                                    <option value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="update_task_remind_before" class="TktcommonFont">Remind Before</label>
                                <select class="form-select" name="UpdateTaskRemindBefore" id="update_task_remind_before">
                                    <option hidden value="<?= substr($getTaskReminderDetailResults['taskRemindBefore'], 0,2) ?>"> <?= $getTaskReminderDetailResults['taskRemindBefore'] ?> Days </option>
                                    <option value="1">1 Days</option>
                                    <option value="2">2 Days</option>
                                    <option value="3">3 Days</option>
                                    <option value="4">4 Days</option>
                                    <option value="5">5 Days</option>
                                    <option value="6">6 Days</option>
                                    <option value="7">7 Days</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="update_task_phone" class="TktcommonFont">Phone Number</label>
                                <input type="number" class="form-control" name="UpdateTaskPhone" id="update_task_phone" value="<?= $getTaskReminderDetailResults['taskReminderPhone'] ?>">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="update_task_remarks" class="TktcommonFont">Task Remarks</label>
                                <textarea class="form-control" rows="5" name="UpdateTaskRemarks" id="update_task_remarks"><?= $getTaskReminderDetailResults['taskRemark'] ?></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">UPDATE</button>
                        </div>
                    </form>

                <?php

                } else {
                ?>

                    <form id="AddTaskForm" class="AddForm px-5" novalidate>

                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="task_name" class="TktcommonFont">Task Name</label>
                                <input type="text" class="form-control" name="TaskName" id="task_name" required>
                            </div>
                            <div class="col-6">
                                <label for="task_date" class="TktcommonFont">Date</label>
                                <input type="date" class="form-control" name="TaskDate" id="task_date" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="task_status" class="TktcommonFont">Status</label>
                                <select class="form-select" name="TaskStatus" id="task_status">
                                    <option selected value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="task_remind_before" class="TktcommonFont">Remind Before</label>
                                <select class="form-select" name="TaskRemindBefore" id="task_remind_before">
                                    <option selected value="1">1 Days</option>
                                    <option value="2">2 Days</option>
                                    <option value="3">3 Days</option>
                                    <option value="4">4 Days</option>
                                    <option value="5">5 Days</option>
                                    <option value="6">6 Days</option>
                                    <option value="7">7 Days</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="task_phone" class="TktcommonFont">Phone Number</label>
                                <input type="number" class="form-control" name="TaskPhone" id="task_phone">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="task_remarks" class="TktcommonFont">Task Remarks</label>
                                <textarea class="form-control" rows="5" name="TaskRemarks" id="task_remarks"></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">SUBMIT</button>
                        </div>
                    </form>

                <?php
                }

                ?>



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
        $('#re_by').focus();

        $('#btnConfirm').click(function() {
            location.replace('TaskReport.php');
        });



        /* Add master Start */
        $(function() {

            let validator = $('#AddTaskForm').jbvalidator({
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
                if ($(el).is('#task_name') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#AddTaskForm', (function(e) {
                e.preventDefault();
                var TRData = new FormData(this);
                console.log(TRData);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: TRData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#AddTaskForm').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                        $('#btnConfirm').hide();
                        $('#btnClose').show();
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#AddTaskForm').removeClass("disable");
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.AddTask == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Checklist is Already Present");
                                $('#confirmModal').modal('show');
                            } else if (response.AddTask == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Added Task Reminder");
                                $('#confirmModal').modal('show');
                                //$('#btnConfirm').show();
                                $('#btnClose').show();
                                $('#AddTaskForm')[0].reset();
                                ResetForms();
                            } else if (response.AddTask == "2") {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Adding Task Reminder");
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



        /* Update master Start */
        $(function() {

            let validator = $('#UpdateTaskForm').jbvalidator({
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
                if ($(el).is('#update_task_name') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#UpdateTaskForm', (function(e) {
                e.preventDefault();
                var TRUData = new FormData(this);
                console.log(TRUData);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: TRUData,
                    beforeSend: function() {
                        $('#loading').show();
                        $('#UpdateTaskForm').addClass("disable");
                        $('#ResponseImage').html("");
                        $('#ResponseText').text("");
                        $('#btnConfirm').hide();
                        $('#btnClose').show();
                    },
                    success: function(data) {
                        $('#loading').hide();
                        console.log(data);
                        $('#UpdateTaskForm').removeClass("disable");
                        if (TestJson(data) == true) {
                            var response = JSON.parse(data);
                            if (response.UpdateTaskReminder == "0") {
                                $('#ResponseImage').html('<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Checklist is Already Present");
                                $('#confirmModal').modal('show');
                            } else if (response.UpdateTaskReminder == "1") {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Successfully Updated Task Reminder ");
                                $('#confirmModal').modal('show');
                                $('#btnConfirm').show();
                                $('#btnClose').hide();
                                ResetForms();
                            } else if (response.UpdateTaskReminder == "2") {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text("Failed Updating Task Reminder ");
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