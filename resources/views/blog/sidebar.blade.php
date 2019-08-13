<h4>Featured</h4>
<div class="owl-carousel owl-theme"
     data-plugin-options="{'items':1, 'margin': 5, 'dots': false, 'nav': true}">
    @foreach($products->chunk(4) as $items)
        <div>
            @foreach($items as $item)
                @if($item->is_featured == 1)
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
@endif
                @endforeach
        </div>
@endforeach
</div>
<div class="container" style="width: 100%;height: 185px;padding-left: 0;">
	<img src="{{ url('storage') . '/' . getConfiguration('ad')  }} " style="height: 185px;">
</div>