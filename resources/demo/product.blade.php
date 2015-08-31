@section('title', 'Zugy - Alcohol Delivery on-demand for Milan')

@extends('layouts.default')

@section('content')
    <link rel="stylesheet" href="/css/smoothproducts.css">

    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.theme.css">

    <ul class="breadcrumb">
        <li> <a href="/">Home</a> </li>
        <li> <a href="/shop">Shop</a> </li>
        <li> <a href="#">Vodka</a> </li>
        <li class="active">Smirnoff Vodka </li>
    </ul>
    <div class="row">
        <div class="col-md-6">
            <div class="gallery sp-wrap">
                <a href="http://www.lcbo.com/content/dam/lcbo/products/038505.jpg/jcr:content/renditions/cq5dam.web.1280.1280.jpeg">
                    <img src="http://www.lcbo.com/content/dam/lcbo/products/038505.jpg/jcr:content/renditions/cq5dam.web.1280.1280.jpeg" alt=""/>
                </a>
                <a href="http://i.imgur.com/nh4bSIh.jpg">
                    <img src="http://i.imgur.com/nh4bSIh.jpg" alt=""/>
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <h1>Smirnoff Vodka</h1>
            <div class="product-price">
                <span class="price-sales">16.00&#8364;</span>
                <span class="price-standard">23.00&#8364;</span>
            </div>
            <div class="product-description">
                <p><b>Smirnoff</b> is made from the finest grains with a triple distillation and proprietary filtration process that has made Smirnoff the world’s number-one premium vodka brand. From everyday drinks to a celebratory toast, Smirnoff vodka is the perfect base to any easy, hassle free cocktail.</p>
            </div>
            <hr/>
            <select name="quantity" class="form-control" placeholder="Quantity">
                <option value="null">Quantity</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
            <hr/>
            <button class="btn btn-success btn-lg" type="button"><i class="fa fa-cart-plus"></i> Add to cart</button>
            <div class="stock">
                <i class="fa fa fa-check-circle-o" style="color: #4CC94A;"></i> In Stock <small>Deliver within an hour</small>
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
                        <tr>
                            <td>Item weight</td>
                            <td>1.1kg</td>
                        </tr>
                        <tr>
                            <td>Volume</td>
                            <td>0.70 litres</td>
                        </tr>
                        <tr>
                            <td>Alchol content</td>
                            <td>37.50 % Vol</td>
                        </tr>
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