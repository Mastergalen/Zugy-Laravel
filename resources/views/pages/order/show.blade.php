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
        @else
            <div class="alert alert-danger">You do not have permission to view details of this order.</div>
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
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    @if(session('orderConfirmation'))
        <!-- Google Code for Website Purchase Conversion Page -->
        <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 880968833;
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "ffffff";
            var google_conversion_label = "O8WZCPvljWcQgYmKpAM";
            var google_conversion_value = {{  $order->total }};
            var google_conversion_currency = "EUR";
            var google_remarketing_only = false;
            /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
        <noscript>
            <div style="display:inline;">
                <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/880968833/?value={{ $order->total }}&amp;currency_code=EUR&amp;label=O8WZCPvljWcQgYmKpAM&amp;guid=ON&amp;script=0"/>
            </div>
        </noscript>
    @endif
@endsection