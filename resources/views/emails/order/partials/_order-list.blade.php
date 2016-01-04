<table class="invoice">
    <tr>
        <td>
            <table class="invoice-items" cellpadding="0" cellspacing="0">
                <thead>
                <th>{!! trans('product.product') !!}</th>
                <th>{!! trans('product.quantity') !!}</th>
                <th>{!! trans('product.price') !!}</th>
                <th>{!! trans('checkout.total') !!}</th>
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
                    <td>{!! trans('checkout.shipping') !!}</td>
                    <td></td>
                    <td></td>
                    <td>{!! money_format("%i", $order->shipping_fee) !!}&euro;</td>
                </tr>
                <tr class="total">
                    <td colspan="3">{!! trans('order.email.confirmation.paid') !!}</td>
                    <td>{!! money_format("%i", $order->total + $order->shipping_fee) !!}&euro;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>