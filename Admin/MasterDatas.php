<?php session_start(); ?>
<?php


if(isset($_SESSION['custname']) && isset($_SESSION['custtype'])){

    if($_SESSION['custtype'] == 'SuperAdmin' || $_SESSION['custtype'] == 'Admin'){

    }
    else{
        header("location:../login.php");
    }

}
else{

header("location:../login.php");

}

include '../MAIN/Dbconfig.php';

if(isset($_GET['TicketExtend'])){

    $find_data = mysqli_query($con, "SELECT TE.*,TB.tPassenger FROM ticketextend TE INNER JOIN ticket_booking_table TB ON TE.ticketBookingId = TB.tbId");
    if(mysqli_num_rows($find_data) > 0){
        while ($dataRow = mysqli_fetch_assoc($find_data)) {
            $rows[] = $dataRow;
        }
    }
    else{
        $rows = array();
    }
    $dataset = array(
        "data" => $rows
    );
    
    echo json_encode($dataset);
    
}


