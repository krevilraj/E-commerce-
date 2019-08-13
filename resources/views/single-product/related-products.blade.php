@if(count($relatedProducts))
    <h2 class="slider-title">
        <span class="inline-title">Related Products</span>
        <span class="line"></span>
    </h2>

    <div class="owl-carousel owl-theme"
         data-plugin-options="{'items':4, 'margin':20, 'nav':true, 'dots': false, 'loop': false}">

        @foreach($relatedProducts as $relatedProduct)
            <div class="product">
                <figure class="product-image-area">
                    <a href="{{ route('product.show', $relatedProduct->slug) }}"
                       title="{{ $relatedProduct->name }}" class="product-image">
                        <img src="{{ optional($relatedProduct->getImageAttribute())->mediumUrl }}" alt="Product Name">
                    </a>

                    <a href="#" class="product-quickview" data-product="{{ $relatedProduct->id }}">
                        <i class="fa fa-share-square-o"></i>
                        <span>Quick View</span>
                    </a>
                    @if($relatedProduct->getDiscountPercentage() != 0)
                        <div class="product-label">
                            <span class="discount">-{{ $relatedProduct->getDiscountPercentage() }}%</span>
                        </div>
                    @endif
                </figure>
                <div class="product-details-area">
                    <h2 class="product-name">
                        <a href="{{ route('product.show', $relatedProduct->slug) }}"
                           title="{{ $relatedProduct->name }}">
                            {{ $relatedProduct->name }}
                        </a>
                    </h2>
                    <div class="product-ratings">
                        <div class="ratings-box">
                            <div class="rating" style="width:{{ $relatedProduct->getRatingPercentage() }}%"></div>
                        </div>
                    </div>

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

                    <div class="product-actions" data-product="{{ $relatedProduct->id }}">
                        <a href="javascript:void(0);" class="addtowishlist" title="Add to Wishlist">
                            <i class="fa fa-heart"></i>
                        </a>

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

                        <a href="javascript:void(0);" class="comparelink" title="Add to Compare" data-loading-text="...">
                            <i class="glyphicon glyphicon-signal"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endif