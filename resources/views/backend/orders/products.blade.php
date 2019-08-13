@foreach($products as $product)
    @php
        if (Route::currentRouteName() == 'dashboard.order.create'){
            $price = $product->getPrice();
        } else{
            $price = isset($product->sale_price) ? $product->sale_price : $product->regular_price;
        }
    @endphp
    <tr class="item" data-product="{{ $product->id }}">
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
            <span>RS{{ $price }}</span>
            <input type="hidden" name="price" value="{{ $price }}">
        </td>
        <td class="quantity" width="2%">
            <div class="view">
                <small class="times">x</small>
                <input type="number" name="quantity" value="{{ isset($product->quantity) ? $product->quantity : 1 }}"
                       min="1" class="form-control">
            </div>
        </td>
        <td class="discount" width="1%">
            <div class="view">
                <small class="times">-</small>
                <input type="number" name="discount" value="{{ isset($product->discount) ? $product->discount : 0 }}"
                       min="0" class="form-control">
            </div>
        </td>
        <td class="line_cost" width="1%">
            <div class="view">
                RS{{ number_format($price*$product->quantity, 2) }}
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
    </tr>
@endforeach