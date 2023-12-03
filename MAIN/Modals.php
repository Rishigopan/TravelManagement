<!-- add customer modal -->
<div class="modal fade addUpdateModal" id="CustomerModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content cntrymodalbg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD CUSTOMER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="AddForm" id="AddCustomer" novalidate>

                    <div class="row">
                        <div class="col-6">
                            <label class="form-label" for="cust_first">First Name</label>
                            <input type="text" class="form-control" name="CustFirst" id="cust_first" placeholder="Enter your firstname" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="cust_last">Last Name</label>
                            <input type="text" class="form-control" name="CustLast" id="cust_last" placeholder="Enter your lastname">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label class="form-label" for="cust_phone">Phone</label>
                            <input type="number" class="form-control" name="CustPhone" id="cust_phone" placeholder="Please enter your phoneno">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="cust_location">Location</label>
                            <input type="text" class="form-control" name="CustLocation" id="cust_location" placeholder="Please type your location">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <label class="form-label" for="cust_open_type">Opening Balance</label>
                            <select class="form-select" name="CustOpenType" id="cust_open_type">
                                <option selected value="">Please select</option>
                                <option value="Cr">Cr</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="cust_open">Amount</label><br>
                            <input type="number" class="form-control" name="CustOpen" id="cust_open" placeholder="&#8377;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-info">SAVE CUSTOMER</button>
                    </div>
                </form>

                <form class="UpdateForm" id="UpdateCustomer" style="display: none;" novalidate>

                    <div class="row">
                        <input type="text" name="UpdateCustId" id="edit_customer_id" hidden>
                        <div class="col-6">
                            <label class="form-label" for="update_cust_first">First Name</label>
                            <input type="text" class="form-control" name="UpdateCustFirst" id="update_cust_first" placeholder="Enter your firstname" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="update_cust_last">Last Name</label>
                            <input type="text" class="form-control" name="UpdateCustLast" id="update_cust_last" placeholder="Enter your lastname">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label class="form-label" for="update_cust_phone">Phone</label>
                            <input type="number" class="form-control" name="UpdateCustPhone" id="update_cust_phone" placeholder="Please enter your phoneno">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="update_cust_location">Location</label>
                            <input type="text" class="form-control" name="UpdateCustLocation" id="update_cust_location" placeholder="Please type your location">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label" for="update_cust_open_type">Opening Balance</label>
                            <select class="form-select" name="UpdateCustOpenType" id="update_cust_open_type">
                                <option selected value="">Please select</option>
                                <option value="Cr">Cr</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="update_cust_open">Amount</label><br>
                            <input type="number" class="form-control" name="UpdateCustOpen" id="update_cust_open" placeholder="&#8377;">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-info">UPDATE CUSTOMER</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- add country modal -->
<div class="modal fade addUpdateModal" id="CountryModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content cntrymodalbg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD COUNTRY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="AddForm" id="AddCountry" novalidate>
                    <div>
                        <label>Country Name</label><br>
                        <input type="text" class="form-control mt-3" id="country_name" name="CountryName" placeholder="Please enter the countryname" autofocus required>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-info">ADD COUNTRY</button>
                    </div>
                </form>

                <form class="UpdateForm" id="UpdateCountry" style="display: none;" novalidate>
                    <div>
                        <label>Country Name</label><br>
                        <input type="text" name="UpdateCountryId" id="edit_country_id" hidden>
                        <input type="text" class="form-control mt-3" id="update_country_name" name="UpdateCountryName" placeholder="Please enter the countryname" required>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-info">UPDATE COUNTRY</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- add supplier modal -->
<div class="modal fade addUpdateModal" id="SupplierModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content cntrymodalbg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD AGENCY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="AddForm" id="AddSupplier" novalidate>

                    <div class="row">
                        <div class="col-6">
                            <label class="form-label" for="sup_first">First Name</label>
                            <input type="text" class="form-control" name="SupFirst" id="sup_first" placeholder="Enter your firstname" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="sup_last">Last Name</label>
                            <input type="text" class="form-control" name="SupLast" id="sup_last" placeholder="Enter your lastname">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label class="form-label" for="sup_phone">Phone</label>
                            <input type="number" class="form-control" name="SupPhone" id="sup_phone" placeholder="Please enter your phoneno">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="sup_email">Email</label>
                            <input type="email" class="form-control" name="SupEmail" id="sup_email" placeholder="Please enter your email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label" for="sup_gst">GST No</label><br>
                            <input type="text" class="form-control" name="SupGST" id="sup_gst" placeholder="Please enter the GST no">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="sup_location">Location</label>
                            <input type="text" class="form-control" name="SupLocation" id="sup_location" placeholder="Please type your location">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label class="form-label" for="sup_address">Address</label>
                            <textarea class="form-control" name="SupAddress" id="sup_address" cols="30" rows="5" placeholder="Please enter your Permanent Address"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label" for="sup_open_type">Opening Balance</label>
                            <select class="form-select" name="SupOpenType" id="sup_open_type">
                                <option selected value="">Please select</option>
                                <option value="Cr">Cr</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="sup_open">Amount</label><br>
                            <input type="number" class="form-control" name="SupOpen" id="sup_open" placeholder="&#8377;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-info">SAVE AGENCY</button>
                    </div>
                </form>

                <form class="UpdateForm" id="UpdateSupplier" style="display: none;" novalidate>

                    <div class="row">
                        <input type="text" name="UpdateSupId" id="edit_supplier_id" hidden>
                        <div class="col-6">
                            <label class="form-label" for="update_sup_first">First Name</label>
                            <input type="text" class="form-control" name="UpdateSupFirst" id="update_sup_first" placeholder="Enter your firstname" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="update_sup_last">Last Name</label>
                            <input type="text" class="form-control" name="UpdateSupLast" id="update_sup_last" placeholder="Enter your lastname">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label class="form-label" for="update_sup_phone">Phone</label>
                            <input type="number" class="form-control" name="UpdateSupPhone" id="update_sup_phone" placeholder="Please enter your phoneno">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="update_sup_email">Email</label>
                            <input type="email" class="form-control" name="UpdateSupEmail" id="update_sup_email" placeholder="Please enter your email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label" for="update_sup_gst">GST No</label><br>
                            <input type="text" class="form-control" name="UpdateSupGST" id="update_sup_gst" placeholder="Please enter the GST no">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="update_sup_location">Location</label>
                            <input type="text" class="form-control" name="UpdateSupLocation" id="update_sup_location" placeholder="Please type your location">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label class="form-label" for="update_sup_address">Address</label>
                            <textarea class="form-control" name="UpdateSupAddress" id="update_sup_address" cols="30" rows="5" placeholder="Please enter your Permanent Address"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label" for="update_sup_open_type">Opening Balance</label>
                            <select class="form-select" name="UpdateSupOpenType" id="update_sup_open_type">
                                <option selected value="">Please select</option>
                                <option value="Cr">Cr</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="update_sup_open">Amount</label><br>
                            <input type="text" class="form-control" name="UpdateSupOpen" id="update_sup_open" placeholder="&#8377;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-info">UPDATE AGENCY</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- add ledger modal -->
<div class="modal fade addUpdateModal" id="LedgerModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content cntrymodalbg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD LEDGER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="AddForm" id="AddLedger" novalidate>
                    <div class="row">
                        <div class="col-12">
                            <label>Ledger Name</label><br>
                            <input type="text" class="form-control" id="ledger_name" name="LedgerName" placeholder="Please enter the ledger name" required>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label" for="ledger_account_group">Account group</label>
                            <select class="form-select AccountGroupChange" name="LedgerAccountGroup" id="ledger_account_group" required>
                                <option hidden value="">Please Select Account Group</option>
                                <?php

                                $FindPrimaryGroups = mysqli_query($con, "SELECT accountgroupid,accountgroupName FROM accountgroup WHERE accountgroupid <> primaryid");
                                foreach ($FindPrimaryGroups as $FindPrimaryGroupsResult) {
                                    echo '<option value="' . $FindPrimaryGroupsResult["accountgroupid"] . '">' . $FindPrimaryGroupsResult["accountgroupName"] . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label" for="ledger_primary_account_name">Primary Account Group</label>
                            <input type="text" class="form-control AccountGroupChangeResultID" id="ledger_primary_account" name="LedgerPrimaryAccount" readonly required hidden>
                            <input type="text" class="form-control AccountGroupChangeResultName" id="ledger_primary_account_name" name="LedgerPrimaryAccountName" readonly required>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label" for="ledger_open_type">Opening Balance</label>
                            <select class="form-select" name="LedgerOpening" id="ledger_open_type">
                                <option selected value="">Please select</option>
                                <option value="Cr">Cr</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <label>Amount</label><br>
                            <input type="text" class="form-control" id="ledger_amount" name="LedgerAmount" placeholder="₹">
                        </div>


                        <div class="col-12 mt-3">
                            <input class="form-check-input" name="IsProfitLedger" type="checkbox" value="1" id="is_profit_ledger">
                            <label class="form-check-label" for="is_profit_ledger">Check if this is a profit ledger</label>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">ADD LEDGER</button>
                        </div>
                    </div>
                </form>

                <form class="UpdateForm" id="UpdateLedger" style="display: none;" novalidate>
                    <div class="row">
                        <div class="col-12">
                            <label>Ledger Name</label><br>
                            <input type="text" name="UpdateLedgerId" id="edit_ledger_id" hidden>
                            <input type="text" class="form-control mt-3" id="update_ledger_name" name="UpdateLedgerName" placeholder="Please enter the ledger name" required>
                        </div>
                        <div class="col-12 mt-3">

                            <label class="form-label" for="ledger_open_type">Account group</label>
                            <select class="form-select AccountGroupChange" name="UpdateLedgerAccountGroup" id="edit_ledger_account_group" required>
                                <option hidden value="">Please Select Account Group</option>
                                <?php

                                $FindPrimaryGroups = mysqli_query($con, "SELECT accountgroupid,accountgroupName FROM accountgroup WHERE accountgroupid <> primaryid");
                                foreach ($FindPrimaryGroups as $FindPrimaryGroupsResult) {
                                    echo '<option value="' . $FindPrimaryGroupsResult["accountgroupid"] . '">' . $FindPrimaryGroupsResult["accountgroupName"] . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label" for="ledger_open_type">Primary Account Group</label>
                            <input type="text" class="form-control mt-3 AccountGroupChangeResultID" id="update_ledger_primary_account" name="UpdateLedgerPrimaryAccount" readonly required hidden>
                            <input type="text" class="form-control mt-3 AccountGroupChangeResultName" id="update_ledger_primary_account_name" name="UpdateLedgerPrimaryAccountName" readonly required>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label" for="update_ledger_open_type">Opening Balance</label>
                            <select class="form-select" name="UpdateLedgerOpening" id="update_ledger_open_type">
                                <option selected value="">Please select</option>
                                <option value="Cr">Cr</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>
                        <div class="col-12 mt-3">
                            <label>Amount</label><br>
                            <input type="text" class="form-control mt-3" id="update_ledger_amount" name="UpdateLedgerAmount" placeholder="₹">
                        </div>
                        <div class="col-12 mt-3">
                            <input class="form-check-input" name="UpdateIsProfitLedger" type="checkbox" value="1" id="update_is_profit_ledger" >
                            <label class="form-check-label" for="update_is_profit_ledger">Check if this is a profit ledger</label>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-info">UPDATE LEDGER</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Confirm Modal -->
<div class="modal fade ResponseModal" id="confirmModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-3 py-5">
                <div class="text-center mb-4" id="ResponseImage">

                </div>
                <h4 id="ResponseText" class="text-center mb-3"></h4>
                <div class="text-center">
                    <button type="button" id="btnConfirm" style="display: none;" class="btn btn_save mt-4 px-5 py-2" data-bs-dismiss="modal">Proceed</button>
                    <button type="button" id="btnClose" class="btn btn_save mt-4 px-5 py-2" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>
</div>