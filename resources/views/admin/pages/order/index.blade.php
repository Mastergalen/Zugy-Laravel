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
            <table class="table table-stripped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Order Placed</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($orders as $o)
                    <tr>
                        <td>#{{ $o['id'] }}</td>
                        <td>{{ $o->order_placed }}</td>
                        <td>{{ $o->grandTotal }}&euro;</td>
                        <td>@include('includes.status.order-status', ['status' => $o['order_status']])</td>
                        <td class="text-right">
                            <div class="btn-group">
                                <a href="{!! action('Admin\OrderController@show', $o->id) !!}" class="btn btn-default btn-xs">View</a>
                                <a href="{!! action('Admin\OrderController@edit', $o->id) !!}" class="btn btn-default btn-xs">Edit</a>
                            </div>
                        </td>

                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6">
                        {!! $orders->render() !!}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection