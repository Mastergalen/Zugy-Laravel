<?php $noindex = true; ?>
<?php $ageSplash = true; ?>
@section('title', trans('ageSplash.prompt'))

@extends('layouts.barebones')

@section('css')
    <style>
            /*
     * Globals
     */

        /* Links */
        a,
        a:focus,
        a:hover {
            color: #fff;
        }

        /* Custom default button */
        .btn-default,
        .btn-default:hover,
        .btn-default:focus {
            color: #333;
            text-shadow: none; /* Prevent inheritence from `body` */
            background-color: #fff;
            border: 1px solid #fff;
        }


        /*
         * Base structure
         */

        html,
        body {
            height: 100%;
            background-color: #333;
        }
        body {
            background-image: url('/img/age-splash/cover-beer.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            text-align: center;
            text-shadow: 0 1px 3px rgba(0,0,0,.5);
        }

        /* Extra markup and styles for table-esque vertical and horizontal centering */
        .site-wrapper {
            color: #fff;
            display: table;
            width: 100%;
            height: 100%; /* For at least Firefox */
            min-height: 100%;
            -webkit-box-shadow: inset 0 0 100px rgba(0,0,0,.5);
            box-shadow: inset 0 0 100px rgba(0,0,0,.5);
        }
        .site-wrapper-inner {
            display: table-cell;
            vertical-align: top;
        }
        .cover-container {
            margin-right: auto;
            margin-left: auto;
        }

        /* Padding for spacing */
        .inner {
            padding: 30px;
        }


        /*
         * Header
         */
        .masthead-nav > li {
            display: inline-block;
        }
        .masthead-nav > li + li {
            margin-left: 20px;
        }
        .masthead-nav > li > a {
            padding-right: 0;
            padding-left: 0;
            font-size: 16px;
            font-weight: bold;
            color: #fff; /* IE8 proofing */
            color: rgba(255,255,255,.75);
            border-bottom: 2px solid transparent;
        }
        .masthead-nav > li > a:hover,
        .masthead-nav > li > a:focus {
            background-color: transparent;
            border-bottom-color: #a9a9a9;
            border-bottom-color: rgba(255,255,255,.25);
        }
        .masthead-nav > .active > a,
        .masthead-nav > .active > a:hover,
        .masthead-nav > .active > a:focus {
            color: #fff;
            border-bottom-color: #fff;
        }


        /*
         * Cover
         */

        .cover {
            padding: 0 20px;
        }
        .cover .btn-lg {
            padding: 10px 20px;
            font-weight: bold;
        }


        /*
         * Footer
         */

        .mastfoot {
            color: #999; /* IE8 proofing */
            color: rgba(255,255,255,.5);
        }


        /*
         * Affix and center
         */

        @media (min-width: 768px) {
            .mastfoot {
                position: fixed;
                bottom: 0;
            }
            /* Start the vertical centering */
            .site-wrapper-inner {
                vertical-align: middle;
            }
            /* Handle the widths */
            .masthead,
            .mastfoot,
            .cover-container {
                width: 100%; /* Must be percentage or pixels for horizontal alignment */
            }
        }

        @media (min-width: 992px) {
            .masthead,
            .mastfoot,
            .cover-container {
                width: 700px;
            }
        }
    </style>
@endsection

@section('body')
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">

                <div class="inner cover">
                    <h1 class="cover-heading"><img src="/img/zugy-navbar-logo.png" alt="Zugy Logo"></h1>
                    <p class="lead">{!! trans('ageSplash.prompt') !!}</p>
                    <p class="lead">
                        <a href="#" class="btn btn-lg btn-default" data-toggle="modal" data-target="#denial-modal">{!! trans('ageSplash.under', ['age' => '18']) !!}</a>
                        <a href="#" class="btn btn-lg btn-default" id="btn-over-18">{!! trans('ageSplash.over', ['age' => '18']) !!}</a>
                    </p>
                </div>

                <div class="mastfoot">
                    <div class="inner">
                        <p>&copy; {!! config('site.name') !!} {!! date("Y") !!}. {!! trans('footer.rights-reserved') !!}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="denial-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! trans('ageSplash.sorry.title') !!}</h4>
                </div>
                <div class="modal-body">
                    <p>{!! trans('ageSplash.sorry.desc') !!}</p>
                    <p>{!! trans('ageSplash.sorry.party') !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#btn-over-18').click(function() {
            var now = new Date();
            var time = now.getTime();
            var expireTime = time + 365*86400 * 1000;
            now.setTime(expireTime);
            document.cookie = "isOver18=true; expires="+now.toGMTString()+"; path=/";
            location.reload();
        });
    </script>
@endsection