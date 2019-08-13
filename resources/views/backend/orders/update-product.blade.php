<td class="thumb" width="1%">
    <div class="thumbnail mb-none">
        <img src="{{ getProductImage($product->id, 'smallUrl') }}"
             class="img-responsive" alt="" title="">
    </div>
</td>
<td class="name" width="10%">
    <a href="{{ route('dashboard.product.edit', $product->id) }}">{{ $product->name }}</a>
</td>
<td class="item_cost" width="1%">
    <span>Rs{{ $product->price }}</span>
    <input type="hidden" name="price" value="{{ $product->price }}">
</td>
<td class="quantity" width="2%">
    <div class="view">
        <small class="times">x</small>
        <input type="number" name="quantity" value="{{ $product->quantity }}" min="1" class="form-control">
    </div>
</td>
<td class="discount" width="1%">
    <div class="view">
        <small class="times">-</small>
        <input type="number" name="discount" value="{{ $product->discount }}" min="0" class="form-control">
    </div>
</td>
<td class="line_cost" width="1%">
    <div class="view">
        Rs{{ number_format($product->price_total*$product->quantity, 2) }}
    </div>
</td>
<td class="order-actions" width="3%">
    <button type="button" class="btn btn-sm btn-info update-order-item">
        Update
    </button>
    <button type="button" class="btn btn-sm btn-danger delete-order-item">
        Delete
    </button>
</td>