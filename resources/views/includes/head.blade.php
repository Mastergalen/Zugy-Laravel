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
<link href="/css/styles.css" rel="stylesheet">

<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat%3A400&#038;subset=latin&#038;ver=1429234940' type='text/css' media='all' />

<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<link rel="shortcut icon" href="/favicon.ico">