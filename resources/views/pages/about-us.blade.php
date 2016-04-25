@section('title', 'About')
@section('meta_description', 'Zugy is a liquor store that delivers right to your front door, 1 hour after you place your order.')

@extends('layouts.default')

@section('css')
    <style>
        .social-icon {
            display: inline-block;
            margin: 2px;
        }
    </style>
@endsection
@section('content')
<div class="page-header">
    <h1>{!! trans('pages.about-us.title') !!}</h1>
</div>
<a href="https://websummit.net/startups/alpha"><img src="/img/badges/badge-websummit.png" style="width: 150px; float:right"></a>
{!! trans('pages.about-us.desc') !!}
<hr>
<div style="text-align: center; font-size: 10em">
    <h2>{!! trans('pages.about-us.find-out-more') !!}</h2>

    <div class="social-icon">
        <a href="https://www.facebook.com/zugymilan" data-toggle="tooltip" title="Facebook"><i
                    class="fa fa-facebook-square"></i></a>
    </div>
    <div class="social-icon">
        <a href="https://instagram.com/zugy_/" data-toggle="tooltip" title="Instagram: zugy_"><i
                    class="fa fa-instagram"></i></a>
    </div>
</div>
<hr>
<h2>{!! trans('pages.about-us.mission-statement.title') !!}</h2>
{!! trans('pages.about-us.mission-statement.desc') !!}

<h2>{!! trans('pages.about-us.partners') !!}</h2>
{!! trans('pages.about-us.partners-desc') !!}
@endsection

@section('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection