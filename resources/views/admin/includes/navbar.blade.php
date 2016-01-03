<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
</a>

<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">

        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="http://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?s=25" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="http://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?s=90" class="img-circle" alt="User Image">
                    <p>{{ Auth::user()->name }}</p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div style="text-align: center">
                        <a href="{{ route('logout')  }}" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</div>