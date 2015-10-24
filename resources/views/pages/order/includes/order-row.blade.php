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