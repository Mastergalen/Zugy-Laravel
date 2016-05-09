@section('title', 'Team')
@section('meta_description', 'Our team that makes Zugy.')

@extends('layouts.default')

@section('content')
    <div class="page-header">
        <h1>{!! trans('pages.team') !!}</h1>
    </div>
    <div class="row">
        <div class="col-md-6 member">
            <div class="avatar">
                <img src="/img/avatars/rafael.jpg" alt="">
            </div>
            <div class="name">Rafael Ruah Arié</div>
            <div class="position">{!!  trans('team.bios.rafael.position') !!}</div>
            {!!  trans('team.bios.rafael.text') !!}
        </div>
        <div class="col-md-6 member">
            <div class="avatar">
                <img src="/img/avatars/andres.jpg" alt="">
            </div>
            <div class="name"><a href="https://it.linkedin.com/in/andresibarguen">Andrés Felipe Ibargüen</a></div>
            <div class="position">{!!  trans('team.bios.andres.position') !!}</div>
            {!!  trans('team.bios.andres.text') !!}
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4 member">
            <div class="avatar">
                <img src="/img/avatars/matthias.jpg" alt="">
            </div>
            <div class="name">Matthias Schnegelsberg</div>
            <div class="position">{!!  trans('team.bios.matthias.position') !!}</div>
            {!!  trans('team.bios.matthias.text') !!}
        </div>
        <div class="col-md-4 member">
            <div class="avatar">
                <img src="/img/avatars/galen.jpg" alt="">
            </div>
            <div class="name"><a href="https://www.linkedin.com/in/galenhan">Galen Han</a></div>
            <div class="position">{!!  trans('team.bios.galen.position') !!}</div>
            {!!  trans('team.bios.galen.text') !!}
        </div>
        <div class="col-md-4 member">
            <div class="avatar">
                <img src="/img/avatars/victor.jpg" alt="">
            </div>
            <div class="name">Victor Da Silva</div>
            <div class="position">{!!  trans('team.bios.victor.position') !!}</div>
            {!!  trans('team.bios.victor.text') !!}
        </div>
    </div>
@endsection