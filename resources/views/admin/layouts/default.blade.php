<!DOCTYPE html>
<html>

<head>
    @include('admin.includes.head')
</head>

<body class="skin-blue sidebar-mini">

<div class="wrapper">
    <header class="main-header">
        <a href="/admin" class="logo">
            <span class="logo-mini">Z</span>
            <span class="logo-lg">{{ Config::get('site.name') }}</span>
        </a>

        <nav class="navbar navbar-static-top" role="navigation">
            @include('admin.includes.navbar')
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                @include('admin.includes.menu')
            </ul>
            <!-- /.sidebar-menu -->
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            @yield('header')
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fa fa-home"></i>Home</a>
                </li>
                @yield('breadcrumb')
            </ol>
        </section>
        <section class="content">
            @yield('content')
        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            Site created by Galen Han
        </div>
        <strong>Copyright</strong> {!! config('site.name') !!} &copy; {!! date('Y') !!}
    </footer>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="/js/admin/app.js"></script>

@yield('scripts')
</body>
</html>
