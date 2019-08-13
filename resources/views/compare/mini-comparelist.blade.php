<a href="#">
    <i class="fa fa-retweet"></i> Compare ({{ count($compareList) }})
</a>

<div class="compare-dropdownmenu">
    <div class="dropdownmenu-wrapper">
        @if(count($compareList))
            <ul class="compare-products">
                @foreach($compareList as $compare)
                    <li class="product">
                        <form action="{{ route('compare.clear', $compare->rowId) }}"
                              method="post">
                            {{ csrf_field() }}
                            <button type="submit" class="btn-link btn-remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </form>
                        <h4 class="product-name">
                            <a href="{{ route('product.show', getProductSlug($compare->id)) }}">{{ $compare->name }}</a>
                        </h4>
                    </li>
                @endforeach
            </ul>

            <div class="compare-actions">
                <form action="{{ route('compare.clearall') }}" method="post">
                    {{ csrf_field() }}
                    <button type="submit" class="btn-link action-link">Clear All</button>
                </form>
                <a href="{{ route('compare') }}" class="btn btn-primary">Compare</a>
            </div>
        @else
            <div class="compare-list-empty">
                <span>No products in compare list.</span>
            </div>
        @endif
    </div>
</div>