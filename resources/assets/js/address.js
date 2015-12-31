(function( address, $, undefined ) {
    var apiEndpoint = '/api/v1/address';

    address.update = function(addressId, address) {
        return $.ajax({
            type: 'PATCH',
            url: apiEndpoint + '/' + addressId,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.message);
            }
        });
    };

}( window.address = window.address || {}, jQuery ));