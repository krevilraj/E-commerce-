<a href="#" class="cart-dropdown-icon">
    <i class="minicart-icon"></i>
    <span class="cart-info">
        <span class="cart-qty">{{ count($cartContents) }}</span>
        <span class="cart-text">item(s)</span>
    </span>
</a>

<div class="cart-dropdownmenu right">
    <div class="dropdownmenu-wrapper">
        @if(count($cartContents))
            <div class="cart-products">
                @foreach($cartContents as $cartContent)
                    <div class="product product-sm">
                        <a href="#" class="btn-remove" title="Remove Product">
                            <i class="fa fa-times"></i>
                        </a>
                        <figure class="product-image-area">
                            <a href="{{ route('product.show', getProductSlug($cartContent->id)) }}"
                               title="{{ $cartContent->name }}"
                               class="product-image">
                                <img src="{{ asset(getProductImage($cartContent->id, 'small')) }}"
                                     alt="{{ $cartContent->name }}">
                            </a>
                        </figure>
                        <div class="product-details-area">
                            <h2 class="product-name">
                                <a href="{{ route('product.show', getProductSlug($cartContent->id)) }}"
                                   title="{{ $cartContent->name }}">{{ $cartContent->name }}</a>
                            </h2>

                            <div class="cart-qty-price">
                                {{ $cartContent->qty }} X
                                <span class="product-price">Rs{{ $cartContent->price }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cart-totals">
                Total: <span>Rs{{ $cartTotal }}</span>
            </div>

            <div class="cart-actions">
                <a href="{{ route('cart.index') }}" class="btn btn-primary">View
                    Cart</a>
                <a href="{{ route('checkout') }}"
                   class="btn btn-primary">Checkout</a>
            </div>
        @else
            <div class="cart-empty">
                <p class="mb-none">No products in cart.</p>
            </div>
        @endif
    </div>
</div>