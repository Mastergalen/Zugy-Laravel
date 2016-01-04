<div id="vat-popover-template" style="display:none">
    <table class="table">
        <tr>
            <td>{!! trans('order.total-before-vat') !!}</td>
            <td class="price">{!! money_format("%i", $grandTotal - $vat)  !!}&euro;</td>
        </tr>
        <tr>
            <td>{!! trans('order.vat') !!}</td>
            <td class="price">{!! money_format("%i", $vat) !!}&euro;</td>
        </tr>
        <tr class="total">
            <td>{!! trans('checkout.total') !!}</td>
            <td class="price">{!! money_format("%i", $grandTotal) !!}&euro;</td>
        </tr>
    </table>
</div>