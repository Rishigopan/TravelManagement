<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container-fluid container-fluid d-flex align-items-center ">

        <div class="logo me-4 d-flex">
            <a href="Dashboard.php"><img src="../IMAGES/TravelNew.jpg" alt="" class="img-fluid me-2"></a>
            <h1><a href="Dashboard.php">TRAVEL APP</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->

        </div>

        <nav id="navbar" class="navbar order-lg-0 me-auto">
            <ul>

                <li class="dropdown"><a href="#" class="<?= ($NewTitle == 'CustomerMaster' || $NewTitle == 'CountryMaster' || $NewTitle == 'ChecklistMaster' || $NewTitle == 'AgencyMaster') ? "active" : "" ?>"><i class="bi bi-plus-circle-fill Icons"></i><span>Masters</span> <i class="bi bi-chevron-down DropIcon"></i></a>
                    <ul>
                        <li><a href="./CustomerMaster.php" class="<?= ($NewTitle == 'CustomerMaster') ? "active" : "" ?>">Customer</a></li>
                        <li><a href="./CountryMaster.php" class="<?= ($NewTitle == 'CountryMaster') ? "active" : "" ?>">Country</a></li>
                        <li><a href="./ChecklistMaster.php" class="<?= ($NewTitle == 'ChecklistMaster') ? "active" : "" ?>">Checklist</a></li>
                        <li><a href="./SupplierMaster.php" class="<?= ($NewTitle == 'AgencyMaster') ? "active" : "" ?>">Agency</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#" class="<?= ($NewTitle == 'PrimaryAccountGroup' || $NewTitle == 'AccountGroup' || $NewTitle == 'ReceiptVoucher' || $NewTitle == 'PaymentVoucher' || $NewTitle == 'LedgerBook' || $NewTitle == 'LedgerMaster') ? "active" : "" ?>"><i class="bi bi-piggy-bank-fill Icons"></i><span>Accounts</span> <i class="bi bi-chevron-down DropIcon"></i></a>
                    <ul>
                        <li><a href="./ReceiptVoucher.php" class="<?= ($NewTitle == 'ReceiptVoucher') ? "active" : "" ?>">Receipt Voucher</a></li>
                        <li><a href="./PaymentVoucher.php" class="<?= ($NewTitle == 'PaymentVoucher') ? "active" : "" ?>">Payment Voucher</a></li>
                        <li><a href="./LedgerBook.php" class="<?= ($NewTitle == 'LedgerBook') ? "active" : "" ?>">Ledger Book</a></li>
                        <li><a href="./PortalAdd.php" class="<?= ($NewTitle == 'PortalRecharge') ? "active" : "" ?>">PortalRecharge</a></li>
                        <li><a href="./PrimaryAccountGroup.php" class="<?= ($NewTitle == 'PrimaryAccountGroup') ? "active" : "" ?>">Primary group</a></li>
                        <li><a href="./AccountGroup.php" class="<?= ($NewTitle == 'AccountGroup') ? "active" : "" ?>">Account Group</a></li>
                        <li><a href="./LedgerMaster.php" class="<?= ($NewTitle == 'LedgerMaster') ? "active" : "" ?>">Ledger</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#" class="<?= ($NewTitle == 'VisaBooking' || $NewTitle == 'TicketBooking' || $NewTitle == 'TaskReminder' || $NewTitle == 'TicketExtend') ? "active" : "" ?>"><i class="bi bi-airplane-fill Icons"></i><span>Booking</span> <i class="bi bi-chevron-down DropIcon"></i></a>
                    <ul>
                        <li><a href="./VisaBooking.php" class="<?= ($NewTitle == 'VisaBooking') ? "active" : "" ?>">Visa Booking</a></li>
                        <li><a href="./TicketBooking.php" class="<?= ($NewTitle == 'TicketBooking') ? "active" : "" ?>">Ticket Booking</a></li>
                        <li><a href="./DummyTicket.php" class="<?= ($NewTitle == 'DummyTicket') ? "active" : "" ?>">Dummy Enquiry</a></li>
                        <li><a href="./TicketExtend.php" class="<?= ($NewTitle == 'TicketExtend') ? "active" : "" ?>">Ticket Extend</a></li>
                        <li><a href="./TaskReminder.php" class="<?= ($NewTitle == 'TaskReminder') ? "active" : "" ?>">Task Reminder</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#" class="<?= ($NewTitle == 'VoucherReport' || $NewTitle == 'TicketBookingReport' || $NewTitle == 'ViewVisa' || $NewTitle == 'DayReport' || $NewTitle == 'TaskReport' || $NewTitle == 'DummyTicketBookingReport' || $NewTitle == 'TicketExtendReport' || $NewTitle == 'DummyEnquiryReport') ? "active" : "" ?>"><i class="bi bi-clipboard-data-fill Icons"></i><span>Reports</span> <i class="bi bi-chevron-down DropIcon"></i></a>
                    <ul>
                        <li><a href="./VoucherReport.php" class="<?= ($NewTitle == 'VoucherReport') ? "active" : "" ?>">Voucher Report</a></li>
                        <li><a href="./TicketBookingReport.php" class="<?= ($NewTitle == 'TicketBookingReport') ? "active" : "" ?>">Ticket Report</a></li>
                        <li><a href="./DummyEnquiryReport.php" class="<?= ($NewTitle == 'DummyEnquiryReport') ? "active" : "" ?>">Dummy Enquiry Report</a></li>
                        <li><a href="./DummyTicketReport.php" class="<?= ($NewTitle == 'DummyTicketBookingReport') ? "active" : "" ?>">Dummy Ticket Report</a></li>
                        <li><a href="./TicketExtendReport.php" class="<?= ($NewTitle == 'TicketExtendReport') ? "active" : "" ?>">Ticket Extend Report</a></li>
                        <li><a href="./ViewVisa.php" class="<?= ($NewTitle == 'ViewVisa') ? "active" : "" ?>">Visa Report</a></li>
                        <li><a href="./DayReport.php" class="<?= ($NewTitle == 'DayReport') ? "active" : "" ?>">Day Report</a></li>
                        <li><a href="./TaskReport.php" class="<?= ($NewTitle == 'TaskReport') ? "active" : "" ?>">Task Reminder Report</a></li>
                    </ul>
                </li>

                <!-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Drop Down 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                                <ul>
                                    <li><a href="#">Deep Drop Down 1</a></li>
                                    <li><a href="#">Deep Drop Down 2</a></li>
                                    <li><a href="#">Deep Drop Down 3</a></li>
                                    <li><a href="#">Deep Drop Down 4</a></li>
                                    <li><a href="#">Deep Drop Down 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Drop Down 2</a></li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li>
                        </ul>
                    </li> -->

                <li class="Customdropdown" id="ReminderNotification"><a href="#" class=""><i class="bi bi-alarm-fill me-2"></i><span>Reminder</span> </a>
                    <ul id="NotificationResult">

                        <li class="text-center" id="LoaderListNotification">
                            <img class="img-fluid loaderGif mx-auto" style="width: 100px; height:60px;" src="../Admin/loader.svg" alt="">
                        </li>

                    </ul>
                </li>


            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <!-- navbar -->

        <a href="../signout.php" class="book-a-table-btn">Log Out</a>

    </div>
</header>




<!-- OLD NAVBAR -->
<!-- <nav class="navbar fixed-top navbar-expand-lg bg-light p-1">
    <div class="container-fluid px-xl-5">
        <button class="btn btn-menu rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"> <i class="material-icons">menu</i> <span class="d-md-inline-block d-none"> Menu </span></button>
        <a class="navbar-brand" href="#"> <strong>BETA</strong> </a>
        <button class="btn btn-menu  rounded-pill"> <span class="d-md-inline-block d-none"> <?php echo $_SESSION['custname']; ?> </span> <i class="material-icons">account_circle</i> </button>

    </div>
</nav> -->

