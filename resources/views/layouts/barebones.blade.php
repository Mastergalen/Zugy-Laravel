<?php
$siteName = Config::get('site.siteName');
?>
<!DOCTYPE html>
<html lang="{!! app()->getLocale() !!}">
    <head>
        @include('includes.head')
    </head>

    <body>
        @yield('body')

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <script src="/dist/js/app.js"></script>

        @yield('scripts')
    </body>
</html>