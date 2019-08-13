@extends('layouts.app')
@push('styles')
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5805b7e129ea8bc1"></script>
<!-- Sweetalert2 -->
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}">
@endpush
@section('meta')
<meta property="fb:pages" content="1488263534737263" />
<meta property="og:title" content="{{$product->name}}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{URL::to('/')}}/product/{{$product->slug}}" />
<meta property="og:site_name" content="{{getConfiguration('company_name')}}" />
<meta property="og:image" content="{{$product->getImageAttribute()->largeUrl}}" />
<meta property="og:image:type" content="image/png" />
<meta property="og:image:width" content="1700" />
<meta property="og:image:height" content="811" />
<meta property="og:description" content="{!!$product->short_description!!}" />
<meta property="fb:app_id" content="1957440451175188" />


<meta name="twitter:card" value="summary_large_image" />
<meta name="twitter:url" value="{{URL::to('/')}}/product/{{$product->slug}}" />
<meta name="twitter:title" value="{{$product->name}}" />
<meta name="twitter:description" value="{{$product->short_description}}" />
<meta name="twitter:image" value="{{$product->getImageAttribute()->largeUrl}}" />
<meta name="twitter:site" value="{{URL::to('/')}}" />
<meta name="twitter:creator" value="" />

@endsection

@section('content')
    <div class="modal fade" id="quickViewModal" tabindex="-1"></div>

    <section class="page-header mb-lg">

        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('shop') }}">Shop</a></li>
                <li class="active">{{ $product->name }}</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="product-view">
            <div class="product-essential">
                <div class="row">

                    <div class="col-md-12">
                        @include('partials.message-success')
                        @include('partials.message-error')

                        <div class="alert alert-success alert-message"></div>

                        <div class="alert alert-danger alert-message"></div>
                    </div>

                    @include('single-product.product-image')

                    <div class="product-details-box col-sm-7">
                        <div class="product-nav-container">
                            @if($previousProduct)
                                <div class="product-nav product-nav-prev">
                                    <a href="{{ route('product.show', $previousProduct->slug) }}"
                                       title="Previous Product">
                                        <i class="fa fa-chevron-left"></i>
                                    </a>

                                    <div class="product-nav-dropdown">
                                        <img src="{{ $previousProduct->getImageAttribute()->smallUrl }}" alt="Product">
                                        <h4>{{ $previousProduct->name }}</h4>
                                    </div>
                                </div>
                            @endif
                            @if($nextProduct)
                                <div class="product-nav product-nav-next">
                                    <a href="{{ route('product.show', $nextProduct->slug) }}" title="Next Product">
                                        <i class="fa fa-chevron-right"></i>
                                    </a>

                                    <div class="product-nav-dropdown">
                                        <img src="{{ $nextProduct->getImageAttribute()->smallUrl }}" alt="Product">
                                        <h4>{{ $nextProduct->name }}</h4>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <h1 class="product-name">
                            {{ $product->name }}
                        </h1>

                        <div class="product-rating-container">
                            <div class="product-ratings">
                                <div class="ratings-box">
                                    <div class="rating" style="width:{{ $product->getRatingPercentage() }}%"></div>
                                </div>
                            </div>
                            <div class="review-link">
                                <a href="#product-reviews" class="review-link-in" data-toggle="tab" rel="nofollow">
                                    <span class="count">{{ count($product->getReviews()) }}</span> customer reviews</a>
                                |
                                <a href="#product-reviews" class="write-review-link" data-toggle="tab" rel="nofollow">Add
                                    a review</a>
                            </div>
                        </div>

                        @if($product->short_description)
                            <div class="product-short-desc">
                                {!! $product->short_description !!}
                            </div>
                        @endif

                        <span class="font-weight-semibold">In Category:</span>

                        @foreach($cats as $category)

                            <li  style="display: inline-block;color: black">
                                <a class="btn " style="padding: 1px 1px 1px 1px;margin-right: 10px" href="{{ route('welcome') . '/category/' . $category->slug }}">{{ $category->name }}</a>
                            </li>

                        @endforeach


                        <div class="product-detail-info">
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
                            <p class="availability">
                                <span class="font-weight-semibold">Availability:</span>
                                {{ $product->in_stock != 0 ? 'In Stock' : 'Out Of Stock' }}
                            </p>
                            <p class="email-to-friend">
                                <a href="javascript:void(0);">Email to a Friend</a>
                            </p>
                        </div>

                        <div class="product-actions" data-product="{{ $product->id }}">
                            @unless($product->disable_price)
                                <div class="product-detail-qty">
                                    <input type="text" value="1" class="vertical-spinner" id="product-vqty">
                                </div>
                            @endunless

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

                        <div class="product-share-box">
                            <div class="addthis_inline_share_toolbox"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tabs product-tabs">
                <ul id="single-product-tabs" class="nav nav-tabs">
                    <li class="active">
                        <a href="#product-specification" data-toggle="tab">Specification</a>

                    </li>


                    @if($product->downloads->count() > 0)
                        <li>
                            <a href="#product-downloads" data-toggle="tab">Downloads</a>
                        </li>
                    @endif
                    @if($product->faqs->count() > 0)
                        <li>
                            <a href="#product-faqs" data-toggle="tab">FAQs</a>
                        </li>
                    @endif
                    <li>
                    @if($product->specifications->count() > 0)
                        <li>
                            <a href="#product-desc" data-toggle="tab">Description</a>

                        </li>
                    @endif
                    <li>
                        <a href="#product-reviews" data-toggle="tab">Reviews</a>
                    </li>
                </ul>
                <div class="tab-content">
                    @if($product->specifications->count() > 0)
                        <div id="product-specification" class="tab-pane active">
                            <table class="product-table">
                                <tbody>
                                @foreach($product->specifications as $specification)
                                    <tr>
                                        <td class="table-label" style="color: black" >{{ $specification->title }}</td>

                                        <td class="table-label" style="color: #777">{{ $specification->description }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div id="product-desc" class="tab-pane ">
                        <div class="product-desc-area">
                            {!! $product->description !!}
                        </div>
                    </div>

                    @if($product->faqs->count() > 0)
                        <div id="product-faqs" class="tab-pane">
                            <div class="toggle toggle-primary" data-plugin-toggle>
                                @foreach($product->faqs as $faq)
                                    <section class="toggle">
                                        <label style="color: black" >{{ $faq->question }}</label>
                                        <p>{{ $faq->answer }}</p>
                                    </section>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($product->downloads->count() > 0)
                        <div id="product-downloads" class="tab-pane">


                            @foreach($product->downloads as $download)




                                @if( File::extension($download->link) == 'pdf' || File::extension($download->link) == 'txt')


                                    <div class="container"
                                         style="width: 100%;margin-bottom: 10px;align-items: center;border-bottom:1px solid #EEE;padding-bottom: 10px">


                                        <div class="table-label col-md-9  " style="color: red">

                                            <h2 style="color: red; font-weight: 500;">  <a href="{{$download->link}}"><div class="visible-xs visible-sm">Download</div> {{$download->title}}</a></h2>

                                        </div>
                                        <div class="table-label col-md-3 hidden-sm hidden-xs">

                                            <h2 style="color: red; font-size: 15px;" class="pull-right"><a href="{{$download->link}}">Download PDF</a> </h2>

                                        </div>

                                        <div class="col-md-offset-2 col-md-8 col-sm-12 col-xs-12 ">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe class="embed-responsive-item" width="100%"
                                                        height="300px"
                                                        src="http://docs.google.com/gview?embedded=true&url={{$download->link}}"></iframe>
                                            </div>
                                        </div>


                                    </div>

                                @elseif( File::extension($download->link) == 'jpeg' )

                                    <div class="container"
                                         style="width: 100%;margin-bottom: 10px;align-items: center;border-bottom:1px solid #EEE;padding-bottom: 10px">


                                        <div class="table-label col-md-12  " style="color: red">

                                            <h2 style="color: red; font-weight: 500;" class="pull-left">  <a href="{{$download->link}}">{{$download->title}}</a></h2>

                                        </div>

                                        <div class="col-md-offset-2 col-md-8 col-sm-12 col-xs-12">

                                            <img src="{{$download->link}}" class="img-responsive">
                                        </div>


                                    </div>

                                @else

                                    <div class="container"
                                         style="width: 100%;margin-bottom: 10px;align-items: center;border-bottom:1px solid #EEE;padding-bottom: 10px">


                                        <div class="table-label col-md-9  " style="color: red">

                                            <h2 style="color: red; font-weight: 500;">  <a href="https://www.youtube.com/watch?v={{$download->link}}"> {{$download->title}}</a></h2>

                                        </div>
                                        <div class="table-label col-md-3 hidden-sm hidden-xs">

                                            <h2 style="color: red; font-size: 15px;" class="pull-right"><a href="https://www.youtube.com/watch?v={{$download->link}}">Watch on YouTube</a> </h2>

                                        </div>


                                        <div class="col-md-offset-2 col-md-8 col-sm-12 col-xs-12">

                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe class="embed-responsive-item"
                                                        src="https://www.youtube.com/embed/{{$download->link}}"
                                                        frameborder="0"
                                                        allowfullscreen></iframe>
                                            </div>

                                        </div>


                                    </div>

                                @endif


                            @endforeach


                        </div>

                    @endif
                    <div id="product-reviews" class="tab-pane">
                        @include('single-product.review',['product' => $product])
                    </div>
                </div>
            </div>
        </div>

        @include('single-product.related-products')

    </div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script>
<script src="{{ asset('vendor/elevatezoom/jquery.elevatezoom.js') }}"></script>
<link href="{{ asset('vendor/bootstrap-star-rating/css/star-rating.css') }}" media="all" rel="stylesheet"
      type="text/css"/>
<script src="{{ asset('vendor/bootstrap-star-rating/js/star-rating.min.js') }}"></script>
<!-- Sweetalert2 -->
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(function () {
        jQuery("#rating").rating({
            'showCaption': false,
            'step': '1',
            'size': 'xs'
        });
    });

    $('a.review-link-in, a.write-review-link').on('shown.bs.tab', function (e) {
        e.preventDefault();
        $('#single-product-tabs').find('.active').removeClass('active');
        $('a[href="' + $(this).attr('href') + '"]').parent().addClass('active');

        var that = this;
        $('html, body').animate({
            scrollTop: $($(that).attr('href')).offset().top
        }, 500);
    });

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
                        $('.alert-message.alert-danger').fadeOut();

                        var message = '<div><span><strong><i class="fa fa-thumbs-o-up"></i>Success!</strong> ';
                        message += data.message;
                        message += '</span><a href="{{ route('cart.index') }}" class="btn btn-xs btn-primary pull-right">View cart</a></div>';

                        $('.alert-message.alert-success').html(message).fadeIn().delay(3000).fadeOut('slow');

                        sweetAlert('success', 'Success', data.message + '<a href="{{ route('cart.index') }}"> View Cart</a>');
                    }

                    UpdateMiniCart();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorsHolder = '';
                    errorsHolder += '<ul>';

                    var err = eval("(" + xhr.responseText + ")");
                    $.each(err.errors, function (key, value) {
                        errorsHolder += '<li>' + value + '</li>';
                    });

                    errorsHolder += '</ul>';

                    $('.alert-message.alert-danger').fadeIn().html(errorsHolder);
                    sweetAlert('error', 'Oops...', 'Something went wrong!');
                },
                complete: function () {
                    $this.button('reset');
                    //$("html, body").animate({scrollTop: 0}, "slow");
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
                        $('.alert-message.alert-danger').fadeOut();

                        var message = '<div><span><strong><i class="fa fa-thumbs-o-up"></i>Success!</strong> ';
                        message += data.message;
                        message += '</span><a href="{{ route('my-account.wishlist') }}" class="btn btn-xs btn-primary pull-right">View wishlist</a></div>';

                        $('.alert-message.alert-success').html(message).fadeIn().delay(3000).fadeOut('slow');

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
                    //$("html, body").animate({scrollTop: 0}, "slow");
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
@endpush