@section('title', 'Your Orders')

@extends('layouts.default')

@section('content')
    <ul class="breadcrumb">
        <li><a href="{!! localize_url('routes.account.index') !!}">Your Account</a></li>
        <li class="active">Your orders</li>
    </ul>

    <div class="page-header">
        <h1>Your orders</h1>
    </div>

    @foreach($orders as $o)
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-2">
                        <p>Order placed: <br>{{$o->order_placed->toFormattedDateString()}}</p>
                    </div>
                    <div class="col-md-2">
                        <p>Order total: <br>{{$o->total}}&euro;</p>
                    </div>
                    <div class="col-md-2">
                        <p>Dispatch to: <br>{{$o->delivery_name}}</p></div>
                    </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        @include('pages.order.includes.order-row', ['order' => $o])
                    </div>
                    <div class="col-md-4">
                        <div class="btn-block">
                            <a href="{!! localize_url('routes.order.show', ['id' => $o->id]) !!}" class="btn btn-primary btn-block">Track order</a>
                            <a href="#" class="btn btn-danger btn-xs btn-block">Cancel order</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection


