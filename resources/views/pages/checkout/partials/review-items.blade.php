@foreach(Cart::content() as $row)
    <div class="panel panel-default" data-product-id="{{$row->id}}" data-row-id="{{$row->rowid}}">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-3">
                    <div class="cart-product-thumb">
                        <a href="{!! $row->product->getUrl() !!}"><img
                                    src="{!! $row->product->images()->first()->url !!}"
                                    alt="{{ $row->name }}"></a>
                    </div>
                </div>
                <div class="col-xs-9">
                    <div class="cart-description">
                        <h4><a href="{!! $row->product->getUrl() !!}">{{ $row->name }}</a></h4>

                        <div class="price">{{ money_format("%i", $row->price) }}&euro;</div>

                        <p><b>Quantity: </b>{!! $row->qty !!}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endforeach