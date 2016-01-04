@extends('emails.layouts.default')

@section('content')
    @parent
    <tr>
        <td class="content-block">
            <h2>{!! trans('email.thanks', ['name' => config('site.name')]) !!}</h2>
        </td>
    </tr>
    <tr>
        <td class="content-block">
            <p>{!! trans('checkout.order.success') !!}</p>
        </td>
    </tr>
    <tr>
        <td class="content-block aligncenter">
            <a href="{!! localize_url('routes.order.show', ['id' => $order->id])  !!}" class="btn-primary">{!! trans('order.email.track') !!}</a>
        </td>
    </tr>
    <tr>
        <td>
            <b>{!! trans('order.number') !!}:</b> {!! $order->id !!}<br>
            <b>{!! trans('order.date') !!}:</b> {!! $order->order_placed !!}
        </td>
    </tr>
    <tr>
        <td class="content-block">
            <p>{!! trans('email.receipt') !!}</p>
            @include('emails.order.partials._order-list', ['order' => $order])
        </td>
    </tr>
@endsection

@include('emails.order.partials._order-schema-markup', ['order' => $order])