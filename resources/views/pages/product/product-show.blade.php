@section('title', $product->title)
@section('meta_description', $product->meta_description)

@extends('layouts.default')

@section('css')
    <style>
        #quantity-selector {
            display: inline-block;
        }

        #quantity-selector input[type=radio] {
            position: absolute;
            z-index: -1;
        }

        #quantity-selector input:checked+label {
            background-color: #ff931e;
            border-color: #c76a06;
            color: white;
        }

        #quantity-selector label {
            display: inline-block;
            min-height: 40px;
            min-width: 40px;
            text-align: center;
            line-height: 40px;
            margin-right: 6px;
            font-size: 1.3125em;
            cursor: pointer;
            border: 1px solid #cdcdcd;
            background-color: #e8e8e8;
            border-radius: 1px;
            color: #282d33;
        }

        #quantity-selector .form-group.has-error label {
            border: 1px solid #BF4949;
        }

        #btn-add-cart {
            font-size: 16px;
        }
    </style>
@endsection

@section('content')
    <ul class="breadcrumb hidden-xs">
        <li><a href="/">{!! trans('pages.home.title') !!}</a></li>
        <li><a href="/shop">{!! trans('pages.shop.title') !!}</a></li>
        @foreach($product->breadcrumbs as $b)
            <li><a href="{!! localize_url('routes.shop.category', ['slug' => $b['slug']]) !!}">{{ $b['name'] }}</a></li>
        @endforeach
        <li class="active">{!! $product->title !!}</li>
    </ul>
    <div class="row">
        <div class="col-md-6">
            <div class="gallery sp-wrap">
                @if($thumbnail)
                    <a href="{!! $thumbnail->url !!}">
                        <img src="{!! $thumbnail->url !!}" alt="{!! $product->title !!} image">
                    </a>
                @endif
                @forelse($product->images as $image)
                    <?php if($image->id == $product->thumbnail_id) continue; ?>
                    <a href="{!! $image->url !!}">
                        <img src="{!! $image->url !!}" alt="{!! $product->title !!} image">
                    </a>
                @empty
                    <a href="/img/zugy-placeholder-image.png">
                        <img src="/img/zugy-placeholder-image.png" alt="Zugy Placeholder image">
                    </a>
                @endforelse
            </div>
        </div>
        <div class="col-md-6">
            <h1>{{$product->title}}</h1>
            <div class="product-price">
                <span class="price-sales">{{$product->price}}&#8364;</span>
                @if(isset($product->compare_price) && $product->compare_price != 0)
                    <span class="price-standard">{{$product->compare_price}}&#8364;</span>
                @endif
            </div>
            <div class="product-description">
                {!! $product->description !!}
            </div>
            <hr/>
            @if($product->stock_quantity > 0)
                <h3>{!! trans('forms.prompts.select-quantity') !!}</h3>
                <fieldset id="quantity-selector"
                          data-product-id="{!! $product->id !!}"
                          data-price="{{$product->price}}"
                          data-thumbnail="{{$product->cover()}}"
                          data-url="{{$product->getUrl()}}"
                        >
                    <div class="form-group">
                        <span class="help-block" style="display: none;">{!! trans('forms.prompts.select-how-many') !!}</span>
                        <?php $i = 1 ?>
                        @while($i <= 9 && $i <= $product->stock_quantity)
                            <input type="radio" name="quantity" value="{!! $i !!}" id="number-{!! $i !!}">
                            <label for="number-{!! $i !!}">{!! $i !!}</label>
                            <?php $i++ ?>
                        @endwhile
                    </div>
                </fieldset>
                <button class="btn btn-success btn-lg" type="button" id="btn-add-cart"><i class="fa fa-cart-plus"></i> {!! trans('buttons.add-cart') !!}</button>
            @endif
            <div class="stock">
                @if($product->stock_quantity >= 10)
                    <i class="fa fa fa-check-circle-o" style="color: #4CC94A;"></i> {!! trans('product.in-stock') !!} <small>{!! trans('shipping.hour-delivery') !!}</small>
                @elseif($product->stock_quantity > 0)
                    <div class="alert alert-warning">
                        {!! trans('product.stock-warning', ['count' => $product->stock_quantity]) !!}
                    </div>
                    <i class="fa fa fa-check-circle-o" style="color: #4CC94A;"></i> {!! trans('product.in-stock') !!} <small>{!! trans('shipping.hour-delivery') !!}</small>
                @else
                    <div class="alert alert-danger">
                        <i class="fa fa fa-times-circle"></i> {!! trans('product.out-of-stock') !!}
                    </div>
                @endif
            </div>

            <hr/>

            <ul class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a href="#details" data-toggle="tab">{!! trans('product.tabs.details') !!}</a>
                </li>
                <li><a href="#shipping" data-toggle="tab">{!! trans('checkout.shipping') !!}</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="details">
                    <table class="table table-bordered table-striped">
                        @if($product->weight != 0)
                            <tr>
                                <td>{!! trans('product.item-weight') !!}</td>
                                <td>{{$product->weight}} kg</td>
                            </tr>
                        @endif
                        @foreach($product->attributes as $a)
                            <tr>
                                <td>{{ $a->name }}</td>
                                <td>{{ $a->pivot->value }} {{ $a->unit }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="tab-pane" id="shipping">
                    <table class="table table-bordered">
                        <thead>
                        <th>{!! trans('shipping.shipping-method') !!}</th>
                        <th>{!! trans('shipping.time') !!}</th>
                        <th>{!! trans('shipping.cost') !!}</th>
                        </thead>
                        <tr>
                            <td>{!! trans('shipping.standard') !!}</td>
                            <td>{!! trans_choice('shipping.hour', 1) !!}</td>
                            <td>{!! trans('shipping.free-shipping') !!}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr/>

    {{-- @include('pages.product.partials.recommendations') --}} <!--TODO Add product recommendations -->
@stop

@section('scripts')
    @if(auth()->guest() && !is_bot() )
        @include('includes._postcode-check')
    @endif
    <script src="/js/smoothproducts.min.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(window).load( function() {
            $('.sp-wrap').smoothproducts();

            $(".products").owlCarousel();

            $('#btn-add-cart').click(function() {
                var $button = $(this);
                $button.prop('disabled', true);

                var $quantitySelector = $('#quantity-selector');
                var quantity = $quantitySelector.find('input[name="quantity"]:checked').val();

                if(typeof quantity === 'undefined') {
                    $quantitySelector.find('.form-group').addClass('has-error').end().find('.help-block').show();
                    $button.prop('disabled', false);
                    return;
                }

                hideErrors();

                var $imgToDrag = $('.gallery .sp-large a img').eq(0);

                cart.addToCartAnimation($imgToDrag);

                cart.add($quantitySelector.data('product-id'), quantity);

                $button.prop('disabled', false);
            });
        });

        function hideErrors() {
            $('#quantity-selector .form-group').removeClass('has-error').end().find('.help-block').hide();
        }
    </script>
@endsection