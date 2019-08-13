<aside class="col-md-3 col-md-pull-9 sidebar shop-sidebar">
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" href="#panel-filter-category">
                        Categories
                    </a>
                </h4>
            </div>
            <div id="panel-filter-category" class="accordion-body collapse in">
                <div class="panel-body">
                    <ul>
                        @if($childProduct)
                        @foreach($childProduct as $category)
                            <li>
                                <a href="{{ route('welcome') . '/category/' . $category->slug }}">{{ $category->name }}</a>
                            </li>
                        @endforeach

                            @else

                            @foreach($productCategories as $category)
                                <li>
                                    <a href="{{ route('welcome') . '/category/' . $category->slug }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                            @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" href="#panel-filter-price">
                        Price
                    </a>
                </h4>
            </div>
            <div id="panel-filter-price" class="accordion-body collapse in">
                <div class="panel-body">
                    <form action="{{ url()->current() }}" method="get">
                        <div class="filter-price">
                            <div id="price-slider"></div>
                            <div class="filter-price-details">
                                <span>from</span>
                                <input type="text" name="min_price" id="price-range-low"
                                       class="form-control" placeholder="Min">
                                <span>to</span>
                                <input type="text" name="max_price" id="price-range-high"
                                       class="form-control" placeholder="Max">
                                <button type="submit" class="btn btn-primary">FILTER</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{--<div class="panel panel-default">--}}
            {{--<div class="panel-heading">--}}
                {{--<h4 class="panel-title">--}}
                    {{--<a class="accordion-toggle" data-toggle="collapse" href="#panel-filter-brand">--}}
                        {{--Brands--}}
                    {{--</a>--}}
                {{--</h4>--}}
            {{--</div>--}}
            {{--<div id="panel-filter-brand" class="accordion-body collapse in">--}}
                {{--<div class="panel-body">--}}
                    {{--<ul>--}}
                        {{--@foreach($brands as $brand)--}}
                            {{--<li><a href="{{ $brand->link }}">{{ $brand->name }}</a></li>--}}
                        {{--@endforeach--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>

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
</aside>