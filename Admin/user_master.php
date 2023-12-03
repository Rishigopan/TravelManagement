<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';

if(isset($_COOKIE['custtypecookie']) && isset($_COOKIE['custidcookie'])){

    if($_COOKIE['custtypecookie'] == 'SuperAdmin'){

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
    <style>
        .disable {
            opacity: 0.3;
            pointer-events: none;
        }
    </style>


</head>

<body>

    <div class="wrapper">


        <!--NAVBAR-->
        <nav class="navbar fixed-top navbar-expand-lg bg-light p-1">
            <div class="container-fluid px-xl-5">
                <button class="btn btn-menu rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"> <i class="material-icons">menu</i> <span class="d-md-inline-block d-none"> Menu </span></button>
                <a class="navbar-brand" href="#"> <strong>BETA</strong> </a>
                <button class="btn btn-menu  rounded-pill"> <span class="d-md-inline-block d-none"> <?php echo $_SESSION['custname']; ?> </span> <i class="material-icons">account_circle</i> </button>

            </div>
        </nav>


        <div class="offcanvas offcanvas-start" tabindex="-8" id="staticBackdrop" aria-labelledby="staticBackdropLabel">

            <div class="offcanvas-body">
                <div class="text-center" id="Menu_heading">
                    <h5>BETA</h5>
                </div>

                <div id="Customer" class="text-center">
                    <img src="../User.png" alt="">
                    <h4><?php echo $_SESSION['custname']; ?></h4>
                </div>

                <div id="Menu_options">
                    <ul class="list-unstyled">
                        <li class=" <?php if($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin'){} else{ echo "d-none" ;} ?>" >
                            <a href="./Dashboard.php">
                                <i class="material-icons">home</i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class=" <?php if($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin'){} else{ echo "d-none" ;} ?>" >
                            <a href="./item_master.php">
                                <i class="material-icons">home</i>
                                <span>Product</span>
                            </a>
                        </li>
                        <li class=" <?php if($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin'){} else{ echo "d-none" ;} ?> ">
                            <a href="./category_master.php">
                                <i class="material-icons">home</i>
                                <span>Category</span>
                            </a>
                        </li>
                        <li class=" <?php if($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin'){} else{ echo "d-none" ;} ?>">
                            <a href="./manufacturer_master.php">
                                <i class="material-icons">home</i>
                                <span>Manufacturer</span>
                            </a>
                        </li>
                        <li class=" <?php if($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin'){} else{ echo "d-none" ;} ?>">
                            <a href="./view_items.php">
                                <i class="material-icons">home</i>
                                <span>Product List</span>
                            </a>
                        </li>
                        <li class=" <?php if($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin' || $_COOKIE['custtypecookie'] == 'Executive'){} else{ echo "d-none" ;} ?>">
                            <a href="./orderForm.php">
                                <i class="material-icons">home</i>
                                <span>Order Form</span>
                            </a>
                        </li>
                        <li class=" <?php if($_COOKIE['custtypecookie'] == 'SuperAdmin'){} else{ echo "d-none" ;} ?>">
                            <a href="./user_master.php" class="active">
                                <i class="material-icons">home</i>
                                <span>User</span>
                            </a>
                        </li>
                        <li class=" <?php if($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin'){} else{ echo "d-none" ;} ?>">
                            <a href="./itemWiseReport.php">
                                <i class="material-icons">home</i>
                                <span>Product Wise Report</span>
                            </a>
                        </li>
                        <li class=" <?php if($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin'){} else{ echo "d-none" ;} ?>">
                            <a href="./manufacturerWiseReport.php">
                                <i class="material-icons">home</i>
                                <span>Manufacturer Wise Report</span>
                            </a>
                        </li>
                        <li class=" <?php if($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin' || $_COOKIE['custtypecookie'] == 'Executive'){} else{ echo "d-none" ;} ?>">
                            <a href="./customerWiseReport.php">
                                <i class="material-icons">home</i>
                                <span>Customer Wise Report</span>
                            </a>
                        </li>
                        <li>
                            <a href="../signout.php">
                                <i class="material-icons">home</i>
                                <span>Signout</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>




        <!--CONTENTS-->
        <div class="container main-content">

            <h3 class="mt-2 title shadow-sm  py-2 text-center">Add User</h3>

            <div class="card card-body main-card shadow-sm">
                <div id="add_manufacturer">
                    <div class="row">
                        <div class="col-md-5 product_details  px-xl-2">
                            <form action="" id="addUserForm" novalidate>
                                <div class="inputs">
                                    <label for="Full_name" class="form-label">Employee Name</label>
                                    <input type="text" name="fullName" id="Full_name" class="form-control" data-v-min-length="3" data-v-max-length="20" data-v-message="Between 3 and 20 Characters" placeholder="" required>
                                </div>
                                <div class="inputs">
                                    <label for="User_name" class="form-label">User Name</label>
                                    <input type="text" id="User_name" name="userName" class="form-control" data-v-min-length="3" data-v-message="Minimum 3 Characters" placeholder="" required>
                                </div>
                                <div class="inputs">
                                    <label for="User_pass" class="form-label">Password</label>
                                    <input type="password" id="User_pass"  name="userPass" class="form-control" data-v-min-length="3" data-v-message="Minimum 3 Characters"   placeholder="Enter Password" required>
                                </div>
                                
                                <div class="inputs">
                                    <label for="User_role" class="form-label">Role</label>
                                    <select name="userRole" id="User_role" class="form-select" data-v-message="Please Select Role" required> 
                                        <option hidden value="">Choose a Role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Executive">Executive</option>
                                    </select>
                                </div>

                                <div class="text-center submit_btn">
                                    <button class="btn btn_submit" type="submit">Save </button>
                                </div>
                            </form>
                            <form action="" id="updateUserForm" style="display: none;" novalidate>
                                <div class="inputs">
                                    <label for="Full_name" class="form-label">Employee Name</label>
                                    <input type="text" id="updateuserId" name="updateuserId" hidden> 
                                    <input type="text" name="updateFullName" id="EditFull_name" class="form-control" data-v-min-length="3" data-v-max-length="20" data-v-message="Between 3 and 20 characters" placeholder="" required>
                                </div>
                                <div class="inputs">
                                    <label for="User_name" class="form-label">User Name</label>
                                    <input type="text" id="EditUser_name" name="updateUserName" class="form-control" data-v-min-length="3" data-v-message="Minimum 3 Characters" placeholder="" required>
                                </div>
                                <div class="inputs">
                                    <label for="User_pass" class="form-label">Password</label>
                                    <input type="password" id="EditUser_pass"  name="updateUserPass" class="form-control" data-v-min-length="3" data-v-message="Minimum 3 Characters" required>
                                </div>
                                
                                <div class="inputs">
                                    <label for="User_role" class="form-label">Role</label>
                                    <select name="UpdateUserRole" id="EditUser_role" class="form-select" data-v-message="Please Select Role" required> 
                                        <option hidden value="">Choose a Role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Executive">Executive</option>
                                    </select>
                                </div>

                                <div class="text-center submit_btn">
                                    <button class="btn btn_submit" type="submit">Update </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-7 p-0  px-xl-4">
                            <div class="card card-body view_details p-0">


                                <div class="card card-body bg-transparent border-0 d-none" id="loadCard"> 

                                    <div id="loader" class="mx-auto"></div>

                                </div>

                                <ul class="list-unstyled px-1" id="displayUser">



                                </ul>

                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>





    </div>



    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

    <script src="../JS/masters.js?ver=1.1"></script>

    <script>
        getUserData();


        $(document).ready(function() {

            $('#Full_name').focus();

            /* Add employee Start */
            $(function() {

                let validator = $('#addUserForm').jbvalidator({
                    language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#Full_name,#User_name,#User_pass') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#addUserForm', (function(e) {
                    e.preventDefault();
                    var UserData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "user_operations.php",
                        data: UserData,
                        beforeSend: function() {
                            $('#addUserForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#addUserForm').removeClass("disable");
                            var response = JSON.parse(data);
                            if (response.addUser == "0") {
                                toastr.warning("User Already Exists");
                            } else if (response.addUser == "1") {
                                toastr.success("Successfully Added User");
                                $('#addUserForm')[0].reset();
                                getUserData();
                                $('#Full_name').focus();
                            } else if (response.addUser == "2") {
                                toastr.error("Some Error Occured");
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });
            /* Add User  End */


            /* update user Start */
            $(function() {

                let validator = $('#updateUserForm').jbvalidator({
                    language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#EditFull_name,#EditUser_name,#EditUser_pass') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#updateUserForm', (function(e) {
                    e.preventDefault();
                    var updateUserData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "user_operations.php",
                        data: updateUserData,
                        beforeSend: function() {
                            $('#updateUserForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#updateUserForm').removeClass("disable");
                            var updateresponse = JSON.parse(data);
                            if (updateresponse.updateUser == "0") {
                                toastr.warning("User Already Exists");
                            } else if (updateresponse.updateUser == "1") {
                                toastr.success("Successfully Updated User");
                                $('#updateUserForm')[0].reset();
                                getUserData();
                                $('#updateUserForm').hide();
                                $('#addUserForm').show();
                                $('#Full_name').focus();
                            } else if (updateresponse.updateUser == "2") {
                                toastr.error("Some Error Occured");
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });
            /* update user End */





        });


        toastr.options = {
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>


</body>

</html>