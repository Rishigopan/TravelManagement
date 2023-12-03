<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

$NewTitle = 'Dashboard';


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




    <?php include('../MAIN/Header.php'); ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    <style>
        
        body {
            background: url('../IMAGES/backgroundForest.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

    </style>



</head>

<body>



    <?php include('../MAIN/Modals.php'); ?>

    <?php include('../MAIN/Sidebar.php'); ?>





    <div class="wrapper">

        <!--NAVBAR-->
        <?php include '../MAIN/Navbar.php'; ?>


        <!--CONTENTS-->
        <div class="container mainContents">
            <div id="admin" class="about-area area-padding">
                <div class="container px-4 main-content mt-4">

                    <div class="row dashboard_row">

                        <div class="col-lg-3 col-md-6 mt-4 mt-lg-2">
                            <div class="card card-body dashboard_card shadow">
                                <h1><i class="bi bi-ticket-perforated-fill"></i></h1>
                                <h1>
                                    <strong id="TicketAmount">
                                       
                                    </strong>
                                </h1>
                                <p class="mt-2"> <strong>Ticket Booking</strong> </p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mt-4 mt-lg-2">
                            <div class="card card-body dashboard_card shadow">
                                <h1><i class="bi bi-airplane-engines-fill"></i></h1>
                                <h1>
                                    <strong id="VisaAmount">

                                    </strong>
                                </h1>
                                <p class="mt-2"> <strong>Visa Booking</strong> </p>
                            </div>
                        </div>


                        <div class="col-lg-3 col-md-6 mt-4 mt-lg-2">
                            <div class="card card-body dashboard_card shadow">
                                <h1><i class="bi bi-bank2"></i></h1>
                                <h1>
                                    <strong id="PortalAmount">

                                    </strong>
                                </h1>
                                <p class="mt-2"> <strong>Portal Balance</strong> </p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mt-4 mt-lg-2">
                            <div class="card card-body dashboard_card shadow">
                                <h1><i class="bi bi-currency-rupee"></i></h1>
                                <h1>
                                    <strong id="ProfitAmount">

                                    </strong>
                                </h1>
                                <p class="mt-2"> <strong>Profit</strong> </p>
                            </div>
                        </div>



                        <!-- Profit Chart -->
                        <div class="col-md-8 col-lg-8 col-12 mt-5">
                            <div class="card-body dashboard_card shadow bg-white">
                                <h5 class="text-center cardTitle"> <strong>Profit Chart</strong> </h5>
                                <div class="charts">
                                    <canvas id="mylineChart" width="" height="320px"></canvas>
                                </div>
                                <?php


                                $new_label_sales = '0,0,0,0,0,0,0';
                                $new_data_sales = '0,0,0,0,0,0,0';

                                ?>

                            </div>
                        </div>


                        <!--Member Approval Status-->
                        <div class="col-md-4 col-lg-4 col-12 mt-5">
                            <div class="card-body dashboard_card shadow bg-white">


                                <div class="px-3 d-flex justify-content-between">
                                    <div class="">

                                        <h5 class="text-center cardTitle"> <strong>Summary</strong> </h5>

                                    </div>

                                    <div class="">
                                        <label for="CustomDate" class="mt-2">
                                            <i class="bi bi-calendar-date-fill" style="font-size: 2rem; color: rgb(106, 175, 1);"></i> 
                                            <input type="text" id="CustomDate" class="form-control p-0 m-0" placeholder="Range Select" style="visibility:hidden;width:5px;">
                                        </label>
                                    </div>

                                </div>

                                <h5 class="DateShow" id="DateShow"> 00/00/00 to 00/00/00 </h5>


                                <div class="row">
                                    <div class="col-12 SmallSummary">
                                        <h6 class="SummaryHead">Ticket Booking</h6>
                                        <h4 class="SummaryContent"> &#8377 <span id="TotalTicketAmount">0</span> </h4>
                                    </div>
                                    <div class="col-12 SmallSummary">
                                        <h6 class="SummaryHead">Visa Booking</h6>
                                        <h4 class="SummaryContent"> &#8377 <span id="TotalVisaAmount">0</span> </h4>
                                    </div>
                                    <div class="col-12 SmallSummary">
                                        <h6 class="SummaryHead">Profit</h6>
                                        <h4 class="SummaryContent"> &#8377 <span id="TotalProfit">0</span> </h4>
                                    </div>
                                </div>

                            </div>
                        </div>

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




    <?php include('../MAIN/Footer.php');  ?>








    <!-- CHART JS SCRIPT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="../JS/Dashboard.js"></script>



    <script>
        $(document).ready(function() {


            TicketAmount();

            VisaAmount();

            PortalAmount();

            ProfitAmount();




            /*LINE CHART sales  start */
            var Profit = [<?= $new_data_sales ?>];
            var Dates = [<?= $new_label_sales ?>];
            const line = document.getElementById('mylineChart').getContext("2d");
            const mylineChart = new Chart(line, {
                type: 'line',
                data: {
                    labels: Dates,
                    datasets: [{
                        label: 'Profit',
                        data: Profit,
                        borderColor: 'rgb(106, 175, 1)',
                        borderWidth: 2,
                        tension: 0,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            grid: {
                                borderDash: [9, 3],
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgb(106, 175, 1)',
                            borderColor: 'rgba(0,0,0,1)',
                            borderWidth: 0.2,
                            bodyColor: 'rgba(0,0,0,1)',
                            titleColor: 'rgba(0,0,0,1)'
                        }
                    }
                }
            });



            $(function() {
                $('#CustomDate').daterangepicker({
                        opens: 'left',
                        showDropdowns: true,
                    },
                    function(start, end, label) {
                        //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                        RangeProfit(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                        RangeFullData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                        $('#DateShow').text(start.format('DD/MM/YY') + ' to ' + end.format('DD/MM/YY'));
                    });
            });


            //Show Profit Day Wise Graph
            function RangeProfit(Start, End) {
                var StartDate = Start;
                var EndDate = End
                $.ajax({
                    method: "POST",
                    url: "DashboardData.php",
                    data: {
                        StartDate: StartDate,
                        EndDate: EndDate
                    },
                    dataType: "JSON",
                    success: function(data) {
                        //console.log(data);
                        var ProfitRangeResult = data;
                        var Dates = ProfitRangeResult.Dates;
                        var Profits = ProfitRangeResult.Profits;
                        var line_data = {
                            labels: Dates,
                            datasets: [{
                                label: 'Profit',
                                data: Profits,
                                borderColor: 'rgb(106, 175, 1)',
                                borderWidth: 2,
                                tension: 0,
                                fill: false
                            }]
                        };

                        mylineChart.data = line_data;
                        mylineChart.update();

                    }
                });
            }

            function RangeFullData(FullStart, FullEnd) {
                var FullStartDate = FullStart;
                var FullEndDate = FullEnd;
                $.ajax({
                    method: "POST",
                    url: "DashboardData.php",
                    data: {
                        FullDataStartDate: FullStartDate,
                        FullDataEndDate: FullEndDate
                    },
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data);
                        var FullDataRangeResult = data;
                        $('#TotalProfit').text((FullDataRangeResult.FullProfit).toLocaleString('en-IN'));
                        $('#TotalTicketAmount').text((FullDataRangeResult.FullTicket).toLocaleString('en-IN'));
                        $('#TotalVisaAmount').text((FullDataRangeResult.FullVisa).toLocaleString('en-IN'));
                    }
                });
            }


        });
    </script>






</body>

</html>