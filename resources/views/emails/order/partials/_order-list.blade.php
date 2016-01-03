<table class="invoice">
    <tr>
        <td>
            <table class="invoice-items" cellpadding="0" cellspacing="0">
                <thead>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
                </thead>
                @foreach($order->items as $i)
                    <tr>
                        <td><a href="{!! $i->product->getUrl() !!}">{{$i->product->title}}</a></td>
                        <td>{!! $i->quantity !!}</td>
                        <td>{!! $i->price !!}&euro;</td>
                        <td>{!! $i->final_price !!}&euro;</td>
                    </tr>
                @endforeach
                <tr>
                    <td>Shipping</td>
                    <td></td>
                    <td></td>
                    <td>{!! money_format("%i", $order->shipping_fee) !!}&euro;</td>
                </tr>
                <tr class="total">
                    <td colspan="3">Total paid</td>
                    <td>{!! money_format("%i", $order->total + $order->shipping_fee) !!}&euro;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>