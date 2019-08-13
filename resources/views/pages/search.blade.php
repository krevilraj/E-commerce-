@extends('layouts.app')
@push('styles')
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}">
@endpush
@section('content')
    <div class="modal fade" id="quickViewModal" tabindex="-1"></div>

    <section class="page-header mb-lg">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="javascript:void(0);">Search</a></li>
                <li class="active">{{ $queryParam }}</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3">
                @if(count($products2) <= 0)
                    <div class="alert alert-danger">
                        No products found.
                    </div>
                @else
                    <div class="toolbar mb-none">
                        <div class="sorter">
                                {{ $products2->setPath(Request::fullUrl()
)->render() }}

                            {{--<div class="sort-by">--}}
                                {{--<form action="{{ url()->current() }}" method="get">--}}
                                    {{--<label for="orderby">Sort by:</label>--}}
                                    {{--<select name="orderby" id="orderby" class="orderby">--}}
                                        {{--<option value="menu_order">Default sorting</option>--}}
                                        {{--<option value="popularity" selected="selected">Sort by popularity</option>--}}
                                        {{--<option value="rating">Sort by average rating</option>--}}
                                        {{--<option value="date">Sort by newness</option>--}}
                                        {{--<option value="price">Sort by price: low to high</option>--}}
                                        {{--<option value="price-desc">Sort by price: high to low</option>--}}
                                    {{--</select>--}}
                                {{--</form>--}}
                            {{--</div>--}}

                            {{--<div class="view-mode">--}}
                                {{--@if(request()->input('view') != 'list')--}}
                                    {{--<span title="Grid">--}}
                                    {{--<i class="fa fa-th"></i>--}}
                                {{--</span>--}}
                                {{--@else--}}
                                    {{--<a href="{{ url()->current() . '?view=grid' }}" title="Grid">--}}
                                        {{--<i class="fa fa-th"></i>--}}
                                    {{--</a>--}}
                                {{--@endif--}}

                                {{--@if(request()->input('view') == 'list')--}}
                                    {{--<span title="List">--}}
                                    {{--<i class="fa fa-list-ul"></i>--}}
                                {{--</span>--}}
                                {{--@else--}}
                                    {{--<a href="{{ url()->current() . '?view=list' }}" title="List">--}}
                                        {{--<i class="fa fa-list-ul"></i>--}}
                                    {{--</a>--}}
                                {{--@endif--}}
                            {{--</div>--}}

                            {{--<div class="limiter">--}}
                                {{--<form action="{{ url()->current() }}" method="get" class="product-viewing">--}}
                                    {{--<label for="count">Show:</label>--}}
                                    {{--<select name="count" id="count" class="count">--}}
                                        {{--<option value="12">12</option>--}}
                                        {{--<option value="24">24</option>--}}
                                        {{--<option value="36">36</option>--}}
                                    {{--</select>--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        </div>
                    </div>

                    <div class="alert alert-success alert-dismissable alert-message mt-sm mb-none">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><i class="fa fa-thumbs-o-up"></i> Success!</strong> Product successfully added to cart.
                    </div>
                    <div class="alert alert-danger alert-dismissable alert-message mt-sm mb-none"></div>

                    <ul class="@if(request()->has('view') && request()->input('view') == 'list') products-list @else products-grid columns4 @endif">
                        @foreach($products2 as $product)
                            @if(request()->has('view') && request()->input('view') == 'list')
                                @include('partials.product-list', ['product' => $product])
                            @else
                                @include('partials.product-grid', ['product' => $product])
                            @endif
                        @endforeach
                    </ul>
                                {{ $products2->setPath(Request::fullUrl()
)->render() }}
                    {{--<div class="toolbar-bottom">--}}
                        {{--<div class="toolbar">--}}
                            {{--<div class="sorter">--}}


                                {{--<div class="limiter">--}}
                                    {{--<form action="{{ url()->current() }}" method="get" class="product-viewing">--}}
                                        {{--<label for="count">Show:</label>--}}
                                        {{--<select name="count" id="count" class="count">--}}
                                            {{--<option value="12">12</option>--}}
                                            {{--<option value="24">24</option>--}}
                                            {{--<option value="36">36</option>--}}
                                        {{--</select>--}}
                                    {{--</form>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                @endif
            </div>

            @include('partials.shop-sidebar3')
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script>
    <!-- Sweetalert2 -->
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>

        $('.orderby, .count').change(function () {
            $(this).closest('form').submit();
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
        $(".product-quickview, .quickview").click(function (e) {
            e.preventDefault();
            $modal.load("{{ route('product.quick.view') }}" + "?product=" + $(this).attr("data-product"), function (response) {
                $modal.modal({show: true});
                // Vertical Spinner - Touchspin - Product Details Quantity input
                if ( $.fn.TouchSpin ) {
                    $('#product-vqty').TouchSpin({
                        verticalbuttons: true
                    });
                }
            });
        });
    </script>
@endpush