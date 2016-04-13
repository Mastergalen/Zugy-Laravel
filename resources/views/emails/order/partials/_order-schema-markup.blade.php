@section('markup')
    <!--TODO Update schema based on order status -->
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
                    <link itemprop="image" href="{!! $i->product->thumbnail_url !!}"/>
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