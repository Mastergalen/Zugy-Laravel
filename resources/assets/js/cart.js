(function( cart, $, undefined ) {
    var apiEndpoint = '/api/v1/cart';

    cart.add = function (productId, quantity) {
        return $.ajax({
            type: 'POST',
            url: apiEndpoint,
            data: {
                'id': productId,
                'qty': quantity
            },
            success: updateMiniCart,
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                swal(err.message, null, "error");
            }
        });
    };

    /**
     * Update an array of items in cart
     * @returns {*}
     * @param items
     */
    cart.update = function(items) {
        return $.ajax({
            type: 'PATCH',
            url: apiEndpoint,
            data: {
                items: items
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                swal({
                    type: 'error',
                    title: err.message,
                    text: err.description,
                });
            }
        });
    };

    cart.delete = function(rowId) {
        console.log("Deleting", rowId);
        $.ajax({
            type: 'DELETE',
            url: apiEndpoint + '/' + rowId,
            success: updateMiniCart,
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

    function updateMiniCart() {
        $.pjax.reload('#mini-cart-container', {timeout: 1500}).done(function() {
            var subtotal = $('#cart-subtotal').text();
            $('.cart-subtotal').text(subtotal);
        });
    }

    /*
     * Make mini cart disappear when clicking anywhere else
     */
    var $navbarCart = $('#navbar-cart');

    function navbarCartHideClickHandler() {
        $navbarCart.collapse('hide');
    }

    $navbarCart.on('show.bs.collapse', function () {
        $(document).click(navbarCartHideClickHandler);
        $('.dropdown-toggle').click(navbarCartHideClickHandler);

        $navbarCart.click(function(e) {
            e.stopPropagation();
        });
    });

    $navbarCart.on('hide.bs.collapse', function () {
        $(document).unbind('click', navbarCartHideClickHandler);
        $('.dropdown-toggle').unbind('click', navbarCartHideClickHandler);
    });


}( window.cart = window.cart || {}, jQuery ));