<div class="navbar navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-cart">
                <i class="fa fa-shopping-cart"></i>
                <span class="cart-respons">Cart (24.39&#8364;)</span>
            </button>

            <a href="/">
                <img src="/img/zugy-navbar-logo.png"
                             style="display:inline; height:35px; float: left; margin: 8px 3px 0 0">
            </a>
        </div>


        <nav class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
                <li class="dropdown mega-dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Shop<b class="caret"></b></a>

                    <ul class="dropdown-menu mega-dropdown-menu row" role="menu">
                        <li class="col-md-2">
                            <ul>
                                <li class="dropdown-header">Alholic Beverages</li>
                                <li><a href="#">Vodka</a></li>
                                <li><a href="#">Beers & Ciders</a></li>
                                <li><a href="#">Wine</a></li>
                                <li><a href="#">Whisky</a></li>
                                <li><a href="#">Spirits</a></li>
                                <li><a href="#">Champagne & Prosecco</a></li>
                            </ul>
                        </li>
                        <li class="col-md-2">
                            <ul>
                                <li class="dropdown-header">Mixers</li>
                                <li><a href="#">Juice</a></li>
                                <li><a href="#">Soda</a></li>
                                <hr/>
                                <li class="dropdown-header">Accessories</li>
                                <li><a href="#">Ice</a></li>
                                <li><a href="#">Cups</a></li>
                            </ul>
                        </li>
                        <li class="col-md-2">
                            <ul>
                                <li class="dropdown-header">Deals and Packs</li>
                                <li><a href="#">Deal Packs</a></li>
                                <li><a href="#">Selected spirits 20% off</a></li>
                            </ul>
                        </li>
                        <li class="col-md-6">
                            <img src="http://placehold.it/350x150" alt=""/>
                        </li>
                    </ul>
                </ul>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="hidden-xs">
                    <a href="#" data-toggle="collapse" data-target=".navbar-cart">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="cart-respons">Cart (24.39&#8364;)</span>
                        <b class="caret"></b>
                    </a>
                </li>
                @if (Auth::check())
                    @if(Auth::user()->group_id === 1) {{-- If in admin goup --}}
                        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    @endif

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="{!! route('your-account') !!}"><i class="fa fa-user"></i> My account <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/your-account/settings"><i class="fa fa-cog"></i> Account settings</a></li>
                            <li><a href="/auth/logout"><i class="fa fa-sign-out"></i> Sign out</a></li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{!! route('your-account') !!}"><i class="fa fa-user"></i> My account</a>
                    </li>
                @endif
            </ul>
        </nav><!--/.nav-collapse -->

        <!--Navbar cart-->
        <div class="navbar-cart collapse" collapse="cartCollapsed">
            <div class="mega-dropdown ">
                <div class="mega-dropdown-menu mini-cart">
                    <div class="mini-cart-product row">
                        <div class="col-md-offset-3 col-md-6 col-xs-12">
                            <div class="row">
                                <div class="col-md-2 col-xs-3 mini-cart-product-thumb">
                                    <div><a href="/product"> <img
                                                    src="http://www.lcbo.com/content/dam/lcbo/products/038505.jpg/jcr:content/renditions/cq5dam.web.1280.1280.jpeg"
                                                    alt="img"> </a></div>
                                </div>
                                <div class="col-md-5 col-xs-4 miniCartDescription">
                                    <h4><a href="/product"> Smirnoff Vodka </a></h4>
                                    <span class="size"> 1.5 L </span>

                                    <div class="price"><span> 12.00&#8364; </span></div>
                                </div>
                                <div class="col-md-1 col-xs-1 miniCartQuantity">x2</div>
                                <div class="col-md-2 col-xs-2 miniCartSubtotal"><span> 24.00&#8364 </span></div>
                                <div class="col-md-1 col-xs-1 delete"><a> <i class="fa fa-remove"></i> </a></div>
                            </div>
                        </div>
                    </div>
                    <div class="mini-cart-product row">
                        <div class="col-md-offset-3 col-md-6 col-xs-12">
                            <div class="row">
                                <div class="col-md-2 col-xs-3 mini-cart-product-thumb">
                                    <div><a href="/product"> <img
                                                    src="http://randolphpackage.com/images/Captain-Morgan%20.jpg"
                                                    alt="img"> </a></div>
                                </div>
                                <div class="col-md-5 col-xs-4 miniCartDescription">
                                    <h4><a href="/product"> Captain Morgan </a></h4>
                                    <span class="size"> Spiced Rum 1.0 L </span>

                                    <div class="price"><span> 12.39&#8364; </span></div>
                                </div>
                                <div class="col-md-1 col-xs-1 miniCartQuantity">x1</div>
                                <div class="col-md-2 col-xs-2 miniCartSubtotal"><span> 12.39&#8364 </span></div>
                                <div class="col-md-1 col-xs-1 delete"><a> <i class="fa fa-remove"></i> </a></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mini-cart-footer" style="text-align: center">
                        <div class="mini-cart-footer">
                            <h3 class="subtotal"> Subtotal: 24.39&#8364; </h3>
                            <a class="btn btn-sm btn-danger"> <i class="fa fa-shopping-cart"> </i> VIEW CART
                            </a>
                            <a class="btn btn-sm btn-primary"> CHECKOUT </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div><!--/Navigation Bar-->

<div class="container">
    <noscript><div class="alert" id="javascriptWarning">You need to enable Javascript in order to properly experience the site.</div></noscript>
</div>