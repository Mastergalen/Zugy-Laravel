<?php $noindex = true ?>
@section('title', 'Order details')

@extends('layouts.default')

@section('css')
@endsection

@section('content')
    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> Order [#{!! $order->id !!}] details</h1>
    </div>
    <p>Ordered on {!! $order->order_placed->toFormattedDateString() !!}</p>

    <p>Order status: <!--TODO more pretty tracking -->
        @include('includes.status.order-status', ['status' => $order->order_status])
    </p>

    @can('show', $order)
        @include('includes.order-template')
    @else
        @if(auth()->guest())
            <div class="well"><a href="{!! route('login') !!}">Sign in</a> to view more information on your order.</div>
        @endif
    @endcan

@endsection

@section('scripts')
    <script>
        $(function() {
            $('#vat-expand').popover({
                html: true,
                title: 'VAT Summary',
                placement: 'bottom',
                content: $('#vat-popover-template').html()
            })
        });
    </script>
@endsection