<meta name="description" content="@yield('meta_description')">

@if (isset($noindex))
  <meta name="robots" content="noindex" />
@endif

<meta charset="utf-8">
<title>@yield('title') - {!! config('site.name') !!}</title>
<meta name="_token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link href="/dist/assets/css/app.css" rel="stylesheet">

<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat%3A400&#038;subset=latin&#038;ver=1429234940' type='text/css' media='all' />

<link rel="apple-touch-icon" sizes="57x57" href="/assets/icons/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/assets/icons/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/assets/icons/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/assets/icons/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/assets/icons/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/assets/icons/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/assets/icons/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/assets/icons/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="/assets/icons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/assets/icons/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="/assets/icons/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/assets/icons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/assets/icons/manifest.json">
<link rel="shortcut icon" href="/assets/icons/favicon.ico">
<meta name="msapplication-TileColor" content="#2d89ef">
<meta name="msapplication-TileImage" content="/assets/icons/mstile-144x144.png">
<meta name="msapplication-config" content="/assets/icons/browserconfig.xml">
<meta name="theme-color" content="#ffffff">

<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Begin Cookie Consent plugin -->
<script type="text/javascript">
  window.cookieconsent_options = {"message":"This website uses cookies to ensure you get the best experience on our website","dismiss":"Got it!","learnMore":"More info","link":"{!! localize_url('routes.privacy-policy') !!}","theme":"dark-bottom"};
</script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>
<!-- End Cookie Consent plugin -->


<link href="//cloud.github.com/downloads/lafeber/world-flags-sprite/flags32.css" rel="stylesheet" />

@yield('css')