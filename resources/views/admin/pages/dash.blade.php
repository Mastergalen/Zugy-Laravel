@extends('admin.layouts.default')

@section('title', trans('admin.dashboard.title'))

@section('header')
    <h1><i class="fa fa-dashboard"></i> {!! trans('admin.dashboard.title') !!}</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $orders->incomplete()->count() }}</h3>

                    <p>{!! trans('admin.incomplete-orders') !!}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="{!! action('Admin\OrderController@index', ['filter' => 'incomplete']) !!}" class="small-box-footer">
                    {!! trans('buttons.more-info') !!} <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-md-3">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ money_format("%i", $revenueYesterday) }}&euro;</h3>

                    <p>{!! trans('admin.revenue-yesterday') !!}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-md-3">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ money_format("%i", $revenueThisMonth) }}&euro;</h3>

                    <p>{!! trans('admin.revenue-this-month') !!}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
            </div>
        </div>
    </div>
@endsection