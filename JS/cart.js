function getcartData() {
    var cart = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "TicketCartData.php",
        data: { cart: cart },
        success: function(data) {
            //console.log(data);
            $('#TicketTable').html(data);
        }
    });
}