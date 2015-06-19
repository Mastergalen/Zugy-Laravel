<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
            <img src="/img/NeuroResponse-icon.png" style="display:inline; height:35px; float: left; margin: 6px 3px 0 0"><a href="/" class="navbar-brand" >NeuroResponse</a>
        </div>

        <!--Menu Items-->
        <nav class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                @foreach ($navbar as $n)
                    <li><a href="{!! $n[0] !!}">{!! $n[1] !!}</a></li>
                @endforeach
            </ul>
            <ul class="nav navbar-nav pull-right">
                @if (Auth::check())
                    @if(Auth::user()->group_id == 1) {{-- If in admin goup --}}
                        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    @else
                        <li><a href="{!! route('dashboard') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    @endif
                    
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user"></i> {{ Auth::user()->first_name }}<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/account/settings"><i class="fa fa-cog"></i> Account settings</a></li>
                            <li><a href="/auth/logout"><i class="fa fa-sign-out"></i> Sign out</a></li>
                        </ul>
                    </li>
                @else
                    <li>
                        <div class="btn-group navbar-btn">
                            <a href="/auth/login" class="btn btn-default"><i class="fa fa-sign-in"></i> Sign in</a>
                            <a href="/auth/register" class="btn btn-primary"><i class="fa fa-user-plus"></i> Register</a>
                        </div>
                    </li>
                @endif
            </ul>
        </nav><!--/.nav-collapse -->
    </div>
</div><!--/Navigation Bar-->

<div class="container">
    <noscript><div class="alert" id="javascriptWarning">You need to enable Javascript in order to properly experience the site.</div></noscript>
</div>