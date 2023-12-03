<?php

include './MAIN/Dbconfig.php';


?>


    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/5914a243cf.js" crossorigin="anonymous"></script>

        <title>TRAVEL</title>

        <style>
            body {
                /* background-image: url('./gold-yellow-honeyed-candied-color-wave-effect-abstract-background-blur-melliferous-honeyed-background.jpg'); */
                background: url("./IMAGES/backgroundTravel.jpg");
                background-repeat: no-repeat;
                background-size: cover;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 10px;
            }
            
            #main_box {
                height: 500px;
                max-width: 800px;
                width: 100%;
                background: white;
                border: none;
            }
            
            #first_box {
                background-image: url('./IMAGES/ticketbgcrop.jpg');
                background-repeat: no-repeat;
                background-size: cover;
                align-items: center;
                display: flex;
                height: 500px;
            }
            
            #second_box {
                height: 500px;
                background-color: #EEEEEE;
                justify-content: center;
            }
            
            #second_box form {
                margin-top: 50px;
            }
            
            h1 {
                color: rgba(14, 174, 87, 1);
                text-shadow: -2px -2px 3px black;
            }
            
            input {
                border: none !important;
                background-color: #EEEEEE !important;
                border-bottom: 2px solid rgba(14, 174, 87, 1) !important;
                border-radius: 0px !important;
            }
            
            .input-group i {
                color: rgba(14, 174, 87, 1);
            }
            
            #second_box p a {
                text-decoration: none;
                color: rgba(14, 174, 87, 1);
            }
            
            #second_box button {
                background-color: rgba(14, 174, 87, 1);
                color: white;
            }
            
            #login {
                background-color: rgba(14, 174, 87, 1);
                color: white;
            }
            
            @media only screen and (max-width: 480px) {
                #second_box {
                    border-radius: 10px;
                }
            }
        </style>


    </head>

    <body>
        <div id="main_box" class="card card-body shadow-lg p-0">
            <div class="row g-0">
                <div id="first_box" class="col-7 d-none  d-md-flex">
                    <img src="" class="img-fluid" alt="">
                </div>
                <div id="second_box" class="col-md-5 col-12">
                    <form action="" id="loginform" class="px-3">
                        <h1 class="text-center">TRAVEL APP</h1>
                        <h3 class="mb-4 mt-5">Login</h3>
                        <div class="input-group mb-3">
                            <span style="position:absolute; margin-left: 10px; margin-top:6px; z-index: 99;">
                            <i class="fas fa-at fa-sm"></i>
                        </span>
                            <input type="text" name="userName" class="form-control shadow-none" placeholder="Enter Username" style="padding-left: 35px;" required>
                        </div>
                        <div class="input-group mb-3">
                            <span style="position:absolute; margin-left: 10px; margin-top:6px; z-index: 99;">
                            <i class="fas fa-key fa-sm"></i>
                        </span>
                            <input type="password" name="password" class="form-control shadow-none" placeholder="Enter Password" style="padding-left: 35px;" required>
                        </div>

                        <div id="message">

                        </div>
                        <button id="login" class="btn mt-4" type="submit" style="width:100%">Login</button>

                    </form>
                </div>
            </div>
        </div>



        <script>
            $(document).ready(function() {
                $('#loginform').submit(function(e) {
                    e.preventDefault();
                    var form = $(this).serializeArray();
                    console.log(form);
                    $.post(
                        "login_verify.php",
                        form,
                        function(form) {
                            $('#message').show();
                            $('#message').html(form);
                            //console.log("hello");
                            var response = JSON.parse(form);
                            if (response.success == "1") {
                                $('#message').hide();
                                //alert("admin");
                                location.replace("./Admin/Dashboard.php");
                            } else if (response.success == "2") {
                                $('#message').hide();
                                //alert("customer");
                                location.href = "./Admin/item_master.php";
                            } else if (response.success == "3") {
                                $('#message').hide();
                                //alert("customer");
                                location.href = "./Admin/orderForm.php";
                            } else {

                            }

                        }
                    );
                });
            });
        </script>

























        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js " integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM " crossorigin="anonymous "></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js " integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p " crossorigin="anonymous "></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js " integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF " crossorigin="anonymous "></script>
    -->
    </body>


















    </html>