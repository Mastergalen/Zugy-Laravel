<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
</a>

<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
                <li class="header">You have 4 notifications</li>
                <li>
                    <!-- inner menu: contains the actual data -->
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                            <li><!-- start message -->
                                <a href="#">
                                    <div class="pull-left">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <h4>
                                        Support Team
                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                    </h4>
                                    <p>A new order was placed?</p>
                                </a>
                            </li><!-- end message -->
                        </ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
                </li>
                <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
        </li>

        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="http://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?s=25" class="user-image" alt="User Image">
                <span class="hidden-xs">{{{ Auth::user()->name }}}</span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="http://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?s=90" class="img-circle" alt="User Image">
                    <p>{{{ Auth::user()->name }}}</p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div style="text-align: center">
                        <a href="{{{ route('logout')  }}}" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</div>