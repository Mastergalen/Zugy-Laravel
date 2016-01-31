/*
 * Add CSRF token to ajax request headers
 */
$.ajaxSetup({
    beforeSend: function(xhr) {
        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));
    }
});

//Pjax default timeout increase
$.pjax.defaults.timeout = 4000;

$(document).on('ready pjax:success', function() {
    $('[data-toggle="popover"]').popover();
});

/**
 * Fetch GET variables from URL
 * @param qs
 * @returns {{}}
 */
function getQueryParams(qs) {
    qs = qs.split("+").join(" ");
    var params = {},
        tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])]
            = decodeURIComponent(tokens[2]);
    }

    return params;
}

