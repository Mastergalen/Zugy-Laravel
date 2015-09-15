<div class="box" style="margin-bottom: 10px">
    <table id="order-summary" class="table">
        <tr>
            <td>Items</td>
            <td class="price">{!! money_format("%i", Cart::total()) !!}&euro;</td>
        </tr>
        <tr>
            <td>Shipping</td>
            <td class="price">
                @if(Cart::shipping() == 0)
                    <span style="color: #8BB418;">Free shipping</span>
                    @else
                    {!! money_format("%i", Cart::shipping()) !!}&euro;
                @endif
            </td>
        </tr>
        <tr class="total">
            <td>Order Total</td>
            <td class="price">{!! money_format("%i", Cart::grandTotal()) !!}&euro;</td>
        </tr>
        <tr><td colspan="2" style="border: 0">Order totals include <a role="button" id="vat-expand">VAT</a></td></tr>
    </table>
</div>