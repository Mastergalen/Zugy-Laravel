/*
 * Add CSRF token to ajax request headers
 */
$.ajaxSetup({
    beforeSend: function(xhr) {
        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));
    }
});

$.pjax.defaults.timeout = 1500;

$(document).on('ready pjax:success', function() {
    $('[data-toggle="popover"]').popover();
});
