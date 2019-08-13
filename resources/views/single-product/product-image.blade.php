@php
    $image = $product->getImageAttribute();

@endphp
<div class="product-img-box col-sm-5">
    <div class="product-img-box-wrapper">
        <div class="product-img-wrapper">
            <img id="product-zoom" src="{{ $image->largeUrl }}"
                 data-zoom-image="{{ $image->largeUrl }}"
                 alt="Product main image">
        </div>

        <a href="#" class="product-img-zoom" title="Zoom">
            <span class="glyphicon glyphicon-search"></span>
        </a>
    </div>

    @if($product->getProductGallery())
        <div class="owl-carousel manual" id="productGalleryThumbs">
            @foreach($product->getProductGallery() as $gallery)
                <div class="product-img-wrapper">
                    <a href="javascript:void(0
                    );" data-image="{{ $gallery->largeUrl }}"
                       data-zoom-image="{{ $gallery->largeUrl }}"
                       class="product-gallery-item">
                        <img src="{{ $gallery->mediumUrl }}" alt="product">
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>