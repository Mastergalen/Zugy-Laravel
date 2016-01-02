@extends('emails.layouts.default')

@section('content')
    @parent
    <tr>
        <td class="content-block">
            <h2>Your order was cancelled.</h2>
        </td>
    </tr>
    <tr>
        <td class="content-block">
            <p>If you have any questions regarding this cancellation you can reply to this email or call us at {!! config('site.phone') !!}.</p>
        </td>
    </tr>
    <tr>
        <td class="content-block aligncenter">
            <a href="{!! localize_url('routes.order.show', ['id' => $order->id])  !!}" class="btn-primary">Track order</a> <!-- TODO Add tracking order link -->
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