@section('title',  trans('your-account.title'))

@extends('layouts.default')

@section('content')
    <div class="page-header">
        <h1>{!! trans('your-account.title') !!}</h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">{!! trans('your-account.orders') !!}</h4>
        </div>
        <div class="panel-body">
            <p>{!! trans('your-account.orders.desc') !!}</p>
            <a href="{!! localize_url('routes.account.orders') !!}" class="btn btn-primary">Your Orders</a>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">{!! trans('checkout.payment.title') !!}</h4>
        </div>
        <div class="panel-body">
            <p><a href="#">{!! trans('your-account.payment.manage') !!}</a></p>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="fa fa-cog"></i> {!! trans('your-account.settings.title') !!}</h4>
        </div>
        <div class="panel-body">
            <p><a href="#">{!! trans('your-account.settings.email') !!}</a></p>
        </div>
    </div>
@endsection


