<div class="box" style="margin-bottom: 10px">
    <table id="order-summary" class="table">
        <tr>
            <td>{!! trans('checkout.items') !!}</td>
            <td class="price">{!! money_format("%i", $total) !!}&euro;</td>
        </tr>
        <tr>
            <td>{!! trans('checkout.shipping') !!}</td>
            <td class="price">
                @if(Cart::shipping() == 0)
                    <span style="color: #8BB418;">{!! trans('shipping.free') !!}</span>
                    @else
                    {!! money_format("%i", $shipping) !!}&euro;
                @endif
            </td>
        </tr>
        <tr class="total">
            <td>{!! trans('checkout.total') !!}</td>
            <td class="price">{!! money_format("%i", $grandTotal) !!}&euro;</td>
        </tr>
        <tr><td colspan="2" style="border: 0">{!! trans('order.include-vat') !!} <a role="button" id="vat-expand">{!! trans('order.vat') !!}</a></td></tr>
    </table>
</div>