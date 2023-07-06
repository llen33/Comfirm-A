function confirmShipOut(orderId) {

    if (confirm("Are you sure you want to ship out this order?")) {

        shipOut(orderId);

    }

}

function shipOut(orderId) {

    // Disable the button
    document.getElementById('shipOutBtn' + orderId).disabled = true;

    // Send AJAX request to update the order status
    $.ajax({

        url: 'seller_ship_out.php',
        type: 'POST',
        data: {orderId: orderId},

        success: function(response) {

            // Move the shipped order to the bottom of the table list
            var orderRow = $('#orderRow' + orderId);
            var orderTable = $('#orderTable');
            orderRow.appendTo(orderTable);

            // Refresh the order list to reflect the updated status
            location.reload();

        }

    });
    
}