@extends('emails.layouts.default')

@section('content')
    @parent
    <tr>
        <td class="content-block">
            <h2>Thank you for using {!! config('site.name') !!}.</h2>
        </td>
    </tr>
    <tr>
        <td class="content-block">
            <p>You've successfully placed an order.</p>
            <p>We will email you again when your order is out for delivery or you can track the status of your order by clicking the button below.</p>
        </td>
    </tr>
    <tr>
        <td class="content-block aligncenter">
            <a href="{!! localize_url('routes.order.show', ['id' => $order->id])  !!}" class="btn-primary">Track order</a> <!-- TODO Add tracking order link -->
        </td>
    </tr>
    <tr>
        <td>
            <b>Order number:</b> {!! $order->id !!}<br>
            <b>Order date:</b> {!! $order->order_placed !!}
        </td>
    </tr>
    <tr>
        <td class="content-block">
            <table class="invoice">
                <tr>
                    <td>Here is your receipt.</td>
                </tr>
                <tr>
                    <td>
                        <table class="invoice-items" cellpadding="0" cellspacing="0">
                            <thead>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </thead>
                            @foreach($order->items as $i)
                                <tr>
                                    <td><a href="{!! $i->product->getUrl() !!}">{{$i->product->title}}</a></td>
                                    <td>{!! $i->quantity !!}</td>
                                    <td>{!! $i->price !!}&euro;</td>
                                    <td>{!! $i->final_price !!}&euro;</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>Shipping</td>
                                <td></td>
                                <td></td>
                                <td>{!! $order->shipping_fee !!}&euro;</td>
                            </tr>
                            <tr class="total">
                                <td colspan="3">Total paid</td>
                                <td>{!! $order->total + $order->shipping_fee !!}&euro;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection

@section('markup')
    <div itemscope itemtype="http://schema.org/Order">
        <div itemprop="merchant" itemscope itemtype="http://schema.org/Organization">
            <meta itemprop="name" content="{!! config('site.name') !!}"/>
        </div>
        <meta itemprop="orderNumber" content="{!! $order->id !!}"/>
        <meta itemprop="priceCurrency" content="{!! $order->payment->currency !!}"/>
        <meta itemprop="price" content="29.99"/>

        @foreach($order->items as $i)
        <div itemprop="acceptedOffer" itemscope itemtype="http://schema.org/Offer">
            <div itemprop="itemOffered" itemscope itemtype="http://schema.org/Product">
                <meta itemprop="name" content="{{$i->product->title}}"/>
                <meta itemprop="sku" content="{!! $i->product->id !!}"/>
                <link itemprop="url" href="{!! $i->product->getUrl() !!}"/>
                <link itemprop="image" href="{!! $i->product->images->first()->url !!}"/>
            </div>
            <meta itemprop="price" content="{!! $i->price !!}"/>
            <meta itemprop="priceCurrency" content="{!! $order->payment->currency !!}"/>
            <div itemprop="eligibleQuantity" itemscope itemtype="http://schema.org/QuantitativeValue">
                <meta itemprop="value" content="{!! $i->quantity !!}"/>
            </div>
        </div>
        @endforeach

        <link itemprop="url" href="{!! localize_url('routes.order.show', ['id' => $order->id])  !!}"/>
        <div itemprop="potentialAction" itemscope itemtype="http://schema.org/ViewAction">
            <link itemprop="target" href="{!! localize_url('routes.order.show', ['id' => $order->id])  !!}"/>
        </div>

        @if(in_array($order->order_status, [0, 1]))
            <link itemprop="orderStatus" href="http://schema.org/OrderStatus/OrderProcessing"/>
        @endif
    </div>
@endsection