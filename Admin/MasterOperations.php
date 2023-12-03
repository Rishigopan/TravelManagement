<?php session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';
include './CommonFunctions.php';


// $user_id = $_SESSION['custid'];
$user_id = '1';
$dateToday = date('Y-m-d h:i:s');
$dayToday = date('Ymd');


////////////////////////Country///////////////////////////////////  

    //Add Country
    if (isset($_POST['CountryName'])) {
        mysqli_autocommit($con, FALSE);
        $CountryName = SanitizeInput($_POST['CountryName']);

        $check_Add_Country_query = mysqli_query($con, "SELECT countryName FROM country_master WHERE countryName = '$CountryName'");
        if (mysqli_num_rows($check_Add_Country_query) > 0) {
            echo json_encode(array('addCountry' => '0'));
        } else {

            $find_max_country = mysqli_query($con, "SELECT MAX(cId) FROM country_master");
            foreach ($find_max_country as $max_country_id) {
                $countryMaxId = $max_country_id['MAX(cId)'] + 1;
            }

            $add_country_query =  mysqli_query($con, "INSERT INTO country_master (cId,countryName,CreatedBy,CreatedDate) VALUES ('$countryMaxId','$CountryName','$user_id','$dateToday')");
            if ($add_country_query) {
                mysqli_commit($con);
                echo json_encode(array('addCountry' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addCountry' => '2'));
            }
        }
    }   



    //Edit Country
    if (isset($_POST['editCountry'])) {
        $Country_edit_id = SanitizeInt($_POST['editCountry']);

        $edit_country = mysqli_query($con, "SELECT countryName FROM country_master WHERE cId = '$Country_edit_id'");
        if ($edit_country) {
            foreach ($edit_country as $edit_country_result) {
                $country_name = $edit_country_result['countryName'];
                echo json_encode(array('CountryName' => $country_name));
            }
        } else {
            echo json_encode(array('CountryValue' => 'error'));
        }
    }   




    //Update Country
    if (isset($_POST['UpdateCountryId'])) {
        mysqli_autocommit($con, FALSE);
        $updateCountryId = SanitizeInt($_POST['UpdateCountryId']);
        $UpdateCountryName = SanitizeInput($_POST['UpdateCountryName']);

        $check_country_update_query = mysqli_query($con, "SELECT countryName FROM country_master WHERE countryName = '$UpdateCountryName'  AND cId <> '$updateCountryId'");
        if (mysqli_num_rows($check_country_update_query) > 0) {
            echo json_encode(array('UpdateCountry' => '0'));
        } else {

            $update_country_query =  mysqli_query($con, "UPDATE country_master SET countryName = '$UpdateCountryName', UpdatedBy = '$user_id' , UpdatedDate = '$dateToday' WHERE cId = '$updateCountryId'");

            if ($update_country_query) {
                mysqli_commit($con);
                echo json_encode(array('UpdateCountry' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('UpdateCountry' => '2'));
            }
        }
    }   




    //Delete Country
    if (isset($_POST['delCountry'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteCountry = SanitizeInt($_POST['delCountry']);

        $check_Country_Checklist_del_query = mysqli_query($con, "SELECT cId FROM checklist_master WHERE cId = '$DeleteCountry'");
        $check_Country_VB_del_query = mysqli_query($con, "SELECT * FROM `visa_booking` WHERE passengerFrom = '$DeleteCountry' OR passengerTo = '$DeleteCountry'");
        $check_Country_TB_del_query = mysqli_query($con, "SELECT * FROM `ticket_booking_table` WHERE tFrom = '$DeleteCountry' OR tTo = '$DeleteCountry'");
        if (mysqli_num_rows($check_Country_Checklist_del_query) > 0) {
            echo json_encode(array('deleteCountry' => '0'));
        }
        elseif(mysqli_num_rows($check_Country_VB_del_query) > 0){
            echo json_encode(array('deleteCountry' => '0'));
        }
        elseif(mysqli_num_rows($check_Country_TB_del_query) > 0){
            echo json_encode(array('deleteCountry' => '0'));
        }else {
            $delete_country_query =  mysqli_query($con, "DELETE FROM country_master WHERE cId = '$DeleteCountry'");
            if ($delete_country_query) {
                mysqli_commit($con);
                echo json_encode(array('deleteCountry' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('deleteCountry' => '2'));
            }
        }
    }   



////////////////////////Country///////////////////////////////////




///////////////////////Checklist////////////////////////////////////    


    //Add Checklist
    if (isset($_POST['CheckCountry'])) {
        mysqli_autocommit($con, FALSE);
        $CheckCountryId = SanitizeInt($_POST['CheckCountry']);
        $ChecklistName = SanitizeInput($_POST['ChecklistName']);

        $check_Add_Checklist_query = mysqli_query($con, "SELECT * FROM checklist_master WHERE checklistName = '$ChecklistName' AND cId = '$CheckCountryId'");
        if (mysqli_num_rows($check_Add_Checklist_query) > 0) {
            echo json_encode(array('addChecklist' => '0'));
        } else {

            $find_max_Checklist = mysqli_query($con, "SELECT MAX(ckId) FROM checklist_master");
            foreach ($find_max_Checklist as $max_Checklist_id) {
                $ChecklistMaxId = $max_Checklist_id['MAX(ckId)'] + 1;
            }

            $add_Checklist_query =  mysqli_query($con, "INSERT INTO checklist_master (ckId,cId,checklistName,CreatedBy,CreatedDate) 
                                    VALUES ('$ChecklistMaxId','$CheckCountryId','$ChecklistName','$user_id','$dateToday')");
            if ($add_Checklist_query) {
                mysqli_commit($con);
                echo json_encode(array('addChecklist' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addChecklist' => '2'));
            }
        }
    }   




    //Edit Checklist
    if (isset($_POST['editChecklist'])) {

        $Checklist_edit_id = SanitizeInt($_POST['editChecklist']);

        $Checklist_table = mysqli_query($con, "SELECT * FROM checklist_master WHERE ckId = '$Checklist_edit_id'");
        if ($Checklist_table) {
            foreach ($Checklist_table as $edit_Checklist_result) {
                $Checklist_name = $edit_Checklist_result['checklistName'];
                $edit_Country_id = $edit_Checklist_result['cId'];
                echo json_encode(array('ChecklistName' => $Checklist_name, 'CheckCountryId' => $edit_Country_id));
            }
        } else {
            echo json_encode(array('CountryValue' => 'error'));
        }
    }   




    //Update Checklist
    if (isset($_POST['UpdateChechklistId'])) {
        mysqli_autocommit($con, FALSE);
        $UpdateChecklistId = SanitizeInt($_POST['UpdateChechklistId']);
        $UpdateChecklistCountry = SanitizeInt($_POST['UpdateCheckCountry']);
        $UpdateChecklistName = SanitizeInput($_POST['UpdateChecklistName']);

        $check_Checklist_update_query = mysqli_query($con, "SELECT * FROM checklist_master WHERE checklistName = '$UpdateChecklistName' AND cId = '$UpdateChecklistCountry' AND ckId <> '$UpdateChecklistId'");
        if (mysqli_num_rows($check_Checklist_update_query) > 0) {
            echo json_encode(array('UpdateChecklist' => '0'));
        } else {

            $update_Checklist_query =  mysqli_query($con, "UPDATE checklist_master SET checklistName = '$UpdateChecklistName', cId = '$UpdateChecklistCountry', UpdatedBy = '$user_id' , UpdatedDate = '$dateToday' WHERE ckId = '$UpdateChecklistId'");

            if ($update_Checklist_query) {
                mysqli_commit($con);
                echo json_encode(array('UpdateChecklist' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('UpdateChecklist' => '2'));
            }
        }
    }   





    //delete Checklist
    if (isset($_POST['delChecklist'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteChecklist = SanitizeInt($_POST['delChecklist']);

        /* $check_Checklist_del_query = mysqli_query($con, "SELECT * FROM order_main WHERE orderTable = '$DeleteTable'");
                if (mysqli_num_rows($check_Checklist_del_query) > 0) {
                    echo json_encode(array('deleteChecklist' => '0'));
                } else {

                    $delete_Checklist_query =  mysqli_query($con, "DELETE FROM checklist_master WHERE ckId = '$DeleteTable'");
                    if ($delete_Checklist_query) {
                        mysqli_commit($con);
                        echo json_encode(array('deleteChecklist' => '1'));
                    } else {
                        mysqli_rollback($con);
                        echo json_encode(array('deleteChecklist' => '2'));
                    }
                } */
        $delete_Checklist_query =  mysqli_query($con, "DELETE FROM checklist_master WHERE ckId = '$DeleteChecklist'");
        if ($delete_Checklist_query) {
            mysqli_commit($con);
            echo json_encode(array('deleteChecklist' => '1'));
        } else {
            mysqli_rollback($con);
            echo json_encode(array('deleteChecklist' => '2'));
        }
    }   





///////////////////////Checklist////////////////////////////////////





////////////////////////Supplier///////////////////////////////////



    //Add Supplier
    if (isset($_POST['SupPhone'])) {
        mysqli_autocommit($con, FALSE);

        $SupplierFirst = SanitizeInput($_POST['SupFirst']);
        $SupplierLast = SanitizeInput($_POST['SupLast']);
        $SupplierPhone = ($_POST['SupPhone'] == '') ? 0 : SanitizeInt($_POST['SupPhone']);
        $SupplierEmail = SanitizeInput($_POST['SupEmail']);
        $SupplierGST = SanitizeInput($_POST['SupGST']);
        $SupplierLocation = SanitizeInput($_POST['SupLocation']);
        $SupplierAddress = SanitizeInput($_POST['SupAddress']);
        $SupplierOpening =  ($_POST['SupOpen'] == '') ? 0 : SanitizeDecimal($_POST['SupOpen']);
        $SupplierOpenType = ($SupplierOpening == 0) ? '' : SanitizeInput($_POST['SupOpenType']);


        if(empty($SupplierOpenType) && $SupplierOpening > 0){
            echo json_encode(array('addSupplier' => '4'));
        }
        else{
            $check_Add_Supplier_query = mysqli_query($con, "SELECT * FROM accounts WHERE firstName = '$SupplierFirst' AND accountType = 'SUPPLIER'");
            if (mysqli_num_rows($check_Add_Supplier_query) > 0) {
                echo json_encode(array('addSupplier' => '0'));
            } else {

                $find_max_Accounts = mysqli_query($con, "SELECT MAX(Aid) FROM accounts");
                foreach ($find_max_Accounts as $max_Accounts_id) {
                    $AccountsMaxId = $max_Accounts_id['MAX(Aid)'] + 1;
                }

                $find_max_AccountTypeid = mysqli_query($con, "SELECT MAX(atId) FROM accounts WHERE accountType = 'SUPPLIER'");
                foreach ($find_max_AccountTypeid as $max_AccountTypeid_result) {
                    $AccountTypeMaxId = $max_AccountTypeid_result['MAX(atId)'] + 1;
                }

                $add_Supplier_query =  mysqli_query($con, "INSERT INTO `accounts`(`Aid`,`atId`,`accountType`, `firstName`, `lastName`, `phone`, `opening`, `openingType`, `isInterstate`, `email`, `GST`, `location`, `address`, `deletePermission`, `primaryAccntGroupId`, `accntGroupId`, `createdBy`, `createdDate`) VALUES ('$AccountsMaxId','$AccountTypeMaxId','SUPPLIER','$SupplierFirst','$SupplierLast','$SupplierPhone','$SupplierOpening','$SupplierOpenType','FALSE','$SupplierEmail','$SupplierGST','$SupplierLocation','$SupplierAddress','YES','2','30','$user_id','$dateToday')");
                if ($add_Supplier_query) {

                    mysqli_commit($con);
                    echo json_encode(array('addSupplier' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('addSupplier' => '2'));
                }
            }

        }

        
    }   



    //Edit Supplier
    if (isset($_POST['editSupplier'])) {
        $Supplier_edit_id = SanitizeInt($_POST['editSupplier']);

        $edit_Supplier = mysqli_query($con, "SELECT * FROM accounts WHERE Aid = '$Supplier_edit_id'");
        if ($edit_Supplier) {
            foreach ($edit_Supplier as $edit_Supplier_result) {
                $EditSupplierFirst = $edit_Supplier_result['firstName'];
                $EditSupplierLast = $edit_Supplier_result['lastName'];
                $EditSupplierPhone = $edit_Supplier_result['phone'];
                $EditSupplierEmail = $edit_Supplier_result['email'];
                $EditSupplierGST = $edit_Supplier_result['GST'];
                $EditSupplierLocation = $edit_Supplier_result['location'];
                $EditSupplierAddress = $edit_Supplier_result['address'];
                $EditSupplierOpening = $edit_Supplier_result['opening'];
                $EditSupplierOpenType = $edit_Supplier_result['openingType'];

                echo json_encode(array('SupplierFirst' => $EditSupplierFirst, 'SupplierLast' => $EditSupplierLast, 'SupplierPhone' => $EditSupplierPhone, 'SupplierEmail' => $EditSupplierEmail, 'SupplierGST' => $EditSupplierGST, 'SupplierLocation' => $EditSupplierLocation, 'SupplierAddress' => $EditSupplierAddress, 'SupplierOpening' => $EditSupplierOpening, 'SupplierOpenType' => $EditSupplierOpenType));
            }
        } else {
            echo json_encode(array('SupplierValue' => 'error'));
        }
    }   



    //Update Supplier
    if (isset($_POST['UpdateSupId'])) {
        mysqli_autocommit($con, FALSE);

        $UpdateSupplierId = SanitizeInput($_POST['UpdateSupId']);
        $UpdateSupplierFirst = SanitizeInput($_POST['UpdateSupFirst']);
        $UpdateSupplierLast = SanitizeInput($_POST['UpdateSupLast']);
        $UpdateSupplierPhone = ($_POST['UpdateSupPhone'] == '') ? "" : SanitizeInt($_POST['UpdateSupPhone']);
        $UpdateSupplierEmail = SanitizeInput($_POST['UpdateSupEmail']);
        $UpdateSupplierGST = SanitizeInput($_POST['UpdateSupGST']);
        $UpdateSupplierLocation = SanitizeInput($_POST['UpdateSupLocation']);
        $UpdateSupplierAddress = SanitizeInput($_POST['UpdateSupAddress']);
        $UpdateSupplierOpening = SanitizeDecimal($_POST['UpdateSupOpen']);
        $UpdateSupplierOpenType = ($UpdateSupplierOpening == 0) ? "" : SanitizeInput($_POST['UpdateSupOpenType']);
       

        if(empty($UpdateSupplierOpenType) && $UpdateSupplierOpening > 0){
            echo json_encode(array('UpdateSupplier' => '4'));
        }else{
            $check_supplier_update_query = mysqli_query($con, "SELECT * FROM accounts WHERE firstName = '$UpdateSupplierFirst' AND accountType = 'SUPPLIER' AND Aid <> '$UpdateSupplierId'");
            if (mysqli_num_rows($check_supplier_update_query) > 0) {
                echo json_encode(array('UpdateSupplier' => '0'));
            } else {
    
                $update_supplier_query =  mysqli_query($con, "UPDATE accounts SET firstName = '$UpdateSupplierFirst', lastName = '$UpdateSupplierLast',phone = '$UpdateSupplierPhone', email = '$UpdateSupplierEmail', GST = '$UpdateSupplierGST', location = '$UpdateSupplierLocation', address = '$UpdateSupplierAddress', opening = '$UpdateSupplierOpening', openingType = '$UpdateSupplierOpenType' , updatedBy = '$user_id' , updatedDate = '$dateToday' WHERE Aid = '$UpdateSupplierId'");
    
                if ($update_supplier_query) {
                    mysqli_commit($con);
                    echo json_encode(array('UpdateSupplier' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('UpdateSupplier' => '2'));
                }
            }
        }
 
    }   




    //delete Supplier
    if (isset($_POST['delSupplier'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteSupplier = SanitizeInt($_POST['delSupplier']);

        $check_Supplier_del_query = mysqli_query($con, "SELECT * FROM `account_transactions` WHERE toId = '$DeleteSupplier' OR byId = '$DeleteSupplier'");
        if (mysqli_num_rows($check_Supplier_del_query) > 0) {
            echo json_encode(array('deleteSupplier' => '0'));
        } else {

            $delete_Supplier_query =  mysqli_query($con, "DELETE FROM accounts WHERE Aid = '$DeleteSupplier'");
            if ($delete_Supplier_query) {
                mysqli_commit($con);
                echo json_encode(array('deleteSupplier' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('deleteSupplier' => '2'));
            }
            
        }

        
    }   



////////////////////////Supplier///////////////////////////////////





////////////////////////Customer///////////////////////////////////



    //Add Customer
    if (isset($_POST['CustPhone'])) {
        mysqli_autocommit($con, FALSE);

        $CustomerFirst = SanitizeInput($_POST['CustFirst']);
        $CustomerLast = SanitizeInput($_POST['CustLast']);
        $CustomerPhone = ($_POST['CustPhone'] == '') ? 0 : SanitizeInt($_POST['CustPhone']);
        $CustomerLocation = SanitizeInput($_POST['CustLocation']);
        $CustomerOpening = ($_POST['CustOpen'] == '') ? 0 : SanitizeDecimal($_POST['CustOpen']);
        $CustomerOpenType = ($CustomerOpening == 0) ? '' : SanitizeInput($_POST['CustOpenType']);

        if(empty($CustomerOpenType) && $CustomerOpening > 0){
            echo json_encode(array('addCustomer' => '4'));
        }
        else{
            $check_Add_Customer_query = mysqli_query($con, "SELECT * FROM accounts WHERE firstName = '$CustomerFirst' AND accountType = 'CUSTOMER'");
            if (mysqli_num_rows($check_Add_Customer_query) > 0) {
                echo json_encode(array('addCustomer' => '0'));
            } else {

                $find_max_Accounts = mysqli_query($con, "SELECT MAX(Aid) FROM accounts");
                foreach ($find_max_Accounts as $max_Accounts_id) {
                    $AccountsMaxId = $max_Accounts_id['MAX(Aid)'] + 1;
                }

                $find_max_AccountTypeid = mysqli_query($con, "SELECT MAX(atId) FROM accounts WHERE accountType = 'CUSTOMER'");
                foreach ($find_max_AccountTypeid as $max_AccountTypeid_result) {
                    $AccountTypeMaxId = $max_AccountTypeid_result['MAX(atId)'] + 1;
                }

                $add_Customer_query =  mysqli_query($con, "INSERT INTO `accounts`(`Aid`,`atId`,`accountType`, `firstName`, `lastName`, `phone`, `opening`, `openingType`, `isInterstate`, `location`, `deletePermission`, `primaryAccntGroupId`, `accntGroupId`, `createdBy`, `createdDate`) VALUES ('$AccountsMaxId','$AccountTypeMaxId','CUSTOMER','$CustomerFirst','$CustomerLast','$CustomerPhone','$CustomerOpening','$CustomerOpenType','FALSE','$CustomerLocation','YES','2','30','$user_id','$dateToday')");
                if ($add_Customer_query) {
                    mysqli_commit($con);
                    echo json_encode(array('addCustomer' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('addCustomer' => '2'));
                }
            }
        }

    }   



    //Edit Customer
    if (isset($_POST['editCustomer'])) {
        $Customer_edit_id = SanitizeInt($_POST['editCustomer']);

        $edit_Customer = mysqli_query($con, "SELECT * FROM accounts WHERE Aid = '$Customer_edit_id'");
        if ($edit_Customer) {
            foreach ($edit_Customer as $edit_Customer_result) {
                $EditCustomerFirst = $edit_Customer_result['firstName'];
                $EditCustomerLast = $edit_Customer_result['lastName'];
                $EditCustomerPhone = $edit_Customer_result['phone'];
                $EditCustomerLocation = $edit_Customer_result['location'];
                $EditCustomerOpening = $edit_Customer_result['opening'];
                $EditCustomerOpenType = $edit_Customer_result['openingType'];

                echo json_encode(array('CustomerFirst' => $EditCustomerFirst, 'CustomerLast' => $EditCustomerLast, 'CustomerPhone' => $EditCustomerPhone, 'CustomerLocation' => $EditCustomerLocation, 'CustomerOpening' => $EditCustomerOpening, 'CustomerOpenType' => $EditCustomerOpenType));
            }
        } else {
            echo json_encode(array('CustomerValue' => 'error'));
        }
    }   



    //Update Customer
    if (isset($_POST['UpdateCustId'])) {
        mysqli_autocommit($con, FALSE);

        $UpdateCustomerId = SanitizeInput($_POST['UpdateCustId']);
        $UpdateCustomerFirst = SanitizeInput($_POST['UpdateCustFirst']);
        $UpdateCustomerLast = SanitizeInput($_POST['UpdateCustLast']);
        $UpdateCustomerPhone = ($_POST['UpdateCustPhone'] == '') ? 0 : SanitizeInt($_POST['UpdateCustPhone']);
        //$UpdateCustomerEmail = SanitizeInput($_POST['UpdateCustEmail']);
        //$UpdateCustomerGST = SanitizeInput($_POST['UpdateCustGST']);
        $UpdateCustomerLocation = SanitizeInput($_POST['UpdateCustLocation']);
        //$UpdateCustomerAddress = SanitizeInput($_POST['UpdateCustAddress']);
        $UpdateCustomerOpening = SanitizeDecimal($_POST['UpdateCustOpen']);
        $UpdateCustomerOpenType = ($UpdateCustomerOpening == 0) ? "" : SanitizeInput($_POST['UpdateCustOpenType']);


        if(empty($UpdateCustomerOpenType) && $UpdateCustomerOpening > 0){
            echo json_encode(array('UpdateCustomer' => '4'));
        }
        else{
            $check_Customer_update_query = mysqli_query($con, "SELECT * FROM accounts WHERE firstName = '$UpdateCustomerFirst' AND accountType = 'CUSTOMER' AND Aid <> '$UpdateCustomerId'");
            if (mysqli_num_rows($check_Customer_update_query) > 0) {
                echo json_encode(array('UpdateCustomer' => '0'));
            } else {
    
                $update_Customer_query =  mysqli_query($con, "UPDATE accounts SET firstName = '$UpdateCustomerFirst', lastName = '$UpdateCustomerLast',phone = '$UpdateCustomerPhone', location = '$UpdateCustomerLocation', opening = '$UpdateCustomerOpening', openingType = '$UpdateCustomerOpenType' , updatedBy = '$user_id' , updatedDate = '$dateToday' WHERE Aid = '$UpdateCustomerId'");
    
                if ($update_Customer_query) {
                    mysqli_commit($con);
                    echo json_encode(array('UpdateCustomer' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('UpdateCustomer' => '2'));
                }
            }
        }
        
    }   


    //delete Customer
    if (isset($_POST['delCustomer'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteCustomer = SanitizeInt($_POST['delCustomer']);

        $check_Supplier_del_query = mysqli_query($con, "SELECT * FROM `account_transactions` WHERE toId = '$DeleteCustomer' OR byId = '$DeleteCustomer'");
        if (mysqli_num_rows($check_Supplier_del_query) > 0) {
            echo json_encode(array('deleteCustomer' => '0'));
        } else {

            $delete_Customer_query =  mysqli_query($con, "DELETE FROM accounts WHERE Aid = '$DeleteCustomer'");
            if ($delete_Customer_query) {
                mysqli_commit($con);
                echo json_encode(array('deleteCustomer' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('deleteCustomer' => '2'));
            }
        }

        
    }   



////////////////////////Customer///////////////////////////////////





////////////////////////Visa Booking///////////////////////////////////



    //Book Visa
    if (isset($_POST['PassengerName'])) {
        mysqli_autocommit($con, FALSE);

        $PassengerName = SanitizeInput($_POST['PassengerName']);
        $PassengerFrom = SanitizeInt($_POST['PassengerFrom']);
        $PassengerTo = SanitizeInt($_POST['PassengerTo']);
        $PassengerDate = (($_POST['DepartureDate']) != '') ? SanitizeInput($_POST['DepartureDate']) : '0000-00-00' ;
        $PassengerPhone = ($_POST['PassengerPhone'] == '') ? 0 : SanitizeInt($_POST['PassengerPhone']);
        $PassengerIdProof = SanitizeInput($_POST['PassengerProof']);
        $PassengerCareof = SanitizeInt($_POST['PassengerCareof']);
        $PassengerVisaType = SanitizeInput($_POST['VisaType']);
        $PassengerValidity = SanitizeInput($_POST['VisaValidity']);
        $PassengerAgency = SanitizeInt($_POST['VisaAgency']);
        $PassengerAgencyRate = ($_POST['AgencyRate'] == '') ? 0 : SanitizeDecimal($_POST['AgencyRate']);
        $PassengerOurRate = ($_POST['OurRate'] == '') ? 0 : SanitizeDecimal($_POST['OurRate']);
        $PassengerStatus = SanitizeInput($_POST['VisaApproval']);


        if($PassengerFrom != $PassengerTo){
            $find_max_VisaBooking = mysqli_query($con, "SELECT MAX(vId) FROM visa_booking");
            foreach ($find_max_VisaBooking  as $max_VisaBooking_id) {
                $VisaBookingMaxId = $max_VisaBooking_id['MAX(vId)'] + 1;
            }
    
           
            $connString = $con;
            $VBvType = 'VB';//voucher type for visa booking
            $VBAgencyVtype = 'VBA';//vcoucher type for agency
            $VBtoId = $PassengerCareof;
            $VBbyId = '4'; //visa id
            $VBaction = 'ADD';
            $VBamount = $PassengerOurRate;
            $VBremarks = 'Visa Type:'.$PassengerVisaType .' , Passport No:'.$PassengerIdProof.' , Visa Holder:'.$PassengerName.' , Application Date:'.$PassengerDate;
            $VBSbyId = $PassengerAgency;
            $VBStoId = '4'; //visa id
            $VBvoucherDate = $dateToday;
            $VBreceivedBy = '';
    
    
            $add_VisaBooking_query =  mysqli_query($con, "INSERT INTO `visa_booking`(`vId`, `passengerName`, `passengerFrom`, `passengerTo`, `passengerDate`, `passengerProof`, `passengerCareof`, `passengerVisa`, `passengerValidity`, `passengerAgency`, `agencyRate`, `ourRate`, `passengerStatus`,`passengerPhone`, `createdBy`, `createdDate`) 
                VALUES ('$VisaBookingMaxId','$PassengerName','$PassengerFrom','$PassengerTo','$PassengerDate','$PassengerIdProof','$PassengerCareof','$PassengerVisaType','$PassengerValidity','$PassengerAgency','$PassengerAgencyRate','$PassengerOurRate','$PassengerStatus','$PassengerPhone','$user_id','$dateToday')");
            if ($add_VisaBooking_query) {
                ledgerTransactions($VBvType, $VBtoId, $VBbyId, $VBamount, $user_id, $VBaction, $VBremarks, $VisaBookingMaxId ,$VBvoucherDate,$VBreceivedBy,$VisaBookingMaxId,$connString);
                ledgerTransactions($VBAgencyVtype, $VBStoId, $VBSbyId, $PassengerAgencyRate, $user_id, $VBaction, $VBremarks, $VisaBookingMaxId ,$VBvoucherDate,$VBreceivedBy,$VisaBookingMaxId,$connString);
                
                if($PassengerDate != '0000-00-00'){

                    $FindCareOff = mysqli_query($con, "SELECT firstName FROM accounts WHERE Aid = '$PassengerCareof'");
                    foreach($FindCareOff as $FindCareOffResult){
                        $CareOffName = $FindCareOffResult['firstName'];
                    }
                    $FindCountry = mysqli_query($con, "SELECT countryName FROM country_master WHERE cId = '$PassengerTo'");
                    foreach($FindCountry as $FindCountryResult){
                        $ToCountryName = $FindCountryResult['countryName'];
                    }

                    $VBADDTaskName = 'Visa - '.$PassengerName;
                    $VBADDTaskDate  = $PassengerDate;
                    $VBADDTaskStatus  = 'Pending';
                    $VBADDTaskRemindBefore  = '7';
                    $VBADDTaskPhone  = $PassengerPhone;
                    $VBADDTaskRemarks  = 'To - '.$ToCountryName.' , CareOff - '.$CareOffName.' , Visa - '.$PassengerVisaType;
                    $BookingId = 'VB-'.$VisaBookingMaxId;
                    $VBADDTaskResults = TaskReminder($connString,'',$VBADDTaskName,$VBADDTaskDate,$VBADDTaskStatus,$VBADDTaskRemindBefore,$VBADDTaskPhone,$VBADDTaskRemarks,'ADD','0','0',$BookingId,$user_id);
                    
                }

                mysqli_commit($con);
                echo json_encode(array('addVisaBooking' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addVisaBooking' => '2'));
            }
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('addVisaBooking' => '0'));
        }


       
    }   


    //Update Visa
    if (isset($_POST['UpdateVisaId'])) {
        mysqli_autocommit($con, FALSE);

        $UpdatePassengerId = SanitizeInput($_POST['UpdateVisaId']);//Visa update Id
        $UpdatePassengerName = SanitizeInput($_POST['UpdatePassengerName']);
        $UpdatePassengerFrom = SanitizeInt($_POST['UpdatePassengerFrom']);
        $UpdatePassengerTo = SanitizeInt($_POST['UpdatePassengerTo']);
        $UpdatePassengerDate = (($_POST['UpdateDepartureDate']) != '') ? SanitizeInput($_POST['UpdateDepartureDate']) : '0000-00-00' ;
        $UpdatePassengerPhone = ($_POST['UpdatePassengerPhone'] == '') ? 0 : SanitizeInt($_POST['UpdatePassengerPhone']);
        $UpdatePassengerIdProof = SanitizeInput($_POST['UpdatePassengerProof']);
        $UpdatePassengerCareof = SanitizeInt($_POST['UpdatePassengerCareof']);
        $UpdatePassengerVisaType = SanitizeInput($_POST['UpdateVisaType']);
        $UpdatePassengerValidity = SanitizeInput($_POST['UpdateVisaValidity']);
        $UpdatePassengerAgency = SanitizeDecimal($_POST['UpdateVisaAgency']);
        $UpdatePassengerAgencyRate = ($_POST['UpdateAgencyRate'] == '') ? 0 : SanitizeDecimal($_POST['UpdateAgencyRate']);
        $UpdatePassengerOurRate = ($_POST['UpdateOurRate'] == '') ? 0 : SanitizeDecimal($_POST['UpdateOurRate']);
        $UpdatePassengerStatus = SanitizeInput($_POST['UpdateVisaApproval']);


        if($UpdatePassengerFrom != $UpdatePassengerTo){

            $update_Customer_query =  mysqli_query($con, "UPDATE `visa_booking` SET `passengerName`='$UpdatePassengerName',`passengerFrom`='$UpdatePassengerFrom',`passengerTo`='$UpdatePassengerTo',`passengerDate`='$UpdatePassengerDate',`passengerProof`='$UpdatePassengerIdProof',`passengerCareof`='$UpdatePassengerCareof',`passengerVisa`='$UpdatePassengerVisaType',`passengerValidity`='$UpdatePassengerValidity',`passengerAgency`='$UpdatePassengerAgency',`agencyRate`='$UpdatePassengerAgencyRate',`ourRate`='$UpdatePassengerOurRate',`passengerStatus`='$UpdatePassengerStatus',`passengerPhone`='$UpdatePassengerPhone',`updatedBy`='$user_id',`updatedDate`='$dateToday' WHERE vId = '$UpdatePassengerId'");

            if ($update_Customer_query) {
      
                $connString = $con;/*  */
                $UpdateVBaction = 'EDITBOOKING';
                $UpdateVBvoucherNo = $UpdatePassengerId;
                $UpdateVBReceivedBy = '';
                $UpdateVBDate = $dateToday;
    
                //customer transaction
                $UpdateVBtoId = $UpdatePassengerCareof;//care of id
                $UpdateVBbyId = '4'; //Visa Booking id
                $UpdateVBCustamount = $UpdatePassengerOurRate;//our rate for visa booking
                $UpdateVBremarks = 'Visa Type:'.$UpdatePassengerVisaType .' , Passport No:'.$UpdatePassengerIdProof.' , Visa Holder:'.$UpdatePassengerName.' , Application Date:'.$UpdatePassengerDate;
                $UpdateVBvType = 'VB';
    
                //agency transaction
                $UpdateVBAtoId = '4'; //Visa Booking id
                $UpdateVBAbyId = $UpdatePassengerAgency;//agency id
                $UpdateVBAgencyamount = $UpdatePassengerAgencyRate;//our rate for visa booking
                $UpdateVBAremarks = 'Visa Type:'.$UpdatePassengerVisaType .' , Passport No:'.$UpdatePassengerIdProof.' , Visa Holder:'.$UpdatePassengerName.' , Application Date:'.$UpdatePassengerDate;
                $UpdateVBAvType = 'VBA';
                
                
                $updateVisaTransaction1Result = ledgerTransactions($UpdateVBvType, $UpdateVBtoId, $UpdateVBbyId, $UpdateVBCustamount, $user_id, $UpdateVBaction, $UpdateVBremarks, $UpdateVBvoucherNo, $UpdateVBDate, $UpdateVBReceivedBy,$UpdatePassengerId,$connString);
    
                $updateVisaTransaction2Result = ledgerTransactions($UpdateVBAvType, $UpdateVBAtoId, $UpdateVBAbyId, $UpdateVBAgencyamount, $user_id, $UpdateVBaction, $UpdateVBAremarks, $UpdateVBvoucherNo, $UpdateVBDate, $UpdateVBReceivedBy,$UpdatePassengerId,$connString);
            
    
                if($updateVisaTransaction1Result == 'Success'){
    
                    if($updateVisaTransaction2Result == 'Success'){


                        if($UpdatePassengerDate != '0000-00-00'){

                            $FindCareOff = mysqli_query($con, "SELECT firstName FROM accounts WHERE Aid = '$UpdatePassengerCareof'");
                            foreach($FindCareOff as $FindCareOffResult){
                                $CareOffName = $FindCareOffResult['firstName'];
                            }
                            $FindCountry = mysqli_query($con, "SELECT countryName FROM country_master WHERE cId = '$UpdatePassengerTo'");
                            foreach($FindCountry as $FindCountryResult){
                                $ToCountryName = $FindCountryResult['countryName'];
                            }
        
                            $VBUPDTaskName = 'Visa - '.$UpdatePassengerName;
                            $VBUPDTaskDate  = $UpdatePassengerDate;
                            $VBUPDTaskStatus  = 'Pending';
                            $VBUPDTaskRemindBefore  = '7';
                            $VBUPDTaskPhone  = $UpdatePassengerPhone;
                            $VBUPDTaskRemarks  = 'To - '.$ToCountryName.' , CareOff - '.$CareOffName.' , Visa - '.$UpdatePassengerVisaType;
                            $ReminderVisaBookingId = 'VB-'.$UpdatePassengerId;


                            $CheckReminderExits = mysqli_query($con, "SELECT * FROM taskreminder WHERE taskBookingId = '$ReminderVisaBookingId'");
                            if(mysqli_num_rows($CheckReminderExits) > 0){
                               $VBUPDTaskResults = TaskReminder($connString,'',$VBUPDTaskName,$VBUPDTaskDate,$VBUPDTaskStatus,$VBUPDTaskRemindBefore,$VBUPDTaskPhone,$VBUPDTaskRemarks,'EDITBOOKING','0','0',$ReminderVisaBookingId,$user_id);

                            }else{
                                $VBUPDTaskResults = TaskReminder($connString,'',$VBUPDTaskName,$VBUPDTaskDate,$VBUPDTaskStatus,$VBUPDTaskRemindBefore,$VBUPDTaskPhone,$VBUPDTaskRemarks,'ADD','0','0',$ReminderVisaBookingId,$user_id);
                            }                           
                        }

                        mysqli_commit($con);
                        echo json_encode(array('UpdateVisaBooking' => '1'));
                    }
                    else{
                        mysqli_rollback($con);
                        echo json_encode(array('UpdateVisaBooking' => '2'));
                    }
    
                }
                else{
                    mysqli_rollback($con);
                    echo json_encode(array('UpdateVisaBooking' => '2'));
                }
                
            } else {
                mysqli_rollback($con);
                echo json_encode(array('UpdateVisaBooking' => '2'));
            }
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('UpdateVisaBooking' => '0'));
        }

    }   


    //Delete Visa
    if (isset($_POST['delVisa'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteVisa = SanitizeInt($_POST['delVisa']);

        $delete_Visa_query =  mysqli_query($con, "UPDATE visa_booking SET cancelStatus = '1' WHERE vId = '$DeleteVisa'");
        if ($delete_Visa_query) {

            $DeleteCustvType = 'VB';
            $DeleteAgencyvType = 'VBA';
            $DeletetoId = '';
            $DeletebyId = '';
            $Deleteamount = '';
            $Deleteuserid = '';
            $Deleteaction = 'CANCEL';
            $Deleteremarks = '';
            $DeletevoucherNo = $DeleteVisa;
            $DeletevoucherDate = '';
            $Deletereceivedby = '';
            $DeleteconnString = $con;
            $DeleteVisaBookingId = 0;
            $DeleteReminderId = 'VB-'.$DeleteVisa;

           

            $visaDeleteCustTransaction = ledgerTransactions($DeleteCustvType, $DeletetoId, $DeletebyId, $Deleteamount, $user_id, $Deleteaction, $Deleteremarks, $DeletevoucherNo, $DeletevoucherDate, $Deletereceivedby,$DeleteVisaBookingId,$DeleteconnString);

            if($visaDeleteCustTransaction == 'Success'){

                $visaDeleteAgencyTransaction = ledgerTransactions($DeleteAgencyvType, $DeletetoId, $DeletebyId, $Deleteamount, $user_id, $Deleteaction, $Deleteremarks, $DeletevoucherNo, $DeletevoucherDate, $Deletereceivedby,$DeleteVisaBookingId,$DeleteconnString);

                if($visaDeleteAgencyTransaction == 'Success'){

                    TaskReminder($DeleteconnString,'','','','','','','','REMOVEBOOKING','','',$DeleteReminderId,'');

                    mysqli_commit($con);
                    echo json_encode(array('deleteVisa' => '1'));
                }
                else{
                    mysqli_rollback($con);
                    echo json_encode(array('deleteVisa' => '2'));
                }
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('deleteVisa' => '2'));
            }

        } else {
            mysqli_rollback($con);
            echo json_encode(array('deleteVisa' => '2'));
        }
    }   



////////////////////////Visa Booking///////////////////////////////////






////////////////////////Ledger///////////////////////////////////   

    //Add Ledger
    if (isset($_POST['LedgerName'])) {
        mysqli_autocommit($con, FALSE);
        $LedgerName = SanitizeInput($_POST['LedgerName']);
        $LedgerOpenBalance = ($_POST['LedgerAmount'] == '') ? 0 : SanitizeDecimal($_POST['LedgerAmount']);
        $LedgerOpenType = ($LedgerOpenBalance == 0) ? '' : SanitizeInput(($_POST['LedgerOpening']));
        $LedgerAccountGroup = SanitizeInt($_POST['LedgerAccountGroup']);
        $LedgerPrimaryAccountGroup = SanitizeInt($_POST['LedgerPrimaryAccount']);
        $IsProfitLedger = (isset($_POST['IsProfitLedger'])) ?  1 : 0;

        if(empty($LedgerOpenType) && $LedgerOpenBalance > 0){
            echo json_encode(array('addLedger' => '4'));
        }
        else{
            $check_Add_Ledger_query = mysqli_query($con, "SELECT firstName FROM accounts WHERE firstName = '$LedgerName' AND accntGroupId = '$LedgerAccountGroup' AND accountType NOT IN('SUPPLIER','CUSTOMER')");
            if (mysqli_num_rows($check_Add_Ledger_query) > 0) {
                echo json_encode(array('addLedger' => '0'));
            } else {

                $find_max_ledger = mysqli_query($con, "SELECT MAX(Aid) FROM accounts");
                foreach ($find_max_ledger as $max_ledger_id) {
                    $ledgerMaxId = $max_ledger_id['MAX(Aid)'] + 1;
                }

                $findLegderTypeId = mysqli_query($con, "SELECT MAX(atId) FROM accounts WHERE accountType NOT IN('SUPPLIER','CUSTOMER')");
                foreach ($findLegderTypeId as $findLegderTypeIdResult) {
                    $LegderTypeId =  $findLegderTypeIdResult['MAX(atId)'] + 1;
                }

                $add_ledger_query =  mysqli_query($con, "INSERT INTO `accounts`(`Aid`, `atId`, `firstName`, `lastName`, `opening`, `openingType`, `isInterstate`, `accntGroupId`, `primaryAccntGroupId`, `deletePermission`,`isProfitLedger`, `createdBy`, `createdDate`) 
                        VALUES ('$ledgerMaxId','$LegderTypeId','$LedgerName',' ','$LedgerOpenBalance','$LedgerOpenType','FALSE','$LedgerAccountGroup','$LedgerPrimaryAccountGroup','YES','$IsProfitLedger','$user_id','$dateToday')");
                if ($add_ledger_query) {
                    mysqli_commit($con);
                    echo json_encode(array('addLedger' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('addLedger' => '2'));
                }
            }

        }
      
    }   



    //Edit Ledger
    if (isset($_POST['editLedger'])) {
        $Ledger_edit_id = SanitizeInt($_POST['editLedger']);

        $edit_Ledger = mysqli_query($con, "SELECT A.firstName,A.isProfitLedger,A.deletePermission,AG.accountgroupid AS AGID,PAG.accountgroupid AS PAGID,PAG.accountgroupName AS PAGNAME,openingType,opening FROM accounts A LEFT JOIN accountgroup AG ON A.accntGroupId = AG.accountgroupid LEFT JOIN accountgroup PAG ON A.primaryAccntGroupId = PAG.accountgroupid WHERE Aid = '$Ledger_edit_id'");
        if (mysqli_num_rows($edit_Ledger) > 0) {
            foreach ($edit_Ledger as $edit_Ledger_result) {
                $Ledger_name = $edit_Ledger_result['firstName'];
                $EditLedgerOpenType = $edit_Ledger_result['openingType'];
                $EditLedgerBalance = $edit_Ledger_result['opening'];
                $EditLedgerAccountGroupId = $edit_Ledger_result['AGID'];
                $EditLedgerPrimaryAccountGroupId = $edit_Ledger_result['PAGID'];
                $EditLedgerPrimaryAccountGroupName = $edit_Ledger_result['PAGNAME'];
                $EditLedgerDeletePermission = $edit_Ledger_result['deletePermission'];
                $EditLedgerIsProfitLedger = $edit_Ledger_result['isProfitLedger'];
                echo json_encode(array('LedgerName' => $Ledger_name, 'LedgerOpenType' => $EditLedgerOpenType, 'LedgerBalance' => $EditLedgerBalance, 'LedgerAccountGroupId' => $EditLedgerAccountGroupId, 'LedgerPrimaryAccountGroupId' => $EditLedgerPrimaryAccountGroupId, 'LedgerPrimaryAccountGroupName' => $EditLedgerPrimaryAccountGroupName,'DeletePermission' => $EditLedgerDeletePermission,'IsProfitLedger' => $EditLedgerIsProfitLedger));
            }
        } else {
            echo json_encode(array('LedgerValue' => 'error'));
        }
    }   


    //Update Ledger
    if (isset($_POST['UpdateLedgerId'])) {
        mysqli_autocommit($con, FALSE);
        $updateLedgerId = SanitizeInt($_POST['UpdateLedgerId']);
        $UpdateLedgerName = SanitizeInput($_POST['UpdateLedgerName']);
        $UpdateLedgerOpenBalance = ($_POST['UpdateLedgerAmount'] == '') ? 0 : SanitizeDecimal($_POST['UpdateLedgerAmount']);
        $UpdateLedgerOpenType = ($UpdateLedgerOpenBalance == 0) ? '' : SanitizeInput(($_POST['UpdateLedgerOpening']));
        $UpdateLedgerAccountGroup = SanitizeInt($_POST['UpdateLedgerAccountGroup']);
        $UpdateLedgerPrimaryAccountGroup = SanitizeInt($_POST['UpdateLedgerPrimaryAccount']);
        $UpdateIsProfitLedger = (isset($_POST['UpdateIsProfitLedger'])) ?  1 : 0;


        if(empty($UpdateLedgerOpenType) && $UpdateLedgerOpenBalance > 0){
            echo json_encode(array('UpdateLedger' => '4'));
        }
        else{
            $check_Ledger_update_query = mysqli_query($con, "SELECT * FROM accounts WHERE firstName = '$UpdateLedgerName' AND accntGroupId = '$UpdateLedgerAccountGroup' AND accountType NOT IN('SUPPLIER','CUSTOMER') AND Aid <> '$updateLedgerId'");
            if (mysqli_num_rows($check_Ledger_update_query) > 0) {
                echo json_encode(array('UpdateLedger' => '0'));
            } else {

                $update_Ledger_query =  mysqli_query($con, "UPDATE accounts SET firstName = '$UpdateLedgerName', openingType = '$UpdateLedgerOpenType', opening = '$UpdateLedgerOpenBalance', UpdatedBy = '$user_id' , accntGroupId = '$UpdateLedgerAccountGroup', primaryAccntGroupId = '$UpdateLedgerPrimaryAccountGroup',isProfitLedger = '$UpdateIsProfitLedger', UpdatedDate = '$dateToday' WHERE Aid = '$updateLedgerId'");

                if ($update_Ledger_query) {
                    mysqli_commit($con);
                    echo json_encode(array('UpdateLedger' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('UpdateLedger' => '2'));
                }
            }

        }
        



        
    }   



    //Delete Ledger
    if (isset($_POST['delLedger'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteLedger = SanitizeInt($_POST['delLedger']);
        $FindLedgerDeleteOrNot = mysqli_query($con, "SELECT deletePermission FROM accounts WHERE Aid = '$DeleteLedger'");
        foreach($FindLedgerDeleteOrNot as $FindLedgerDeleteOrNotResult){
            $LedgerDeleteOrNot = $FindLedgerDeleteOrNotResult['deletePermission'];
        }

        if($LedgerDeleteOrNot == 'NO'){
            echo json_encode(array('deleteLedger' => '3'));
        }elseif($DeleteLedger == 10){
            echo json_encode(array('deleteLedger' => '3'));
        }else{
            $check_legder_del_to_query = mysqli_query($con, "SELECT toId FROM account_transactions WHERE toId = '$DeleteLedger'");
            $check_legder_del_by_query = mysqli_query($con, "SELECT byId FROM account_transactions WHERE byId = '$DeleteLedger'");
            if (mysqli_num_rows($check_legder_del_to_query) > 0) {
                echo json_encode(array('deleteLedger' => '0'));
            } else if (mysqli_num_rows($check_legder_del_by_query) > 0) {
                echo json_encode(array('deleteLedger' => '0'));
            } else {
                $delete_ledger_query =  mysqli_query($con, "DELETE FROM accounts WHERE Aid = '$DeleteLedger'");
                if ($delete_ledger_query) {
                    mysqli_commit($con);
                    echo json_encode(array('deleteLedger' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('deleteLedger' => '2'));
                }
            }
        }
    }   

    

    //find primary account in adding ledger
    if(isset($_POST['AccountGroupValue'])){
        $AccountGroupValue = $_POST['AccountGroupValue'];
        $findPrimaryAccountIdQuery = mysqli_query($con, "SELECT A.accountgroupid,A.accountgroupName FROM `accountgroup` PA INNER JOIN accountgroup A ON PA.primaryid = A.accountgroupid WHERE PA.accountgroupid = '$AccountGroupValue'");
        if(mysqli_num_rows($findPrimaryAccountIdQuery) > 0){
            foreach($findPrimaryAccountIdQuery as $findPrimaryAccountIdResult){
                $findPrimaryAccountId = $findPrimaryAccountIdResult['accountgroupid'];
                $findPrimaryAccountName = $findPrimaryAccountIdResult['accountgroupName'];
            }
            echo json_encode(array('FindPrimaryAccountId' => $findPrimaryAccountId, 'FindPrimaryAccountName' => $findPrimaryAccountName));
        }
        else{
            echo json_encode(array('FindPrimaryAccountValue' => 'error'));
        }
    }


////////////////////////Ledger///////////////////////////////////





///////////////////////////Primary Account Group//////////////////////////////////  

    //Add Primary Account Group
    if (isset($_POST['PrimAccntName'])) {
        mysqli_autocommit($con, FALSE);
        $PrimaryAccountGroup = SanitizeInput($_POST['PrimAccntName']);  


        $check_Add_primary_account_group_query = mysqli_query($con, "SELECT accountgroupName FROM accountgroup WHERE accountgroupName = '$PrimaryAccountGroup'");
        if (mysqli_num_rows($check_Add_primary_account_group_query) > 0) {
            echo json_encode(array('addPrimaryAccountGroup' => '0'));
        } else {    

            $find_max_primary_account_group = mysqli_query($con, "SELECT MAX(accountgroupid) FROM accountgroup");
            foreach ($find_max_primary_account_group as $max_primary_account_group_id) {
                $PrimaryAccountGroupMaxId = $max_primary_account_group_id['MAX(accountgroupid)'] + 1;
            }   


            $add_primary_account_group_query =  mysqli_query($con, "INSERT INTO `accountgroup`(`accountgroupid`, `primaryid`, `accountgroupName`, `visiblestatus`, `createdBy`, `createdDate`) VALUES ('$PrimaryAccountGroupMaxId','$PrimaryAccountGroupMaxId','$PrimaryAccountGroup','1','$user_id','$dateToday')");
            if ($add_primary_account_group_query) {
                mysqli_commit($con);
                echo json_encode(array('addPrimaryAccountGroup' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addPrimaryAccountGroup' => '2'));
            }
        }
    }   

   

    //Edit Primary Account Group
    if (isset($_POST['editPrimaryAccountGroup'])) {
        $PrimaryAccountGroup_edit_id = SanitizeInt($_POST['editPrimaryAccountGroup']);

        $edit_PrimaryAccountGroup = mysqli_query($con, "SELECT * FROM accountgroup WHERE accountgroupid = '$PrimaryAccountGroup_edit_id'");
        if ($edit_PrimaryAccountGroup) {
            foreach ($edit_PrimaryAccountGroup as $edit_PrimaryAccountGroup_result) {
                $EditPrimaryAccountGroupName = $edit_PrimaryAccountGroup_result['accountgroupName'];
                
                echo json_encode(array('PrimaryAccountGroupName' => $EditPrimaryAccountGroupName));
            }
        } else {
            echo json_encode(array('PrimaryAccountGroupValue' => 'error'));
        }
    }   


    //Update Primary Account Group
    if (isset($_POST['UpdatePrimAccntId'])) {
        mysqli_autocommit($con, FALSE);
        $UpdatePrimAccntId = SanitizeInt($_POST['UpdatePrimAccntId']);
        $UpdatePrimAccntName = SanitizeInput($_POST['UpdatePrimAccntName']);
       
        
        $check_PrimAccnt_update_query = mysqli_query($con, "SELECT accountgroupName FROM accountgroup WHERE accountgroupName = '$UpdatePrimAccntName'  AND accountgroupid <> '$UpdatePrimAccntId'");
        if (mysqli_num_rows($check_PrimAccnt_update_query) > 0) {
            echo json_encode(array('UpdatePrimAccntGroup' => '0'));
        } else {
        
            $update_PrimAccnt_query =  mysqli_query($con, "UPDATE accountgroup SET accountgroupName = '$UpdatePrimAccntName', updatedBy = '$user_id' , updatedDate = '$dateToday' WHERE accountgroupid = '$UpdatePrimAccntId'");
        
            if ($update_PrimAccnt_query) {
                mysqli_commit($con);
                echo json_encode(array('UpdatePrimAccntGroup' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('UpdatePrimAccntGroup' => '2'));
            }
        }
    }   
    

    //Delete Primary Account Group
    if (isset($_POST['delPrimAccntGroupId'])) {

        mysqli_autocommit($con, FALSE);
        $DeletePrimAcctGroupId = SanitizeInt($_POST['delPrimAccntGroupId']);

        $check_PrimAcctGroup_permission_query = mysqli_query($con, "SELECT deletePermission FROM accountgroup WHERE accountgroupid = '$DeletePrimAcctGroupId'");
        foreach($check_PrimAcctGroup_permission_query as $check_PrimAcctGroup_permission_query_result){
            $PrimAcctGroup_permission = $check_PrimAcctGroup_permission_query_result['deletePermission'];
        }
        if( $PrimAcctGroup_permission == 0 ){
            echo json_encode(array('DeletePrimAccntGroup' => '0'));
        }
        else{

            $check_PrimAcctGroup_esixt_query = mysqli_query($con, "SELECT primaryAccntGroupId FROM accounts WHERE primaryAccntGroupId = '$DeletePrimAcctGroupId'");
            if (mysqli_num_rows($check_PrimAcctGroup_esixt_query) > 0) {
                echo json_encode(array('DeletePrimAccntGroup' => '0'));
            } else {
                $delete_PrimAcctGroup_query =  mysqli_query($con, "DELETE FROM accountgroup WHERE accountgroupid = '$DeletePrimAcctGroupId'");
                if ($delete_PrimAcctGroup_query) {
                    mysqli_commit($con);
                    echo json_encode(array('DeletePrimAccntGroup' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('DeletePrimAccntGroup' => '2'));
                }
            }
        }
           
        
    }   



///////////////////////////Primary Account Group//////////////////////////////////






/////////////////////////// Account Group//////////////////////////////////




    //Add Account Group
    if (isset($_POST['PrimaryAccountGroupId'])) {
        mysqli_autocommit($con, FALSE);
        $PrimaryAccountGroupId = SanitizeInt($_POST['PrimaryAccountGroupId']);  
        $AccountGroupName = SanitizeInput($_POST['AccntName']);  


        $check_Add_account_group_query = mysqli_query($con, "SELECT accountgroupName FROM accountgroup WHERE accountgroupName = '$AccountGroupName' AND primaryid = '$AccountGroupName'");
        if (mysqli_num_rows($check_Add_account_group_query) > 0) {
            echo json_encode(array('addAccountGroup' => '0'));
        } else {    

            $find_max_account_group = mysqli_query($con, "SELECT MAX(accountgroupid) FROM accountgroup");
            foreach ($find_max_account_group as $max_account_group_id) {
                $AccountGroupMaxId = $max_account_group_id['MAX(accountgroupid)'] + 1;
            }   


            $add_account_group_query =  mysqli_query($con, "INSERT INTO `accountgroup`(`accountgroupid`,primaryid,`accountgroupName`,`visiblestatus`,`createdBy`,`createdDate`) 
            VALUES ('$AccountGroupMaxId','$PrimaryAccountGroupId','$AccountGroupName','1','$user_id','$dateToday')");
            if ($add_account_group_query) {
                mysqli_commit($con);
                echo json_encode(array('addAccountGroup' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addAccountGroup' => '2'));
            }
        }
    }   



    //Edit Account Group
    if (isset($_POST['editAccountGroup'])) {
        $AccountGroup_edit_id = SanitizeInt($_POST['editAccountGroup']);

        $edit_AccountGroup = mysqli_query($con, "SELECT accountgroupName,primaryid FROM accountgroup WHERE accountgroupid = '$AccountGroup_edit_id'");
        if ($edit_AccountGroup) {
            foreach ($edit_AccountGroup as $edit_AccountGroup_result) {
                $EditAccountGroupName = $edit_AccountGroup_result['accountgroupName'];
                $EditPrimaryAccountGroupID = $edit_AccountGroup_result['primaryid'];
                
                echo json_encode(array('AccountGroupName' => $EditAccountGroupName , 'PrimaryAccountGroupID' => $EditPrimaryAccountGroupID));
            }
        } else {
            echo json_encode(array('AccountGroupValue' => 'error'));
        }
    }   



    //Update Account Group
    if (isset($_POST['UpdateAccntGroupId'])) {
        mysqli_autocommit($con, FALSE);
        $UpdateAccntId = SanitizeInt($_POST['UpdateAccntGroupId']);
        $UpdatePrimAccntId = SanitizeInt($_POST['UpdatePrimaryAccountGroupId']);
        $UpdateAccntName = SanitizeInput($_POST['UpdateAccntName']);
       
        
        $check_Accnt_update_query = mysqli_query($con, "SELECT accountgroupName FROM accountgroup WHERE accountgroupName = '$UpdateAccntName'  AND primaryid = '$UpdatePrimAccntId' AND accountgroupid <> '$UpdateAccntId'");
        if (mysqli_num_rows($check_Accnt_update_query) > 0) {
            echo json_encode(array('UpdateAccntGroup' => '0'));
        } else {
        
            $update_Accnt_query =  mysqli_query($con, "UPDATE accountgroup SET accountgroupName = '$UpdateAccntName', primaryid = '$UpdatePrimAccntId', updatedBy = '$user_id' , updatedDate = '$dateToday' WHERE accountgroupid = '$UpdateAccntId'");
        
            if ($update_Accnt_query) {
                mysqli_commit($con);
                echo json_encode(array('UpdateAccntGroup' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('UpdateAccntGroup' => '2'));
            }
        }
    }   


   

    //Delete Primary Account Group
    if (isset($_POST['delAccntGroupId'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteAcctGroupId = SanitizeInt($_POST['delAccntGroupId']);

        $check_AcctGroup_permission_query = mysqli_query($con, "SELECT deletePermission FROM accountgroup WHERE accountgroupid = '$DeleteAcctGroupId'");
        foreach($check_AcctGroup_permission_query as $check_AcctGroup_permission_query_result){
            $AcctGroup_permission = $check_AcctGroup_permission_query_result['deletePermission'];
        }
        if( $AcctGroup_permission == 0 ){
            echo json_encode(array('DeleteAccntGroup' => '0'));
        }
        else{

            $check_AcctGroup_exist_query = mysqli_query($con, "SELECT accntGroupId FROM accounts WHERE accntGroupId = '$DeleteAcctGroupId'");
            if (mysqli_num_rows($check_AcctGroup_exist_query) > 0) {
                echo json_encode(array('DeleteAccntGroup' => '0'));
            } else {
                $delete_AcctGroup_query =  mysqli_query($con, "DELETE FROM accountgroup WHERE accountgroupid = '$DeleteAcctGroupId'");
                if ($delete_AcctGroup_query) {
                    mysqli_commit($con);
                    echo json_encode(array('DeleteAccntGroup' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('DeleteAccntGroup' => '2'));
                }
            }
        }
        
        
    }   




/////////////////////////// Account Group//////////////////////////////////






////////////////////////Ticket Booking///////////////////////////////////



    //Add Tickets
    if (isset($_POST['TicketPassengerName'])) {
        mysqli_autocommit($con, FALSE);

        $TicketPassenger = SanitizeInput($_POST['TicketPassengerName']);
        $TicketFrom = SanitizeInt($_POST['TicketPassengerFrom']);
        $TicketTo = SanitizeInt($_POST['TicketPassengerTo']);
        $TicketDate = (($_POST['TicketDepartureDate']) != '') ? SanitizeInput($_POST['TicketDepartureDate']) : '0000-00-00' ;
        $TicketPhone = ($_POST['TicketPassengerPhone'] == '') ? 0 : SanitizeInt($_POST['TicketPassengerPhone']);
        $TicketIdProof = SanitizeInput($_POST['TicketIDProof']);
        $TicketIdProofNo = SanitizeInput($_POST['TicketIDProofNo']);
        $TicketCareOf = SanitizeInt($_POST['TicketPassengerCareof']);
        $TicketAONumber = SanitizeInt($_POST['TicketAONumber']);
        $TicketOurRate = ($_POST['TicketOurRate'] == '') ? 0 : SanitizeDecimal($_POST['TicketOurRate']);
        $TicketAgencyRate = ($_POST['TicketAgencyRate'] == '') ? 0 : SanitizeDecimal($_POST['TicketAgencyRate']);
        $TicketStatus = SanitizeInput($_POST['TicketApproval']);
        $TicketBookingAgency = SanitizeInt($_POST['TicketBookingAgency']);
        $TicketType = ($TicketBookingAgency == 7) ? "Normal" : "Group";

        if($TicketFrom != $TicketTo){
            $find_max_ticketTemp = mysqli_query($con, "SELECT MAX(tbId) FROM ticket_booking_table");
            foreach ($find_max_ticketTemp  as $max_ticketTemp_id) {
                $ticketTempMaxId = $max_ticketTemp_id['MAX(tbId)'] + 1;
            }
    
            $add_ticket_query =  mysqli_query($con, "INSERT INTO `ticket_booking_table`(`tbId`, `tPassenger`, `tFrom`, `tTo`, `tDeparture`, `tPhone`, `tProof`, `tProofNo`,`tType`,`tAgency`, `tAmount`,`tAgencyamount`, `tStatus`,`tbCareoff`,`tAoNumber`, `createdBy`, `createdDate`) VALUES ('$ticketTempMaxId','$TicketPassenger','$TicketFrom','$TicketTo','$TicketDate','$TicketPhone','$TicketIdProof','$TicketIdProofNo','$TicketType','$TicketBookingAgency','$TicketOurRate','$TicketAgencyRate','$TicketStatus','$TicketCareOf','$TicketAONumber','$user_id','$dateToday')");
    
            if ($add_ticket_query) {
    
                $connString = $con;
                $TBvType = 'TB';//voucher type for Ticket booking
                $TBtoId = $TicketCareOf;
                $TBbyId = '3'; //Ticket Booking id
                $TBaction = 'ADD';
                $TBamount = $TicketOurRate;
                //$TBremarks = 'TicketBookId:'.$ticketTempMaxId .' - Date:'.$dateToday;
                $TBremarks = 'Passenger:'.$TicketPassenger.' , AO No:'.$TicketAONumber.' , Application Date:'.$TicketDate;
                $TBvoucherDate = $dateToday;
                $TBreceivedBy = '';
                //$TBAgencyvType = 'TBA';//voucher type for agency Ticket booking
                $TBAbyId = $TicketBookingAgency;
                $TBAtoId = '3'; //ticket id
                $TBAgencyvType = ($TicketBookingAgency == 7) ? "PD" : "GRP";//voucher type for agency Ticket booking ,GRP => Group Ticket ,TBP => Ticket From Portal 
                
        
    
                $TicketBookingLedger = ledgerTransactions($TBvType, $TBtoId, $TBbyId, $TBamount, $user_id, $TBaction, $TBremarks, $ticketTempMaxId ,$TBvoucherDate,$TBreceivedBy,$ticketTempMaxId,$connString);
    
                $TicketBookingAgencyLedger = ledgerTransactions($TBAgencyvType, $TBAtoId, $TBAbyId, $TicketAgencyRate, $user_id, $TBaction, $TBremarks, $ticketTempMaxId ,$TBvoucherDate,$TBreceivedBy,$ticketTempMaxId,$connString);
    
                if($TicketBookingLedger == 'Success' && $TicketBookingAgencyLedger == 'Success'){

                    if($TicketDate != '0000-00-00'){

                        $FindCareOff = mysqli_query($con, "SELECT firstName FROM accounts WHERE Aid = '$TicketCareOf'");
                        foreach($FindCareOff as $FindCareOffResult){
                            $CareOffName = $FindCareOffResult['firstName'];
                        }
                        $FindCountry = mysqli_query($con, "SELECT countryName FROM country_master WHERE cId = '$TicketTo'");
                        foreach($FindCountry as $FindCountryResult){
                            $ToCountryName = $FindCountryResult['countryName'];
                        }

                        $TBADDTaskName = ($TicketBookingAgency == 7) ? ('Ticket - '.$TicketPassenger) : ('Group Ticket - '.$TicketPassenger);

                        // $TBADDTaskName = 'Ticket - '.$TicketPassenger;
                        $TBADDTaskDate  = $TicketDate;
                        $TBADDTaskStatus  = 'Pending';
                        $TBADDTaskRemindBefore  = '7';
                        $TBADDTaskPhone  = $TicketPhone;
                        $TBADDTaskRemarks  = 'To - '.$ToCountryName.' , CareOff- '.$CareOffName;
                        $ReminderBookingId = 'TB-'.$ticketTempMaxId;
                        $TBADDTaskResults = TaskReminder($connString,'',$TBADDTaskName,$TBADDTaskDate,$TBADDTaskStatus,$TBADDTaskRemindBefore,$TBADDTaskPhone,$TBADDTaskRemarks,'ADD','0','0',$ReminderBookingId,$user_id); 
                    }
                    
                    mysqli_commit($con);
                    echo json_encode(array('addTicketBooking' => '1', 'BookingId' => $ticketTempMaxId, 'BookingCareoff' => $TicketCareOf, 'BookingAmount' => $TicketOurRate));
                }else{
                    mysqli_rollback($con);
                    echo json_encode(array('addTicketBooking' => '2'));
                }


                // if($TicketBookingLedger == 'Success' && $TicketBookingAgencyLedger == 'Success'){
    
                //     $action = 'RECHARGE';
                //     $amount = '-'.$TicketAgencyRate;
                //     $bonus = '0';
                //     $from = '3';// ticket booking id
                //     $transactionDate = $dateToday;
                //     $userid = $user_id; 
                //     $particularId = '1';
                //     $particularName = 'PORTAL BALANCE';
            
                //     $AddPortalRecharge =  PortalTransactions($connString,$action,$amount,$bonus,$from,$transactionDate,$userid,$particularId,$particularName);
    
                //     if($AddPortalRecharge == 'Success'){
    
                //         $PDvType = 'PD'; // portal deduction
                //         $PDtoId = '3';// ticket booking id 
                //         $PDbyId =   '7'; //PORTAL ID 
                //         $PDaction = 'ADD';
                //         $PDamount = $TicketAgencyRate;
                //         $PDremarks = $TBremarks;
                //         $PDDate = $dateToday;
                //         $PDReceivedBy = '';
                //         $PDvoucherNo = $ticketTempMaxId;
                        
            
                //         // ticketbooking to portal
                //         $PDResult = ledgerTransactions($PDvType, $PDtoId, $PDbyId, $PDamount, $user_id, $PDaction, $PDremarks, $PDvoucherNo, $PDDate, $PDReceivedBy,$ticketTempMaxId,$connString);
    
                //         if($PDResult == 'Success'){

                //             if($TicketDate != '0000-00-00'){

                //                 $FindCareOff = mysqli_query($con, "SELECT firstName FROM accounts WHERE Aid = '$TicketCareOf'");
                //                 foreach($FindCareOff as $FindCareOffResult){
                //                     $CareOffName = $FindCareOffResult['firstName'];
                //                 }
                //                 $FindCountry = mysqli_query($con, "SELECT countryName FROM country_master WHERE cId = '$TicketTo'");
                //                 foreach($FindCountry as $FindCountryResult){
                //                     $ToCountryName = $FindCountryResult['countryName'];
                //                 }

                //                 $TBADDTaskName = 'Ticket - '.$TicketPassenger;
                //                 $TBADDTaskDate  = $TicketDate;
                //                 $TBADDTaskStatus  = 'Pending';
                //                 $TBADDTaskRemindBefore  = '7';
                //                 $TBADDTaskPhone  = $TicketPhone;
                //                 $TBADDTaskRemarks  = 'To - '.$ToCountryName.' , CareOff- '.$CareOffName;
                //                 $ReminderBookingId = 'TB-'.$ticketTempMaxId;
                //                 $TBADDTaskResults = TaskReminder($connString,'',$TBADDTaskName,$TBADDTaskDate,$TBADDTaskStatus,$TBADDTaskRemindBefore,$TBADDTaskPhone,$TBADDTaskRemarks,'ADD','0','0',$ReminderBookingId,$user_id); 
                //             }
                           
                //             mysqli_commit($con);
                //             echo json_encode(array('addTicketBooking' => '1', 'BookingId' => $ticketTempMaxId, 'BookingCareoff' => $TicketCareOf, 'BookingAmount' => $TicketOurRate));
                //         }
                //         else{
                //             mysqli_rollback($con);
                //             echo json_encode(array('addTicketBooking' => '2'));
                //         }
    
                //     }
                //     else{
                //         mysqli_rollback($con);
                //         echo json_encode(array('addTicketBooking' => '2'));
                //     }
    
                // }
                // else{
                //     mysqli_rollback($con);
                //     echo json_encode(array('addTicketBooking' => '2'));
                // }

                
    
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addTicketBooking' => '2'));
            }

        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('addTicketBooking' => '0'));
        }


        
    }



    //Update Tickets
    if (isset($_POST['UpdateTicketId'])) {
        mysqli_autocommit($con, FALSE);

        $UpdateTicketId = SanitizeInt($_POST['UpdateTicketId']);
        $UpdateTicketPassenger = SanitizeInput($_POST['UpdateTicketPassenger']);
        $UpdateTicketFrom = SanitizeInt($_POST['UpdateTicketFrom']);
        $UpdateTicketTo = SanitizeInt($_POST['UpdateTicketTo']);
        $UpdateTicketDate = (($_POST['UpdateTicketDeparture']) != '') ? SanitizeInput($_POST['UpdateTicketDeparture']) : '0000-00-00' ;
        $UpdateTicketPhone = ($_POST['UpdateTicketPhone'] == '') ? 0 : SanitizeInt($_POST['UpdateTicketPhone']);
        $UpdateTicketIdProof = SanitizeInput($_POST['UpdateTicketProof']);
        $UpdateTicketIdProofNo = SanitizeInput($_POST['UpdateTicketProofNo']);
        $UpdateTicketCareOf = SanitizeInt($_POST['UpdateTicketCareof']);
        $UpdateTicketAONumber = SanitizeInt($_POST['UpdateTicketAONumber']);
        $UpdateTicketStatus = SanitizeInput($_POST['UpdateTicketStatus']);
        $UpdateTicketOurRate = ($_POST['UpdateTicketAmount'] == '') ? 0 : SanitizeDecimal($_POST['UpdateTicketAmount']);
        $UpdateTicketAgencyRate = ($_POST['UpdateTicketAgencyRate'] == '') ? 0 : SanitizeDecimal($_POST['UpdateTicketAgencyRate']);
        $UpdateTicketBookingAgency = SanitizeInt($_POST['UpdateTicketBookingAgency']);
        $UpdateTicketType = ($UpdateTicketBookingAgency == 7) ? "Normal" : "Group";


        $FindTicketType = mysqli_query($con, "SELECT tType FROM ticket_booking_table WHERE tbId = '$UpdateTicketId'");
        foreach($FindTicketType as $FindTicketTypeResult){
            $TicketTypeCheck = $FindTicketTypeResult['tType'];
        }


        if($UpdateTicketType != $TicketTypeCheck){
            mysqli_rollback($con);
            echo json_encode(array('UpdateTicketBooking' => '3'));
        }else{
            if($UpdateTicketFrom != $UpdateTicketTo){
                $findTicketAmount = mysqli_query($con, "SELECT tAgencyamount FROM ticket_booking_table WHERE tbId = '$UpdateTicketId'");
                foreach($findTicketAmount as $findTicketAmountResult){
                    $TicketAgencyAmount = $findTicketAmountResult['tAgencyamount'];
                }
    
        
                $update_Ticket_query =  mysqli_query($con, "UPDATE `ticket_booking_table` SET `tPassenger`='$UpdateTicketPassenger',`tFrom`='$UpdateTicketFrom',`tTo`='$UpdateTicketTo',`tDeparture`='$UpdateTicketDate',`tPhone`='$UpdateTicketPhone',`tProof`='$UpdateTicketIdProof',`tProofNo`='$UpdateTicketIdProofNo',`tbCareoff`='$UpdateTicketCareOf',`tAoNumber` = '$UpdateTicketAONumber',`tAgency`= '$UpdateTicketBookingAgency',`tAmount`='$UpdateTicketOurRate',`tAgencyamount`= '$UpdateTicketAgencyRate',`tStatus`='$UpdateTicketStatus' WHERE tbId = '$UpdateTicketId'");
        
                if ($update_Ticket_query) {
        
                    $connString = $con;
                    $UTBvType = 'TB';//voucher type for Ticket booking
                    $UTBtoId = $UpdateTicketCareOf;
                    $UTBbyId = '3'; //Ticket Booking id
                    $UTBaction = 'EDITBOOKING';
                    $UTBamount = $UpdateTicketOurRate;
                    $UTBremarks = 'Passenger:'.$UpdateTicketPassenger.' , AO No:'.$UpdateTicketAONumber.' , Application Date:'.$UpdateTicketDate;
                    $UTBvoucherDate = $dateToday;
                    $UTBreceivedBy = '';
                    // $UTBAgencyvType = 'TBA';//voucher type for agency Ticket booking
                    $UTBAbyId = $UpdateTicketBookingAgency;
                    $UTBAtoId = '3'; //ticket id
                    $UTBAgencyvType = ($UpdateTicketBookingAgency == 7) ? "PD" : "GRP";//voucher type for agency Ticket booking ,GRP => Group Ticket ,TBP => Ticket From Portal 
                    
        
                    $UpdateTicketBookingLedger = ledgerTransactions($UTBvType, $UTBtoId, $UTBbyId, $UTBamount, $user_id, $UTBaction, $UTBremarks, $UpdateTicketId ,$UTBvoucherDate,$UTBreceivedBy,$UpdateTicketId,$connString);
        
                    $UpdateTicketBookingAgencyLedger = ledgerTransactions($UTBAgencyvType, $UTBAtoId, $UTBAbyId, $UpdateTicketAgencyRate, $user_id, $UTBaction, $UTBremarks, $UpdateTicketId ,$UTBvoucherDate,$UTBreceivedBy,$UpdateTicketId,$connString);


                    if($UpdateTicketBookingLedger == 'Success' && $UpdateTicketBookingAgencyLedger == 'Success'){
                        if($UpdateTicketDate != '0000-00-00'){

                            $FindCareOff = mysqli_query($con, "SELECT firstName FROM accounts WHERE Aid = '$UpdateTicketCareOf'");
                            foreach($FindCareOff as $FindCareOffResult){
                                $CareOffName = $FindCareOffResult['firstName'];
                            }
                            $FindCountry = mysqli_query($con, "SELECT countryName FROM country_master WHERE cId = '$UpdateTicketTo'");
                            foreach($FindCountry as $FindCountryResult){
                                $ToCountryName = $FindCountryResult['countryName'];
                            }

                            $TBUPDTaskName = ($UpdateTicketBookingAgency == 7) ? ('Ticket - '.$UpdateTicketPassenger) : ('Group Ticket - '.$UpdateTicketPassenger);

        
                            //$TBUPDTaskName = 'Ticket - '.$UpdateTicketPassenger;
                            $TBUPDTaskDate  = $UpdateTicketDate;
                            $TBUPDTaskStatus  = 'Pending';
                            $TBUPDTaskRemindBefore  = '7';
                            $TBUPDTaskPhone  = $UpdateTicketPhone;
                            $TBUPDTaskRemarks  = 'To - '.$ToCountryName.' , CareOff- '.$CareOffName;
                            $TBUPDReminderBookingId = 'TB-'.$UpdateTicketId;
        
                            
        
        
                            $CheckReminderExits = mysqli_query($con, "SELECT * FROM taskreminder WHERE taskBookingId = '$TBUPDReminderBookingId'");
                            if(mysqli_num_rows($CheckReminderExits) > 0){
                                $TBUPDTaskResults = TaskReminder($connString,'',$TBUPDTaskName,$TBUPDTaskDate,$TBUPDTaskStatus,$TBUPDTaskRemindBefore,$TBUPDTaskPhone,$TBUPDTaskRemarks,'EDITBOOKING','0','0',$TBUPDReminderBookingId,$user_id); 
                            }else{
                                $TBUPDTaskResults = TaskReminder($connString,'',$TBUPDTaskName,$TBUPDTaskDate,$TBUPDTaskStatus,$TBUPDTaskRemindBefore,$TBUPDTaskPhone,$TBUPDTaskRemarks,'ADD','0','0',$TBUPDReminderBookingId,$user_id); 
                            }
        
                        }
        
                        mysqli_commit($con);
                        echo json_encode(array('UpdateTicketBooking' => '1'));
                    }
                
                    // if($UpdateTicketBookingLedger == 'Success' && $UpdateTicketBookingAgencyLedger == 'Success'){
        
        
                    //     $ChangeInTicket = $TicketAgencyAmount - $UpdateTicketAgencyRate;
        
                    //     //echo $ChangeInTicket;
        
                    //     $connString = $con;
                    //     $action = 'RECHARGE';
                    //     $amount = $ChangeInTicket;
                    //     $bonus = '0';
                    //     $from = '3';// ticket booking id
                    //     $transactionDate = $dateToday;
                    //     $userid = $user_id; 
                    //     $particularId = '1';
                    //     $particularName = 'PORTAL BALANCE';
                
                    //     $AddPortalRecharge =  PortalTransactions($connString,$action,$amount,$bonus,$from,$transactionDate,$userid,$particularId,$particularName);
        
                    //     if($AddPortalRecharge == 'Success'){
        
                    //         $PDvType = 'PD'; // portal deduction
                    //         $PDtoId = '3'; // ticket booking id
                    //         $PDbyId = '7';  //PORTAL ID 
                    //         $PDaction = 'EDITBOOKING';
                    //         $PDamount = $UpdateTicketAgencyRate;
                    //         $PDremarks = $UTBremarks;
                    //         $PDDate = $dateToday;
                    //         $PDReceivedBy = '';
                    //         $PDvoucherNo = $UpdateTicketId;
                
                    //         // ticketbooking to portal
                    //         $PDResult = ledgerTransactions($PDvType, $PDtoId, $PDbyId, $PDamount, $user_id, $PDaction, $PDremarks, $PDvoucherNo, $PDDate, $PDReceivedBy,$UpdateTicketId,$connString);
        
                    //         if($PDResult == 'Success'){

                    //             if($UpdateTicketDate != '0000-00-00'){

                    //                 $FindCareOff = mysqli_query($con, "SELECT firstName FROM accounts WHERE Aid = '$UpdateTicketCareOf'");
                    //                 foreach($FindCareOff as $FindCareOffResult){
                    //                     $CareOffName = $FindCareOffResult['firstName'];
                    //                 }
                    //                 $FindCountry = mysqli_query($con, "SELECT countryName FROM country_master WHERE cId = '$UpdateTicketTo'");
                    //                 foreach($FindCountry as $FindCountryResult){
                    //                     $ToCountryName = $FindCountryResult['countryName'];
                    //                 }

                    //                 $TBUPDTaskName = 'Ticket - '.$UpdateTicketPassenger;
                    //                 $TBUPDTaskDate  = $UpdateTicketDate;
                    //                 $TBUPDTaskStatus  = 'Pending';
                    //                 $TBUPDTaskRemindBefore  = '7';
                    //                 $TBUPDTaskPhone  = $UpdateTicketPhone;
                    //                 $TBUPDTaskRemarks  = 'To - '.$ToCountryName.' , CareOff- '.$CareOffName;
                    //                 $TBUPDReminderBookingId = 'TB-'.$UpdateTicketId;

                                    


                    //                 $CheckReminderExits = mysqli_query($con, "SELECT * FROM taskreminder WHERE taskBookingId = '$TBUPDReminderBookingId'");
                    //                 if(mysqli_num_rows($CheckReminderExits) > 0){
                    //                     $TBUPDTaskResults = TaskReminder($connString,'',$TBUPDTaskName,$TBUPDTaskDate,$TBUPDTaskStatus,$TBUPDTaskRemindBefore,$TBUPDTaskPhone,$TBUPDTaskRemarks,'EDITBOOKING','0','0',$TBUPDReminderBookingId,$user_id); 
                    //                 }else{
                    //                     $TBUPDTaskResults = TaskReminder($connString,'',$TBUPDTaskName,$TBUPDTaskDate,$TBUPDTaskStatus,$TBUPDTaskRemindBefore,$TBUPDTaskPhone,$TBUPDTaskRemarks,'ADD','0','0',$TBUPDReminderBookingId,$user_id); 
                    //                 }

                    //             }

                    //             mysqli_commit($con);
                    //             echo json_encode(array('UpdateTicketBooking' => '1'));
                    //         }
                    //         else{
                    //             mysqli_rollback($con);
                    //             echo json_encode(array('UpdateTicketBooking' => '2'));
                    //         }
        
                            
                    //     }
                    //     else{
                    //         mysqli_rollback($con);
                    //         echo json_encode(array('UpdateTicketBooking' => '2'));
                    //     }
                        
                    // }
                    // else{
                    //     mysqli_rollback($con);
                    //     echo json_encode(array('UpdateTicketBooking' => '2'));
                    // }
        
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('UpdateTicketBooking' => '2'));
                }
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('UpdateTicketBooking' => '0'));
            }
        }


    }



    //Delete Tickets
    if (isset($_POST['CTicket'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteTicket = SanitizeInt($_POST['CTicket']);

        $delete_Ticket_query =  mysqli_query($con, "UPDATE ticket_booking_table SET cancelStatus = '1' WHERE tbId = '$DeleteTicket'");
        if ($delete_Ticket_query) {

            $DeleteTicketvType = 'TB';
            $DeleteTickettoId = '';
            $DeleteTicketbyId = '';
            $DeleteTicketamount = '';
            $DeleteTicketuserid = '';
            $DeleteTicketaction = 'CANCEL';
            $DeleteTicketremarks = '';
            $DeleteTicketvoucherNo = $DeleteTicket;
            $DeleteTicketvoucherDate = '';
            $DeleteTicketreceivedby = '';
            $DeleteTicketconnString = $con;
            $DeleteTicketBookingId = 0;

            $DeleteTicketAgencyvType = 'TBA';
            $DeleteTicketAgencytoId = '';
            $DeleteTicketAgencybyId = '';
            $DeleteTicketAgencyamount = '';
            $DeleteTicketAgencyuserid = '';
            $DeleteTicketAgencyaction = 'CANCEL';
            $DeleteTicketAgencyremarks = '';
            $DeleteTicketAgencyvoucherNo = $DeleteTicket;
            $DeleteTicketAgencyvoucherDate = '';
            $DeleteTicketAgencyreceivedby = '';
            $DeleteTicketAgencyconnString = $con;


            $findTicketAmount = mysqli_query($con, "SELECT tAgencyamount FROM ticket_booking_table WHERE tbId = '$DeleteTicket'");
            foreach($findTicketAmount as $findTicketAmountResult){
                $TicketAgencyAmount = $findTicketAmountResult['tAgencyamount'];
            }

            $DeleteAllReceipt = mysqli_query($con, "UPDATE account_transactions SET hiddenStatus = '1' WHERE voucherType = 'RV' AND bookingId = '$DeleteTicket'");
            if($DeleteAllReceipt){

                $TicketDeleteTransaction = ledgerTransactions($DeleteTicketvType, $DeleteTickettoId, $DeleteTicketbyId, $DeleteTicketamount, $user_id, $DeleteTicketaction, $DeleteTicketremarks, $DeleteTicketvoucherNo, $DeleteTicketvoucherDate, $DeleteTicketreceivedby,$DeleteTicketBookingId,$DeleteTicketconnString);

                $TicketDeleteAgencyTransaction = ledgerTransactions($DeleteTicketAgencyvType, $DeleteTicketAgencytoId, $DeleteTicketAgencybyId, $DeleteTicketAgencyamount, $user_id, $DeleteTicketAgencyaction, $DeleteTicketAgencyremarks, $DeleteTicketAgencyvoucherNo, $DeleteTicketAgencyvoucherDate, $DeleteTicketAgencyreceivedby,$DeleteTicketBookingId,$DeleteTicketAgencyconnString);
    
                if($TicketDeleteTransaction == 'Success' && $TicketDeleteAgencyTransaction == 'Success'){
    
                    $connString = $con;
                    $action = 'RECHARGE';
                    $amount = '+'.$TicketAgencyAmount;
                    $bonus = '0';
                    $from = '3';// ticket booking id
                    $transactionDate = $dateToday;
                    $userid = $user_id; 
                    $particularId = '1';
                    $particularName = 'PORTAL BALANCE';
            
                    $AddPortalRecharge =  PortalTransactions($connString,$action,$amount,$bonus,$from,$transactionDate,$userid,$particularId,$particularName);
    
                    if($AddPortalRecharge == 'Success'){
    
                        $PRvType = 'PR'; // portal refund
                        $PRtoId = '7'; //PORTAL ID 
                        $PRbyId = '3';// ticket booking id 
                        $PRaction = 'ADD';
                        $PRamount = $TicketAgencyAmount;
                        $PRremarks = 'ticket booking refund';
                        $PRDate = $dateToday;
                        $PRReceivedBy = '';
                        $PRvoucherNo = $DeleteTicket;
            
                        // ticketbooking to portal
                        $PRResult = ledgerTransactions($PRvType, $PRtoId, $PRbyId, $PRamount, $user_id, $PRaction, $PRremarks, $PRvoucherNo, $PRDate, $PRReceivedBy,$DeleteTicketBookingId,$connString);
    
                        if($PRResult == 'Success'){
                            $DeleteReminderId = 'TB-'.$DeleteTicket;
                            TaskReminder($DeleteTicketconnString,'','','','','','','','REMOVEBOOKING','','',$DeleteReminderId,'');

                            mysqli_commit($con);
                            echo json_encode(array('CancelTicket' => '1'));
                        }
                        else{
                            mysqli_rollback($con);
                            echo json_encode(array('CancelTicket' => '2'));
                        }
                    }
                    else{
                        mysqli_rollback($con);
                        echo json_encode(array('CancelTicket' => '2'));
                    }
    
                }
                else{
                    mysqli_rollback($con);
                    echo json_encode(array('CancelTicket' => '2'));
                }

            }else{
                mysqli_rollback($con);
                echo json_encode(array('CancelTicket' => '2'));
            }


        } else {
            mysqli_rollback($con);
            echo json_encode(array('CancelTicket' => '2'));
        }
    }   


    //Payment Form
    if(isset($_POST['TBookingId'])){

        mysqli_autocommit($con, FALSE);

        $ModeofPay = array();

        $PayTBookingId = $_POST['TBookingId'];
        $PayTBookingAmount = $_POST['TBookingAmount'];
        $PayTBookingCareoff = $_POST['TBookingCareoff'];

        foreach($_POST['ModePay'] as $Values){
            array_push($ModeofPay,$Values);
        }

        $Pay6  = $_POST['UpiAmount'];
        $Pay10  = $_POST['BankAmount'];
        $Pay2  = $_POST['CashAmount'];


        foreach($ModeofPay as $PayModes){

            if($PayModes == '6'){
                $RVamount = $Pay6;
            }
            elseif($PayModes == '10'){
                $RVamount = $Pay10;
            }
            else{
                $RVamount = $Pay2;
            }

            if($RVamount > 0){
                $connString = $con;
                $RVvType = 'RV';
                $RVtoId =  $PayModes;
                $RVbyId = $PayTBookingCareoff;
                $RVaction = 'ADD';
                $RVremarks = 'TicketBookingID-'.$PayTBookingId;
                $RVDate = $dateToday;
                $RVReceivedBy = '';
                $RVvoucherNo = $PayTBookingId;
        
                $RVResult = ledgerTransactions($RVvType, $RVtoId, $RVbyId, $RVamount, $user_id, $RVaction, $RVremarks, $RVvoucherNo, $RVDate, $RVReceivedBy,$PayTBookingId,$connString);
        
            }
            else{
                $RVResult = '';
            }

        }


        if($RVResult == 'Success'){
            mysqli_commit($con);
            echo json_encode(array('addMOPVoucher' => '1'));
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('addMOPVoucher' => '2'));
        }
        

    }


    //Find Ticket Details
    if(isset($_POST['CancelTicketFetch'])){
        $FetchTicketId = $_POST['CancelTicketFetch'];
        $FetchTicketDetails = mysqli_query($con, "SELECT tAgencyamount,tAmount,tAoNumber,tDeparture FROM ticket_booking_table WHERE tbId = '$FetchTicketId'");
        if(mysqli_num_rows($FetchTicketDetails) > 0){
            foreach($FetchTicketDetails as $FetchTicketDetailsResult){
                $OurRate = $FetchTicketDetailsResult['tAmount'];
                $AgencyRate = $FetchTicketDetailsResult['tAgencyamount'];
                $AONumber = $FetchTicketDetailsResult['tAoNumber'];
                $DepartureDate = $FetchTicketDetailsResult['tDeparture'];
            }
            echo json_encode(array('Status' => 1, 'OurRate' => $OurRate, 'AgencyRate' => $AgencyRate, 'AONumber' => $AONumber, 'DepartureDate' => $DepartureDate));
        }else{
            echo json_encode(array('Status' => 0));
        }
    } 


    //Cancel Ticket Booking
    if(isset($_POST['CancelTicketBookingId'])){
        $CancelTicketBookingId = SanitizeInt($_POST['CancelTicketBookingId']);
        $CustomerRefundAmount = SanitizeDecimal($_POST['RefundAmount']);
        $PenaltyAmount = SanitizeDecimal($_POST['PenaltyAmount']);

        $FetchTicketDetails = mysqli_query($con, "SELECT tAgencyamount,tAmount,tbCareoff,tStatus,tType FROM ticket_booking_table WHERE tbId = '$CancelTicketBookingId'");
        foreach($FetchTicketDetails as $FetchTicketDetailsResult){
            $OurRate = $FetchTicketDetailsResult['tAmount'];
            $AgencyRate = $FetchTicketDetailsResult['tAgencyamount'];
            $Customer = $FetchTicketDetailsResult['tbCareoff'];  
            $Status = $FetchTicketDetailsResult['tStatus'];  
            $Type = $FetchTicketDetailsResult['tType'];  
        }

        if($Type == 'Normal'){
            if($Status == 'Cancelled'){
                echo json_encode(array('CancelStatus' => '4'));//Ticket Already cancelled
            }else{
    
                $RefundAmount = $AgencyRate - $PenaltyAmount;
                $PRvType = 'PR'; // portal refund
                $PRtoId = '7'; //PORTAL ID 
                $PRbyId = '3'; // ticket booking id 
                $PRaction = 'ADD';
                $PRamount = $RefundAmount;
                $PRremarks = 'Ticket Cancellation Refund';
                $PRDate = $dateToday;
                $PRReceivedBy = '';
                $PRvoucherNo = $CancelTicketBookingId;
                $connString = $con;
                //Ticketbooking to portal
                $PortalRefund = ledgerTransactions($PRvType, $PRtoId, $PRbyId, $PRamount, $user_id, $PRaction, $PRremarks, $PRvoucherNo, $PRDate, $PRReceivedBy,$CancelTicketBookingId,$connString);
        
                $TBvType = 'TBR';//voucher type for Ticket booking to refund
                $TBtoId = '9';
                $TBbyId = '3'; //Ticket Booking id
                $TBaction = 'ADD';
                $TBamount = $CustomerRefundAmount;
                $TBremarks = 'Ticket Booking To Refund';
                $TBvoucherDate = $dateToday;
                $TBreceivedBy = '';
                //Ticket Booking to Refund
                $TicketBookingToRefund = ledgerTransactions($TBvType, $TBtoId, $TBbyId, $TBamount, $user_id, $TBaction, $TBremarks, $CancelTicketBookingId,$TBvoucherDate,$TBreceivedBy,$CancelTicketBookingId,$connString);

                $RFvType = 'RF';//voucher type for Customer to Refund
                $RFtoId = '9';
                $RFbyId = $Customer;
                $RFaction = 'ADD';
                $RFamount = $CustomerRefundAmount;
                $RFremarks = 'Customer Refund ';
                $RFvoucherDate = $dateToday;
                $RFreceivedBy = '';
                //Ticket Booking to Refund
                $TicketBookingRefund = ledgerTransactions($RFvType, $RFtoId, $RFbyId, $RFamount, $user_id, $RFaction, $RFremarks, $CancelTicketBookingId,$RFvoucherDate,$RFreceivedBy,$CancelTicketBookingId,$connString);
        
                if($PortalRefund == 'Success' && $TicketBookingToRefund == 'Success' && $TicketBookingRefund == 'Success'){
                    $ChangeTicketStatus = mysqli_query($con,"UPDATE ticket_booking_table SET tStatus = 'Cancelled' WHERE tbId = '$CancelTicketBookingId'");
                    if($ChangeTicketStatus){
                        mysqli_commit($con);
                        echo json_encode(array('CancelStatus' => '1'));
                    }else{
                        mysqli_rollback($con);
                        echo json_encode(array('CancelStatus' => '2'));
                    }
                }else{
                    mysqli_rollback($con);
                    echo json_encode(array('CancelStatus' => '2'));
                }
            }
        }else{
            echo json_encode(array('CancelStatus' => '3'));//Cannot cancel group ticket
        }
    } 



    //Extend Ticket Booking
    if(isset($_POST['TicketExtendId'])){
        $TicketExtendId = SanitizeInt($_POST['TicketExtendId']);
        $ExtendedOurRate = SanitizeDecimal($_POST['NewTicketExtendOurRate']);
        $ExtendedAgencyRate = SanitizeDecimal($_POST['NewTicketExtendAgencyRate']);
        $ExtendedAoNumber = SanitizeInput($_POST['NewTicketExtendAO']);
        $ExtendedDepartureDate = SanitizeInput($_POST['NewTicketExtendDate']);

        $FetchTicketDetails = mysqli_query($con, "SELECT tPassenger,tAgencyamount,tAmount,tbCareoff,tStatus,tType,tDeparture,tAoNumber FROM ticket_booking_table WHERE tbId = '$TicketExtendId'");
        foreach($FetchTicketDetails as $FetchTicketDetailsResult){
            $OurRate = $FetchTicketDetailsResult['tAmount'];
            $AgencyRate = $FetchTicketDetailsResult['tAgencyamount'];
            $Customer = $FetchTicketDetailsResult['tbCareoff'];  
            $Status = $FetchTicketDetailsResult['tStatus'];  
            $Type = $FetchTicketDetailsResult['tType'];  
            $AONumber = $FetchTicketDetailsResult['tAoNumber'];  
            $TicketExtendPassenger = $FetchTicketDetailsResult['tPassenger'];  
            $TicketExtendOldDate = $FetchTicketDetailsResult['tDeparture'];  
        }

        $TableOurRate = $OurRate + $ExtendedOurRate;
        $TableAgencyRate = $AgencyRate + $ExtendedAgencyRate;

        if($Type == 'Normal'){
            if($Status == 'Cancelled'){
                echo json_encode(array('ExtendTicket' => '4'));//Ticket Already cancelled
            }else{

                $PRvType = 'PDE'; // portal deduction
                $PRtoId = '3'; // ticket booking id
                $PRbyId = '7'; //PORTAL ID 
                $PRaction = 'ADD';
                $PRamount = $ExtendedAgencyRate;
                $PRremarks = 'Ticket Extend , Passenger:'.$TicketExtendPassenger.' , AO No:'.$ExtendedAoNumber.' , Extended Date:'.$ExtendedDepartureDate;
                $PRDate = $dateToday;
                $PRReceivedBy = '';
                $PRvoucherNo = $TicketExtendId;
                $connString = $con;
                //Portal to Ticket Booking
                $PortalDeduct = ledgerTransactions($PRvType, $PRtoId, $PRbyId, $PRamount, $user_id, $PRaction, $PRremarks, $PRvoucherNo, $PRDate, $PRReceivedBy,$TicketExtendId,$connString);
        
                $TBvType = 'TBE';//voucher type for Ticket booking Extend
                $TBtoId = $Customer;
                $TBbyId = '3'; //Ticket Booking id
                $TBaction = 'ADD';
                $TBamount = $ExtendedOurRate;
                $TBremarks = 'Extend Ticket Booking Penalty';
                $TBvoucherDate = $dateToday;
                $TBreceivedBy = '';
                //Ticket Booking to Customer
                $ExtendTicketBookingLedger = ledgerTransactions($TBvType, $TBtoId, $TBbyId, $TBamount, $user_id, $TBaction, $TBremarks, $TicketExtendId,$TBvoucherDate,$TBreceivedBy,$TicketExtendId,$connString);
        
                if($PortalDeduct == 'Success' && $ExtendTicketBookingLedger == 'Success'){

                    $InsertIntoTicketExtend = mysqli_query($con, "INSERT INTO `ticketextend`(`ticketBookingId`,`oldDate`,`newDate`,`oldAgencyRate`,`newAgencyRate`,`oldOurRate`,`newOurRate`,`oldAoNumber`,`newAoNumber`,`createdBy`,`createdDate`) VALUES ('$TicketExtendId','$TicketExtendOldDate','$ExtendedDepartureDate','$AgencyRate','$TableAgencyRate','$OurRate','$TableOurRate','$AONumber','$ExtendedAoNumber','$user_id','$dateToday');
                    ");
                    if($InsertIntoTicketExtend){
                        $ChangeTicketStatus = mysqli_query($con,"UPDATE ticket_booking_table SET tType = 'Extended',tDeparture = '$ExtendedDepartureDate',tAmount = tAmount + $ExtendedOurRate,tAgencyamount = tAgencyamount + $ExtendedAgencyRate WHERE tbId = '$TicketExtendId'");
                        if($ChangeTicketStatus){
                            mysqli_commit($con);
                            echo json_encode(array('ExtendTicket' => '1'));
                        }else{
                            mysqli_rollback($con);
                            echo json_encode(array('ExtendTicket' => '2'));
                        }
                    }
                }else{
                    mysqli_rollback($con);
                    echo json_encode(array('ExtendTicket' => '2'));
                }
            }
        }else{
            echo json_encode(array('ExtendTicket' => '3'));//Cannot cancel group ticket
        }
    } 

////////////////////////Ticket Booking///////////////////////////////////





//////////////////////// Dummy Ticket Booking///////////////////////////////////

    //Add Tickets
    if (isset($_POST['DummyTicketPassengerName'])) {
        mysqli_autocommit($con, FALSE);

        $DummyTicketPassenger = SanitizeInput($_POST['DummyTicketPassengerName']);
        $DummyTicketFrom = SanitizeInt($_POST['DummyTicketPassengerFrom']);
        $DummyTicketTo = SanitizeInt($_POST['DummyTicketPassengerTo']);
        $DummyTicketDate = (($_POST['DummyTicketDepartureDate']) != '') ? SanitizeInput($_POST['DummyTicketDepartureDate']) : '0000-00-00' ;
        $DummyTicketPhone = ($_POST['DummyTicketPassengerPhone'] == '') ? 0 : SanitizeInt($_POST['DummyTicketPassengerPhone']);
        $DummyTicketIdProof = SanitizeInput($_POST['DummyTicketIDProof']);
        $DummyTicketIdProofNo = SanitizeInput($_POST['DummyTicketIDProofNo']);
        $DummyTicketCareOf = SanitizeInt($_POST['DummyTicketPassengerCareof']);
        $DummyTicketAONumber = SanitizeInt($_POST['DummyTicketAONumber']);
        $DummyTicketOurRate = ($_POST['DummyTicketOurRate'] == '') ? 0 : SanitizeDecimal($_POST['DummyTicketOurRate']);
        $DummyTicketStatus = SanitizeInput($_POST['DummyTicketApproval']);
        $DummyTicketType = "Dummy Ticket";
        $DummyTicketAgencyRate = ($_POST['DummyTicketAgencyRate'] == '') ? 0 : SanitizeDecimal($_POST['DummyTicketAgencyRate']);
        $DummyTicketBookingAgency = ($_POST['DummyTicketBookingAgency'] == '') ? 0 : SanitizeInt($_POST['DummyTicketBookingAgency']);
        if($Branch == 'TEZZA'){
            $DummyTicketType = ($DummyTicketBookingAgency == 0) ? "Dummy Normal" : "Dummy Group";
        }else{
            $DummyTicketType = ($DummyTicketBookingAgency == 7) ? "Dummy Normal" : "Dummy Group";
        }
        
        if($DummyTicketFrom != $DummyTicketTo){
            $find_max_ticketTemp = mysqli_query($con, "SELECT MAX(tbId) FROM ticket_booking_table");
            foreach ($find_max_ticketTemp  as $max_ticketTemp_id) {
                $ticketTempMaxId = $max_ticketTemp_id['MAX(tbId)'] + 1;
            }
    
            $add_ticket_query =  mysqli_query($con, "INSERT INTO `ticket_booking_table`(`tbId`, `tPassenger`, `tFrom`, `tTo`, `tDeparture`, `tPhone`, `tProof`, `tProofNo`,`tType`,`tAgency`, `tAmount`,`tAgencyamount`, `tStatus`,`tbCareoff`,`tAoNumber`,`bookingStatus`,`createdBy`, `createdDate`) VALUES ('$ticketTempMaxId','$DummyTicketPassenger','$DummyTicketFrom','$DummyTicketTo','$DummyTicketDate','$DummyTicketPhone','$DummyTicketIdProof','$DummyTicketIdProofNo','$DummyTicketType','$DummyTicketBookingAgency','$DummyTicketOurRate','$DummyTicketAgencyRate','$DummyTicketStatus','$DummyTicketCareOf','$DummyTicketAONumber','0','$user_id','$dateToday')");
    
            if ($add_ticket_query) {
    
                $connString = $con;
                $TBvType = 'DT';//voucher type for Ticket booking
                $TBtoId = $DummyTicketCareOf;
                $TBbyId = '3'; //Ticket Booking id
                $TBaction = 'ADD';
                $TBamount = $DummyTicketOurRate;
                //$TBremarks = 'TicketBookId:'.$ticketTempMaxId .' - Date:'.$dateToday;
                $TBremarks = 'Passenger:'.$DummyTicketPassenger.' , AO No:'.$DummyTicketAONumber.' , Application Date:'.$DummyTicketDate;
                $TBvoucherDate = $dateToday;
                $TBreceivedBy = '';
                //$TBAgencyvType = 'TBA';//voucher type for agency Ticket booking
                $TBAbyId = $DummyTicketBookingAgency;
                $TBAtoId = '3'; //ticket id
                $TBAgencyvType = ($DummyTicketBookingAgency == 7) ? "DP" : "DGRP";//voucher type for agency Ticket booking ,DGRP => Dummy Group ,DP =>  Dummy Ticket From Portal 
                
                if($DummyTicketAgencyRate == 0 && $DummyTicketBookingAgency == 0){
                    $TicketBookingAgencyLedger = 'Success';
                }else{
                    $TicketBookingAgencyLedger = ledgerTransactions($TBAgencyvType, $TBAtoId, $TBAbyId, $DummyTicketAgencyRate, $user_id, $TBaction, $TBremarks, $ticketTempMaxId ,$TBvoucherDate,$TBreceivedBy,$ticketTempMaxId,$connString,1);
                }

                $TicketBookingLedger = ledgerTransactions($TBvType, $TBtoId, $TBbyId, $TBamount, $user_id, $TBaction, $TBremarks, $ticketTempMaxId ,$TBvoucherDate,$TBreceivedBy,$ticketTempMaxId,$connString,1);
                
                if($TicketBookingLedger == 'Success' && $TicketBookingAgencyLedger == 'Success'){

                    if($DummyTicketDate != '0000-00-00'){

                        $FindCareOff = mysqli_query($con, "SELECT firstName FROM accounts WHERE Aid = '$DummyTicketCareOf'");
                        foreach($FindCareOff as $FindCareOffResult){
                            $CareOffName = $FindCareOffResult['firstName'];
                        }
                        $FindCountry = mysqli_query($con, "SELECT countryName FROM country_master WHERE cId = '$DummyTicketTo'");
                        foreach($FindCountry as $FindCountryResult){
                            $ToCountryName = $FindCountryResult['countryName'];
                        }

                        // $TBADDTaskName = ($TicketBookingAgency == 7) ? ('Ticket - '.$TicketPassenger) : ('Group Ticket - '.$TicketPassenger);
                        $TBADDTaskName = "Dummy Ticket";
                        // $TBADDTaskName = 'Ticket - '.$TicketPassenger;
                        $TBADDTaskDate  = $DummyTicketDate;
                        $TBADDTaskStatus  = 'Pending';
                        $TBADDTaskRemindBefore  = '1';
                        $TBADDTaskPhone  = $DummyTicketPhone;
                        $TBADDTaskRemarks  = 'To - '.$ToCountryName.' , CareOff- '.$CareOffName;
                        $ReminderBookingId = 'DT-'.$ticketTempMaxId;
                        $TBADDTaskResults = TaskReminder($connString,'',$TBADDTaskName,$TBADDTaskDate,$TBADDTaskStatus,$TBADDTaskRemindBefore,$TBADDTaskPhone,$TBADDTaskRemarks,'ADD','0','0',$ReminderBookingId,$user_id); 
                    }
                    
                    mysqli_commit($con);
                    echo json_encode(array('addTicketBooking' => '1', 'BookingId' => $ticketTempMaxId, 'BookingCareoff' => $DummyTicketCareOf, 'BookingAmount' => $DummyTicketOurRate));
                }else{
                    mysqli_rollback($con);
                    echo json_encode(array('addTicketBooking' => '2'));
                }

            } else {
                mysqli_rollback($con);
                echo json_encode(array('addTicketBooking' => '2'));
            }

        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('addTicketBooking' => '0'));
        }
    }



    //Update Tickets
    if (isset($_POST['DummyUpdateTicketId'])) {
        mysqli_autocommit($con, FALSE);

        $DummyUpdateTicketId = SanitizeInt($_POST['DummyUpdateTicketId']);
        $DummyUpdateTicketPassenger = SanitizeInput($_POST['DummyUpdateTicketPassenger']);
        $DummyUpdateTicketFrom = SanitizeInt($_POST['DummyUpdateTicketFrom']);
        $DummyUpdateTicketTo = SanitizeInt($_POST['DummyUpdateTicketTo']);
        $DummyUpdateTicketDate = (($_POST['DummyUpdateTicketDeparture']) != '') ? SanitizeInput($_POST['DummyUpdateTicketDeparture']) : '0000-00-00' ;
        $DummyUpdateTicketPhone = ($_POST['DummyUpdateTicketPhone'] == '') ? 0 : SanitizeInt($_POST['DummyUpdateTicketPhone']);
        $DummyUpdateTicketIdProof = SanitizeInput($_POST['DummyUpdateTicketProof']);
        $DummyUpdateTicketIdProofNo = SanitizeInput($_POST['DummyUpdateTicketProofNo']);
        $DummyUpdateTicketCareOf = SanitizeInt($_POST['DummyUpdateTicketCareof']);
        $DummyUpdateTicketAONumber = SanitizeInt($_POST['DummyUpdateTicketAONumber']);
        $DummyUpdateTicketStatus = SanitizeInput($_POST['DummyUpdateTicketStatus']);
        $DummyUpdateTicketOurRate = ($_POST['DummyUpdateTicketAmount'] == '') ? 0 : SanitizeDecimal($_POST['DummyUpdateTicketAmount']);
        $DummyUpdateTicketAgencyRate = ($_POST['DummyUpdateTicketAgencyRate'] == '') ? 0 : SanitizeDecimal($_POST['DummyUpdateTicketAgencyRate']);
        $DummyUpdateTicketBookingAgency = ($_POST['DummyUpdateTicketBookingAgency'] == '') ? 0 : SanitizeInt($_POST['DummyUpdateTicketBookingAgency']);
        if($Branch == 'TEZZA'){
            $DummyUpdateTicketType = ($DummyUpdateTicketBookingAgency == 0) ? "Dummy Normal" : "Dummy Group";
        }else{
            $DummyUpdateTicketType = ($DummyUpdateTicketBookingAgency == 7) ? "Dummy Normal" : "Dummy Group";
        }
        // $DummyUpdateTicketType = "Dummy Ticket"; //($DummyUpdateTicketBookingAgency == 7) ? "Normal" : "Group";

        $FindTicketType = mysqli_query($con, "SELECT tType FROM ticket_booking_table WHERE tbId = '$DummyUpdateTicketId'");
        foreach($FindTicketType as $FindTicketTypeResult){
            $DummyTicketTypeCheck = $FindTicketTypeResult['tType'];
        }

        if($DummyUpdateTicketType != $DummyTicketTypeCheck){
            mysqli_rollback($con);
            echo json_encode(array('UpdateTicketBooking' => '3'));
        }else{
            if($DummyUpdateTicketFrom != $DummyUpdateTicketTo){
                $findTicketAmount = mysqli_query($con, "SELECT tAgencyamount FROM ticket_booking_table WHERE tbId = '$DummyUpdateTicketId'");
                foreach($findTicketAmount as $findTicketAmountResult){
                    $TicketAgencyAmount = $findTicketAmountResult['tAgencyamount'];
                }
    
                $update_Ticket_query =  mysqli_query($con, "UPDATE `ticket_booking_table` SET `tPassenger`='$DummyUpdateTicketPassenger',`tFrom`='$DummyUpdateTicketFrom',`tTo`='$DummyUpdateTicketTo',`tDeparture`='$DummyUpdateTicketDate',`tPhone`='$DummyUpdateTicketPhone',`tProof`='$DummyUpdateTicketIdProof',`tProofNo`='$DummyUpdateTicketIdProofNo',`tbCareoff`='$DummyUpdateTicketCareOf',`tAoNumber` = '$DummyUpdateTicketAONumber',`tAgency`= '$DummyUpdateTicketBookingAgency',`tAmount`='$DummyUpdateTicketOurRate',`tAgencyamount`= '$DummyUpdateTicketAgencyRate',`tStatus`='$DummyUpdateTicketStatus' WHERE tbId = '$DummyUpdateTicketId'");
        
                if ($update_Ticket_query) {
        
                    $connString = $con;
                    $UTBvType = 'DT';//voucher type for Ticket booking
                    $UTBtoId = $DummyUpdateTicketCareOf;
                    $UTBbyId = '3'; //Ticket Booking id
                    $UTBaction = 'EDITBOOKING';
                    $UTBamount = $DummyUpdateTicketOurRate;
                    $UTBremarks = 'Passenger:'.$DummyUpdateTicketPassenger.' , AO No:'.$DummyUpdateTicketAONumber.' , Application Date:'.$DummyUpdateTicketDate;
                    $UTBvoucherDate = $dateToday;
                    $UTBreceivedBy = '';
                    // $UTBAgencyvType = 'TBA';//voucher type for agency Ticket booking
                    $UTBAbyId = $DummyUpdateTicketBookingAgency;
                    $UTBAtoId = '3'; //ticket id
                    $UTBAgencyvType = ($DummyUpdateTicketBookingAgency == 7) ? "DP" : "DGRP";//voucher type for agency Ticket booking ,DGRP => Dummy Group ,DP =>  Dummy Ticket From Portal 

                    if($DummyUpdateTicketAgencyRate == 0 && $DummyUpdateTicketBookingAgency == 0){
                        $UpdateTicketBookingAgencyLedger = 'Success';
                    }else{
                        $UpdateTicketBookingAgencyLedger = ledgerTransactions($UTBAgencyvType, $UTBAtoId, $UTBAbyId, $DummyUpdateTicketAgencyRate, $user_id, $UTBaction, $UTBremarks, $DummyUpdateTicketId ,$UTBvoucherDate,$UTBreceivedBy,$DummyUpdateTicketId,$connString);
                    }

                    $UpdateTicketBookingLedger = ledgerTransactions($UTBvType, $UTBtoId, $UTBbyId, $UTBamount, $user_id, $UTBaction, $UTBremarks, $DummyUpdateTicketId ,$UTBvoucherDate,$UTBreceivedBy,$DummyUpdateTicketId,$connString);
        
                
                    if($UpdateTicketBookingLedger == 'Success' && $UpdateTicketBookingAgencyLedger == 'Success'){
                        if($DummyUpdateTicketDate != '0000-00-00'){

                            $FindCareOff = mysqli_query($con, "SELECT firstName FROM accounts WHERE Aid = '$DummyUpdateTicketCareOf'");
                            foreach($FindCareOff as $FindCareOffResult){
                                $CareOffName = $FindCareOffResult['firstName'];
                            }
                            $FindCountry = mysqli_query($con, "SELECT countryName FROM country_master WHERE cId = '$DummyUpdateTicketTo'");
                            foreach($FindCountry as $FindCountryResult){
                                $ToCountryName = $FindCountryResult['countryName'];
                            }

                            $TBUPDTaskName = "Dummy Ticket"; //($UpdateTicketBookingAgency == 7) ? ('Ticket - '.$UpdateTicketPassenger) : ('Group Ticket - '.$UpdateTicketPassenger);

        
                            //$TBUPDTaskName = 'Ticket - '.$UpdateTicketPassenger;
                            $TBUPDTaskDate  = $DummyUpdateTicketDate;
                            $TBUPDTaskStatus  = 'Pending';
                            $TBUPDTaskRemindBefore  = '1';
                            $TBUPDTaskPhone  = $DummyUpdateTicketPhone;
                            $TBUPDTaskRemarks  = 'To - '.$ToCountryName.' , CareOff- '.$CareOffName;
                            $TBUPDReminderBookingId = 'DT-'.$DummyUpdateTicketId;
        

                            $CheckReminderExits = mysqli_query($con, "SELECT * FROM taskreminder WHERE taskBookingId = '$TBUPDReminderBookingId'");
                            if(mysqli_num_rows($CheckReminderExits) > 0){
                                $TBUPDTaskResults = TaskReminder($connString,'',$TBUPDTaskName,$TBUPDTaskDate,$TBUPDTaskStatus,$TBUPDTaskRemindBefore,$TBUPDTaskPhone,$TBUPDTaskRemarks,'EDITBOOKING','0','0',$TBUPDReminderBookingId,$user_id); 
                            }else{
                                $TBUPDTaskResults = TaskReminder($connString,'',$TBUPDTaskName,$TBUPDTaskDate,$TBUPDTaskStatus,$TBUPDTaskRemindBefore,$TBUPDTaskPhone,$TBUPDTaskRemarks,'ADD','0','0',$TBUPDReminderBookingId,$user_id); 
                            }
        
                        }
        
                        mysqli_commit($con);
                        echo json_encode(array('UpdateTicketBooking' => '1'));
                    }
                
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('UpdateTicketBooking' => '2'));
                }
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('UpdateTicketBooking' => '0'));
            }
        }


    }



    //Delete Tickets
    if (isset($_POST['CDummyTicket'])) {
        mysqli_autocommit($con, FALSE);
        $DeleteTicket = SanitizeInt($_POST['CDummyTicket']);
        $delete_Ticket_query =  mysqli_query($con, "UPDATE ticket_booking_table SET cancelStatus = '1' WHERE tbId = '$DeleteTicket'");
        if ($delete_Ticket_query) {
            $DeleteRelatedVouchers = mysqli_query($con, "UPDATE account_transactions SET hiddenStatus = 1 WHERE bookingId = '$DeleteTicket' AND voucherType IN ('DT','RV','DGRP','DP')");

            if($DeleteRelatedVouchers){
                mysqli_commit($con);
                echo json_encode(array('CancelTicket' => '1'));
            }
        } else {
            mysqli_rollback($con);
            echo json_encode(array('CancelTicket' => '2'));
        }
    }   



    //Payment Form
    if(isset($_POST['DummyTBookingId'])){

        mysqli_autocommit($con, FALSE);

        $DummyModeofPay = array();

        $DummyPayTBookingId = $_POST['DummyTBookingId'];
        $DummyPayTBookingAmount = $_POST['DummyTBookingAmount'];
        $DummyPayTBookingCareoff = $_POST['DummyTBookingCareoff'];

        foreach($_POST['DummyModePay'] as $Values){
            array_push($DummyModeofPay,$Values);
        }

        $Pay6  = $_POST['DummyUpiAmount'];
        $Pay10  = $_POST['DummyBankAmount'];
        $Pay2  = $_POST['DummyCashAmount'];


        foreach($DummyModeofPay as $PayModes){

            if($PayModes == '6'){
                $RVamount = $Pay6;
            }
            elseif($PayModes == '10'){
                $RVamount = $Pay10;
            }
            else{
                $RVamount = $Pay2;
            }

            if($RVamount > 0){
                $connString = $con;
                $RVvType = 'RV';
                $RVtoId =  $PayModes;
                $RVbyId = $DummyPayTBookingCareoff;
                $RVaction = 'ADD';
                $RVremarks = 'DummyTicketBookingID-'.$DummyPayTBookingId;
                $RVDate = $dateToday;
                $RVReceivedBy = '';
                $RVvoucherNo = $DummyPayTBookingId;
        
                $RVResult = ledgerTransactions($RVvType, $RVtoId, $RVbyId, $RVamount, $user_id, $RVaction, $RVremarks, $RVvoucherNo, $RVDate, $RVReceivedBy,$DummyPayTBookingId,$connString);
        
            }
            else{
                $RVResult = '';
            }

        }


        if($RVResult == 'Success'){
            mysqli_commit($con);
            echo json_encode(array('addMOPVoucher' => '1'));
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('addMOPVoucher' => '2'));
        }
        

    }



    //Book Dummy Ticket
    if(isset($_POST['DummyBookId'])){
        $DummyTicketBookingId = $_POST['DummyBookId'];
        mysqli_autocommit($con, FALSE);

        $FindBookingDetails = mysqli_query($con,"SELECT tType,bookingStatus FROM ticket_booking_table WHERE tbId = '$DummyTicketBookingId'");
        foreach($FindBookingDetails as $FindBookingDetailsResults){
            $BookingType = $FindBookingDetailsResults['tType'];
            $BookingStatus = $FindBookingDetailsResults['bookingStatus'];
        }

        if($BookingType == 'Dummy Normal' || $BookingType == 'Dummy Group'){
            if($BookingStatus == 0){
                if($BookingType == 'Dummy Normal'){
                    $UpdateTicketTable = mysqli_query($con, "UPDATE account_transactions SET hiddenStatus = 0, voucherDate = '$dateToday' WHERE bookingId = '$DummyTicketBookingId' AND voucherType = 'DT'");
                }
                else{
                    $UpdateTicketTable = mysqli_query($con, "UPDATE account_transactions SET hiddenStatus = 0, voucherDate = '$dateToday' WHERE bookingId = '$DummyTicketBookingId' AND voucherType IN ('DT','DGRP')");
                }
                if($UpdateTicketTable){
                    $UpdateMainTable =  mysqli_query($con,"UPDATE ticket_booking_table SET bookingStatus = 1 WHERE tbId = '$DummyTicketBookingId'");
                    if($UpdateMainTable){
                        mysqli_commit($con);
                        echo json_encode(array('BookTicket' => '1'));
                    }else{
                        mysqli_rollback($con);
                        echo json_encode(array('BookTicket' => '2'));
                    }
                }else{
                    mysqli_rollback($con);
                    echo json_encode(array('BookTicket' => '1'));
                }
            }else{
                mysqli_rollback($con);
                echo json_encode(array('BookTicket' => '0'));
            }
        }else{
            mysqli_rollback($con);
            echo json_encode(array('BookTicket' => '4'));
        }

        

       
    }


//////////////////////// Dummy Ticket Booking///////////////////////////////////






/////////////////////////Day Report ////////////////////////////////////


    if(isset($_POST['DrDate']) && isset($_POST['DrStartup']) && isset($_POST['DrCash'])){

        mysqli_autocommit($con, FALSE);

        $DRDate = $_POST['DrDate'];
        $DRCashinHand = $_POST['DrCash'];
        $DRStartup = $_POST['DrStartup'];
        $DRProfitAdjustment = $_POST['DrProfitAdjustment'];
        $DRProfitAdjustmentLedger = $_POST['DrProfitAdjustmentLedger'];

        try{

            if($DRProfitAdjustment > 0 && $DRProfitAdjustmentLedger != 0){

                $connString = $con;
                $PRADvType = 'PRAD'; //voucher type for Profit Adjustment
                $PRADtoId = $DRProfitAdjustmentLedger; //Profit Adjustment Id
                $PRADbyId = '10'; //Profit Ledger id
                $PRADaction = 'ADD';
                $PRADamount = $DRProfitAdjustment;
                $PRADremarks = 'Profit Adjustment Date - ' . date('Y-m-d');
                $PRADvoucherDate = $dateToday;
                $PRADreceivedBy = '';
    
                $GetVoucherMaxId = mysqli_query($con,"SELECT MAX(voucherNo) FROM account_transactions WHERE voucherType = 'PRAD'");
                foreach($GetVoucherMaxId as $GetVoucherMaxIdResult){
                    $VoucherMaxId = $GetVoucherMaxIdResult['MAX(voucherNo)'] + 1;
                }
    
                $ProfitAdjustmentLedger = ledgerTransactions($PRADvType, $PRADtoId, $PRADbyId, $PRADamount, $user_id, $PRADaction, $PRADremarks,$VoucherMaxId,$PRADvoucherDate,$PRADreceivedBy,$VoucherMaxId,$connString);
    
                if($ProfitAdjustmentLedger == 'Success'){
                    GOTO SAVEDAYREPORT;
                }else{
                    mysqli_rollback($con);
                    echo json_encode(array('Status' => 0, 'DayReport' => 'Failed'));
                }
    
            }else{
                GOTO SAVEDAYREPORT;
            }
    
            SAVEDAYREPORT:
    
            $CheckDayReportExists = mysqli_query($con, "SELECT * FROM dayreport WHERE DATE(dayDate) = '$DRDate'");
            if(mysqli_num_rows($CheckDayReportExists) > 0){
                $ChangeDayReport =  mysqli_query($con, "UPDATE dayreport SET dayCashInHand = '$DRCashinHand', dayStartupCapital = '$DRStartup', updatedDate = '$dateToday', `profitAdjusted` = '$PRADamount' WHERE dayDate = '$DRDate'");
            }
            else{
    
                $findMaxDayReport = mysqli_query($con, "SELECT MAX(dayId) FROM dayreport");
                foreach($findMaxDayReport as $findMaxDayReportResult){
                    $MaxDayReport = $findMaxDayReportResult['MAX(dayId)'] + 1;
                }
    
                $ChangeDayReport =  mysqli_query($con, "INSERT INTO dayreport (`dayId`,`dayDate`,`dayCashInHand`,`dayStartupCapital`,`profitAdjusted`,`createdBy`,`createdDate`) VALUES ('$MaxDayReport','$DRDate','$DRCashinHand','$DRStartup','$DRProfitAdjustment','1','$dateToday')");
            }
    
            if($ChangeDayReport){
                mysqli_commit($con);
                echo json_encode(array('Status' => 1, 'DayReport' => 'Success'));
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('Status' => 2, 'DayReport' => 'Failed'));
            }
        }
        catch(Exception $e){
            echo json_encode(array('Status' => 2, 'DayReport' => 'Failed'));
        }

      


    }



/////////////////////////Day Report ////////////////////////////////////






////////////////////////// Task Reminder ////////////////////////////////


    //Add task
    if(isset($_POST['TaskName'])){

        mysqli_autocommit($con, FALSE);

        $TaskName = $_POST['TaskName'];
        $TaskDate  = $_POST['TaskDate'];
        $TaskStatus  = $_POST['TaskStatus'];
        $TaskRemindBefore  = $_POST['TaskRemindBefore'];
        $TaskPhone  = $_POST['TaskPhone'];
        $TaskRemarks  = $_POST['TaskRemarks'];
        

        $TaskResults = TaskReminder($con,'',$TaskName,$TaskDate,$TaskStatus,$TaskRemindBefore,$TaskPhone,$TaskRemarks,'ADD','0','0','0',$user_id);
        if($TaskResults == 'Success'){
            mysqli_commit($con);
            echo json_encode(array('AddTask' => '1'));
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('AddTask' => '2'));
        }

    }



    //Delete Task
    if(isset($_POST['delTask'])){

        mysqli_autocommit($con, FALSE);
        $DeleteTaskId = $_POST['delTask'];
        
        $DeleteTaskResult = TaskReminder($con,$DeleteTaskId,'','','','','','','REMOVE','','','','');
        if($DeleteTaskResult == 'Success'){
            mysqli_commit($con);
            echo json_encode(array('deleteTask' => '1'));
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('deleteTask' => '2'));
        }


    }



    //Update task
    if(isset($_POST['UpdateTaskId'])){

        mysqli_autocommit($con, FALSE);

        $UpdateTaskId = $_POST['UpdateTaskId'];
        $UpdateTaskName = $_POST['UpdateTaskName'];
        $UpdateTaskDate  = $_POST['UpdateTaskDate'];
        $UpdateTaskStatus  = $_POST['UpdateTaskStatus'];
        $UpdateTaskRemindBefore  = $_POST['UpdateTaskRemindBefore'];
        $UpdateTaskPhone  = $_POST['UpdateTaskPhone'];
        $UpdateTaskRemarks  = $_POST['UpdateTaskRemarks'];
        
       

        $UpdateTaskResults = TaskReminder($con,$UpdateTaskId,$UpdateTaskName,$UpdateTaskDate,$UpdateTaskStatus,$UpdateTaskRemindBefore,$UpdateTaskPhone,$UpdateTaskRemarks,'EDIT','0','0','0',$user_id);
        if($UpdateTaskResults == 'Success'){
            mysqli_commit($con);
            echo json_encode(array('UpdateTaskReminder' => '1'));
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('UpdateTaskReminder' => '2'));
        }



    }


////////////////////////// Task Reminder ////////////////////////////////








////////////////////////User///////////////////////////////////



    //Add Employee
    if (isset($_POST['FullName'])) {
        mysqli_autocommit($con, FALSE);
        $EmpName = SanitizeInput($_POST['FullName']);
        $EmpUserName = SanitizeInt($_POST['UserName']);
        $EmpPhone = SanitizeInt($_POST['UserPhone']);
        $EmpPass = SanitizeInput($_POST['UserPassword']);
        $EmpAddr = SanitizeInput($_POST['UserAddress']);
        $EmpEmail = SanitizeInput($_POST['UserEmail']);
        $EmpBranch = SanitizeInt($_POST['UserBranch']);
        $EmpRole = SanitizeInput($_POST['UserRole']);


        $check_add_employee_query = mysqli_query($con, "SELECT * FROM employee_master WHERE empPhone = '$EmpPhone'");
        if (mysqli_num_rows($check_add_employee_query) > 0) {
            echo json_encode(array('addUser' => '0'));
        } else {

            $add_employee_max_query = mysqli_query($con, "SELECT MAX(empId) FROM employee_master");
            foreach ($add_employee_max_query as $add_employee_max_result) {
                $add_employee_max = $add_employee_max_result['MAX(empId)'] + 1;
            }

            $add_employee_query =  mysqli_query($con, "INSERT INTO employee_master (empId,empName,empPhone,empAddress,empEmail,empBranch,empRole,createdBy,createdDate) 
                        VALUES ('$add_employee_max','$EmpName','$EmpPhone','$EmpAddr','$EmpEmail','$EmpBranch','$EmpRole','$user_id','$dateToday')");

            if ($add_employee_query) {

                $find_max_user_employee = mysqli_query($con, "SELECT MAX(users_id) FROM user_table");
                foreach ($find_max_user_employee as $max_user_employee) {
                    $MaxEmplUserId = $max_user_employee['MAX(users_id)'] + 1;
                }

                $add_Empl_user_query =  mysqli_query($con, "INSERT INTO user_table (users_id,userName,userPhone,userPassword,userRole,empId,createdBy,createdDate) 
                                    VALUES ('$MaxEmplUserId','$EmpName','$EmpPhone','$EmpPass','$EmpRole','$add_employee_max','$user_id','$dateToday')");

                if ($add_Empl_user_query) {
                    mysqli_commit($con);
                    echo json_encode(array('addUser' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('addUser' => '2'));
                }
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addUser' => '2'));
            }
        }
    }



    //Update Employee
    if (isset($_POST['UpdateEmployeeId'])) {


        $UpdateEmpId = SanitizeInt($_POST['UpdateEmployeeId']);
        $UpdateEmpName = SanitizeInput($_POST['UpdateFullName']);
        $UpdateEmpUserName = SanitizeInt($_POST['UpdateUserName']);
        $UpdateEmpPhone = SanitizeInt($_POST['UpdateUserPhone']);
        $UpdateEmpPass = SanitizeInput($_POST['UpdateUserPassword']);
        $UpdateEmpAddr = SanitizeInput($_POST['UpdateUserAddress']);
        $UpdateEmpEmail = SanitizeInput($_POST['UpdateUserEmail']);
        $UpdateEmpBranch = SanitizeInt($_POST['UpdateUserBranch']);
        $UpdateEmpRole = SanitizeInput($_POST['UpdateUserRole']);


        mysqli_autocommit($con, FALSE);
        $check_employee_update_query = mysqli_query($con, "SELECT * FROM employee_master WHERE empPhone = '$UpdateEmpPhone' AND empId <> '$UpdateEmpId'");
        if (mysqli_num_rows($check_employee_update_query) > 0) {
            echo json_encode(array('EmployeeUpdate' => '0'));
        } else {

            $update_employee_query =  mysqli_query($con, "UPDATE employee_master SET empName = '$UpdateEmpName', empPhone = '$UpdateEmpPhone', empAddress = '$UpdateEmpAddr', 
                        empEmail = '$UpdateEmpEmail', empRole = '$UpdateEmpRole', empBranch = '$UpdateEmpBranch', updatedBy = '$user_id', updatedDate = '$dateToday' WHERE empId = '$UpdateEmpId'");

            if ($update_employee_query) {
                $update_user_query = mysqli_query($con, "UPDATE user_table SET userName = '$UpdateEmpName', userPhone ='$UpdateEmpPhone', userPassword = '$UpdateEmpPass', userRole ='$UpdateEmpRole', updatedBy = '$user_id', updatedDate = '$dateToday' WHERE empId = '$UpdateEmpId'");

                if ($update_user_query) {
                    mysqli_commit($con);
                    echo json_encode(array('EmployeeUpdate' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('EmployeeUpdate' => '2'));
                }
            } else {
                mysqli_rollback($con);
                echo json_encode(array('EmployeeUpdate' => '2'));
            }
        }
    }


    //Delete Employee
    if (isset($_POST['delUser'])) {

        $DelEmpId = SanitizeInt($_POST['delUser']);

        mysqli_autocommit($con, FALSE);

        $check_Employee_delete_query = mysqli_query($con, "SELECT * FROM order_main WHERE createdBy = '$DelEmpId'");
        if (mysqli_num_rows($check_Employee_delete_query) > 0) {
            echo json_encode(array('deleteUser' => '0'));
        } else {
            $delete_Employee_query =  mysqli_query($con, "DELETE FROM employee_master WHERE empId = '$DelEmpId'");

            if ($delete_Employee_query) {

                $DeleteFromUser = mysqli_query($con, "DELETE FROM user_table WHERE empId = '$DelEmpId'");
                if ($DeleteFromUser) {
                    mysqli_commit($con);
                    echo json_encode(array('deleteUser' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('deleteUser' => '2'));
                }
            } else {
                mysqli_rollback($con);
                echo json_encode(array('deleteUser' => '2'));
            }
        }
    }


////////////////////////User///////////////////////////////////




////////////////////////Data Purge/////////////////////////////

    if(isset($_POST['DataPurge'])){
        $DataPurgePassword = $_POST['DataPurgePassword'];
        if(trim($DataPurgePassword != '')){
            if($DataPurgePassword == 'Techstas@123'){
                $Query = "
                DROP TABLE IF EXISTS `account_transactions`;
                CREATE TABLE `account_transactions` (
                  `acctId` bigint NOT NULL,
                  `voucherNo` bigint NOT NULL,
                  `voucherDate` datetime NOT NULL,
                  `toId` int NOT NULL,
                  `byId` int NOT NULL,
                  `toAmount` decimal(18,3) DEFAULT NULL,
                  `byAmount` decimal(18,3) DEFAULT NULL,
                  `receivedBy` varchar(100) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `remarks` varchar(250) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `voucherType` varchar(10) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `createdBy` int DEFAULT NULL,
                  `createdDate` datetime DEFAULT NULL,
                  `updatedBy` int DEFAULT NULL,
                  `updatedDate` datetime DEFAULT NULL,
                  `bookingId` int DEFAULT '0',
                  `hiddenStatus` int DEFAULT '0',
                  PRIMARY KEY (`acctId`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                
                DROP TABLE IF EXISTS `accountgroup`;
                CREATE TABLE `accountgroup` (
                  `accountgroupid` bigint NOT NULL,
                  `primaryid` bigint NOT NULL,
                  `accountgroupName` varchar(100) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `visiblestatus` tinyint DEFAULT NULL,
                  `deletePermission` tinyint DEFAULT '1',
                  `createdBy` bigint DEFAULT NULL,
                  `createdDate` varchar(25) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `updatedBy` bigint DEFAULT NULL,
                  `updatedDate` varchar(25) CHARACTER SET utf8mb4  DEFAULT NULL,
                  PRIMARY KEY (`accountgroupid`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                
                LOCK TABLES `accountgroup` WRITE;
                INSERT INTO `accountgroup` VALUES (1,1,'Capital Account',1,0,1,'2022-11-16 08:56:31',NULL,NULL),(2,2,'Current Assets',1,1,1,'2022-11-16 08:59:14',1,'2022-11-16 10:11:02'),(3,1,'Current Liabilitiy',1,0,1,'2022-11-16 10:29:16',1,'2022-11-23 07:19:07'),(4,4,'Direct Expenses',1,1,1,'2022-11-16 10:31:22',NULL,NULL),(6,6,'Current Liabilities',1,1,1,'2022-11-23 06:56:44',NULL,NULL),(7,7,'Direct Incomes',1,1,1,'2022-11-23 06:56:59',NULL,NULL),(8,8,'Fixed Assets',1,1,1,'2022-11-23 06:57:13',NULL,NULL),(9,9,'Indirect Expenses',1,1,1,'2022-11-23 06:57:34',NULL,NULL),(10,10,'Indirect Incomes',1,1,1,'2022-11-23 06:57:53',NULL,NULL),(11,11,'Investments',1,1,1,'2022-11-23 06:58:05',NULL,NULL),(12,12,'Loans Libility',1,1,1,'2022-11-23 06:58:34',NULL,NULL),(13,13,'Misc Expenses Asset',1,1,1,'2022-11-23 06:59:06',NULL,NULL),(14,14,'Purchase Accounts',1,1,1,'2022-11-23 06:59:22',NULL,NULL),(15,15,'Sales Accounts',1,1,1,'2022-11-23 06:59:37',NULL,NULL),(16,16,'Suspense A C',1,1,1,'2022-11-23 07:00:20',NULL,NULL),(17,2,'Bank Accounts',1,1,1,'2022-11-23 07:14:57',NULL,NULL),(18,12,'Bank Od A C',1,1,1,'2022-11-23 07:30:25',NULL,NULL),(19,2,'Cash   In  Hand',1,1,1,'2022-11-23 07:30:53',NULL,NULL),(20,2,'Deposits  Asset',1,1,1,'2022-11-23 07:32:39',NULL,NULL),(21,6,'Duties  Taxes',1,1,1,'2022-11-23 07:33:20',NULL,NULL),(22,2,'Loans   Advances  Asset',1,1,1,'2022-11-23 07:33:57',NULL,NULL),(23,6,'Provisions',1,1,1,'2022-11-23 07:34:11',NULL,NULL),(24,14,'Purchase',1,1,1,'2022-11-23 07:34:40',NULL,NULL),(25,1,'Reserves  Surplus',1,1,1,'2022-11-23 08:12:29',NULL,NULL),(26,15,'Sales',1,1,1,'2022-11-23 08:12:50',NULL,NULL),(27,12,'Secured Loans',1,1,1,'2022-11-23 08:13:10',NULL,NULL),(28,2,'Stock  In  Hand',1,1,1,'2022-11-23 08:13:34',NULL,NULL),(29,6,'Sundry Creditors',1,1,1,'2022-11-23 08:13:51',NULL,NULL),(30,2,'Sundry Debtors',1,1,1,'2022-11-23 08:14:08',NULL,NULL),(31,12,'Unsecured Loans',1,1,1,'2022-11-23 08:14:30',NULL,NULL);
                UNLOCK TABLES;
                
                DROP TABLE IF EXISTS `accounts`;
                
                CREATE TABLE `accounts` (
                  `Aid` bigint NOT NULL,
                  `atId` int NOT NULL,
                  `accountType` varchar(32) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `firstName` varchar(32) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `lastName` varchar(32) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `phone` bigint DEFAULT NULL,
                  `opening` decimal(18,3) DEFAULT '0.000',
                  `openingType` varchar(16) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `isInterstate` varchar(16) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `email` varchar(64) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `GST` varchar(32) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `location` varchar(255) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `address` varchar(500) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `deletePermission` varchar(15) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `isProfitLedger` tinyint DEFAULT '0',
                  `primaryAccntGroupId` int DEFAULT NULL,
                  `accntGroupId` int DEFAULT NULL,
                  `createdBy` int DEFAULT NULL,
                  `createdDate` datetime DEFAULT NULL,
                  `updatedBy` int DEFAULT NULL,
                  `updatedDate` datetime DEFAULT NULL,
                  PRIMARY KEY (`Aid`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                
                LOCK TABLES `accounts` WRITE;
                INSERT INTO `accounts` VALUES (1,1,'','GENERAL','',0,0.000,'','FALSE','','','','','NO',0,1,3,0,'2022-11-09 05:32:06',1,'2023-04-18 06:38:14'),(2,2,'','CASH','',0,0.000,'','FALSE','','','','','NO',0,2,19,0,'0000-00-00 00:00:00',1,'2023-04-18 05:48:59'),(3,3,'','Ticket Booking','',0,0.000,'','FALSE','','','','','NO',0,0,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(4,4,'','Visa Booking','',0,0.000,'','FALSE','','','','','NO',0,0,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(5,5,'','Purchase','',0,0.000,'','FALSE','','','','','NO',0,0,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(6,6,'','UPI','',0,0.000,'','FALSE','','','','','NO',0,0,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(7,7,'','PORTAL','',0,0.000,'','FALSE','','','','','NO',0,2,20,0,'0000-00-00 00:00:00',1,'2023-05-04 06:22:59'),(8,8,'','BONUS','',0,0.000,'','FALSE','','','','','NO',0,0,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(9,9,'','REFUND','',0,0.000,'','FALSE','','','','','NO',0,0,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(10,10,'','FEDERAL','',0,0.000,'','FALSE','','','',' ','YES',0,2,17,1,'2022-11-23 09:38:22',1,'2023-04-18 06:41:52'),(11,11,' ','PROFIT',' ',0,0.000,' ','FALSE',' ',' ',' ',' ','NO',0,0,0,0,'2022-11-23 09:38:22',0,NULL),(12,12,' ','PROFIT ADJUSTED',' ',0,0.000,' ','FALSE',' ',' ',' ',' ','NO',0,0,17,0,'2022-11-23 09:38:22',0,NULL);
                UNLOCK TABLES;
                
                DROP TABLE IF EXISTS `checklist_master`;
                CREATE TABLE `checklist_master` (
                  `ckId` int NOT NULL,
                  `cId` int NOT NULL,
                  `checklistName` varchar(64) CHARACTER SET utf8mb4  NOT NULL,
                  `createdBy` int DEFAULT NULL,
                  `createdDate` datetime DEFAULT NULL,
                  `updatedBy` int DEFAULT NULL,
                  `updatedDate` datetime DEFAULT NULL,
                  PRIMARY KEY (`ckId`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                
                
                DROP TABLE IF EXISTS `country_master`;
                CREATE TABLE `country_master` (
                  `cId` int NOT NULL,
                  `countryName` varchar(128) CHARACTER SET utf8mb4  NOT NULL,
                  `createdBy` int DEFAULT NULL,
                  `createdDate` datetime DEFAULT NULL,
                  `updatedBy` int DEFAULT NULL,
                  `updatedDate` datetime DEFAULT NULL,
                  PRIMARY KEY (`cId`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                
                LOCK TABLES `country_master` WRITE;
                INSERT INTO `country_master` VALUES (1,'AMERICA',1,'2022-11-08 06:43:00',0,'0000-00-00 00:00:00'),(3,'DUBAI',1,'2022-11-08 07:01:21',1,'2022-11-08 07:01:54'),(4,'GERMANY',1,'2022-11-08 07:02:02',0,'0000-00-00 00:00:00'),(5,'RUSSIA',1,'2022-11-08 07:02:31',0,'0000-00-00 00:00:00'),(6,'AUSTRALIA',1,'2022-11-08 07:02:51',0,'0000-00-00 00:00:00'),(8,'UK',1,'2022-11-08 07:36:57',0,'0000-00-00 00:00:00'),(11,'NEW ZEALAND',1,'2022-12-15 11:57:24',1,'2022-12-17 02:33:38'),(28,'BRAZIL',1,'2022-12-17 11:47:11',1,'2023-05-10 03:38:12');
                UNLOCK TABLES;
                
                
                DROP TABLE IF EXISTS `dayreport`;
                CREATE TABLE `dayreport` (
                  `dayId` int NOT NULL,
                  `dayDate` datetime DEFAULT NULL,
                  `dayCashInHand` decimal(18,2) DEFAULT '0.00',
                  `dayStartupCapital` decimal(18,2) DEFAULT '0.00',
                  `profitAdjusted` decimal(18,2) DEFAULT '0.00',
                  `createdBy` int DEFAULT NULL,
                  `createdDate` datetime DEFAULT NULL,
                  `updatedBy` int DEFAULT NULL,
                  `updatedDate` datetime DEFAULT NULL,
                  PRIMARY KEY (`dayId`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                
                DROP TABLE IF EXISTS `extratransactions`;
                CREATE TABLE `extratransactions` (
                  `transactionId` int NOT NULL,
                  `transactionDate` datetime DEFAULT NULL,
                  `fromId` int DEFAULT NULL,
                  `particularId` int DEFAULT NULL,
                  `particularName` varchar(80)  DEFAULT NULL,
                  `incentiveAmount` decimal(18,2) DEFAULT NULL,
                  `amount` decimal(18,2) DEFAULT NULL,
                  `totalAmount` decimal(18,2) DEFAULT NULL,
                  `createdBy` int DEFAULT NULL,
                  `createdDate` datetime DEFAULT NULL,
                  `updatedBy` int DEFAULT NULL,
                  `updatedDate` datetime DEFAULT NULL,
                  PRIMARY KEY (`transactionId`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                
                DROP TABLE IF EXISTS `ledgerextra`;
                CREATE TABLE `ledgerextra` (
                  `partId` int NOT NULL,
                  `particularName` varchar(80)  DEFAULT NULL,
                  `partType` varchar(45)  DEFAULT NULL,
                  `totalAdded` decimal(18,2) DEFAULT NULL,
                  `totalDeduced` decimal(18,2) DEFAULT NULL,
                  `totalIncentive` decimal(18,2) DEFAULT NULL,
                  `totalRedeemable` decimal(18,2) DEFAULT NULL,
                  `createdBy` int DEFAULT NULL,
                  `createdDate` datetime DEFAULT NULL,
                  `updatedBy` int DEFAULT NULL,
                  `updatedDate` datetime DEFAULT NULL,
                  PRIMARY KEY (`partId`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                
                
                DROP TABLE IF EXISTS `taskreminder`;
                CREATE TABLE `taskreminder` (
                  `taskId` int NOT NULL,
                  `taskName` varchar(120)  DEFAULT NULL,
                  `taskDate` datetime DEFAULT NULL,
                  `taskRemark` varchar(500)  DEFAULT NULL,
                  `taskStatus` varchar(45)  DEFAULT NULL,
                  `taskReminderPhone` bigint DEFAULT '0',
                  `taskRemindBefore` varchar(45)  DEFAULT NULL,
                  `taskAssignedTo` int DEFAULT '0',
                  `taskRemindSend` int DEFAULT '0',
                  `taskBookingId` varchar(45)  DEFAULT NULL,
                  `createdBy` int DEFAULT '0',
                  `createdDate` datetime DEFAULT NULL,
                  `updatedBy` int DEFAULT NULL,
                  `updatedDate` datetime DEFAULT NULL,
                  PRIMARY KEY (`taskId`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                
                
                DROP TABLE IF EXISTS `ticket_booking_table`;
                CREATE TABLE `ticket_booking_table` (
                  `tbId` bigint NOT NULL,
                  `tPassenger` varchar(100) CHARACTER SET utf8mb4  NOT NULL,
                  `tFrom` int DEFAULT NULL,
                  `tTo` int DEFAULT NULL,
                  `tType` varchar(40)  DEFAULT NULL,
                  `tDeparture` datetime DEFAULT NULL,
                  `tPhone` bigint DEFAULT NULL,
                  `tProof` varchar(32) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `tProofNo` varchar(32) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `tbCareoff` int DEFAULT NULL,
                  `tGender` varchar(10) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `tAge` int DEFAULT NULL,
                  `tClass` varchar(32) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `tAgency` int DEFAULT NULL,
                  `tAoNumber` varchar(64) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `tAmount` decimal(18,3) DEFAULT NULL,
                  `tAgencyamount` decimal(18,3) DEFAULT NULL,
                  `tStatus` varchar(32) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `tRemarks` varchar(500)  DEFAULT NULL,
                  `bookingStatus` tinyint DEFAULT '0',
                  `cancelStatus` tinyint DEFAULT '0',
                  `createdBy` int DEFAULT NULL,
                  `createdDate` datetime DEFAULT NULL,
                  `updatedBy` int DEFAULT NULL,
                  `updatedDate` datetime DEFAULT NULL,
                  PRIMARY KEY (`tbId`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                
                
                DROP TABLE IF EXISTS `ticketextend`;
                CREATE TABLE `ticketextend` (
                  `ticketExtendId` bigint NOT NULL AUTO_INCREMENT,
                  `ticketBookingId` bigint DEFAULT NULL,
                  `oldDate` datetime DEFAULT NULL,
                  `newDate` datetime DEFAULT NULL,
                  `oldAgencyRate` decimal(18,2) DEFAULT NULL,
                  `newAgencyRate` decimal(18,2) DEFAULT NULL,
                  `oldOurRate` decimal(18,2) DEFAULT NULL,
                  `newOurRate` decimal(18,2) DEFAULT NULL,
                  `oldAoNumber` varchar(60)  DEFAULT NULL,
                  `newAoNumber` varchar(60)  DEFAULT NULL,
                  `createdBy` int DEFAULT NULL,
                  `createdDate` datetime DEFAULT NULL,
                  `updatedBy` int DEFAULT NULL,
                  `updatedDate` datetime DEFAULT NULL,
                  PRIMARY KEY (`ticketExtendId`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                
                DROP TABLE IF EXISTS `user_db`;
                CREATE TABLE `user_db` (
                  `userId` bigint NOT NULL,
                  `userName` varchar(64) CHARACTER SET utf8mb4  NOT NULL,
                  `userPass` varchar(32) CHARACTER SET utf8mb4  NOT NULL,
                  `fullName` varchar(64) CHARACTER SET utf8mb4  DEFAULT NULL,
                  `userType` varchar(32) CHARACTER SET utf8mb4  DEFAULT NULL,
                  PRIMARY KEY (`userId`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                
                LOCK TABLES `user_db` WRITE;
                INSERT INTO `user_db` VALUES (1,'Admin','G','SuperAdmin','SuperAdmin');
                UNLOCK TABLES;
                
                
                DROP TABLE IF EXISTS `visa_booking`;
                CREATE TABLE `visa_booking` (
                  `vId` int NOT NULL,
                  `visaBookingId` int DEFAULT NULL,
                  `passengerName` varchar(64)  DEFAULT NULL,
                  `passengerFrom` int DEFAULT NULL,
                  `passengerTo` int DEFAULT NULL,
                  `passengerDate` datetime DEFAULT NULL,
                  `passengerProof` varchar(64)  DEFAULT NULL,
                  `passengerCareof` varchar(64)  DEFAULT NULL,
                  `passengerVisa` varchar(128)  DEFAULT NULL,
                  `passengerValidity` varchar(64)  DEFAULT NULL,
                  `passengerAgency` int DEFAULT NULL,
                  `agencyRate` decimal(18,3) DEFAULT NULL,
                  `ourRate` decimal(18,3) DEFAULT NULL,
                  `passengerStatus` varchar(64)  DEFAULT NULL,
                  `passengerPhone` bigint DEFAULT NULL,
                  `cancelStatus` tinyint(1) DEFAULT '0',
                  `createdBy` int DEFAULT NULL,
                  `createdDate` datetime DEFAULT NULL,
                  `updatedBy` int DEFAULT NULL,
                  `updatedDate` datetime DEFAULT NULL,
                  PRIMARY KEY (`vId`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
                ";

                //echo $Query;

                $ExecuteDataPurge = mysqli_multi_query($con, $Query);

                if($ExecuteDataPurge){
                    echo json_encode(array('Status' => '1','Message' => 'Data Purge Completed'));
                }
            }else{
                echo json_encode(array('Status' => '2','Message' => 'Password is Not Correct'));
            }
        }else{
            echo json_encode(array('Status' => '2','Message' => 'Password is Empty'));
        }
    }


////////////////////////Data Purge/////////////////////////////