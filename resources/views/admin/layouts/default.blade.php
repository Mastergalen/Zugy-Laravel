<!DOCTYPE html>
<html>

<head>
    @include('admin.includes.head')
</head>

<body>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                @include('admin.includes.menu')
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                @include('admin.includes.navbar')
            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading animated fadeIn">
            <div class="col-lg-10">
                @yield('breadcrumb')
            </div>
        </div>
        <div class="wrapper wrapper-content">
            @yield('content')
        </div>
        <div class="footer">
            <div>
                <strong>Copyright</strong> {!! config('site.name') !!} &copy; {!! date('Y') !!}
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="/js/admin/plugins/jquery-ui/jquery-ui.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="/js/admin/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/js/admin/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="/js/admin/plugins/flot/jquery.flot.js"></script>
<script src="/js/admin/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/js/admin/plugins/flot/jquery.flot.spline.js"></script>
<script src="/js/admin/plugins/flot/jquery.flot.resize.js"></script>
<script src="/js/admin/plugins/flot/jquery.flot.pie.js"></script>
<script src="/js/admin/plugins/flot/jquery.flot.symbol.js"></script>
<script src="/js/admin/plugins/flot/jquery.flot.time.js"></script>

<!-- Peity -->
<script src="/js/admin/plugins/peity/jquery.peity.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="/js/admin/main.js"></script>
<script src="/js/admin/plugins/pace/pace.min.js"></script>

<!-- EayPIE -->
<script src="/js/admin/plugins/easypiechart/jquery.easypiechart.js"></script>

<!-- Sparkline -->
<script src="/js/admin/plugins/sparkline/jquery.sparkline.min.js"></script>

@yield('scripts')
</body>
</html>
