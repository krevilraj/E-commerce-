@extends('layouts.app')
@push('scripts')
<!-- Sweetalert2 -->
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('content')
    <div class="modal fade" id="quickViewModal" tabindex="-1"></div>

     <div class="banners-container">
        <div class="container">
            <div class="row">
                @if($slideshows->isNotEmpty())
                    <div class="slider-area">
                        <div class="owl-carousel owl-theme" data-plugin-options="{'items':1, 'loop': true,'autoplay':true,'autoplayTimeout':6000}">
                            @foreach($slideshows as $slideshow)
                                <a href="{{$slideshow->link}}" class="banner">
                                    <img src="{{ optional($slideshow->getImage())->largeSlideshowUrl }}"
                                         alt="Banner">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="side-area">
                    <div class="home-side-menu-container">
                        <h2 class="side-menu-title">CATEGORIES</h2>
                        <ul class="home-side-menu">
                            @foreach($categoryMenuList as $menu)
                                <li class="{{ !empty($menu['child']) ? ' dropdown-full-color dropdown-primary' : '' }}">
                                    <a class="{{ !empty($menu['child']) ? 'dropdown-toggle' : '' }}"
                                       href="{{ $menu['link'] }}">
                                        {{ $menu['label'] }} @if(!empty($menu['child'])) <i
                                                class="fa fa-caret-right"></i> @endif
                                    </a>
                                    @include('partials.menu', ['menu' => $menu, 'menu_id' => 'category'])
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="homepage-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <i class="fa fa-shopping-bag bar-icon"></i>
                    <div class="bar-textarea">
                        <a href="#" data-toggle="modal" data-target="#requestModal" style="text-decoration:none" ><h3>Requst New Product</h3></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <i class="fa fa-product-hunt bar-icon"></i>
                    <div class="bar-textarea">
                        <a href="#" style="text-decoration:none"><h3>Get Project Consulting</h3></a>

                    </div>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-building bar-icon"></i>
                    <div class="bar-textarea">
                        <a href="#" style="text-decoration:none"><h3>Build Project With Us</h3></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="requestModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <h1 style="text-align: center;color: white;background-color: #57BC90;margin-top: -20px;padding-top: 10px;padding-bottom: 10px"><strong>Request New Product</strong></h1>

                <div class="modal-body" style="color: Black;">





                                            <div class="alert alert-danger alert-request">Please Fill All The Forms Correctly!!</div>
                    <form >
                        {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-6">
                    <div class="form-group">

                        <label for="name">Name <span class="required">*</span></label>
                        <input type="text" value="" data-msg-required="Please enter your name."
                               maxlength="100" class="form-control" name="name" id="name1" required autofocus>
                    </div>

                                </div>
                                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" value="" data-msg-required="Please enter your email address."
                               data-msg-email="Please enter a valid email address." maxlength="100"
                               class="form-control" name="email" id="email1" required>
                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                        <div class="form-group">
                            <label for="phone">Phone No <span class="required">*</span></label>
                            <input type="text" value="" data-msg-required="Please enter your phone number."
                                   data-msg-email="Please enter a valid email address." maxlength="13"
                                   class="form-control" name="phone" id="phone1" required>
                        </div>
                                </div>

                                    <div class="col-sm-6">
                    <div class="form-group">
                        <label for="subject">Product Title <span class="required">*</span> </label>
                        <input type="text" value="" data-msg-required="Please enter the subject."
                               maxlength="100" class="form-control" name="subject" id="subject1" required>
                    </div>
                                    </div>

                            </div>


                    <div class="form-group mb-lg">
                        <label for="message">Product Specification <span class="required">*</span></label>
                        <textarea maxlength="5000" data-msg-required="Please enter your message." rows="5"
                                  class="form-control" name="message" id="message1" required></textarea>
                    </div>

                        <div class="row">

                                <div class="col-sm-6">
                        <div class="form-group">
                            <label for="subject">Product Refrence Link </label>
                            <input type="text" value="" data-msg-required="Please enter the link."
                                   maxlength="100" class="form-control" name="link" id="link" >
                        </div>
                                </div>

                                <div class="col-sm-6">
                        <div class="form-group">
                            <label for="subject">Application Of Product </label>
                            <input type="text" value="" data-msg-required="Please enter the application of product."
                                   maxlength="100" class="form-control" name="application" id="application" >
                        </div>
                                </div>
                        </div>

                    <input type="checkbox" onchange="document.getElementById('send').disabled = !this.checked"/> Check
                    If You Are A Human
                    <br>

                    <input type="submit" class="btn btn-primary btn-request" id="send"
                            data-loading-text="Loading..." value="Request" disabled>
                    </button>


                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="container mb-sm">
        <div class="row">
            <div class="col-md-12 normal">
                <div class="tabs home-products-tab">
                    <ul class="nav nav-links">
                        @foreach(json_decode(getConfiguration('products_section_1')) as $configuration)
                            <li class="{{ $loop->first ? 'active' : '' }}">
                                <a href="#products_section_1{{ $loop->index }}"
                                   data-toggle="tab">{{ $configuration }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-lg">
                        @foreach(json_decode(getConfiguration('products_section_1')) as $configuration)
                            <div id="products_section_1{{ $loop->index }}"
                                 class="tab-pane {{ $loop->first ? 'active' : '' }}">
                                <div class="owl-carousel owl-theme manual featured-products-carousel">
                                    @foreach(getProductsByCategory($configuration) as $product)
                                        <div class="product">
                                            <figure class="product-image-area">
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                   title="Product Name"
                                                   class="product-image">
                                                    <img src="{{ $product->getImageAttribute()->mediumUrl }}"
                                                         alt="{{ $product->name }}">
                                                </a>

                                                <a href="#" class="product-quickview"
                                                   data-product="{{ $product->id }}">
                                                    <i class="fa fa-share-square-o"></i>
                                                    <span>Quick View</span>
                                                </a>
                                                @if($product->getDiscountPercentage() != 0)
                                                    <div class="product-label">
                                                    <span class="discount">-{{ $product->getDiscountPercentage() }}
                                                        %</span>
                                                    </div>
                                                @endif
                                            </figure>
                                            <div class="product-details-area">
                                                <h2 class="product-name">
                                                    <a href="{{ route('product.show', $product->slug) }}"
                                                       title="{{ $product->name }}">{{ $product->name }}</a>
                                                </h2>
                                                <div class="product-ratings">
                                                    <div class="ratings-box">
                                                        <div class="rating"
                                                             style="width:{{ $product->getRatingPercentage() }}%"></div>
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

                                                <div class="product-actions" data-product="{{ $product->id }}">
                                                    <a href="javascript:void(0);" class="addtowishlist"
                                                       title="Add to Wishlist">
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
                                                    <a href="javascript:void(0);" class="comparelink"
                                                       title="Add to Compare" data-loading-text="...">
                                                        <i class="glyphicon glyphicon-signal"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container mb-sm">
        <div class="row">
            <div class="col-md-12 normal">
                <div class="tabs home-products-tab">
                    <ul class="nav nav-links">
                        @foreach(json_decode(getConfiguration('products_section_2')) as $configuration)
                            <li class="{{ $loop->first ? 'active' : '' }}">
                                <a href="#products_section_1{{ $loop->index }}"
                                   data-toggle="tab">{{ $configuration }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-lg">
                        @foreach(json_decode(getConfiguration('products_section_2')) as $configuration)
                            <div id="products_section_1{{ $loop->index }}"
                                 class="tab-pane {{ $loop->first ? 'active' : '' }}">
                                <div class="owl-carousel owl-theme manual featured-products-carousel">
                                    @foreach(getProductsByCategory($configuration) as $product)
                                        <div class="product">
                                            <figure class="product-image-area">
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                   title="Product Name"
                                                   class="product-image">
                                                    <img src="{{ $product->getImageAttribute()->mediumUrl }}"
                                                         alt="{{ $product->name }}">
                                                </a>

                                                <a href="" class="product-quickview"
                                                   data-product="{{ $product->id }}">
                                                    <i class="fa fa-share-square-o"></i>
                                                    <span>Quick View</span>
                                                </a>
                                                @if($product->getDiscountPercentage() != 0)
                                                    <div class="product-label">
                                                    <span class="discount">-{{ $product->getDiscountPercentage() }}
                                                        %</span>
                                                    </div>
                                                @endif
                                            </figure>
                                            <div class="product-details-area">
                                                <h2 class="product-name">
                                                    <a href="{{ route('product.show', $product->slug) }}"
                                                       title="{{ $product->name }}">{{ $product->name }}</a>
                                                </h2>
                                                <div class="product-ratings">
                                                    <div class="ratings-box">
                                                        <div class="rating"
                                                             style="width:{{ $product->getRatingPercentage() }}%"></div>
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

                                                <div class="product-actions" data-product="{{ $product->id }}">
                                                    <a href="javascript:void(0);" class="addtowishlist"
                                                       title="Add to Wishlist">
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
                                                    <a href="javascript:void(0);" class="comparelink"
                                                       title="Add to Compare" data-loading-text="...">
                                                        <i class="glyphicon glyphicon-signal"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>



    <div class="container mb-md">
        <div class="row">
            <div class="col-md-12 normal">
                <div class="tabs home-products-tab">
                    <h1 class="slider-title v2 heading-primary font-lg">Top Products</h1>
                    <ul class="nav nav-links">
                        @foreach(json_decode(getConfiguration('products_section_4')) as $configuration)
                            <li class="{{ $loop->first ? 'active' : '' }}">
                                <a href="#products_section_4{{ $loop->index }}"
                                   data-toggle="tab">{{ $configuration }}</a>
                            </li>
                        @endforeach


                    </ul>
                    <div class="tab-content mt-lg">
                        @foreach(json_decode(getConfiguration('products_section_4')) as $configuration)
                            <div id="products_section_4{{ $loop->index }}"
                                 class="tab-pane {{ $loop->first ? 'active' : '' }}">
                                <div class="owl-carousel owl-theme manual featured-products-carousel">
                                    @foreach(getProductsByCategory($configuration) as $product)
                                        <div class="product">
                                            <figure class="product-image-area">
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                   title="{{ $product->name }}"
                                                   class="product-image">
                                                    <img src="{{ $product->getImageAttribute()->mediumUrl }}"
                                                         alt="{{ $product->name }}">
                                                </a>

                                                <a href="#" class="product-quickview"
                                                   data-product="{{ $product->id }}">
                                                    <i class="fa fa-share-square-o"></i>
                                                    <span>Quick View</span>
                                                </a>
                                                @if($product->getDiscountPercentage() != 0)
                                                    <div class="product-label">
                                                    <span class="discount">-{{ $product->getDiscountPercentage() }}
                                                        %</span>
                                                    </div>
                                                @endif
                                            </figure>
                                            <div class="product-details-area">
                                                <h2 class="product-name">
                                                    <a href="{{ route('product.show', $product->slug) }}"
                                                       title="{{ $product->name }}">{{ $product->name }}</a>
                                                </h2>
                                                <div class="product-ratings">
                                                    <div class="ratings-box">
                                                        <div class="rating"
                                                             style="width:{{ $product->getRatingPercentage() }}%"></div>
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


                                                <div class="product-actions" data-product="{{ $product->id }}">
                                                    <a href="javascript:void(0);" class="addtowishlist"
                                                       title="Add to Wishlist">
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
                                                    <a href="javascript:void(0);" class="comparelink"
                                                       title="Add to Compare" data-loading-text="...">
                                                        <i class="glyphicon glyphicon-signal"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <section

            class="parallax section section-text-light section-parallax section-center section-overlay-opacity section-overlay-opacity-scale-8 mt-none mb-50"
            data-plugin-parallax
            data-plugin-options="{'speed': 1.5}" data-image-src="{{url('storage') . '/'. 'background/background.jpeg' }} ">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="owl-carousel owl-theme nav-bottom rounded-nav"
                         data-plugin-options="{'items': 1, 'loop': true, 'autoplay': true}">

                        @foreach($testimonials as $testimonial)
                            <div>

                                <div class="col-md-12">
                                    <div class="testimonial testimonial-style-2 testimonial-with-quotes mb-none">
<p style="color: #c1bdbd;font-size: 30px;font-family: museo-slab;/* height: 25px; */padding-bottom: 0px;margin-bottom: 0;"><strong>What Our Customers Say </strong></p>
                                        <div class="testimonial-author">
                                        
                                            <img src="{{ null === $testimonial->getImage()  ? $testimonial->getDefaultImage('uploads/avatar.jpg')->url : $testimonial->getImage()->smallUrl }}"
                                                 class="img-responsive img-circle" alt="">
                                        </div>


                                        <blockquote>
                                            {!! $testimonial->content !!}
                                        </blockquote>
                                        <div class="testimonial-author">
                                            <p><strong>{{ $testimonial->client_name }}</strong>
                                                @if($testimonial->client_company)
                                                    <span>{{ $testimonial->client_company }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <a href="/testimonials" class="btn btn-primary btn-sm" style="margin-top: 40px;">View
                                    All</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mb-xlg">
        <h2 class="slider-title">
            <span class="inline-title">TOP CLIENTS</span>
            <span class="line"></span>
            <a href="{{ route('brands') }}" class="view-all">View All</a>
        </h2>

        <div class="owl-carousel owl-theme manual clients-carousel owl-no-narrow mb-sm">
            @foreach($brands as $brand)
                <a href="{{ $brand->link }}" title="{{ $brand->name }}" class="client" target="_blank">
                    <img class="img-responsive" src="{{ optional($brand->getImage())->url }}" alt="{{ $brand->name }}">
                </a>
            @endforeach
        </div>
    </div>

    @if($latestPosts)
        <div class="container">
            <h2 class="slider-title">
                <span class="inline-title">FROM THE BLOG</span>
                <span class="line"></span>
                <a href="{{ route('blog') }}" class="view-all">View All</a>
            </h2>

            <div class="owl-carousel owl-theme manual recent-posts-carousel mb-sm">
                @foreach($latestPosts as $latestPost)
                    <article class="post">
                        <div class="row">
                            <div class="col-sm-5">
                                @if(optional($latestPost->getImage())->mediumBlogUrl)
                                    <div class="post-image">
                                        <div class="img-thumbnail">
                                            <img class="img-responsive"
                                                 src="{{ optional($latestPost->getImage())->mediumBlogUrl }}"
                                                 alt="Post">
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-sm-7">
                                <div class="post-date">
                                    <span class="day">{{ Carbon\Carbon::parse($latestPost->created_at)->format('d') }}</span>
                                    <span class="month">{{ Carbon\Carbon::parse($latestPost->created_at)->format('M') }}</span>
                                </div>
                                <h2>
                                    <a href="{{ route('post.show', $latestPost->slug) }}">{{ $latestPost->title }}</a>
                                </h2>

                                <div class="post-content">

                                    <p>{{ excerpt($latestPost->content, 12) }}</p>

                                    <a href="{{ route('post.show', $latestPost->slug) }}" class="btn btn-link">Read
                                        more</a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<!-- Revolution Slider -->
<script src="{{ asset('vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script>
<!-- Sweetalert2 -->
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

<script>

    function UpdateMiniCart() {
        $.ajax({
            type: "GET",
            url: "{{ route('cart.mini')  }}",
            beforeSend: function (data) {
                //
            },
            success: function (data) {
                $('#mini-cart').html(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //
            },
            complete: function () {
                //
            }
        });
    }

    function UpdateCompareList() {
        $.ajax({
            type: "GET",
            url: "{{ route('comparelist.mini')  }}",
            success: function (data) {
                $('#compare-dropdown').html(data);
            }
        });
    }

    function sweetAlert(type, title, message) {
        swal({
            title: title,
            html: message,
            type: type,
            confirmButtonColor: '#57BC90',
            timer: 20000
        }).catch(swal.noop);
    }

    // Add product to cart
    $(document).on("click", ".addtocart", function (e) {
        e.preventDefault();
        var $this = $(this);
        var product = $this.parent().attr('data-product');
        var quantity = $this.siblings('.product-detail-qty').find('#product-vqty').val();
        quantity = quantity ? quantity : 1;

        if (product) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('cart.store')  }}",
                data: {
                    product: product,
                    quantity: quantity
                },
                beforeSend: function (data) {
                    $this.button('loading');
                },
                success: function (data) {
                    if (data.status) {
                        sweetAlert('success', 'Success', data.message + '<a href="{{ route('cart.index') }}"> View Cart</a>');
                    }

                    UpdateMiniCart();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    sweetAlert('error', 'Oops...', 'Something went wrong!');
                },
                complete: function () {
                    $this.button('reset');
                }
            });
        }

    });


    // Add product to enquiry list
    $(document).on("click", ".enquiry", function (e) {
        e.preventDefault();
        var $this = $(this);
        var product = $this.parent().attr('data-product');

        if (product) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('enquiry.list.store')  }}",
                data: {
                    product: product
                },
                beforeSend: function () {
                    $this.button('loading');
                },
                success: function (data) {
                    if (data.status) {
                        sweetAlert('success', 'Success', data.message + '<a href="{{ route('enquiry') }}"> View Enquiry List</a>');
                    }
                },
                 error: function (xhr, ajaxOptions, thrownError) {
                    var err;
                    if (xhr.status === 401) {
                        err = eval("(" + xhr.responseText + ")");
                        sweetAlert('error', 'Oops...', err.message + '<a href="{{ route('login') }}"> Login</a>');
                        return false;
                    }

                    sweetAlert('error', 'Oops...', 'Something went wrong!');
                },
                complete: function () {
                    $this.button('reset');
                }
            });
        }

    });

    // Add product to wishlist
    $(document).on("click", ".addtowishlist", function (e) {
        e.preventDefault();
        var $this = $(this);
        var product = $this.parent().attr('data-product');

        if (product) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('wishlist.store')  }}",
                data: {
                    product: product
                },
                beforeSend: function (data) {
                    $this.prop('disabled', true);
                },
                success: function (data) {
                    if (data.status) {
                        sweetAlert('success', 'Success', data.message + '<a href="{{ route('my-account.wishlist') }}"> View Wishlist</a>');
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var err;
                    if (xhr.status === 401) {
                        err = eval("(" + xhr.responseText + ")");
                        sweetAlert('error', 'Oops...', err.message + '<a href="{{ route('login') }}"> Login</a>');
                        return false;
                    }

                    sweetAlert('error', 'Oops...', 'Something went wrong!');
                },
                complete: function () {
                    $this.prop('disabled', false);
                }
            });
        }

    });

    // Add product to compare list
    $(document).on("click", ".comparelink", function (e) {
        e.preventDefault();
        var $this = $(this);
        var product = $this.parent().attr('data-product');

        if (product) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('compare.store')  }}",
                data: {
                    product: product
                },
                beforeSend: function () {
                    $this.button('loading');
                },
                success: function (data) {
                    if (data.status) {
                        sweetAlert('success', 'Success', data.message + '<a href="{{ route('compare') }}"> View Compare List</a>');
                    }

                    UpdateCompareList();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //
                },
                complete: function () {
                    $this.button('reset');
                }
            });
        }

    });

    /**
     * Load Product Modal
     *
     * @type {*|jQuery|HTMLElement}
     */
    var $modal = $('#quickViewModal');
    $(".product-quickview").click(function (e) {
        e.preventDefault();
        $modal.load("{{ route('product.quick.view') }}" + "?product=" + $(this).attr("data-product"), function (response) {
            $modal.modal({show: true});
            // Vertical Spinner - Touchspin - Product Details Quantity input
            if ($.fn.TouchSpin) {
                $('#product-vqty').TouchSpin({
                    verticalbuttons: true
                });
            }
        });
    });
</script>
<script>
    $(document).on("click", ".btn-request", function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{route('request-product.post')}}",
            data: {name: $('#name1').val(), email: $('#email1').val(),subject: $('#subject1').val(),message: $('#message1').val(),link: $('#link').val(),application: $('#application').val(),phone: $('#phone1').val()},
            beforeSend: function () {
                $this.button('loading');
            },
            success: function (data) {
                $(location).attr('href', '{{ route('request.confirmed') }}');

            },
            error: function (xhr, ajaxOptions, thrownError) {
                var errorsHolder = '';
                errorsHolder += '<ul>';

                var err = eval("(" + xhr.responseText + ")");
                $.each(err.errors, function (key, value) {
                    errorsHolder += '<li>' + value + '</li>';
                });
               

                errorsHolder += '</ul>';

                $this.closest('form').find('.alert-request.alert-danger').fadeIn().html(errorsHolder);

            },
            complete: function () {
                $this.button('reset');
            }
        });

    });

</script>
@endpush
