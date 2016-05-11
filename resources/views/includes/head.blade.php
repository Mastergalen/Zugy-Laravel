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
            captureUnhandledRejections: false,
            payload: {
                environment: "production"
            }
        };
        // Rollbar Snippet
        !function(r){function e(t){if(o[t])return o[t].exports;var n=o[t]={exports:{},id:t,loaded:!1};return r[t].call(n.exports,n,n.exports,e),n.loaded=!0,n.exports}var o={};return e.m=r,e.c=o,e.p="",e(0)}([function(r,e,o){"use strict";var t=o(1).Rollbar,n=o(2);_rollbarConfig.rollbarJsUrl=_rollbarConfig.rollbarJsUrl||"https://d37gvrvc0wt4s1.cloudfront.net/js/v1.9/rollbar.min.js";var a=t.init(window,_rollbarConfig),i=n(a,_rollbarConfig);a.loadFull(window,document,!_rollbarConfig.async,_rollbarConfig,i)},function(r,e){"use strict";function o(r){return function(){try{return r.apply(this,arguments)}catch(e){try{console.error("[Rollbar]: Internal error",e)}catch(o){}}}}function t(r,e,o){window._rollbarWrappedError&&(o[4]||(o[4]=window._rollbarWrappedError),o[5]||(o[5]=window._rollbarWrappedError._rollbarContext),window._rollbarWrappedError=null),r.uncaughtError.apply(r,o),e&&e.apply(window,o)}function n(r){var e=function(){var e=Array.prototype.slice.call(arguments,0);t(r,r._rollbarOldOnError,e)};return e.belongsToShim=!0,e}function a(r){this.shimId=++c,this.notifier=null,this.parentShim=r,this._rollbarOldOnError=null}function i(r){var e=a;return o(function(){if(this.notifier)return this.notifier[r].apply(this.notifier,arguments);var o=this,t="scope"===r;t&&(o=new e(this));var n=Array.prototype.slice.call(arguments,0),a={shim:o,method:r,args:n,ts:new Date};return window._rollbarShimQueue.push(a),t?o:void 0})}function l(r,e){if(e.hasOwnProperty&&e.hasOwnProperty("addEventListener")){var o=e.addEventListener;e.addEventListener=function(e,t,n){o.call(this,e,r.wrap(t),n)};var t=e.removeEventListener;e.removeEventListener=function(r,e,o){t.call(this,r,e&&e._wrapped?e._wrapped:e,o)}}}var c=0;a.init=function(r,e){var t=e.globalAlias||"Rollbar";if("object"==typeof r[t])return r[t];r._rollbarShimQueue=[],r._rollbarWrappedError=null,e=e||{};var i=new a;return o(function(){if(i.configure(e),e.captureUncaught){i._rollbarOldOnError=r.onerror,r.onerror=n(i);var o,a,c="EventTarget,Window,Node,ApplicationCache,AudioTrackList,ChannelMergerNode,CryptoOperation,EventSource,FileReader,HTMLUnknownElement,IDBDatabase,IDBRequest,IDBTransaction,KeyOperation,MediaController,MessagePort,ModalWindow,Notification,SVGElementInstance,Screen,TextTrack,TextTrackCue,TextTrackList,WebSocket,WebSocketWorker,Worker,XMLHttpRequest,XMLHttpRequestEventTarget,XMLHttpRequestUpload".split(",");for(o=0;o<c.length;++o)a=c[o],r[a]&&r[a].prototype&&l(i,r[a].prototype)}return e.captureUnhandledRejections&&(i._unhandledRejectionHandler=function(r){var e=r.reason,o=r.promise,t=r.detail;!e&&t&&(e=t.reason,o=t.promise),i.unhandledRejection(e,o)},r.addEventListener("unhandledrejection",i._unhandledRejectionHandler)),r[t]=i,i})()},a.prototype.loadFull=function(r,e,t,n,a){var i=function(){var e;if(void 0===r._rollbarPayloadQueue){var o,t,n,i;for(e=new Error("rollbar.js did not load");o=r._rollbarShimQueue.shift();)for(n=o.args,i=0;i<n.length;++i)if(t=n[i],"function"==typeof t){t(e);break}}"function"==typeof a&&a(e)},l=!1,c=e.createElement("script"),d=e.getElementsByTagName("script")[0],p=d.parentNode;c.crossOrigin="",c.src=n.rollbarJsUrl,c.async=!t,c.onload=c.onreadystatechange=o(function(){if(!(l||this.readyState&&"loaded"!==this.readyState&&"complete"!==this.readyState)){c.onload=c.onreadystatechange=null;try{p.removeChild(c)}catch(r){}l=!0,i()}}),p.insertBefore(c,d)},a.prototype.wrap=function(r,e){try{var o;if(o="function"==typeof e?e:function(){return e||{}},"function"!=typeof r)return r;if(r._isWrap)return r;if(!r._wrapped){r._wrapped=function(){try{return r.apply(this,arguments)}catch(e){throw e._rollbarContext=o()||{},e._rollbarContext._wrappedSource=r.toString(),window._rollbarWrappedError=e,e}},r._wrapped._isWrap=!0;for(var t in r)r.hasOwnProperty(t)&&(r._wrapped[t]=r[t])}return r._wrapped}catch(n){return r}};for(var d="log,debug,info,warn,warning,error,critical,global,configure,scope,uncaughtError,unhandledRejection".split(","),p=0;p<d.length;++p)a.prototype[d[p]]=i(d[p]);r.exports={Rollbar:a,_rollbarWindowOnError:t}},function(r,e){"use strict";r.exports=function(r,e){return function(o){if(!o&&!window._rollbarInitialized){var t=window.RollbarNotifier,n=e||{},a=n.globalAlias||"Rollbar",i=window.Rollbar.init(n,r);i._processShimQueue(window._rollbarShimQueue||[]),window[a]=i,window._rollbarInitialized=!0,t.processPayloads()}}}}]);
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