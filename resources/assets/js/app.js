$('.getFullSearch').click(function () {
    $('#search-full').addClass('active')
        .find('input').focus();

})

$('#search-close').click(function () {
   $(this).parent().removeClass('active');
});

$('#search-form').submit(function (e) {
    e.preventDefault();

    var $field = $(this).find('input').eq(0);
    var query = $field.val();

    if(query == '') {
        return;
    }

    var searchUrl = $field.data('search-url') + '/' + query;

    window.open(searchUrl, "_self");
});