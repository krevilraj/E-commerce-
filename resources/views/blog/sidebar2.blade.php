<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading"><h4 style="
    padding-top: 10px;
    padding-left: 10px;
">Latest Products</h4></div>


<div class="owl-carousel owl-theme"
     data-plugin-options="{'items':1, 'margin': 5, 'dots': false, 'nav': true}">
    @foreach($lat->chunk(2) as $items)
        <div>
            @foreach($items as $item)

                    <div class="product product-sm">
                        <figure class="product-image-area">
                            <a href="{{ route('product.show', $item->slug) }}" title="{{ $item->name }}"
                               class="product-image">
                                <img src="{{ $item->getImageAttribute()->smallUrl }}"
                                     alt="{{ $item->name }}">
                            </a>
                        </figure>
                        <div class="product-details-area">
                            <h2 class="product-name">
                                <a href="{{ route('product.show', $item->slug) }}"
                                   title="{{ $item->name }}">
                                    {{ $item->name }}
                                </a>
                            </h2>
                            <div class="product-ratings">
                                <div class="ratings-box">
                                    <div class="rating"
                                         style="width:{{ $item->getRatingPercentage() }}%"></div>
                                </div>
                            </div>

                            <div class="product-price-box">
                                <span class="product-price">RS{{ $item->getPrice() }}</span>
                            </div>
                        </div>
                    </div>

                @endforeach
        </div>
@endforeach
</div>
    </div>
</div>