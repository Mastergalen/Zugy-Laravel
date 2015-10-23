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
        <li><a href="/">Home</a></li>
        <li><a href="/shop">Shop</a></li>
        @foreach($product->breadcrumbs as $b)
            <li><a href="{!! localize_url('routes.shop.category', ['slug' => $b['slug']]) !!}">{{ $b['name'] }}</a></li>
        @endforeach
        <li class="active">{!! $product->title !!}</li>
    </ul>
    <div class="row">
        <div class="col-md-6">
            <div class="gallery sp-wrap">
                @forelse($product->images as $image)
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
                @if(isset($product->compare_price))
                    <span class="price-standard">{{$product->compare_price}}&#8364;</span>
                @endif
            </div>
            <div class="product-description">
                {!! $product->description !!}
            </div>
            <hr/>
            @if($product->stock_quantity > 0)
                <h3>Select quantity</h3>
                <fieldset id="quantity-selector"
                          data-product-id="{!! $product->id !!}"
                          data-product-name="{{$product->title}}"
                          data-price="{{$product->price}}"
                          data-thumbnail="{{$product->cover()}}"
                          data-url="{{$product->getUrl()}}"
                        >
                    <div class="form-group">
                        <span class="help-block" style="display: none;">Please select how many you want!</span>
                        <?php $i = 1 ?>
                        @while($i <= 9 && $i <= $product->stock_quantity)
                            <input type="radio" name="quantity" value="{!! $i !!}" id="number-{!! $i !!}">
                            <label for="number-{!! $i !!}">{!! $i !!}</label>
                            <?php $i++ ?>
                        @endwhile
                    </div>
                </fieldset>
                <button class="btn btn-success btn-lg" type="button" id="btn-add-cart"><i class="fa fa-cart-plus"></i> Add to cart</button>
            @endif
            <div class="stock">
                @if($product->stock_quantity >= 5)
                    <i class="fa fa fa-check-circle-o" style="color: #4CC94A;"></i> In Stock <small>Delivery within an hour</small>
                @elseif($product->stock_quantity > 0)
                    <i class="fa fa fa-check-circle-o" style="color: #4CC94A;"></i> In Stock <small>(only {{$product->stock_quantity}} left) Delivery within an hour</small>
                @else
                    <div class="alert alert-danger">
                        <i class="fa fa fa-times-circle"></i> Out of stock
                    </div>
                @endif
            </div>

            <hr/>

            <ul class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a href="#details" data-toggle="tab">Details</a>
                </li>
                <li><a href="#shipping" data-toggle="tab">Shipping</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="details">
                    <table class="table table-bordered table-striped">
                        @if($product->weight != 0)
                            <tr>
                                <td>Item weight</td>
                                <td>{{$product->weight}} kg</td>
                            </tr>
                        @endif
                        @foreach($product->attributes as $a)
                            <tr>
                                <td>{{ $a->description[0]->name }}</td>
                                <td>{{ $a->pivot->value }} {{ $a->description[0]->unit }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="tab-pane" id="shipping">
                    <table class="table table-bordered">
                        <thead>
                        <th>Shipping method</th>
                        <th>Shipping time</th>
                        <th>Cost</th>
                        </thead>
                        <tr>
                            <td>Standard</td>
                            <td>24 hours</td>
                            <td>9.50&#8364;</td>
                        </tr>
                        <tr>
                            <td>Express</td>
                            <td>1 hour</td>
                            <td>15.90&#8364;</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row recommendations">
        <h2>You may also like</h2>
        <div class="products owl-carousel">
            <div class="item">
                <a class="image" href="#">
                    <img src="http://www.lcbo.com/content/dam/lcbo/products/110056.jpg/jcr:content/renditions/cq5dam.web.1280.1280.jpeg" alt=""/>
                </a>
                <div class="description">
                    <a href="#"><h4>Absolut Vodka</h4></a>
                    <span class="price">14.20&#8364;</span>
                </div>
            </div>

            <div class="item">
                <a class="image" href="#">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/df/W%C3%B3dka_Wyborowa.jpg" alt=""/>
                </a>
                <div class="description">
                    <a href="#"><h4>Wyborowa</h4></a>
                    <span class="price">10.00&#8364;</span>
                </div>
            </div>

            <div class="item">
                <a class="image" href="#">
                    <img src="http://distinctdrinks.co.uk/wp-content/uploads/2015/02/eristoffvodka.jpg" alt=""/>
                </a>
                <div class="description">
                    <a href="#"><h4>Eristoff</h4></a>
                    <span class="price">12.20&#8364;</span>
                </div>
            </div>

            <div class="item">
                <a class="image" href="#">
                    <img src="http://www.lcbo.com/content/dam/lcbo/products/110056.jpg/jcr:content/renditions/cq5dam.web.1280.1280.jpeg" alt=""/>
                </a>
                <div class="description">
                    <a href="#"><h4>Absolut Vodka</h4></a>
                    <span class="price">14.20&#8364;</span>
                </div>
            </div>

            <div class="item">
                <a class="image" href="#">
                    <img src="http://www.lcbo.com/content/dam/lcbo/products/110056.jpg/jcr:content/renditions/cq5dam.web.1280.1280.jpeg" alt=""/>
                </a>
                <div class="description">
                    <a href="#"><h4>Absolut Vodka</h4></a>
                    <span class="price">14.20&#8364;</span>
                </div>
            </div>

            <div class="item">
                <a class="image" href="#">
                    <img src="http://www.lcbo.com/content/dam/lcbo/products/110056.jpg/jcr:content/renditions/cq5dam.web.1280.1280.jpeg" alt=""/>
                </a>
                <div class="description">
                    <a href="#"><h4>Absolut Vodka</h4></a>
                    <span class="price">14.20&#8364;</span>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
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
                    return;
                }

                var item = {
                    'id': $quantitySelector.data('product-id'),
                    name: $quantitySelector.data('product-name'),
                    'quantity': quantity,
                    price: $quantitySelector.data('price'),
                    thumbnail: $quantitySelector.data('thumbnail'),
                    url: $quantitySelector.data('url')
                }

                hideErrors();

                var $cart = $('.navbar .cart-icon:visible').eq(0);
                var $imgToDrag = $('.gallery .sp-large a img').eq(0);

                if($imgToDrag) {
                    var $imgClone = $imgToDrag.clone().offset({
                        top: $(this).offset().top,
                        left: $(this).offset().left
                    }).css({
                        'opacity': '0.5',
                        'position': 'absolute',
                        'height': '150px',
                        'width': '150px',
                        'z-index': '100'
                    }).appendTo($('body')).animate({
                        'top': $cart.offset().top + 10,
                        'left': $cart.offset().left + 10,
                        'width': 75,
                        'height': 75
                    }, 1000, 'easeInOutExpo');

                    $imgClone.animate({
                        'width': 0,
                        'height': 0
                    }, function () {
                        $(this).detach()
                    });
                }

                //TODO Update cart in navbar price after success
                //TODO Prevent adding more than in stock and show error message
                $.ajax({
                    type: 'POST',
                    url: '{!! action('API\CartController@store') !!}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    data: {
                        'name': item.name,
                        'id': item.id,
                        'qty': item.quantity
                    },
                    success: function() {
                        cart.add(item.url, item.thumbnail, item.name, item.price, item.quantity);
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.message);
                    }
                });

                $button.prop('disabled', false);
            });
        });

        function hideErrors() {
            $('#quantity-selector .form-group').removeClass('has-error').end().find('.help-block').hide();
        }
    </script>
@endsection