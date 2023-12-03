//Calculate ticket amount of present day
function TicketAmount() {
    var Ticket = 'fetch_data';
    $.ajax({
        url: "DashboardData.php",
        method: "POST",
        data: { Ticket: Ticket },
        success: function(data) {
            //console.log(data);
            var TicketResult = JSON.parse(data);
            if (TicketResult.Status == 1) {
                $('#TicketAmount').text(Number(TicketResult.TicketAmount).toLocaleString('en-IN'));
            } else {
                $('#TicketAmount').text('0');
            }
        }
    });
}


//Calculate VisaAmount of Present day
function VisaAmount() {
    var Visa = 'fetch_data';
    $.ajax({
        url: "DashboardData.php",
        method: "POST",
        data: { Visa: Visa },
        success: function(data) {
            //console.log(data);
            var VisaResult = JSON.parse(data);
            if (VisaResult.Status == 1) {
                $('#VisaAmount').text(Number(VisaResult.VisaAmount).toLocaleString('en-IN'));
            } else {
                $('#VisaAmount').text('0');
            }
        }
    });
}


//Calculate Portal amount of present day
function PortalAmount() {
    var Portal = 'fetch_data';
    $.ajax({
        url: "DashboardData.php",
        method: "POST",
        data: { Portal: Portal },
        success: function(data) {
            //console.log(data);
            var PortalResult = JSON.parse(data);
            if (PortalResult.Status == 1) {
                $('#PortalAmount').text(Number(PortalResult.PortalAmount).toLocaleString('en-IN'));
            } else {
                $('#PortalAmount').text('0');
            }
        }
    });
}



//Calculate Profit amount of present day
function ProfitAmount() {
    var Profit = 'fetch_data';
    $.ajax({
        url: "DashboardData.php",
        method: "POST",
        data: { Profit: Profit },
        success: function(data) {
            //console.log(data);
            var ProfitResult = JSON.parse(data);
            if (ProfitResult.Status == 1) {
                $('#ProfitAmount').text(Number(ProfitResult.ProfitAmount).toLocaleString('en-IN'));
            } else {
                $('#ProfitAmount').text('0');
            }
        }
    });
}