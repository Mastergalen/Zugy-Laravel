<?php $noindex = true; ?>
@section('title', 'Cart')

@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css">
@endsection

@section('content')
    <!-- TODO Show estimated delivery -->
    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> {!! trans('cart.shopping-cart') !!}</h1>
    </div>
    @if(Cart::shipping() != 0)
        <div class="alert alert-info">{!! trans('cart.free-shipping-reminder') !!}</div>
    @endif

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <table class="table table-responsive" id="cart-table">
                <thead>
                    <th>{!! trans('product.product') !!}</th>
                    <th>{!! trans('product.tabs.details') !!}</th>
                    <th></th>
                    <th>{!! trans('product.quantity') !!}</th>
                    <th>{!! trans('checkout.total') !!}</th>
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
                            <p>{!! trans('cart.empty-cart-msg', ['storeUrl' => action('ShopController@index')]) !!}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-footer">
                <div class="pull-left">
                    <a class="btn btn-footer" href="{!! action('ShopController@index') !!}"><i class="fa fa-arrow-left"></i> {!! trans('buttons.continue-shopping') !!}</a>
                </div>
                <div class="pull-right">
                    <button class="btn btn-footer" id="btn-update-cart"><i class="fa fa-repeat"></i> {!! trans('buttons.update-cart') !!}</button>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5">
            <div class="box" style="margin-bottom: 10px">
                <table id="order-summary" class="table">
                    <tr>
                        <td>{!! trans('checkout.items') !!}</td>
                        <td class="price">{!! money_format("%i", Cart::total()) !!}&euro;</td>
                    </tr>
                    <tr>
                        <td>{!! trans('checkout.shipping') !!}</td>
                        <td class="price">
                            @if(Cart::shipping() == 0)
                                <span style="color: #8BB418;">{!! trans('shipping.free') !!}</span>
                            @else
                                {!! money_format("%i", Cart::shipping()) !!}&euro;
                            @endif
                        </td>
                    </tr>
                    <tr class="total">
                        <td>{!! trans('checkout.total') !!}</td>
                        <td class="price">{!! money_format("%i", Cart::grandTotal()) !!}&euro;</td>
                    </tr>
                </table>
            </div>
            <a href="{!! localize_url('routes.checkout.landing') !!}" class="btn btn-block btn-lg btn-success" @if(Cart::count(false) === 0)disabled @endif>
                {!! trans('buttons.proceed-to-checkout') !!} <i class="fa fa-arrow-right"></i>
            </a>
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

                cart.delete(rowId);

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

                    cart.update(rowId, quantity);
                });

                window.location.reload();
            });
        });
    </script>
@endsection