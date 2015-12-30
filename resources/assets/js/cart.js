(function( cart, $, undefined ) {
    var apiEndpoint = '/api/v1/cart';

    cart.add = function (productId, quantity) {
        $.ajax({
            type: 'POST',
            url: apiEndpoint,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data: {
                'id': productId,
                'qty': quantity
            },
            success: function() {
                $.pjax.reload('#mini-cart-container').done(function() {
                    var subtotal = $('#cart-subtotal').text();
                    $('.cart-subtotal').text(subtotal);
                });
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.message);
            }
        });
    };

    cart.update = function(rowId, quantity) {
        $.ajax({
            type: 'PATCH',
            url: apiEndpoint + '/' + rowId,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data: {
                'qty': quantity
            },
            async: false,
                error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.message);
            }
        });
    };

    cart.delete = function(rowId) {
        $.ajax({
            type: 'DELETE',
            url: apiEndpoint + '/' + rowId,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        async: false,
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.message);
            }
        });
    };

    cart.addToCartAnimation = function($productImage) {
        var $cartTarget = $('.navbar .cart-icon:visible').eq(0);

        if($productImage) {
            var $imgClone = $productImage.clone().offset({
                top: $productImage.offset().top,
                left: $productImage.offset().left
            }).css({
                'opacity': '0.5',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100'
            }).appendTo($('body')).animate({
                'top': $cartTarget.offset().top + 10,
                'left': $cartTarget.offset().left + 10,
                'width': 75,
                'height': 75
            }, 1000, 'easeInOutExpo');

            $imgClone.animate({
                'width': 0,
                'height': 0
            }, function () {
                $(this).detach()
            });
        }
    };
}( window.cart = window.cart || {}, jQuery ));