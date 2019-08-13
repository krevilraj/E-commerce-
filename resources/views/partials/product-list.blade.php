<li>
    <div class="product product-list">
        <figure class="product-image-area">
            <a href="{{ route('product.show', $product->slug) }}" title="{{ $product->name }}" class="product-image">
                <img src="{{ $product->getImageAttribute()->mediumUrl }}" alt="{{ $product->name }}">
            </a>
            @if($product->getDiscountPercentage() != 0)
                <div class="product-label">
                    <span class="discount">-{{ $product->getDiscountPercentage() }}%</span>
                </div>
            @endif
        </figure>
        <div class="product-details-area">
            <h2 class="product-name">
                <a href="{{ route('product.show', $product->slug) }}" title="{{ $product->name }}">
                    {{ $product->name }}
                </a>
            </h2>
            <div class="product-ratings">
                <div class="ratings-box">
                    <div class="rating" style="width:{{ $product->getRatingPercentage() }}%"></div>
                </div>
            </div>

            <div class="product-short-desc">
                {!! $product->short_description !!}
            </div>

            @unless($product->disable_price)
                <div class="product-price-box">
                    @if(null !== $product->getSalePriceAttribute())
                        <span class="old-price">NRS {{ $product->getRegularPriceAttribute() }}</span>
                        <span class="product-price">NRS {{ $product->getSalePriceAttribute() }}</span>
                    @else
                        <span class="product-price">NRS {{ $product->getRegularPriceAttribute() }}</span>
                    @endif
                </div>
            @endunless
@if ( auth()->guest() )

                                                @unless($product->disable_price)
                                                    <div class="product-price-box">
                                                        @if(null !== $product->getSalePriceAttribute())
                                                            <span class="old-price">NRS {{ $product->getRegularPriceAttribute() }}</span>
                                                            <span class="product-price">NRS {{ $product->getSalePriceAttribute() }}</span>
                                                        @else
                                                            <span class="product-price">NRS {{ $product->getRegularPriceAttribute() }}</span>
                                                        @endif
                                                    </div>
                                                @endunless
                                                   @else
                                          <div class="product-price-box">
                                                        @if(null !== $product->getSalePriceAttribute())
                                                            <span class="old-price">NRS {{ $product->getRegularPriceAttribute() }}</span>
                                                            <span class="product-price">NRS {{ $product->getSalePriceAttribute() }}</span>
                                                        @else
                                                            <span class="product-price">NRS {{ $product->getRegularPriceAttribute() }}</span>
                                                        @endif
                                                    </div>
                                                               @endif
            <div class="product-actions" data-product="{{ $product->id }}">
                  @if ( auth()->guest() )
                                                    @if($product->disable_price)
                                                        <a href="{{ route('enquiry', 'product=' . $product->slug) }}"
                                                           class="enquiry" title="Enquiry"
                                                           data-loading-text="Loading...">
                                                            <i class="fa fa-info"></i>
                                                            <span>Enquiry</span>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0);" class="addtocart"
                                                           title="Add to Cart"
                                                           data-loading-text="Loading...">
                                                            <i class="fa fa-shopping-cart"></i>
                                                            <span>Add to Cart</span>
                                                        </a>
                                                    @endif
                                                        
                                                @else
                                                        <a href="javascript:void(0);" class="addtocart"
                                                           title="Add to Cart"
                                                           data-loading-text="Loading...">
                                                            <i class="fa fa-shopping-cart"></i>
                                                            <span>Add to Cart</span>
                                                        </a>
                                                    @endif

                <a href="javascript:void(0);" class="addtowishlist" title="Add to Wishlist">
                    <i class="fa fa-heart"></i>
                </a>
                <a href="javascript:void(0);" class="comparelink" title="Add to Compare" data-loading-text="...">
                    <i class="glyphicon glyphicon-signal"></i>
                </a>
                <a href="javascript:void(0);" class="quickview" title="Quick View" data-product="{{ $product->id }}">
                    <i class="fa fa-search"></i>
                </a>
            </div>
        </div>
    </div>
</li>