<?php $noindex = true ?>
@section('title', 'Cart')
@section('meta_description', '')

@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css">
@endsection
<!-- TODO Show estimated delivery -->
@section('content')
    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> Shopping Cart</h1>
    </div>
    @if(Cart::shipping() != 0)
        <div class="alert alert-info">Order more than 20&euro; worth and get <b>free shipping</b>!</div>

    @endif

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <table class="table table-responsive" id="cart-table">
                <thead>
                    <th>Product</th>
                    <th>Details</th>
                    <th></th>
                    <th>Qty</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    @foreach(Cart::content() as $row)
                         <tr class="cart-row" data-product-id="{{$row->id}}" data-row-id="{{$row->rowid}}">
                            <td class="cart-product-thumb"><a href="{!! $row->product->getUrl() !!}"><img
                                            src="{!! $row->product->cover() !!}"
                                            alt="{{ $row->name }}"></a></td>
                            <td>
                                <div class="cart-description">
                                    <h4><a href="{!! $row->product->getUrl() !!}">{{ $row->name }}</a></h4>
                                    <div class="price">{{ money_format("%i", $row->price) }}&euro;</div>
                                </div>
                            </td>
                            <td class="delete"><i class="fa fa-trash fa-2x" title="Delete"></i></td>
                            <td class="quantity">
                                <input type="text" name="quantity" value="{!! $row->qty !!}">
                            </td>
                            <td class="price">{{ money_format("%i", $row->subtotal) }}&euro;</td>
                        </tr>
                    @endforeach
                    <tr id="empty-cart-msg" @if(Cart::count(false) !== 0)style="display:none"@endif>
                        <td colspan="5">
                            <p>You don't have anything in your cart yet. Visit the <a href="{!! action('ShopController@index') !!}">shop</a> to start filling it up!</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-footer">
                <div class="pull-left">
                    <a class="btn btn-footer" href="{!! action('ShopController@index') !!}"><i class="fa fa-arrow-left"></i> Continue shopping</a>
                </div>
                <div class="pull-right">
                    <button class="btn btn-footer" id="btn-update-cart"><i class="fa fa-repeat"></i> Update cart</button>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5">
            <div class="box" style="margin-bottom: 10px">
                <table id="order-summary" class="table">
                    <tr>
                        <td>Items</td>
                        <td class="price">{!! money_format("%i", Cart::total()) !!}&euro;</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td class="price">
                            @if(Cart::shipping() == 0)
                                <span style="color: #8BB418;">Free shipping</span>
                            @else
                                {!! money_format("%i", Cart::shipping()) !!}&euro;
                            @endif
                        </td>
                    </tr>
                    <tr class="total">
                        <td>Total</td>
                        <td class="price">{!! money_format("%i", Cart::grandTotal()) !!}&euro;</td>
                    </tr>
                </table>
            </div>
            <a href="{!! Localization::getURLFromRouteNameTranslated(Localization::getCurrentLocale(), 'routes.checkout.landing') !!}" class="btn btn-block btn-lg btn-success" @if(Cart::count(false) === 0)disabled @endif>Proceed to checkout <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script>
        $("#cart-table .quantity input").TouchSpin({
            min: 1,
            step: 1,
            boostat: 5,
            maxboostedstep: 5,
        });

        $(function() {
            $('#cart-table .cart-row .delete').click(function() {
                $row = $(this).closest('.cart-row')
                var rowId = $row.data('row-id');

                console.log('Deleting ' + $row.data('row-id'));

                $.ajax({
                    type: 'DELETE',
                    url: '{!! action('API\CartController@index') !!}/' + rowId,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    async: false,
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.message);
                    }
                });

                $row.fadeOut('slow', function() {
                    $(this).remove();

                    if($('#cart-table .cart-row').length == 0) {
                        $('#cart-table #empty-cart-msg').show('slow');
                    }
                });
            });

            /* Update cart */
            $('#btn-update-cart').click(function() {

                $('#cart-table .cart-row').each(function() {
                    var rowId = $(this).data('row-id');
                    var quantity = $(this).find('.quantity input').val();

                    console.log(rowId);
                    console.log(quantity);

                    if(quantity == 0) {
                        console.log('Deleting ' +  rowId);
                        $(this).find('delete').trigger('click');
                        return;
                    }

                    $.ajax({
                        type: 'PATCH',
                        url: '{!! action('API\CartController@index') !!}/' + rowId,
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
                });

                window.location.reload();
            });
        });
    </script>
@endsection