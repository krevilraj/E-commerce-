@if($priceTotal != 0.00)
    <tr>
        <td class="label">Tax(%):</td>
        <td class="tax">
            <span class="tax-percentage">
                <input type="number" name="tax_percentage" class="form-control" value="{{ (isset($order->enable_tax) && $order->enable_tax == 1) ? $order->tax_percentage : 0 }}" min="0" max="100">
            </span>
        </td>
    </tr>

    <tr>
        <td class="label">Order Total:</td>
        <td class="total">
        <span class="price-amount">
            <span class="price-currency-symbol">RS </span>{{ number_format($priceTotal, 2) }}</span>
        </td>
    </tr>
@endif