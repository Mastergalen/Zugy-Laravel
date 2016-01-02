@extends('emails.layouts.default')

@section('content')
    @parent
    <tr>
        <td class="content-block">
            <h2>Your order is out for delivery!</h2>
        </td>
    </tr>
    <tr>
        <td class="content-block">
            <p>Our driver is now on his way to you!</p>
            <p>If anything goes wrong or we have trouble finding you, we will call you on your phone at <b>{{ $order->delivery_phone }}</b></p>
            <p>You can track the current status of your order by clicking the button below.</p>
        </td>
    </tr>
    <tr>
        <td class="content-block aligncenter">
            <a href="{!! localize_url('routes.order.show', ['id' => $order->id])  !!}" class="btn-primary">Track order</a>
        </td>
    </tr>
    <tr>
        <td>
            <b>Order number:</b> {!! $order->id !!}<br>
            <b>Order date:</b> {!! $order->order_placed !!}
        </td>
    </tr>
    <tr>
        <td class="content-block">
            @include('emails.order.partials._order-list', ['order' => $order])
        </td>
    </tr>
@endsection

@include('emails.order.partials._order-schema-markup', ['order' => $order])