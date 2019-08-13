@extends('layouts.app')
@section('content')
    <section class="page-header mb-lg">

        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ul>
        </div>
    </section>
     @if(session('enquiry'))
        <div class="container">
            <div class="alert alert-primary ">
                <strong><i class="fa fa-warning"></i>Out Of Stock!</strong>
                <span class="text-light">The Product You Selecetd Are Out Of Stock !</span>
            </div>
        </div>
        </div>
    @endif

    <div class="cart">
        <div class="container">


            <div class="row">
                @if(Cart::instance('default')->count())
                    <div class="col-md-8 col-lg-9">
                        <div class="cart-table-wrap">
                            <table class="cart-table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(Cart::instance('default')->content() as $cartContent)
                                    <tr data-row="{{ $cartContent->rowId }}">
                                        <td class="product-action-td">
                                            <a href="javascript:void(0);" title="Remove product"
                                               class="btn-remove btn-remove-row">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                        <td class="product-image-td">
                                            <a href="{{ route('product.show', getProductSlug($cartContent->id)) }}"
                                               title="{{ $cartContent->name }}">
                                                <img src="{{ asset(getProductImage($cartContent->id, 'small')) }}"
                                                     alt="{{ $cartContent->name }}">
                                            </a>
                                        </td>
                                        <td class="product-name-td">
                                            <h2 class="product-name">
                                                <a href="{{ route('product.show', getProductSlug($cartContent->id)) }}"
                                                   title="{{ $cartContent->name }}">{{ $cartContent->name }}</a>
                                            </h2>
                                        </td>
                                        <td>RS{{ $cartContent->price }}</td>
                                        <td>
                                            <div class="qty-holder">
                                                <a href="javascript:void(0);" class="qty-dec-btn" title="Dec">-</a>
                                                <input type="text" class="qty-input" name="quantity"
                                                       value="{{ $cartContent->qty }}">
                                                <a href="javascript:void(0);" class="qty-inc-btn" title="Inc">+</a>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-primary">RS {{ $cartContent->total }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6" class="clearfix">
                                        <button class="btn btn-primary btn-update btn-update-cart pull-right" disabled>
                                            Update Cart
                                        </button>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <aside class="col-md-4 col-lg-3 sidebar shop-sidebar">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" href="#panel-cart-total">
                                            Cart Totals
                                        </a>
                                    </h4>
                                </div>
                                <div id="panel-cart-total" class="accordion-body collapse in">
                                    <div class="panel-body">
                                        <table class="totals-table">
                                            <tbody>
                                                @php
                                                    $subTotal = str_replace(',', '', Cart::instance('default')->subtotal());
                                                    $tax = 0;
                                                    if (getConfiguration('enable_tax')) {
                                                        $tax = ($subTotal * getConfiguration('tax_percentage')) / 100;
                                                    }
                                                    $grandTotal = $subTotal + $tax;
                                                @endphp
                                                <tr>
                                                    <td>Subtotal</td>
                                                    <td>RS {{ $subTotal }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tax</td>
                                                    <td>RS {{ number_format($tax, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Grand Total</td>
                                                    <td>RS {{ number_format($grandTotal, 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="totals-table-action">
                                            <a href="{{ route('checkout') }}" class="btn btn-primary btn-block">Proceed
                                                to Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                @else
                    <div class="col-md-12">
                        <div class="alert alert-success alert-message display-block mb-none">
                            <div>
                                <span>No items found in cart.
                                    <a href="{{ url('/shop') }}"
                                       class="btn btn-xs btn-primary pull-right">Back to shop</a>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection


@push('scripts')

    <script>
        // Increment quantity
        $(document).on("click", ".qty-inc-btn", function (e) {
            e.preventDefault();
            var $this = $(this);

            var quantity = $this.siblings(".qty-input");
            var val = parseInt(quantity.val());
            quantity.val(val + 1);

            $('.btn-update-cart').prop('disabled', false);

        });

        // Decrement quantity
        $(document).on("click", ".qty-dec-btn", function (e) {
            e.preventDefault();
            var $this = $(this);

            var quantity = $this.siblings(".qty-input");
            var val = parseInt(quantity.val());
            quantity.val(val - 1);
            if (quantity.val() < 0) {
                quantity.val(0);
            }

            $('.btn-update-cart').prop('disabled', false);
        });

        // On quantity change event
        $('.qty-input').on('input', function (e) {
            $('.btn-update-cart').prop('disabled', false);
        });

        // Update cart
        $(document).on("click", ".btn-update-cart", function (e) {
            e.preventDefault();
            var $this = $(this);

            var cartContents = [];

            $('.cart-table > tbody  > tr').each(function (i, tr) {
                var rowId = $(tr).attr('data-row');
                var quantity = $(tr).find('.qty-input').val();

                cartContents.push({
                    rowId: rowId,
                    quantity: quantity
                });

            });

            if (cartContents) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('cart.update') }}",
                    data: {
                        cartContents: cartContents
                    },
                    beforeSend: function () {
                        $this.prop('disabled', true);
                    },
                    success: function (data) {
                        //
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        //
                    },
                    complete: function () {
                        location.reload();
                    }
                });
            }
        });

        // Remove row
        $(document).on("click", ".btn-remove-row", function (e) {
            e.preventDefault();
            var $this = $(this);

            var rowId = $this.parent().parent().attr('data-row');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('cart/destroy')  }}" + '/' + rowId,
                data: {
                    rowId: rowId
                },
                beforeSend: function () {
                    $this.prop('disabled', true);
                },
                success: function (data) {
                    //
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //
                },
                complete: function () {
                    location.reload();
                }
            });

        });

        $(document).on("click", ".btn-clear", function (e) {
            e.preventDefault();
            var $this = $(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('cart.destroy')  }}",
                beforeSend: function () {
                    $this.button('loading');
                },
                success: function (data) {
                    //
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //
                },
                complete: function () {
                    location.reload();
                }
            });

        });

    </script>

@endpush