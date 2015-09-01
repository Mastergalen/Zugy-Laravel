@section('title', $product->description[0]->title)
@section('meta_description', $product->description[0]->title)

@extends('layouts.default')

@section('content')
    <link rel="stylesheet" href="/css/smoothproducts.css">

    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.theme.css">

    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><a href="/shop">Shop</a></li>
        @foreach($product->breadcrumbs as $b)
            <li><a href="#">{{ collect($b['description'])->where('language_id', $language_id)->first()['name']}}</a></li>
        @endforeach
        <li class="active">{!! $product->description[0]->title !!}</li>
    </ul>
    <div class="row">
        <div class="col-md-6">
            <div class="gallery sp-wrap">
                @foreach($product->images as $image)
                    <a href="{!! $image->url !!}">
                        <img src="{!! $image->url !!}" alt="{!! $product->description[0]->title !!} image">
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <h1>{{$product->description[0]->title}}</h1>
            <div class="product-price">
                <span class="price-sales">{{$product->price}}&#8364;</span>
                @if(isset($product->compare_price))
                    <span class="price-standard">{{$product->compare_price}}&#8364;</span>
                @endif
            </div>
            <div class="product-description">
                {!! $product->description[0]->description !!}
            </div>
            <hr/>
            @if($product->stock_quantity > 0)
                <select name="quantity" class="form-control" placeholder="Quantity">
                    <option value="null">Quantity</option>
                    <?php $i = 1 ?>
                    @while($i <= 9 && $i <= $product->stock_quantity)
                        <option value="{!! $i !!}">{!! $i !!}</option>
                        <?php $i++ ?>
                    @endwhile
                </select>
                <hr/>
                <button class="btn btn-success btn-lg" type="button"><i class="fa fa-cart-plus"></i> Add to cart</button>
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
    <script type="text/javascript">
        /* wait for images to load */
        $(window).load( function() {
            $('.sp-wrap').smoothproducts();

            $(".products").owlCarousel();
        });
    </script>
@endsection