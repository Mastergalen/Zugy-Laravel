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

<hr>

<h2 style="text-align: center">{!! trans('pages.team') !!}</h2>
<div class="row">
    <div class="col-md-3 member">
        <div class="avatar">
            <img src="/img/avatars/andres.jpg" alt="">
        </div>
        <div class="name"><a href="https://it.linkedin.com/in/andresibarguen">Andrés Felipe Ibargüen</a></div>
        <div class="position">{!!  trans('team.bios.andres.position') !!}</div>
        {!!  trans('team.bios.andres.text') !!}
    </div>
    <div class="col-md-3 member">
        <div class="avatar">
            <img src="/img/avatars/matthias.jpg" alt="">
        </div>
        <div class="name">Matthias Schnegelsberg</div>
        <div class="position">{!!  trans('team.bios.matthias.position') !!}</div>
        {!!  trans('team.bios.matthias.text') !!}
    </div>
    <div class="col-md-3 member">
        <div class="avatar">
            <img src="/img/avatars/galen.jpg" alt="">
        </div>
        <div class="name"><a href="https://www.linkedin.com/in/galenhan">Galen Han</a></div>
        <div class="position">{!!  trans('team.bios.galen.position') !!}</div>
        {!!  trans('team.bios.galen.text') !!}
    </div>
    <div class="col-md-3 member">
        <div class="avatar">
            <img src="/img/avatars/victor.jpg" alt="">
        </div>
        <div class="name">Victor Da Silva</div>
        <div class="position">{!!  trans('team.bios.victor.position') !!}</div>
        {!!  trans('team.bios.victor.text') !!}
    </div>
</div>

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
