@extends('emails.layouts.default')

@section('content')
    @parent
    <tr>
        <td class="content-block">
            <h2>Thank you for using {!! config('site.name') !!}.</h2>
        </td>
    </tr>
    <tr>
        <td class="content-block">
            <p>You've successfully placed an order.</p>
            <p>We will email you again when your order is out for delivery or you can track the status of your order by clicking the button below.</p>
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
            <p>Here is your receipt.</p>
            @include('emails.order.partials._order-list', ['order' => $order])
        </td>
    </tr>
@endsection

@include('emails.order.partials._order-schema-markup', ['order' => $order])