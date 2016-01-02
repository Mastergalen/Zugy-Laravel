(function( order, $, undefined ) {
    var apiEndpoint = '/api/v1/order';

    /**
     * Check if postcode is in delivery range
     * @param orderId
     * @param status
     */
    order.updateStatus = function(orderId, status) {
        $.ajax({
            type: 'PATCH',
            url: apiEndpoint + '/' + orderId,
            data: {
                order_status: status
            },
            success: function(data) {
                swal({
                    title: data.message,
                    type: 'success',
                    timer: 1000,
                    showConfirmButton: false
                });
                $.pjax.reload('#container');
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                swal(err.message, JSON.stringify(err.errors), "error");
            }
        });
    };

}( window.order = window.order || {}, jQuery ));