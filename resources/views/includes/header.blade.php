<div class="navbar navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <button type="button" class="navbar-toggle cart-icon" data-toggle="collapse" data-target=".navbar-cart">
                <i class="fa fa-shopping-cart"></i>
                <span class="cart-respons">Cart (<span class="cart-subtotal">{!! money_format("%i", Cart::total()) !!}</span>&#8364;)</span>
            </button>

            <div class="search-box visible-xs">
                <div class="input-group">
                    <button class="btn btn-nobg getFullSearch" type="button"> <i class="fa fa-search"> </i> </button>
                </div>
            </div>

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
                        @include('includes.mega-dropdown')
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <div class="search-box">
                    <div class="input-group">
                        <button class="btn btn-nobg getFullSearch" type="button"> <i class="fa fa-search"> </i> </button>
                    </div>
                </div>
                <li class="hidden-xs cart-icon">
                    <a href="#" data-toggle="collapse" data-target=".navbar-cart">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="cart-respons">Cart (<span class="cart-subtotal">{!! money_format("%i", Cart::total()) !!}</span>&#8364;)</span>
                        <b class="caret"></b>
                    </a>
                </li>
                @if (!auth()->guest())
                    @if(Auth::user()->group_id === 1) {{-- If in admin goup --}}
                        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    @endif

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="{!! localize_url('routes.account.settings') !!}"><i class="fa fa-user"></i> My account <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{!! localize_url('routes.account.index') !!}"><i class="fa fa-user"></i> Your account</a></li>
                            <li><a href="{!! localize_url('routes.account.settings') !!}"><i class="fa fa-cog"></i> Account settings</a></li>
                            <li><a href="/auth/logout"><i class="fa fa-sign-out"></i> Sign out</a></li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{!! route('login') !!}"><i class="fa fa-sign-in"></i> Sign in</a>
                    </li>
                @endif
            </ul>
        </nav><!--/.nav-collapse -->
        <!--Navbar cart-->
        <div class="navbar-cart collapse" collapse="cartCollapsed">
            <div class="mega-dropdown ">
                @include('includes._mini-cart')
            </div>
        </div>

    </div>

    <div id="search-full" class="text-right">
        <a class="pull-right search-close" id="search-close"> <i class=" fa fa-times-circle"> </i> </a>
        <div class="search-input-box pull-right">
            <form id="search-form" method="GET" action="#">
                <input type="search" data-search-url="{!! localize_url('routes.search', ['query' => '']) !!}" name="q" placeholder="start typing and search" class="search-input">
                <button class="btn-nobg search-btn" type="submit"> <i class="fa fa-search"> </i> </button>
            </form>
        </div>
    </div>
</div><!--/Navigation Bar-->

<div class="container">
    <noscript><div class="alert" id="javascriptWarning">You need to enable Javascript in order to properly experience the site.</div></noscript>
</div>