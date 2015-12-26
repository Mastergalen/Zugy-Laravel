<!-- includes.payment-method-->
@if($payment['method'] == 'cash')
    <p><i class="fa fa-money"></i> Cash</p>
    <p>Payment upon delivery</p>
@elseif($payment['method'] == 'card')
    <p><i class="fa fa-credit-card"></i> <b>{{ $payment['card']['brand'] }}</b> ending in {{ $payment['card']['last4'] }}</p>
@elseif($payment['method'] == 'paypal')
    <p><i class="fa fa-paypal"></i> PayPal</p>
@else
    <div class="alert alert-danger">Payment method not found</div>
@endif
<!-- /includes.payment-method-->