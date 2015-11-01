@if(Cart::count(false) === 0)
    <div class="mini-cart-product row" id="empty-cart-row" style="text-align: center; padding-bottom: 17px">
        <h2>Nothing in your cart yet <i class="fa fa-frown-o"></i></h2>
    </div>
@endif
<!-- TODO Get cart buttons to work -->

@foreach(Cart::content() as $row)
    <?php $row->product->cover() ?>
    <div class="mini-cart-product row">
        <div class="col-md-offset-3 col-md-6 col-xs-12">
            <div class="row">
                <div class="col-md-2 col-xs-3 mini-cart-product-thumb">
                    <div>
                        <a href="{!! $row->product->getUrl() !!}">
                            <img src="{!! $row->product->cover() !!}" alt="img">
                        </a>
                    </div>
                </div>
                <div class="col-md-5 col-xs-4 miniCartDescription">
                    <h4><a href="{!! $row->product->getUrl() !!}">{{ $row->name }}</a></h4>
                    <span class="size"></span>

                    <div class="price"><span>{{money_format("%i", $row->price)}}&euro;</span></div>
                </div>
                <div class="col-md-1 col-xs-1 miniCartQuantity">x{!! $row->qty !!}</div>
                <div class="col-md-2 col-xs-2 miniCartSubtotal"><span>{{ money_format("%i", $row->subtotal) }}&euro;</span></div>
                <div class="col-md-1 col-xs-1 delete"><a> <i class="fa fa-remove"></i> </a></div>
            </div>
        </div>
    </div>
@endforeach