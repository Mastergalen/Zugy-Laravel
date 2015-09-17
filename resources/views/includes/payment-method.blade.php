@if($payment['method'] == 'card')
    <p><i class="fa fa-credit-card"></i> <b>{{ $payment['card']['brand'] }}</b> ending in {{ $payment['card']['last4'] }}</p>
@elseif($payment['method'] == 'paypal')
    <p><i class="fa fa-paypal"></i> {{ $payment['email'] }}</p>
@endif