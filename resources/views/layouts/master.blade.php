<?php
$navbar = array(
    array("/", "<i class='fa fa-home'></i> Home"),
    array("https://www.uclh.nhs.uk/OurServices/ServiceA-Z/Neuro/MS/NeuroResponse/Pages/Home.aspx", "<i class='fa fa-book'></i> About us")
);

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
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

        {{--{!! HTML::script('js/main.js') !!}--}}
        
        @yield('scripts')
    </body>
</html>