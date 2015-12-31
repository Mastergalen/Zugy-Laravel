(function( postcode, $, undefined ) {
    var apiEndpoint = '/api/v1/postcode';

    /**
     * Check if postcode is in delivery range
     * @param zipCode
     */
    postcode.check = function(zipCode) {
        if(zipCode == "") {
            zipCode = 0;
        }

        $.ajax({
            type: 'GET',
            url: apiEndpoint + '/check/' + zipCode,
            success: function(data) {
                if(data.delivery == true) {
                    swal({
                        title: data.message,
                        timer: 1000,
                        type: "success",
                        showConfirmButton: false,
                    }, function() {
                        window.location.href = data.storeUrl;
                    })
                } else {
                    swal({
                        title: data.message,
                        text: data.description,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: data.confirmButtonText,
                    }, function() {
                        window.location.href = data.storeUrl;
                    });
                }

            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                swal(err.message, JSON.stringify(err.errors.postcode), "error");
            }
        });
    };

}( window.postcode = window.postcode || {}, jQuery ));