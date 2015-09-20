<?php $noindex = true ?>
@section('title', 'Order details')

@extends('layouts.default')

@section('css')
@endsection

@section('content')
    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> Order [#{!! $order->id !!}] details</h1>
    </div>
    <p>Ordered on {!! $order->order_placed->toFormattedDateString() !!}</p>

    <p>Order status: <!--TODO more pretty tracking -->
        @if($order->order_status == 0)
            <span class="label label-default">Awaiting processing</span>
        @elseif($order->order_status == 1)
            <span class="label label-primary">Being processed</span>
        @elseif($order->order_status == 2)
            <span class="label label-primary">Out for delivery</span>
        @elseif($order->order_status == 3)
            <span class="label label-success">Delivered</span>
        @elseif($order->order_status == 4)
            <span class="label label-danger">Cancelled</span>
        @endif
    </p>

    @can('view-confidential-order', $order)
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <h4>Delivery address</h4>
                <address>
                    {{ $order->delivery_name }}<br>
                    {{ $order->delivery_line_1 }}<br>
                    @if($order->delivery_line_2 != ""){{$order->delivery_line_2}}<br>@endif
                    {{$order->delivery_city}}, {{$order->delivery_postcode}}<br>
                    <i class="fa fa-phone"></i> {{$order->delivery_phone}}<br>
                    @if($order->delivery_instructions != "")Delivery instructions: {{$order->delivery_instructions}}<br>@endif
                </address>
            </div>
            <div class="col-md-3">
                <h4>Payment method</h4>
                @include('includes.payment-method', ['payment' => $order->payment->getFormatted()])
            </div>
            <div class="col-md-3">
                <h4>Billing address</h4>
                {{ $order->payment->billing_name }}<br>
                {{ $order->payment->billing_line_1 }}<br>
                @if($order->payment->billing_line_2 != ""){{$order->payment->billing_line_2}}<br>@endif
                {{$order->payment->billing_city}}, {{$order->payment->billing_postcode}}<br>
            </div>
            <div class="col-md-3">
                <h4>Order summary</h4>
                @include('includes.order-summary',  ['total' => $order->total, 'shipping' => $order->shipping_fee, 'grandTotal' => $order->grandTotal])
                <form action="{!! request()->url() !!}">
                    <input type="hidden" name="_method" value="DELETE">
                    {!! Form::token() !!}
                    <button class="btn btn-danger btn-block btn-sm"><i class="fa fa-remove"></i> Cancel order</button><!--FIXME Cancel order and refund-->
                </form>
            </div>
        </div>
        @include('includes.vat-popover', ['vat' => $order->vat, 'grandTotal' => $order->grandTotal])

        <hr>

        @foreach($order->items as $item)
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="cart-product-thumb">
                                <a href="{!! $item->product->getUrl() !!}"><img
                                            src="{!! $item->product->images()->first()->url !!}"
                                            alt="{{ $item->product->title }}"></a>
                            </div>
                        </div>
                        <div class="col-xs-9">
                            <div class="cart-description">
                                <h4><a href="{!! $item->product->getUrl() !!}">{{ $item->product->title }}</a></h4>

                                <div class="price">{{ money_format("%i", $item->price) }}&euro;</div>

                                <p><b>Quantity: </b>{!! $item->quantity !!}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    @else
        @if(auth()->guest())
            <div class="well"><a href="{!! route('login') !!}">Sign in</a> to view more information on your order.</div>
        @endif
    @endcan

@endsection

@section('scripts')
    <script>
        $(function() {
            $('#vat-expand').popover({
                html: true,
                title: 'VAT Summary',
                placement: 'bottom',
                content: $('#vat-popover-template').html()
            })
        });
    </script>
@endsection