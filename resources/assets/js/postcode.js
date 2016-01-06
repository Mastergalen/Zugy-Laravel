(function( postcode, $, undefined ) {
    var apiEndpoint = '/api/v1/postcode';

    /**
     * Check if postcode is in delivery range
     * @param zipCode
     */
    postcode.check = function(zipCode, redirect) {
        if(zipCode == "") {
            zipCode = 0;
        }

        if(typeof redirect == 'undefined') redirect = true;

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
                        if(redirect == true) {
                            window.location.href = data.storeUrl;
                        }
                        swal.close();
                    })
                } else {
                    swal({
                        title: data.message,
                        text: data.description,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: data.confirmButtonText
                    }, function() {
                        if(redirect == true) {
                            window.location.href = data.storeUrl;
                        }
                        swal.close();
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