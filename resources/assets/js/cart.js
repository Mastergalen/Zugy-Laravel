(function( cart, $, undefined ) {
    var apiEndpoint = '/api/v1/cart';

    cart.add = function (item) {
        $.ajax({
            type: 'POST',
            url: apiEndpoint,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data: {
            'name': item.name,
                'id': item.id,
                'qty': item.quantity
        },
        success: function() {
            $.pjax.reload('#mini-cart-container');
        },
        error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.message);
        }
    });

}

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
    }

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
    }
}( window.cart = window.cart || {}, jQuery ));