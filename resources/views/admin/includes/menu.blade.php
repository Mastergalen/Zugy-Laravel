<li class="nav-header">
    <div class="dropdown profile-element">
        <span>
            <img alt="image" class="img-circle" src="http://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?s=48"/>
        </span>
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <span class="clear">
                <span class="block m-t-xs">
                    <strong class="font-bold">{{ auth()->user()->name }} <b class="caret"></b></strong>
                </span>
            </span>
        </a>
        <ul class="dropdown-menu animated fadeInRight m-t-xs">
            <li><a href="/auth/logout"><i class="fa fa-sign-out"></i> Sign out</a></li>
        </ul>
    </div>
    <div class="logo-element">
        <a href="/admin">Z</a>
    </div>
</li>
<li>
    <a href="/admin">
        <i class="fa fa-dashboard"></i>
        <span class="nav-label">Dashboard</span>
    </a>
</li>
<li>
    <a href="/admin/orders">
        <i class="fa fa-file-text"></i>
        <span class="nav-label">Orders</span>
        <span class="label label-warning pull-right">3</span>
    </a>
</li>
<li>
    <a href="/admin/catalogue"><i class="fa fa-book"></i> <span class="nav-label">Catalogue</span> </a>
</li>
<li>
    <a href="/admin/customers"><i class="fa fa-users"></i> <span class="nav-label">Customers</span> </a>
</li>

<li>
    <a href="#">
        <i class="fa fa-cog"></i>
        <span class="nav-label">Settings</span>
        <span class="fa arrow"></span>
    </a>
    <ul class="nav nav second collapse">
        <li><a href="/admin/settings/tax">Tax</a></li>
    </ul>
</li>