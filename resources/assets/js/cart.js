(function( cart, $, undefined ) {
    cart.add = function (url, thumbnail, title, price, quantity) {
        $container = $('#mini-cart-container');

        var template = $('#mini-cart-product-row-template').html();
        Mustache.parse('template');

        var rendered = Mustache.render(template, {
            url: url,
            thumbnail: thumbnail,
            price: price.toFixed(2),
            title: title,
            quantity: quantity,
            subtotal: (price * quantity).toFixed(2)
        });

        $container.append(rendered);

        //Update subtotal
        var subtotal = $('.cart-subtotal').eq(0).html();

        subtotal = (parseFloat(subtotal) + parseFloat(price * quantity)).toFixed(2);

        $('.cart-subtotal').html(subtotal);
    }
}( window.cart = window.cart || {}, jQuery ));