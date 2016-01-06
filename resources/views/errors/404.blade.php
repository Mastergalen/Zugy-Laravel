@extends('layouts.default')

@section('title', '404 - ' . trans('errors.404.message'))

@section('content')
<h1>404 - {!! trans('errors.404.message') !!}</h1>
<p>{!! trans('errors.404.description') !!}</p>
<a href="/" class="btn btn-primary"><i class="fa fa-home"></i> {!! trans('buttons.return-home') !!}</a>
@endsection