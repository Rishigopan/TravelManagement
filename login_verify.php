<?php session_start(); ?>
<?php     


include './MAIN/Dbconfig.php';

$user = 0;
$pass = 0;
    if(isset($_POST['userName'])){

        $username = $_POST['userName'];
        $password = $_POST['password'];
       
        if (!empty($_POST['userName']) && !empty($_POST['password'])) {

            $search_user = mysqli_query($con, "SELECT userName FROM user_db WHERE userName = '$username'");

            foreach($search_user as $user_rows){
                if($username === $user_rows['userName']){
                    $user = 1;
                }
                else{
                    $user = 0;
                }
            }
            if($user === 1){

                $search_pass = mysqli_query($con, "SELECT userPass FROM user_db WHERE userName = '$username'");

                foreach($search_pass as $pass_rows){

                    if($password === $pass_rows['userPass']){
                        $pass = 1;
                    }
                    else{
                    // $pass = 0;
                    }
                        
                }
                if(($user === 1) & ($pass === 1)){

                    $id_query = mysqli_query($con, "SELECT userId,userType from user_db WHERE userName = '$username' AND userPass = '$password'");
                    foreach($id_query as $id_row){
                        $user_id = $id_row['userId'];
                        $user_type = $id_row['userType'];
                        $_SESSION['custname'] = $username;
                        $_SESSION['custtype'] = $user_type;
                        $_SESSION['custid'] = $user_id;
                        
                        setcookie('custname',$username,time()+(86400*2), "/");
                        setcookie('custid',$user_id,time()+(86400*2), "/");
                        setcookie('custtype',$user_type,time()+(86400*2), "/");
                    }

                    if($user_type == 'SuperAdmin'){
                        echo json_encode(array('success' => 1));
                    }
                    elseif($user_type == 'Admin'){
                        echo json_encode(array('success' => 2));
                    }
                    else if($user_type == 'Executive'){
                        echo json_encode(array('success' => 3));
                    }

                }
                else{

                   // echo json_encode(array('success' => 0));
                    echo "Password In correct";
                }
            }
            else{
                echo "User not found";
            }

        }
        else{
            echo "The feilds are empty";
        }
        

        


        

        

    
    }
















?>