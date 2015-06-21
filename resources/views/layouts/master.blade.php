<?php
$siteName = Config::get('site.siteName');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.head')
    </head>

    <body>
        @include('includes.header')
        
        @yield('content')

        <footer>@include('includes.footer')</footer>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <script src="js/main.js"></script>
        
        @yield('scripts')
    </body>
</html>