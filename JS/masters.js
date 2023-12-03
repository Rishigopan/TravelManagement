/* Add country master Start */
$(function() {
    let validator = $("#AddCountry").jbvalidator({
        language: "dist/lang/en.json",
        successClass: false,
        html5BrowserDefault: true,
    });

    validator.validator.custom = function(el, event) {
        if ($(el).is("#country_name") && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]+/)) {
            return "Only allowed alphabets";
        } else if ($(el).is("#country_name") && $(el).val().trim().length == 0) {
            return "Cannot be empty";
        }
    };

    $(document).on("submit", "#AddCountry", function(e) {
        e.preventDefault();
        var BranchData = new FormData(this);
        console.log(BranchData);
        $.ajax({
            type: "POST",
            url: "MasterOperations.php",
            data: BranchData,
            beforeSend: function() {
                $("#loading").show();
                $("#updatebranch_form").addClass("disable");
                $("#CountryModal").modal("hide");
                $("#ResponseImage").html("");
                $("#ResponseText").text("");
            },
            success: function(data) {
                $("#loading").hide();
                console.log(data);
                if (TestJson(data) == true) {
                    var response = JSON.parse(data);
                    if (response.addCountry == "0") {
                        $("#ResponseImage").html(
                            '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Country is Already Present");
                        $("#confirmModal").modal("show");
                    } else if (response.addCountry == "1") {
                        $("#ResponseImage").html(
                            '<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Successfully Added Country");
                        $("#confirmModal").modal("show");
                        $("#testbtn").focus();
                        ResetForms();
                        ReloadTable();
                    } else if (response.addCountry == "2") {
                        //$('#BranchModal').modal('hide');
                        $("#ResponseImage").html(
                            '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Failed Adding Country");
                        $("#confirmModal").modal("show");
                    }
                } else {
                    $("#ResponseImage").html(
                        '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                    );
                    $("#ResponseText").text(
                        "Some Error Occured, Please refresh the page (ERROR : 12ENJ)"
                    );
                    $("#confirmModal").modal("show");
                }
            },
            error: function() {
                $("#ResponseImage").html(
                    '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                );
                $("#ResponseText").text(
                    "Please refresh the page to continue (ERROR : 12EFF)"
                );
                $("#confirmModal").modal("show");
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });
});
/* Add country master  End */

/* Add customer master Start */
$(function() {
    let validator = $("#AddCustomer").jbvalidator({
        //language: 'dist/lang/en.json',
        successClass: false,
        html5BrowserDefault: true,
    });

    validator.validator.custom = function(el, event) {
        /* if ($(el).is('#country_name') && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]+/)) {
                            return 'Only allowed alphabets';
                        } else if ($(el).is('#country_name') && $(el).val().trim().length == 0) {
                            return 'Cannot be empty';
                        } */
        if (
            $(el).is("#cust_first") &&
            $(el).val().trim().length == 0
        ) {
            return "Cannot be empty";
        }
    };

    $(document).on("submit", "#AddCustomer", function(f) {
        f.preventDefault();
        var CustomerData = new FormData(this);
        console.log(CustomerData);
        $.ajax({
            type: "POST",
            url: "MasterOperations.php",
            data: CustomerData,
            beforeSend: function() {
                $("#loading").show();
                $("#AddCustomer").addClass("disable");
                $("#CustomerModal").modal("hide");
                $("#ResponseImage").html("");
                $("#ResponseText").text("");
            },
            success: function(data) {
                $("#loading").hide();
                console.log(data);
                $("#AddCustomer").removeClass("disable");
                if (TestJson(data) == true) {
                    var response = JSON.parse(data);
                    if (response.addCustomer == "0") {
                        $("#ResponseImage").html(
                            '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Customer is Already Present");
                        $("#confirmModal").modal("show");
                    } else if (response.addCustomer == "1") {
                        $("#ResponseImage").html(
                            '<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Successfully Added Customer");
                        $("#confirmModal").modal("show");
                        ResetForms();
                        ReloadTable();
                    } else if (response.addCustomer == "4") {
                        //$('#BranchModal').modal('hide');
                        $("#ResponseImage").html(
                            '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Please Choose Opening Type First");
                        $("#confirmModal").modal("show");
                    } else if (response.addCustomer == "2") {
                        //$('#BranchModal').modal('hide');
                        $("#ResponseImage").html(
                            '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Failed Adding Customer");
                        $("#confirmModal").modal("show");
                    }
                } else {
                    $("#ResponseImage").html(
                        '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                    );
                    $("#ResponseText").text(
                        "Some Error Occured, Please refresh the page (ERROR : 12ENJ)"
                    );
                    $("#confirmModal").modal("show");
                }
            },
            error: function() {
                $("#ResponseImage").html(
                    '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                );
                $("#ResponseText").text(
                    "Please refresh the page to continue (ERROR : 12EFF)"
                );
                $("#confirmModal").modal("show");
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });
});
/* Add customer master  End */

/* Add supplier master Start */
$(function() {
    let validator = $("#AddSupplier").jbvalidator({
        //language: 'dist/lang/en.json',
        successClass: false,
        html5BrowserDefault: true,
    });

    validator.validator.custom = function(el, event) {
        /* if ($(el).is('#country_name') && $(el).val().match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]+/)) {
                            return 'Only allowed alphabets';
                        } else if ($(el).is('#country_name') && $(el).val().trim().length == 0) {
                            return 'Cannot be empty';
                        } */
        if (
            $(el).is("#sup_first") &&
            $(el).val().trim().length == 0
        ) {
            return "Cannot be empty";
        }
    };

    $(document).on("submit", "#AddSupplier", function(e) {
        e.preventDefault();
        var SupplierData = new FormData(this);
        console.log(SupplierData);
        $.ajax({
            type: "POST",
            url: "MasterOperations.php",
            data: SupplierData,
            beforeSend: function() {
                $("#loading").show();
                $("#AddSupplier").addClass("disable");
                $("#SupplierModal").modal("hide");
                $("#ResponseImage").html("");
                $("#ResponseText").text("");
            },
            success: function(data) {
                $("#loading").hide();
                console.log(data);
                $("#AddSupplier").removeClass("disable");
                if (TestJson(data) == true) {
                    var response = JSON.parse(data);
                    if (response.addSupplier == "0") {
                        $("#ResponseImage").html(
                            '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Agency is Already Present");
                        $("#confirmModal").modal("show");
                    } else if (response.addSupplier == "1") {
                        $("#ResponseImage").html(
                            '<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Successfully Added Agency");
                        $("#confirmModal").modal("show");
                        ResetForms();
                        ReloadTable();
                        //MasterTable.ajax.reload();
                    } else if (response.addSupplier == "2") {
                        //$('#BranchModal').modal('hide');
                        $("#ResponseImage").html(
                            '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Failed Adding Supplier");
                        $("#confirmModal").modal("show");
                    } else if (response.addSupplier == "4") {
                        //$('#BranchModal').modal('hide');
                        $("#ResponseImage").html(
                            '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Please Choose Opening Type First");
                        $("#confirmModal").modal("show");
                    }
                } else {
                    $("#ResponseImage").html(
                        '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                    );
                    $("#ResponseText").text(
                        "Some Error Occured, Please refresh the page (ERROR : 12ENJ)"
                    );
                    $("#confirmModal").modal("show");
                }
            },
            error: function() {
                $("#ResponseImage").html(
                    '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                );
                $("#ResponseText").text(
                    "Please refresh the page to continue (ERROR : 12EFF)"
                );
                $("#confirmModal").modal("show");
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });
});
/* Add supplier master  End */

/* Add ledger master Start */
$(function() {
    let validator = $("#AddLedger").jbvalidator({
        //language: 'dist/lang/en.json',
        successClass: false,
        html5BrowserDefault: true,
    });

    validator.validator.custom = function(el, event) {
        if (
            $(el).is("#ledger_name") &&
            $(el)
            .val()
            .match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]+/)
        ) {
            return "Only allowed alphabets";
        } else if ($(el).is("#ledger_name") && $(el).val().trim().length == 0) {
            return "Cannot be empty";
        }
    };

    $(document).on("submit", "#AddLedger", function(e) {
        e.preventDefault();
        var LedgerData = new FormData(this);
        console.log(LedgerData);
        $.ajax({
            type: "POST",
            url: "MasterOperations.php",
            data: LedgerData,
            beforeSend: function() {
                $("#loading").show();
                $("#AddLedger").addClass("disable");
                $("#LedgerModal").modal("hide");
                $("#ResponseImage").html("");
                $("#ResponseText").text("");
            },
            success: function(data) {
                $("#loading").hide();
                $("#AddLedger").removeClass("disable");
                console.log(data);
                if (TestJson(data) == true) {
                    var response = JSON.parse(data);
                    if (response.addLedger == "0") {
                        $("#ResponseImage").html(
                            '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Ledger is Already Present");
                        $("#confirmModal").modal("show");
                    } else if (response.addLedger == "1") {
                        $("#ResponseImage").html(
                            '<img src="./success.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Successfully Added Ledger");
                        $("#confirmModal").modal("show");
                        ResetForms();
                        ReloadTable();
                        //MasterTable.ajax.reload();
                    } else if (response.addLedger == "2") {
                        //$('#BranchModal').modal('hide');
                        $("#ResponseImage").html(
                            '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Failed Adding Ledger");
                        $("#confirmModal").modal("show");
                    } else if (response.addLedger == "4") {
                        //$('#BranchModal').modal('hide');
                        $("#ResponseImage").html(
                            '<img src="./warning.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                        );
                        $("#ResponseText").text("Please Choose Opening Type First");
                        $("#confirmModal").modal("show");
                    }
                } else {
                    $("#ResponseImage").html(
                        '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                    );
                    $("#ResponseText").text(
                        "Some Error Occured, Please refresh the page (ERROR : 12ENJ)"
                    );
                    $("#confirmModal").modal("show");
                }
            },
            error: function() {
                $("#ResponseImage").html(
                    '<img src="./error.jpg" style="height:130px;width:130px;" class="img-fluid" alt="">'
                );
                $("#ResponseText").text(
                    "Please refresh the page to continue (ERROR : 12EFF)"
                );
                $("#confirmModal").modal("show");
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });
});
/* Add ledger master  End */




/********************** MASTER EXTRAS *************************/


    //From Country
    $('.SelectFromCountry').focus(function() {
        //console.log('test');
        var selectCountry = 'fetch_data';
        $.ajax({
            type: "POST",
            url: "MasterExtras.php",
            data: {
                selectCountry: selectCountry
            },
            success: function(data) {
                $('.SelectFromCountry').html(data);
            }
        });
    });


    //To Country
    $('.SelectToCountry').focus(function() {
        //console.log('test');
        var selectCountry = 'fetch_data';
        $.ajax({
            type: "POST",
            url: "MasterExtras.php",
            data: {
                selectCountry: selectCountry
            },
            success: function(data) {
                $('.SelectToCountry').html(data);
            }
        });
    });


    //Agency
    $('.SelectAgency').focus(function() {
        //console.log('test');
        var selectAgency = 'fetch_data';
        $.ajax({
            type: "POST",
            url: "MasterExtras.php",
            data: {
                selectAgency: selectAgency
            },
            success: function(data) {
                $('.SelectAgency').html(data);
            }
        });
    });


    //Customer
    $('.SelectCustomer').focus(function() {
        //console.log('test');
        var selectCustomer = 'fetch_data';
        $.ajax({
            type: "POST",
            url: "MasterExtras.php",
            data: {
                selectCustomer: selectCustomer
            },
            success: function(data) {
                $('.SelectCustomer').html(data);
            }
        });
    });


    //Ledger
    $('.SelectLedger').focus(function() {
        //console.log('test');
        var selectLedger = 'fetch_data';
        $.ajax({
            type: "POST",
            url: "MasterExtras.php",
            data: {
                selectLedger: selectLedger
            },
            success: function(data) {
                $('.SelectLedger').html(data);
            }
        });
    });


/********************** MASTER EXTRAS *************************/