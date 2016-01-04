<!-- includes.payment-method-->
@if($payment['method'] == 'cash')
    <p><i class="fa fa-money"></i> {!! trans('checkout.payment.form.cash') !!}</p>
    <p>{!! trans('checkout.payment.form.cash.desc') !!}</p>
@elseif($payment['method'] == 'card')
    <p><i class="fa fa-credit-card"></i> {!! trans('checkout.payment.form.card.show', ['brand' => $payment['card']['brand'], 'last4' => $payment['card']['last4']]) !!}</p>
@elseif($payment['method'] == 'paypal')
    <p><i class="fa fa-paypal"></i> PayPal</p>
@endif

<!-- /includes.payment-method-->