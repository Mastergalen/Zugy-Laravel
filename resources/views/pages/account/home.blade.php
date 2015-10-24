@section('title', 'Your account')

@extends('layouts.default')

@section('content')
    <div class="page-header">
        <h1>Your account</h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Orders</h4>
        </div>
        <div class="panel-body">
            <p>View track, or cancel an order</p>
            <a href="{!! localize_url('routes.account.orders') !!}" class="btn btn-primary">Your Orders</a>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Payment</h4>
        </div>
        <div class="panel-body">
            <p><a href="#">Manage your payment methods</a></p>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="fa fa-cog"></i> Settings</h4>
        </div>
        <div class="panel-body">
            <p><a href="#">Change E-Mail address or password</a></p>
        </div>
    </div>
@endsection


