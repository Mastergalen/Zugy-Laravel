/*
 * Add CSRF token to ajax request headers
 */
$.ajaxSetup({
    beforeSend: function(xhr) {
        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));
    }
});
