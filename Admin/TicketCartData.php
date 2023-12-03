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

$userId = '1';


$find_data = mysqli_query($con, "SELECT temp.tbId,temp.tPassenger,temp.tDeparture,c.countryName AS FR,cm.countryName AS T,temp.tPhone,temp.tProof,temp.tProofNo,temp.tGender,temp.tAge,temp.tClass,temp.tAmount FROM `ticket_temp` temp INNER JOIN country_master c ON temp.tFrom = c.cId INNER JOIN country_master cm ON temp.tTo = cm.cId WHERE temp.tUser = '$userId'");
if(mysqli_num_rows($find_data) > 0){
    
    foreach($find_data as $dataResults){
      echo '
        <tr>
            <td> '.$dataResults["tbId"].' </td>
            <td> '.$dataResults["tPassenger"].' </td>
            <td> '.$dataResults["FR"].' </td>
            <td> '.$dataResults["T"].' </td>
            <td> '.$dataResults["tDeparture"].' </td>
            <td> '.$dataResults["tPhone"].' </td>
            <td> '.$dataResults["tProof"].' </td>
            <td> '.$dataResults["tProofNo"].' </td>
            <td> '.$dataResults["tGender"].' </td>
            <td> '.$dataResults["tAge"].' </td>
            <td> '.$dataResults["tClass"].' </td>
            <td> '.$dataResults["tAmount"].' </td>
            <td class="text-center"> <button class=" btn btn_actions btn_delete" data-bs-toggle="tooltip" data-bs-custom-class="delete-tooltip" data-bs-placement="top" data-bs-title="Delete" value="'.$dataResults["tbId"].'"><i class="material-icons">delete</i> </button> </td>
        </tr>';
        }
}
else{
    
}