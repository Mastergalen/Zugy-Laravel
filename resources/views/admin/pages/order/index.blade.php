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
            <form id="order-id-form" class="form-inline">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="order-id" id="order-id" value=""
                                                     placeholder="Order ID"
                                                     class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default"><i class="fa fa-eye"></i></button>
                        </span>
                    </div>
                </div>
                <a href="{!! action('Admin\OrderController@index', ['filter' => 'incomplete']) !!}"
                        class="btn btn-primary">
                    <i class="fa fa-filter"></i> Filter incomplete
                </a>
            </form>
            <hr>
            @if(request()->has('filter'))
                <div class="alert alert-info">
                    Currently showing incomplete orders only.
                </div>
            @endif
        </div>

        <div class="box-body">
            @include('admin.partials._order-list', ['orders' => $orders])
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('ready pjax:success', function() {
            $('#order-id-form').submit(function(e) {
                e.preventDefault();

                var orderId = $(this).find('#order-id').val();

                window.location.href = "{!! action('Admin\OrderController@index') !!}/" + orderId;
            })
        });
    </script>
@endsection