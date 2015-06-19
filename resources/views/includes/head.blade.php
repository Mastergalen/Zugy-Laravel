<meta name="description" content="@yield('meta_description')">

@if (isset($noindex))
  <meta name="robots" content="noindex" />
@endif

<meta charset="utf-8">
<title>@yield('title') - {{{$siteName}}}</title>
<meta name="_token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link href="/css/stylesheet.min.css" rel="stylesheet">

<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<link rel="shortcut icon" href="/favicon.ico">