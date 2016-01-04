@extends('admin.layouts.default')

@section('title', trans('admin.orders.title'))

@section('header')
    <h1><i class="fa fa-book"></i> {!! trans('admin.orders.title') !!}</h1>
@endsection

@section('breadcrumb')
    <li class="active">
        <strong>{!! trans('admin.orders.title') !!}</strong>
    </li>
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-body">
            <form id="order-id-form" class="form-inline">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="order-id" id="order-id" value=""
                                                     placeholder="{!! trans('admin.orders.form.id.label') !!}"
                                                     class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default"><i class="fa fa-eye"></i></button>
                        </span>
                    </div>
                </div>
                <a href="{!! action('Admin\OrderController@index', ['filter' => 'incomplete']) !!}"
                        class="btn btn-primary">
                    <i class="fa fa-filter"></i> {!! trans('admin.orders.filter.incomplete') !!}
                </a>
            </form>
            <hr>
            @if(request()->has('filter'))
                <div class="alert alert-info">
                    {!! trans('admin.order.filters.incomplete.info') !!}
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