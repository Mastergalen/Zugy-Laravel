(function( address, $, undefined ) {
    var apiEndpoint = '/api/v1/address';

    address.update = function(addressId, address) {
        return $.ajax({
            type: 'PATCH',
            url: apiEndpoint + '/' + addressId,
            data: address,
            success: function(data) {
                swal(data.message, null, "success");
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.message);
            }
        });
    };

    address.delete = function(addressId) {
        return $.ajax({
            type: 'DELETE',
            url: apiEndpoint + '/' + addressId,
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.message);
            }
        });
    };

}( window.address = window.address || {}, jQuery ));