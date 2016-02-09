<?php
$siteName = Config::get('site.siteName');
?>
<!DOCTYPE html>
<html lang="{!! app()->getLocale() !!}">
    <head>
        @include('includes.head')
    </head>

    <body>
        @if(app()->environment() == 'production')
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-72027202-1', 'auto');
                ga('send', 'pageview');
            </script>
        @endif
        @yield('body')

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <script src="/dist/js/app.js"></script>

        @yield('scripts')
    </body>
</html>