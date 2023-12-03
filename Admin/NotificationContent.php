<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';
include './CommonFunctions.php';

$DateToday = date('Y-m-d');

if (isset($_POST['Notifications'])) {

    $FindTasks = mysqli_query($con, "SELECT * FROM taskreminder WHERE taskStatus = 'Pending'");
    if (mysqli_num_rows($FindTasks) > 0) {
        foreach ($FindTasks as $FindTaskResults) {
            $TaskId = $FindTaskResults['taskId'];
            $TaskRemindBefore = $FindTaskResults['taskRemindBefore'];
            $TaskDate = new DateTime($FindTaskResults['taskDate']);
            $TaskDateFormat = $TaskDate->format('Y-m-d');
            $RemindStartDateVar = $TaskDate->modify('-' . $TaskRemindBefore . ' day');
            $RemindStartDate =  $RemindStartDateVar->format('Y-m-d');
            $NowDate = new DateTime($DateToday);
            $DateDifference = ($NowDate->diff(new DateTime($FindTaskResults['taskDate'])))->days;

            if ($DateToday >= $RemindStartDate) {
                if ($DateToday > $TaskDateFormat) {
                    $Sign = '-';
                } else {
                    $Sign = '+';
                }
?>
                <li>
                    <a class="NotificationLinks" href='./TaskReport.php?TNID=<?= $TaskId ?>'>
                        <div class="NotificationList">

                            
                            <!-- <div class="me-5">
                                <p class="p-0 m-0"> <?= date('d M Y', strtotime($FindTaskResults['taskDate'])) ?></p>
                                <p class="days  m-0 p-0 <?= ($Sign == '+') ? "taskcoming" : "taskdue" ?> "> <?php echo $Sign . ' ' . $DateDifference; ?> Days </p>
                            </div>
                            <div class="">
                                <h6 class="title"> <?= $FindTaskResults['taskName'] ?> </h6>
                                <p class="m-0 p-0 description"><?= substr($FindTaskResults['taskRemark'], 0, 15) . '....'  ?></p>
                            </div> -->



                            <div class="me-5">
                                <h6 class="title"> <?= $FindTaskResults['taskName'] ?> </h6>
                                <p class="m-0 p-0 description"><?= substr($FindTaskResults['taskRemark'], 0, 15) . '....'  ?></p>
                            </div>
                            <div class="ms-5">
                                <p class="p-0 m-0">  <?= date('d M Y', strtotime($FindTaskResults['taskDate'])) ?></p>
                                <p class="days text-end m-0 p-0 <?= ($Sign == '+') ? "taskcoming" : "taskdue" ?> "> <?php echo $Sign . ' ' . $DateDifference; ?> Days </p>
                            </div>

                        </div>
                    </a>
                </li>
<?php

            }
        }
    } else {
        echo '
        <li>
            <a href="">
                <h5> NO Reminders for Now</h5>
            </a>
        </li>
        ';
    }
}




?>
