@extends('admin.layouts.default')

@section('title', "Order [#{$order->id}]" )

@section('header')
    <h1><i class="fa fa-book"></i> Order [#{{$order->id}}]</h1>
@endsection

@section('breadcrumb')
    <li><a href="{!! action('Admin\OrderController@index') !!}">Orders</a></li>
    <li class="active">
        <strong>Order [#{{$order->id}}]</strong>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 col-md-push-9">
            <div class="box box-default">
                <div class="box-body">
                    <h3>Order actions</h3>
                    {!! Form::open() !!}
                        <div class="form-group">
                            {!! Form::select('action', [null => "Actions", 'processing' => 'Processing', 'completed' => 'Completed', 'cancel' => 'Cancel Order'], Input::old('action'), ['class' => 'form-control']) !!}
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">Update order</button>
                        <!-- TODO Make updating order status work-->
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
        <div class="col-md-9 col-md-pull-3">
            <div class="box box-default">
                <div class="box-body">
                    @include('includes.status.order-status', ['status' => $order->order_status, 'type' => 'callout'])
                    <div class="row">
                        <div class="col-md-4">
                            <h4>Order details</h4>
                            <dl>
                                <dt>Order placed:</dt>
                                <dd>{{ $order->order_placed }}</dd>
                                <dd>{{ $order->order_placed->diffForHumans() }}</dd>

                                @if($order->payment->paid)
                                    <dt>Paid:</dt>
                                    <dd>{{ $order->payment->paid }}</dd>
                                @endif

                                @if($order->order_completed)
                                    <dt>Order completed:</dt>
                                    <dd>{{ $order->order_completed }}</dd>
                                @endif
                            </dl>
                        </div>
                        <div class="col-md-4">
                            <h4>Delivery address</h4>
                            <address>
                                {{ $order->delivery_name }}<br>
                                {{ $order->delivery_line_1 }}<br>
                                @if($order->delivery_line_2 != ""){{$order->delivery_line_2}}<br>@endif
                                {{$order->delivery_city}}, {{$order->delivery_postcode}}<br>
                                <i class="fa fa-phone"></i> {{$order->delivery_phone}}<br>
                                @if($order->delivery_instructions != "")Delivery instructions: {{$order->delivery_instructions}}<br>@endif
                            </address>
                            <p><a href="{!! Maps::getGoogleMapsUrl($order->delivery_line_1, $order->delivery_line_2, $order->delivery_city, $order->delivery_postcode) !!}" class="btn btn-primary" target="_blank"><i class="fa fa-map-marker"></i> Show on Google Maps</a></p>
                        </div>
                        <div class="col-md-4">
                            <h4>Payment method</h4>
                            @include('includes.payment-method', ['payment' => $order->payment->getFormatted()])
                            @include('includes.status.payment-status', ['status' => $order->payment->status])

                            <h4>Billing address</h4>
                            {{ $order->payment->billing_name }}<br>
                            {{ $order->payment->billing_line_1 }}<br>
                            @if($order->payment->billing_line_2 != ""){{$order->payment->billing_line_2}}<br>@endif
                            {{$order->payment->billing_city}}, {{$order->payment->billing_postcode}}<br>
                        </div>
                    </div>
                    @include('includes.vat-popover', ['vat' => $order->vat, 'grandTotal' => $order->grandTotal])

                    <hr>

                    <h2>Items</h2>
                    @foreach($order->items as $item)
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="cart-product-thumb">
                                            <a href="{!! $item->product->getUrl() !!}"><img
                                                        src="{!! $item->product->cover() !!}"
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

                    <h4>Order summary</h4>
                    @include('includes.order-summary',  ['total' => $order->total, 'shipping' => $order->shipping_fee, 'grandTotal' => $order->grandTotal])
                </div>
            </div>
        </div>
    </div>
@endsection