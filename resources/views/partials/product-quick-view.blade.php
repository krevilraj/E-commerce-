<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="product-view">
                <div class="product-essential mb-lg">
                    <div class="row">

                        <div class="product-img-box col-sm-6">
                            <div class="product-img-box-wrapper">

                                <div class="product-img-wrapper">
                                    <img id="product-zoom"
                                         src="{{ $product->getImageAttribute()->largeUrl }}"
                                         data-zoom-image="{{ $product->getImageAttribute()->largeUrl }}"
                                         alt="Product main image">
                                </div>
                            </div>
                        </div>

                        <div class="product-details-box col-sm-6">
                            <h1 class="product-name mt-none">{{ $product->name }}</h1>
                            <div class="product-rating-container">
                                <div class="product-ratings">
                                    <div class="ratings-box">
                                        <div class="rating" style="width:{{ $product->getRatingPercentage() }}%"></div>
                                    </div>
                                </div>
                            </div>

                            @if($product->short_description)
                                <div class="product-short-desc">
                                    <p>{{ excerpt($product->short_description, 40) }}</p>
                                </div>
                            @endif

                            <div class="product-detail-info">
                                @if ( auth()->guest() )
                                @unless($product->disable_price)
                                    <div class="product-price-box">
                                        @if(null !== $product->getSalePriceAttribute())
                                            <span class="old-price">RS{{ $product->getRegularPriceAttribute() }}</span>
                                            <span class="product-price">RS{{ $product->getSalePriceAttribute() }}</span>
                                        @else
                                            <span class="product-price">RS{{ $product->getRegularPriceAttribute() }}</span>
                                        @endif
                                    </div>
                                @endunless
@else 
<div class="product-price-box">
                                        @if(null !== $product->getSalePriceAttribute())
                                            <span class="old-price">RS{{ $product->getRegularPriceAttribute() }}</span>
                                            <span class="product-price">RS{{ $product->getSalePriceAttribute() }}</span>
                                        @else
                                            <span class="product-price">RS{{ $product->getRegularPriceAttribute() }}</span>
                                        @endif
                                    </div>
@endif

                                <p class="availability">
                                    <span class="font-weight-semibold">Availability:</span>
                                    {{ $product->in_stock != 0 ? 'In Stock' : 'Out Of Stock' }}
                                </p>
                            </div>

                            <div class="product-actions" data-product="{{ $product->id }}">
                               
                                    <div class="product-detail-qty">
                                        <input type="text" value="1" class="vertical-spinner" id="product-vqty">
                                    </div>
                                @if ( auth()->guest() )

                                @if($product->disable_price)
                                    <a href="{{ route('enquiry', 'product=' . $product->slug) }}" class="enquiry"
                                       title="Enquiry">
                                        <i class="fa fa-info"></i>
                                        <span>Enquiry</span>
                                    </a>
                                @else
                                    <a href="javascript:void(0);"
                                       class="addtocart @if($product->in_stock != 1) disabled @endif"
                                       title="Add to Cart" data-loading-text="Loading...">
                                        <i class="fa fa-shopping-cart"></i>
                                        <span>Add to Cart</span>
                                    </a>
                                @endif
                                     @else
               <a href="javascript:void(0);"
                                       class="addtocart @if($product->in_stock != 1) disabled @endif"
                                       title="Add to Cart" data-loading-text="Loading...">
                                        <i class="fa fa-shopping-cart"></i>
                                        <span>Add to Cart</span>
                                    </a>
                                  @endif
                                <div class="actions-right" data-product="{{ $product->id }}">
                                    <a href="javascript:void(0);" class="addtowishlist" title="Add to Wishlist">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="comparelink" title="Add to Compare"
                                       data-loading-text="...">
                                        <i class="glyphicon glyphicon-signal"></i>
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>