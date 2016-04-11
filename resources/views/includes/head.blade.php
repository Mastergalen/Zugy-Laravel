<meta name="description" content="@yield('meta_description')">

@if (isset($noindex))
    <meta name="robots" content="noindex" />
@endif

<meta charset="utf-8">
<title>@yield('title') - {!! config('site.name') !!}</title>
<meta name="_token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

@if(app()->getLocale() == 'en')
    <meta name="og:locale" content="en_GB">
@elseif(app()->getLocale() == 'it')
    <meta name="og:locale" content="it_IT">
@else
    <?php throw new Dimsav\Translatable\Exception\LocalesNotDefinedException; ?>
@endif

@if(isset($translations))
    @foreach($translations as $localeCode => $url)
        @if($localeCode == app()->getLocale()) <?php continue; ?> @endif
        <link rel="alternate" hreflang="{{ $localeCode }}" href="{{ $url }}" />
    @endforeach
@else
    @foreach(Localization::getSupportedLocales() as $localeCode => $properties)
        @if($localeCode == app()->getLocale()) <?php continue; ?> @endif
        <link rel="alternate" hreflang="{{ $localeCode }}" href="{{ Localization::getLocalizedURL($localeCode) }}" />
    @endforeach
@endif

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link href="{{ elixir('dist/assets/css/app.css') }}" rel="stylesheet">

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

@if(app()->environment() == 'production')
    <script>
        var _rollbarConfig = {
            accessToken: "{!! env('ROLLBAR_POST_CLIENT_ITEM') !!}",
            captureUncaught: true,
            payload: {
                environment: "production"
            }
        };
        // Rollbar Snippet
        !function(r){function o(e){if(t[e])return t[e].exports;var n=t[e]={exports:{},id:e,loaded:!1};return r[e].call(n.exports,n,n.exports,o),n.loaded=!0,n.exports}var t={};return o.m=r,o.c=t,o.p="",o(0)}([function(r,o,t){"use strict";var e=t(1).Rollbar,n=t(2);_rollbarConfig.rollbarJsUrl=_rollbarConfig.rollbarJsUrl||"https://d37gvrvc0wt4s1.cloudfront.net/js/v1.8/rollbar.min.js";var a=e.init(window,_rollbarConfig),i=n(a,_rollbarConfig);a.loadFull(window,document,!_rollbarConfig.async,_rollbarConfig,i)},function(r,o){"use strict";function t(r){return function(){try{return r.apply(this,arguments)}catch(o){try{console.error("[Rollbar]: Internal error",o)}catch(t){}}}}function e(r,o,t){window._rollbarWrappedError&&(t[4]||(t[4]=window._rollbarWrappedError),t[5]||(t[5]=window._rollbarWrappedError._rollbarContext),window._rollbarWrappedError=null),r.uncaughtError.apply(r,t),o&&o.apply(window,t)}function n(r){var o=function(){var o=Array.prototype.slice.call(arguments,0);e(r,r._rollbarOldOnError,o)};return o.belongsToShim=!0,o}function a(r){this.shimId=++s,this.notifier=null,this.parentShim=r,this._rollbarOldOnError=null}function i(r){var o=a;return t(function(){if(this.notifier)return this.notifier[r].apply(this.notifier,arguments);var t=this,e="scope"===r;e&&(t=new o(this));var n=Array.prototype.slice.call(arguments,0),a={shim:t,method:r,args:n,ts:new Date};return window._rollbarShimQueue.push(a),e?t:void 0})}function l(r,o){if(o.hasOwnProperty&&o.hasOwnProperty("addEventListener")){var t=o.addEventListener;o.addEventListener=function(o,e,n){t.call(this,o,r.wrap(e),n)};var e=o.removeEventListener;o.removeEventListener=function(r,o,t){e.call(this,r,o&&o._wrapped?o._wrapped:o,t)}}}var s=0;a.init=function(r,o){var e=o.globalAlias||"Rollbar";if("object"==typeof r[e])return r[e];r._rollbarShimQueue=[],r._rollbarWrappedError=null,o=o||{};var i=new a;return t(function(){if(i.configure(o),o.captureUncaught){i._rollbarOldOnError=r.onerror,r.onerror=n(i);var t,a,s="EventTarget,Window,Node,ApplicationCache,AudioTrackList,ChannelMergerNode,CryptoOperation,EventSource,FileReader,HTMLUnknownElement,IDBDatabase,IDBRequest,IDBTransaction,KeyOperation,MediaController,MessagePort,ModalWindow,Notification,SVGElementInstance,Screen,TextTrack,TextTrackCue,TextTrackList,WebSocket,WebSocketWorker,Worker,XMLHttpRequest,XMLHttpRequestEventTarget,XMLHttpRequestUpload".split(",");for(t=0;t<s.length;++t)a=s[t],r[a]&&r[a].prototype&&l(i,r[a].prototype)}return r[e]=i,i})()},a.prototype.loadFull=function(r,o,e,n,a){var i=function(){var o;if(void 0===r._rollbarPayloadQueue){var t,e,n,i;for(o=new Error("rollbar.js did not load");t=r._rollbarShimQueue.shift();)for(n=t.args,i=0;i<n.length;++i)if(e=n[i],"function"==typeof e){e(o);break}}"function"==typeof a&&a(o)},l=!1,s=o.createElement("script"),u=o.getElementsByTagName("script")[0],p=u.parentNode;s.crossOrigin="",s.src=n.rollbarJsUrl,s.async=!e,s.onload=s.onreadystatechange=t(function(){if(!(l||this.readyState&&"loaded"!==this.readyState&&"complete"!==this.readyState)){s.onload=s.onreadystatechange=null;try{p.removeChild(s)}catch(r){}l=!0,i()}}),p.insertBefore(s,u)},a.prototype.wrap=function(r,o){try{var t;if(t="function"==typeof o?o:function(){return o||{}},"function"!=typeof r)return r;if(r._isWrap)return r;if(!r._wrapped){r._wrapped=function(){try{return r.apply(this,arguments)}catch(o){throw o._rollbarContext=t()||{},o._rollbarContext._wrappedSource=r.toString(),window._rollbarWrappedError=o,o}},r._wrapped._isWrap=!0;for(var e in r)r.hasOwnProperty(e)&&(r._wrapped[e]=r[e])}return r._wrapped}catch(n){return r}};for(var u="log,debug,info,warn,warning,error,critical,global,configure,scope,uncaughtError".split(","),p=0;p<u.length;++p)a.prototype[u[p]]=i(u[p]);r.exports={Rollbar:a,_rollbarWindowOnError:e}},function(r,o){"use strict";r.exports=function(r,o){return function(t){if(!t&&!window._rollbarInitialized){var e=window.RollbarNotifier,n=o||{},a=n.globalAlias||"Rollbar",i=window.Rollbar.init(n,r);i._processShimQueue(window._rollbarShimQueue||[]),window[a]=i,window._rollbarInitialized=!0,e.processPayloads()}}}}]);
        // End Rollbar Snippet
    </script>
@endif

@if(!isset($page['ageSplash']))
    @if(!is_bot())
        <!-- Begin Cookie Consent plugin -->
        <script type="text/javascript">
            window.cookieconsent_options = {
                "message":"{!! trans('auth.cookies-consent') !!}",
                "dismiss":"{!! trans('buttons.got-it') !!}",
                "learnMore":"{!! trans('buttons.more-info') !!}",
                "link":"{!! localize_url('routes.privacy-policy') !!}",
                "theme":"dark-top"
            };
        </script>

        <!-- Cookie consent plugin -->
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>
    @endif

    <!-- Crisp Live Chat -->
    <script type="text/javascript">CRISP_WEBSITE_ID = "-K4rvQmW22wetbVM5Z-_";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.im/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
@endif

<link href="//cloud.github.com/downloads/lafeber/world-flags-sprite/flags32.css" rel="stylesheet" />

@yield('css')