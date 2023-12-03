<?php session_start(); ?>
<?php 
        
    include '../MAIN/Dbconfig.php';



    //Add user
    if(isset($_POST['fullName'])){

 
        $userfullName = $_POST['fullName'];
        $userName =  $_POST['userName'];
        $userPass =  $_POST['userPass'];
        $userRole =  $_POST['userRole'];

        
        
        $check_query = mysqli_query($con, "SELECT * FROM user_db WHERE userName = '$userName'");
        if(mysqli_num_rows($check_query) > 0){
            echo json_encode(array('addUser' => '0'));
        }
        else{

            $find_max = mysqli_query($con, "SELECT MAX(userId) FROM user_db");
            foreach($find_max as $max_id){
                $userId = $max_id['MAX(userId)'] + 1;
            }
           
            $add_query =  mysqli_query($con, "INSERT INTO user_db (userId,fullName,userName,userPass,userType) 
            VALUES ('$userId','$userfullName','$userName','$userPass','$userRole')");

            $table_name = $userId.'_'.$userName;

            if($add_query){

                $create_table = mysqli_query($con, "CREATE TABLE $table_name (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `item_id` int(11) NOT NULL,
                    `item_qty` int(11) NOT NULL,
                    `item_desc` varchar(128) NOT NULL, PRIMARY KEY (id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

                if($create_table){
                    echo json_encode(array('addUser' => '1'));
                }
                else{
                    echo json_encode(array('addUser' => '2'));
                }
            }
            else{
                echo json_encode(array('addUser' => '2'));
            }
        }
        

    }

    //delete category
    if(isset($_POST['del_category_id'])){
 
        $Deletecategory = $_POST['del_category_id'];
       
        $check_category_query = mysqli_query($con, "SELECT * FROM item_master WHERE item_category = '$Deletecategory' ");
        if(mysqli_num_rows($check_category_query) > 0){
            echo json_encode(array('categorydel' => '0'));
        }
        else{
            $delete_query =  mysqli_query($con, "DELETE FROM category_master WHERE category_id = '$Deletecategory'");

            if($delete_query){
                echo json_encode(array('categorydel' => '1'));
            }
            else{
                echo json_encode(array('categorydel' => '2'));
            }
        }
        
    }


    //Edit User
    if(isset($_POST['edit_user_id'])){
        $edit_user_id = $_POST['edit_user_id'];

        $edit_user = mysqli_query($con, "SELECT * FROM user_db WHERE userId = '$edit_user_id'");
        if($edit_user){
            foreach($edit_user as $edit_users){
                $usereditId = $edit_users['userId'];
                $usereditfullName = $edit_users['fullName'];
                $usereditName = $edit_users['userName'];
                $usereditPass = $edit_users['userPass'];
                $usereditRole = $edit_users['userType'];
                echo json_encode(array('uservalue' => 0,'userId' => $usereditId,'userFullname' => $usereditfullName,'userName' => $usereditName,'userPass' => $usereditPass, 'userRole' => $usereditRole ));
            }
        }
        else{
            echo json_encode(array('uservalue' => 'error'));
        }
     
    }



    //Update user
    if(isset($_POST['updateuserId'])){
        $UpdatefullName = $_POST['updateFullName'];
        $updateUserName = $_POST['updateUserName'];
        $updateuserId = $_POST['updateuserId'];
        $updateUserPass = $_POST['updateUserPass'];
        $updateUserRole = $_POST['UpdateUserRole'];

        $check_user_query = mysqli_query($con, "SELECT * FROM user_db WHERE userName = '$updateUserName'  AND userId <> '$updateuserId'");
        if(mysqli_num_rows($check_user_query) > 0){
            echo json_encode(array('updateUser' => '0'));
        }
        else{
           
            $update_query =  mysqli_query($con, "UPDATE user_db SET userName = '$updateUserName', userPass = '$updateUserPass', fullName = '$UpdatefullName', userType = '$updateUserRole'  WHERE userId = '$updateuserId'");

            if($update_query){
                echo json_encode(array('updateUser' => '1'));
            }
            else{
                echo json_encode(array('updateUser' => '2'));
            }
        }
    }


    

   











    

?>