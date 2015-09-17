<div id="vat-popover-template" style="display:none">
    <table class="table">
        <tr>
            <td>Total before VAT</td>
            <td class="price">{!! money_format("%i", $grandTotal - $vat)  !!}&euro;</td>
        </tr>
        <tr>
            <td>VAT</td>
            <td class="price">{!! money_format("%i", $vat) !!}&euro;</td>
        </tr>
        <tr class="total">
            <td>Order Total</td>
            <td class="price">{!! money_format("%i", $grandTotal) !!}&euro;</td>
        </tr>
    </table>
</div>