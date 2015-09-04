<?php $noindex = true ?>
@section('title', 'Cart')
@section('meta_description', '')

@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css">
    <style>
        #empty-cart-msg {
            font-size: 1.5em;
        }
        .btn-cart {
            background-color: #BDC3C7;
            color: #FFFFFF;
        }

        .btn-cart:hover {
            background-color: #CACFD2;
            border-color: #CACFD2;
            color: #FFFFFF;
        }

        #cart-table {
            margin-bottom: 0;
        }
        #cart-table thead {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 14px;
            background: #EBEDEF;
            border-bottom: 1px solid #E7E9EC;
        }

        #cart-table tr {
            border-bottom: 1px solid #E7E9EC;
        }

        #cart-table tbody>tr>td, #cart-table thead>tr>th{
            padding: 10px 0;
            text-align: center;
            vertical-align: middle;
        }

        #cart-table td:nth-child(2), #cart-table th:nth-child(2) {
            text-align: left;
        }

        #cart-table .quantity {
            width: 102px;
        }

        .cart-product-thumb a img {
            width: 86px;
            max-width: 100%;
        }

        .box {
            border: 1px solid #DDDDDD;
            padding: 10px;
        }

        #cart-summary tr:first-child td {
            border: none;
        }

        #cart-summary tr td:nth-child(2) {
            text-align: right;
        }

        #total-price {
            color: #4ec67f;
            font-size: 22px;
            font-weight: bold;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }

        .cart-footer {
            padding: 20px;
            border-top: solid 1px #eee;
            background: #EBEDEF;
            display: inline-block;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> Shopping Cart</h1>
    </div>
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
                            <td class="cart-product-thumb"><a href=""><img
                                            src="{!! $row->product->images()->first()->url !!}"
                                            alt="{{ $row->name }}"></a></td>
                            <td>
                                <div class="cart-description">
                                    <h4>{{ $row->name }}</h4>
                                    <div class="price">{{$row->price}}&euro;</div>
                                </div>
                            </td>
                            <td class="delete"><i class="fa fa-trash fa-2x" title="Delete"></i></td>
                            <td class="quantity">
                                <input type="text" name="quantity" value="{!! $row->qty !!}">
                            </td>
                            <td class="price">{{ $row->subtotal }}&euro;</td>
                        </tr>
                    @endforeach
                    <tr id="empty-cart-msg" @if(Cart::count(false) !== 0)style="display:none"@endif>
                        <td colspan="5">
                            <p>You don't have anything in your cart yet. Visit the <a href="{!! action('ShopController@index') !!}">shop</a> to start filling it up!</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="cart-footer">
                <div class="pull-left">
                    <a class="btn btn-cart" href="{!! action('ShopController@index') !!}"><i class="fa fa-arrow-left"></i> Continue shopping</a>
                </div>
                <div class="pull-right">
                    <button class="btn btn-cart" id="btn-update-cart"><i class="fa fa-repeat"></i> Update cart</button>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5">
            <button class="btn btn-block btn-lg btn-success" style="margin-bottom: 20px" @if(Cart::count(false) === 0)disabled @endif>Proceed to checkout <i class="fa fa-arrow-right"></i></button>
            <div class="box">
                <table id="cart-summary" class="table">
                    <tr>
                        <td>Total products</td>
                        <td class="price">{!! Cart::total() !!}&euro;</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td class="price"><span style="color: #8BB418;">Free shipping</span></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td id="total-price">{!! Cart::total() !!}&euro;</td>
                        <!--Need to add shipping later -->
                    </tr>
                </table>
            </div>
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