@extends('layouts.default')

@section('title', '500 - ' . trans('errors.500.message'))

@section('content')
<h1>500 - {!! trans('errors.500.message') !!}</h1>
<p>{!! trans('errors.500.description') !!}</p>
<a href="/" class="btn btn-primary"><i class="fa fa-home"></i> {!! trans('buttons.return-home') !!}</a>
@endsection