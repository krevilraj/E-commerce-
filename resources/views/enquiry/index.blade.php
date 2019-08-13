@extends('layouts.app')

@section('content')
    <section class="page-header mb-lg">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li class="active">Enquiry</li>
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
    <div class="checkout">
        <div class="container">
            <div class="row">
                @if(Cart::instance('enquiry')->count())
                <form action="{{ route('enquiry.store') }}" method="post">
                    {{ csrf_field() }}
                    @if(isset($address->id))
                        <input type="hidden" name="address_id" value="{{ $address->id }}">
                    @endif
                    @include('enquiry.form')
                </form>
                @else
                    <div class="col-md-12">
                        <div class="alert alert-success alert-message display-block mb-none">
                            <div>
                                <span>No items found in enquiry list.
                                    <a href="{{ route('shop') }}"
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
    <!-- Sweetalert2 -->
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        // Increment quantity
        $(document).on("click", ".qty-inc-btn", function (e) {
            e.preventDefault();
            var $this = $(this);

            var quantity = $this.siblings(".qty-input");
            var val = parseInt(quantity.val());
            quantity.val(val + 1);

            $('.btn-update-enquiry-list').prop('disabled', false);

        });

        // Decrement quantity
        $(document).on("click", ".qty-dec-btn", function (e) {
            e.preventDefault();
            var $this = $(this);

            var quantity = $this.siblings(".qty-input");
            var val = parseInt(quantity.val());
            quantity.val(val - 1);
            if (quantity.val() < 1) {
                quantity.val(1);
            }

            $('.btn-update-enquiry-list').prop('disabled', false);
        });

        // On quantity change event
        $('.qty-input').on('input', function (e) {
            $('.btn-update-enquiry-list').prop('disabled', false);
        });

        function sweetAlert(type, title, message) {
            swal({
                title: title,
                html: message,
                type: type,
                confirmButtonColor: '#57BC90',
                timer: 3000
            }).catch(swal.noop);
        }

        // Remove product from enquiry list
        $(document).on("click", ".btn-enquiry-list", function (e) {
            e.preventDefault();
            var $this = $(this);
            var rowId = $this.attr('data-row');

            if (!rowId) {
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('enquiry.row.destroy')  }}",
                data: {
                    rowId: rowId
                },
                beforeSend: function (data) {
                    $this.button('loading');
                },
                complete: function () {
                    location.reload();
                }
            });

        });

        // Update enquiry list
        $(document).on("click", ".btn-update-enquiry-list", function (e) {
            e.preventDefault();
            var $this = $(this);

            var enquiryContents = [];

            $('.table-product-enquiry > tbody  > tr').each(function (i, tr) {
                var rowId = $(tr).attr('data-row');
                var quantity = $(tr).find('.qty-input').val();

                enquiryContents.push({
                    rowId: rowId,
                    quantity: quantity
                });

            });

            if (enquiryContents) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('enquiry.row.update') }}",
                    data: {
                        enquiryContents: enquiryContents
                    },
                    beforeSend: function () {
                        $this.prop('disabled', true);
                    },
                    complete: function () {
                        location.reload();
                    }
                });
            }
        });
    </script>
@endpush