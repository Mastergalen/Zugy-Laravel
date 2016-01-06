<?php $noindex = true; ?>
@section('title', trans('buttons.login'))

@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @include('auth.partials._login-form')
        </div>
    </div>
@stop