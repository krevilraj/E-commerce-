@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add New Order</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('dashboard.order.index') }}">Order</a></li>
            <li class="active">Create</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            {!! Form::open(['route'=>'dashboard.order.store', 'files' => true, 'class' => 'form-order']) !!}
            @include('backend.orders.form', ['submitButtonText' => 'Submit'])
            {!! Form::close() !!}
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>

        function getOrderSummary() {
            var productsArray = [];

            $('.table-order > tbody > tr.item').each(function (i, el) {
                var product = $(el).attr('data-product');
                var price = $(el).find('.item_cost input').val();
                var quantity = $(el).find('.quantity input').val();
                var discount = $(el).find('.discount input').val();

                productsArray.push({
                    id: product,
                    price: price,
                    quantity: quantity,
                    discount: discount
                });

            });

            $.ajax({
                type: "GET",
                url: "{{ route('dashboard.order.update-product-summary') }}",
                data: {
                    products: productsArray
                },
                success: function (data) {
                    $('.table-order-summary tbody').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                },
                complete: function () {
                    //
                }
            });
        }

        //Date picker
        $('#order_date').datepicker({
            autoclose: true,
            format: "yyyy/mm/dd",
            useCurrent: true
        });

        $('.select2').select2();

        $('#customer').select2({
            placeholder: 'Guest',
            allowClear: true,
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('dashboard.search.user') }}",
                dataType: 'json',
                type: 'GET',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    return {
                        results: data
                    };
                },
                cache: true
            }

        }).on('change', function () {
            var user = this.value;

            $.ajax({
                type: "GET",
                url: "{{ route('dashboard.order.update-user-address') }}",
                data: {user: user},
                beforeSend: function (xhr, settings) {
                    //
                },
                success: function (data) {
                    $('div.address-details').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                },
                complete: function () {
                    //
                }
            });

        });

        $('#products').select2({
            placeholder: 'Select Product',
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('dashboard.search.product') }}",
                dataType: 'json',
                type: 'GET',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    return {
                        results: data
                    };
                },
                cache: true
            }

        });

        $(document).on("click", "#btn-product-add", function () {
            var $this = $(this);

            var productsSelector = $("#products");
            var products = $.trim(productsSelector.select2("val"));

            if (products) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('dashboard.order.add.product') }}",
                    data: {products: products},
                    beforeSend: function (xhr, settings) {
                        $this.prop('disabled', true);
                    },
                    success: function (data) {
                        $('.table-order tbody').append(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                    },
                    complete: function () {
                        $this.prop('disabled', false);
                        productsSelector.val('').trigger('change');
                        getOrderSummary();
                    }
                });
            }
        });

        $(document).on("click", ".delete-order-item", function () {
            var $this = $(this);

            $this.parent().parent().remove();
            getOrderSummary();

        });

        $(document).on("click", ".update-order-item", function () {
            var $this = $(this);

            var productSelector = $this.parent().parent();
            var product = productSelector.attr('data-product');
            var quantity = $this.parent().parent().find('.quantity input').val();
            var discount = $this.parent().parent().find('.discount input').val();

            if (product) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('dashboard.order.update-product') }}",
                    data: {
                        product: product,
                        quantity: quantity,
                        discount: discount
                    },
                    success: function (data) {
                        productSelector.html(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                    },
                    complete: function () {
                        getOrderSummary();
                    }
                });
            }

        });

        $(document).on("click", "#btn-order-save", function (e) {
            e.preventDefault();
            var $this = $(this);

            // General details
            var orderDate = $("input[name=order_date]").val();
            var orderStatus = $("select[name=order_status]").find(":selected").val();
            var customer = $("select[name=customer]").find(":selected").val();
            var orderNote = $("textarea[name=order_note]").val();

            // Address details
            var firstName = $("input[name=first_name]").val();
            var lastName = $("input[name=last_name]").val();
            var email = $("input[name=email]").val();
            var phone = $("input[name=phone]").val();
            var address1 = $("input[name=address1]").val();
            var address2 = $("input[name=address2]").val();
            var country = $("select[name=country]").find(":selected").val();
            var state = $("select[name=state]").find(":selected").val();
            var city = $("input[name=city]").val();
            var postcode = $("input[name=postcode]").val();

            // Product details
            var products = [];

            $('.table-order > tbody > tr.item').each(function (i, el) {
                var product = $(el).attr('data-product');
                var price = $(el).find('.item_cost input').val();
                var quantity = $(el).find('.quantity input').val();
                var discount = $(el).find('.discount input').val();

                products.push({
                    id: product,
                    price: price,
                    qty: quantity,
                    discount: discount
                });

            });

            var taxPercentage = $("input[name=tax_percentage]").val();

            if (products.length > 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.order.store')  }}",
                    data: {
                        order_date: orderDate,
                        order_status: orderStatus,
                        customer: customer,
                        order_note: orderNote,
                        first_name: firstName,
                        last_name: lastName,
                        email: email,
                        phone: phone,
                        address1: address1,
                        address2: address2,
                        country: country,
                        state: state,
                        city: city,
                        postcode: postcode,
                        products: products,
                        tax_percentage: taxPercentage
                    },
                    beforeSend: function (data) {
                        $this.button('loading');
                    },
                    success: function (data) {
                        if (data.success) {
                            $this.prop('disabled', true);
                            $('.callout.callout-danger').fadeOut();
                            $('.callout.callout-success').fadeIn().html(data.message);
                        }

                        window.setTimeout(function () {
                            location.reload()
                        }, 2000);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorsHolder = '';
                        errorsHolder += '<ul>';

                        var err = eval("(" + xhr.responseText + ")");
                        $.each(err.errors, function (key, value) {
                            errorsHolder += '<li>' + value + '</li>';
                        });

                        errorsHolder += '</ul>';

                        $('.callout.callout-danger').fadeIn().html(errorsHolder);
                    },
                    complete: function () {
                        $this.button('reset');
                        $("html, body").animate({scrollTop: 0}, "slow");
                    }
                });
            } else {
                alert('Select products to continue.');
            }

        });

    </script>
@endpush