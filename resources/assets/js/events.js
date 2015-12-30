/**
 * Add click listener for deleting items from mini cart
 */



$('#mini-cart-container').on('click', '.delete button', function() {
    $(this).prop('disabled', true);

    var rowId = $(this).data('row-id');

    cart.delete(rowId);

    $(this).prop('disabled', false);
}).on('pjax:start', function() { $(this).fadeOut(200); })
  .on('pjax:end',   function() { $(this).fadeIn(200); });