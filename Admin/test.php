<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';
include './CommonFunctions.php';

$DateToday = date('Y-m-d');

$StartDate = '2023-01-05';
$EndDate = '2023-01-08';
$connString = $con;



   

    $FindTasks = mysqli_query($con, "SELECT * FROM taskreminder WHERE taskStatus = 'Pending'");
    if(mysqli_num_rows($FindTasks) > 0){
        foreach($FindTasks as $FindTaskResults){
            $TaskId = $FindTaskResults['taskId'];
            $TaskRemindBefore = $FindTaskResults['taskRemindBefore'];
            $TaskDate = new DateTime($FindTaskResults['taskDate']);

            ///echo $TaskDate -> format('Y-m-d');

            //echo '<pre>';

            $newDate = new DateTime($DateToday);

            $RemindStartDateVar = $TaskDate -> modify('-'.$TaskRemindBefore.' day');

            $findDifference = ($newDate -> diff(new DateTime($FindTaskResults['taskDate']))) -> days;

            print_r($findDifference);

           

            $RemindStartDate =  $RemindStartDateVar -> format('Y-m-d');

            //echo '<pre>';

            //echo $DateToday;
            //echo '<pre>';

            if($DateToday >= $RemindStartDate){

                echo $FindTaskResults['taskName'];

                echo '<pre>';
            }
            else{
               //echo  "Not Remind";
            }
         

        }
    } 




?>





            