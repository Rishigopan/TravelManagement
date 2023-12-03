<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';


$NewTitle = 'DataPurge';

$dateToday = date('Y-m-d');


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

    <?php include('../MAIN/Modals.php'); ?>


    <?php include('../MAIN/Sidebar.php');  ?>

    <div class="wrapper">

        <!--NAVBAR-->
        <?php include '../MAIN/Navbar.php'; ?>

        <!--CONTENTS-->
        <div class="container mainContents">
            <div class="card card-body main_card mt-5 shadow-lg p-3 mb-5">

                <div class="row justify-content-center">
                    <div class="col-6 text-center">
                        <h1 class="text-center mt-2">ENTER THE PASSWORD TO CLEAR ALL DATA</h1>
                        <form id="DataPurgeForm">
                            <input class="form-control py-3 mt-4" type="text" id="data_purge_password">
                            <button class="btn btn-danger py-3 mt-4"> Clear All Data </button>
                        </form>
                    </div>
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
        $('#DataPurgeForm').submit(function(e) {
            e.preventDefault();
            var DataPurgePassword = $('#data_purge_password').val();
            if (DataPurgePassword.trim() != '') {
                if (confirm("Are you sure, you want to clear all data?") == true) {
                    var DataPurge = 'fetch_data';
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: {
                            DataPurge: DataPurge,
                            DataPurgePassword: DataPurgePassword,
                        },
                        beforeSend: function() {
                            $('#loading').show();
                            $('#ResponseImage').html("");
                            $('#ResponseText').text("");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#loading').hide();
                            $('#confirmModal').modal('show');
                            var Response = JSON.parse(data);
                            if (Response.Status == 1) {
                                $('#ResponseImage').html('<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text(Response.Message);
                            } else if (Response.Status == 2) {
                                $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                                $('#ResponseText').text(Response.Message);
                                $('#confirmModal').modal('show');
                            }
                        },
                        error: function() {
                            $('#ResponseImage').html('<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">');
                            $('#ResponseText').text("Please refresh the page to continue (ERROR : 12EFF)");
                            $('#confirmModal').modal('show');
                        }
                    });
                } else {}
            }
        });
    </script>


</body>

</html>