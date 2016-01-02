@section('title', 'Contact us')
@section('meta_description', 'Contact us')

@extends('layouts.default')

@section('content')
    <div class="page-header">
        <h1>{!! trans('pages.contact.title') !!}</h1>
    </div>
        <address>
            {!! trans('pages.contact.address') !!}
        </address>
        <p>{!! trans('pages.contact.customer-service') !!}</p>
        <p><tel>{!! config('site.phone') !!}</tel></p>
        <p>{!! trans('pages.contact.email.general') !!} <a href="mailto:{!! config('site.email.support') !!}">{!! config('site.email.support') !!}</a></p>
        <p>{!! trans('pages.contact.email.investors') !!} <a href="mailto:management@myzugy.com">management@myzugy.com</a></p>
@endsection