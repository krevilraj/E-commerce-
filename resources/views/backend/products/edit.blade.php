@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Product</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('dashboard.product.index') }}">Products</a></li>
            <li class="active">Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                @include('backend.partials.message-success')
                @include('backend.partials.message-error')
            </div>

            {!! Form::model($product, ['method' => 'PATCH', 'files' => true, 'action' => ['Backend\ProductController@update', $product->id]]) !!}
            @include('backend.products.form', ['submitButtonText' => 'Update'])
            {!! Form::close() !!}
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        /**
         * Generate random integer
         *
         * @returns {number}
         */
        function generateRandomInteger() {
            return Math.floor(Math.random() * 90000) + 10000;
        }

        $(function () {
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            });

            var trackStock = jQuery('input[name=track_stock]:checked').val();
            if (trackStock !== undefined) {
                jQuery('.stock-qty').css('display', 'block');
            }

            var trackStockSelector = jQuery('input[name="track_stock"]');

            trackStockSelector.on('ifChecked', function () {
                jQuery('.stock-qty').css('display', 'block');
            });

            trackStockSelector.on('ifUnchecked', function () {
                jQuery('.stock-qty').css('display', 'none');
            });

            jQuery(document).on('click', '.product-image-list .is_main_image_button', function (e) {
                e.preventDefault();

                jQuery('.product-image-list .is_main_image_button').removeClass('active');
                jQuery('.product-image-list .is_main_image_hidden_field').val(0);


                if (jQuery(this).hasClass('active')) {

                    jQuery(this).removeClass('active');
                    jQuery(this).parents('.image-preview:first').find('.is_main_image_hidden_field').val(0);
                } else {
                    jQuery(this).addClass('active');
                    jQuery(this).parents('.image-preview:first').find('.is_main_image_hidden_field').val(1);
                }

            });

            jQuery(document).on('click', '.product-image-list .image-preview .destroy-image', function (e) {

                var token = jQuery('.product-image-element').attr('data-token');
                var path = jQuery(e.target).parents('.image-preview:first').find('.img-tag').attr('data-path');
                var data = {_token: token, path: path};
                jQuery.ajax({
                    url: '{{ url('/dashboard/product/image/delete') }}',
                    data: data,
                    dataType: 'json',
                    type: 'post',
                    success: function (response) {
                        if (response.success === true) {
                            jQuery(e.target).parents('.image-preview:first').remove();
                        }

                    }
                });

            });

            jQuery('.product-image-element').change(function (e) {
                var files = e.target.files;

                if (files.length <= 0) {
                    return;
                }

                var formData = new FormData();

                formData.append('_token', jQuery(e.target).attr('data-token'));
                for (var i = 0, file; file = files[i]; ++i) {
                    formData.append('image', file);
                }

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ url('/dashboard/product/image/upload') }}', true);
                xhr.onload = function (e) {
                    if (this.status === 200) {
                        jQuery('.product-image-list').append(this.response);
                        if (jQuery('.product-image-list .image-preview').length === 1) {
                            jQuery('.product-image-list .image-preview .is_main_image_button').trigger('click');
                        }
                    }
                };

                xhr.send(formData);

                jQuery(".product-image-element").val('');
            });

            jQuery(document).on('click', '.btn-delete-specification', function (e) {
                e.preventDefault();

                var $this = $(this);

                var specification = $this.attr('data-specification');

                if (!specification) {
                    $this.closest("tr").remove();
                    return false;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.product.specification.delete')  }}",
                    data: {
                        specification: specification
                    },
                    beforeSend: function () {
                        $this.prop('disabled', true);
                    },
                    success: function (data) {
                        $this.closest("tr").remove();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        //
                    },
                    complete: function () {
                        $this.prop('disabled', false);
                    }
                });
            });

            jQuery(document).on('click', '.btn-add-specification', function (e) {
                e.preventDefault();

                var lastRow = $('table.table-specifications > tbody > tr').last().attr('data-row');
                var counter = parseInt(lastRow) + 1;
                var randomInteger = generateRandomInteger();

                var newRow = jQuery('<tr data-row="' + counter + '">' +
                    '<td>' + counter + '</td>' +
                    '<td><input type="text" name="specifications[title][' + randomInteger + ']" class="form-control" required/></td>' +
                    '<td><input type="text" name="specifications[description][' + randomInteger + ']" class="form-control" required/></td>' +
                    '<td><button type="button" class="btn btn-danger btn-xs btn-delete-specification" data-specification=""><i class="fa fa-trash"></i></button></td>' +
                    '</tr>');

                jQuery('table.table-specifications').append(newRow);

            });

            jQuery(document).on('click', '.btn-delete-faq', function (e) {
                e.preventDefault();

                var $this = $(this);

                var faq = $this.attr('data-faq');

                if (!faq) {
                    $this.closest("tr").remove();
                    return false;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.product.faq.delete')  }}",
                    data: {
                        faq: faq
                    },
                    beforeSend: function () {
                        $this.prop('disabled', true);
                    },
                    success: function (data) {
                        $this.closest("tr").remove();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        //
                    },
                    complete: function () {
                        $this.prop('disabled', false);
                    }
                });
            });

            jQuery(document).on('click', '.btn-faqs', function (e) {
                e.preventDefault();

                var lastRow = $('table.table-faqs > tbody > tr').last().attr('data-row');
                var counter = parseInt(lastRow) + 1;
                var randomInteger = generateRandomInteger();

                var newRow = jQuery('<tr data-row="' + counter + '">' +
                    '<td>' + counter + '</td>' +
                    '<td><input type="text" name="faqs[question][' + randomInteger + ']" class="form-control" required/></td>' +
                    '<td><textarea name="faqs[answer][' + randomInteger + ']" class="form-control" rows="3" required></textarea></td>' +
                    '<td><button type="button" class="btn btn-danger btn-xs btn-delete-faq" data-faq=""><i class="fa fa-trash"></i></button></td>' +
                    '</tr>');

                jQuery('table.table-faqs').append(newRow);

            });

            jQuery(document).on('click', '.btn-delete-download', function (e) {
                e.preventDefault();

                var $this = $(this);

                var download = $this.attr('data-download');

                if (!download) {
                    $this.closest("tr").remove();
                    return false;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.product.download.delete')  }}",
                    data: {
                        download: download
                    },
                    beforeSend: function () {
                        $this.prop('disabled', true);
                    },
                    success: function (data) {
                        $this.closest("tr").remove();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        //
                    },
                    complete: function () {
                        $this.prop('disabled', false);
                    }
                });
            });

            jQuery(document).on('change', '.download-file', function (e) {
                e.preventDefault();

                var $this = $(this);

                var fileData = $this.prop('files')[0];
                var formData = new FormData();
                formData.append('file', fileData);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('dashboard.product.download.file.upload') }}",
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    type: 'post',
                    beforeSend: function( xhr ) {

                    },
                    success: function(response){
                        var res = JSON.parse(response);

                        $this.siblings('.download-file-link').val(res.fileName);
                        $this.val('');
                    }
                });

            });

            jQuery(document).on('click', '.btn-add-download', function (e) {
                e.preventDefault();

                var lastRow = $('table.table-downloads > tbody > tr').last().attr('data-row');
                var counter = parseInt(lastRow) + 1;
                var randomInteger = generateRandomInteger();

                var newRow = jQuery('<tr data-row="' + counter + '">' +
                    '<td>' + counter + '</td>' +
                    '<td><input type="text" name="downloads[title][' + randomInteger + ']" class="form-control" required/></td>' +
                    '<td><input type="file" name="downloads[file][' + randomInteger + ']" class="form-control mb-15 download-file"><input type="text" name="downloads[link][' + randomInteger + ']" class="download-file-link form-control" placeholder="Link" required/></td>' +
                    '<td><button type="button" class="btn btn-danger btn-xs btn-delete-download" data-download=""><i class="fa fa-trash"></i></button></td>' +
                    '</tr>');

                jQuery('table.table-downloads').append(newRow);

            });

        });

    </script>
@endpush