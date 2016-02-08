<?php $noindex = true ?>
@section('title', 'Order details')

@extends('layouts.default')

@section('css')
@endsection

@section('content')
    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> {!! trans('order.details') !!} [#{!! $order->id !!}]</h1>
    </div>
    <p>{!! trans('order.date') !!}: {!! $order->order_placed->toFormattedDateString() !!}</p>

    <p>{!! trans('forms.status') !!}:
        @include('includes.status.order-status', ['status' => $order->order_status])
    </p>

    <p>
        {!! trans('checkout.review.delivery-time') !!}:
        @include('includes._order-delivery_time', ['delivery_time' => $order->delivery_time])
    </p>

    @include('includes._order-timeline', ['activity' => $order->activity])

    @can('show', $order)
        @include('includes.order-template')
    @else
        @if(auth()->guest())
            <div class="well">{!! trans('order.sign-in', ['loginUrl' => route('login', ['intended' => request()->url()])]) !!}</div>
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

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection