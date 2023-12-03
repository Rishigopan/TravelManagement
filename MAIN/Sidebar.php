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
                <!-- <li class=" <?php if ($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin') {
                                    } else {
                                        echo "d-none";
                                    } ?>">
                            <a href="./CustomerMaster.php" class="<?= ($NewTitle == 'CustomerMaster') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Customer Master</span>
                            </a>
                        </li> -->

                <li class="">
                    <a href="./VisaBooking.php" class="<?= ($NewTitle == 'VisaBooking') ? "active" : "" ?>">
                        <i class="material-icons">home</i>
                        <span>Visa Booking</span>
                    </a>
                </li>
                <li class="">
                    <a href="./TicketBooking.php" class="<?= ($NewTitle == 'TicketBooking') ? "active" : "" ?>">
                        <i class="material-icons">home</i>
                        <span>Ticket Booking</span>
                    </a>
                </li>
                <li class="">
                    <a href="./ViewVisa.php" class="<?= ($NewTitle == 'ViewVisa') ? "active" : "" ?>">
                        <i class="material-icons">home</i>
                        <span>Visa Booking Report</span>
                    </a>
                </li>

                <li class="">
                    <a href="./TicketBookingReport.php" class="<?= ($NewTitle == 'TicketBookingReport') ? "active" : "" ?>">
                        <i class="material-icons">home</i>
                        <span>Ticket Booking Report</span>
                    </a>
                </li>
                <!-- <li class="">
                    <a href="./AccountTransactions.php" class="<?php // ($PageTitle == 'AccountTransactions') ? "active" : "" ?>">
                        <i class="material-icons">home</i>
                        <span>Account Transactions</span>
                    </a>
                </li> -->

                <li class="">

                    <a href="#AccountsMenu" role="button" data-bs-toggle="collapse" class=" <?= ($NewTitle == 'PrimaryAccountGroup' || $NewTitle == 'AccountGroup' || $NewTitle == 'ReceiptVoucher' || $NewTitle == 'PaymentVoucher' || $NewTitle == 'VoucherReport' || $NewTitle == 'LedgerBook' || $NewTitle == 'LedgerMaster' || $NewTitle == 'DayReport' ) ? "active" : "" ?>">
                        <i class="material-icons">home</i>
                        <span>Accounts</span>
                        <span class="float-end"> <i class="ri-arrow-down-s-fill"></i> </span>
                    </a>


                    <ul class="list-unstyled collapse" id="AccountsMenu">
                        
                        <li class="">
                            <a href="./ReceiptVoucher.php" class="ps-3 <?= ($NewTitle == 'ReceiptVoucher') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Receipt Voucher</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="./PaymentVoucher.php" class="ps-3 <?= ($NewTitle == 'PaymentVoucher') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Payment Voucher</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="./DayReport.php" class="ps-3 <?= ($NewTitle == 'DayReport') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Day Report</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="./VoucherReport.php" class="ps-3 <?= ($NewTitle == 'VoucherReport') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Voucher Report</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="./LedgerBook.php" class="ps-3 <?= ($NewTitle == 'LedgerBook') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Ledger Book</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="./PortalAdd.php" class="ps-3 <?= ($NewTitle == 'PortalRecharge') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>PortalRecharge</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="./PrimaryAccountGroup.php" class="ps-3 <?= ($NewTitle == 'PrimaryAccountGroup') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Primary Account Group</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="./AccountGroup.php" class="ps-3 <?= ($NewTitle == 'AccountGroup') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Account Group</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="./LedgerMaster.php" class="ps-3 <?= ($NewTitle == 'LedgerMaster') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Ledger</span>
                            </a>
                        </li>
                        



                    </ul>

                </li>

                
                <li class="">

                    <a href="#MastersMenu" role="button" data-bs-toggle="collapse" class=" <?= ($NewTitle == 'CustomerMaster' || $NewTitle == 'CountryMaster' || $NewTitle == 'ChecklistMaster' || $NewTitle == 'AgencyMaster') ? "active" : "" ?>">
                        <i class="material-icons">home</i>
                        <span>Masters</span>
                        <span class="float-end"> <i class="ri-arrow-down-s-fill"></i> </span>
                    </a>


                    <ul class="list-unstyled collapse" id="MastersMenu">
                        <li class="">
                            <a href="./CustomerMaster.php" class="ps-3 <?= ($NewTitle == 'CustomerMaster') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Customer Master </span>
                            </a>
                        </li>
                        <li class="">
                            <a href="./CountryMaster.php" class="ps-3 <?= ($NewTitle == 'CountryMaster') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Country Master</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="./ChecklistMaster.php" class="ps-3 <?= ($NewTitle == 'ChecklistMaster') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Checklist Master</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="./SupplierMaster.php" class="ps-3 <?= ($NewTitle == 'AgencyMaster') ? "active" : "" ?>">
                                <i class="material-icons">home</i>
                                <span>Agency Master</span>
                            </a>
                        </li>


                    </ul>

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