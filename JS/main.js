//function to check if json
function TestJson(json) {
    var Untrimmed = json;
    var trimmed = Untrimmed.trim();

    if (typeof trimmed !== "string") {
        return false;
    }
    try {
        var NewJson = JSON.parse(trimmed);
        return typeof NewJson === "object";
    } catch (error) {
        return false;
    }
}



//reset forms
function ResetForms() {
    //$(".UpdateForm")[0].reset();
    //$(".AddForm")[0].reset();
    $('#AddCountry')[0].reset();
    $('#AddCustomer')[0].reset();
    $('#AddSupplier')[0].reset();
    $('#AddLedger')[0].reset();
    console.log("resetforms");
}



//modal close function
$(".addUpdateModal").on("hidden.bs.modal", function() {
    $(".UpdateForm").hide();
    $(".AddForm").show();
    $(".UpdateForm")[0].reset();
    $(".AddForm")[0].reset();
});



//reload table
function ReloadTable() {
    if ($.fn.DataTable.isDataTable("#MasterTable")) {
        MasterTable.ajax.reload();
    } else {
        //console.log("bye");
    }
}



$('#ReminderNotification').click(function() {
    $('#ReminderNotification').addClass('showdropdown');
    var Notifications = 'fetch_data';
    $.ajax({
        url: "NotificationContent.php",
        method: "POST",
        data: {
            Notifications: Notifications
        },
        beforeSend: function() {
            $('#LoaderListNotification').show();
        },
        success: function(data) {
            $('#LoaderListNotification').hide();
            $('#NotificationResult').html(data);
        }
    });

});

// $('#ReminderNotification').focusout(function() {
//     // $('#NotificationResult').click(function() {

//     // });

//     if ($('#NotificationResult li').data('clicked', true)) {
//         console.log('test');
//     } else {
//         $('#ReminderNotification').removeClass('showdropdown');
//     }

// });

$('#NotificationResult').mouseleave(function() {
    $('#ReminderNotification').removeClass('showdropdown');
});