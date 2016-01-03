@extends('admin.layouts.default')

@section('title', 'Orders')

@section('header')
    <h1><i class="fa fa-book"></i> Orders</h1>
@endsection

@section('breadcrumb')
    <li class="active">
        <strong>Orders</strong>
    </li>
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="product_name">Order ID</label>
                        <input type="text" name="orderId" value="" placeholder="Order ID"
                               class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="box-body no-padding">
            @include('admin.partials._order-list', ['orders' => $orders])
        </div>
    </div>
@endsection