<div class="row">
    <div class="col-md-3">
        <h4>{!! trans('checkout.address.form.delivery') !!}</h4>
        <address>
            {{ $order->delivery_name }}<br>
            {{ $order->delivery_line_1 }}<br>
            @if($order->delivery_line_2 != ""){{$order->delivery_line_2}}<br>@endif
            {{$order->delivery_city}}, {{$order->delivery_postcode}}<br>
            <i class="fa fa-phone"></i> {{$order->delivery_phone}}<br>
            @if($order->delivery_instructions != ""){!! trans('checkout.address.form.instructions') !!}: {{$order->delivery_instructions}}<br>@endif
        </address>
    </div>
    <div class="col-md-3">
        <h4>{!! trans('payment.payment-method') !!}</h4>
        @include('includes.payment-method', ['payment' => $order->payment->getFormatted()])
        @include('includes.status.payment-status', ['status' => $order->payment->status])
    </div>
    <div class="col-md-3">
        <h4>{!! trans('checkout.address.form.billing') !!} </h4>
        {{ $order->payment->billing_name }}<br>
        {{ $order->payment->billing_line_1 }}<br>
        @if($order->payment->billing_line_2 != ""){{$order->payment->billing_line_2}}<br>@endif
        {{$order->payment->billing_city}}, {{$order->payment->billing_postcode}}<br>
    </div>
    <div class="col-md-3">
        <h4>{!! trans('order.summary') !!}</h4>
        @include('includes.order-summary',  [
            'total' => $order->total,
            'shipping' => $order->shipping_fee,
            'grandTotal' => $order->grandTotal,
            'couponDeduction' => $order->coupon_deduction,
            'coupon' => $order->coupon
        ])
        {{-- ORDER ACTIONS --}}
        @if(auth()->check())
            <form action="{!! request()->url() !!}">
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="action" value="cancel">
                {!! Form::token() !!}
                {{--  <button class="btn btn-danger btn-block btn-sm"><i class="fa fa-remove"></i> Cancel order</button> FIXME Cancel order and refund --}}
            </form>
        @endif
    </div>
</div>
@include('includes.vat-popover', ['vat' => $order->vat, 'grandTotal' => $order->grandTotal])

<hr>

@include('pages.order.includes.order-row', ['order' => $order])