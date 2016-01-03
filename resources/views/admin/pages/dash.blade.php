@extends('admin.layouts.default')

@section('title', 'Dashboard')

@section('header')
    <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $orders->incomplete()->count() }}</h3>

                    <p>Incomplete Orders</p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="{!! action('Admin\OrderController@index', ['filter' => 'incomplete']) !!}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ money_format("%i", $revenueYesterday) }}&euro;</h3>

                    <p>Revenue yesterday</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
            </div>
        </div>
    </div>
@endsection