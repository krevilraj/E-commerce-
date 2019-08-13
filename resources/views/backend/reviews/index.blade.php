@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>All Pages
            <small>({{ count($reviews) }})</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Reviews</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                @include('backend.partials.message-success')
                @include('backend.partials.message-error')
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All Reviews</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Comment</th>
                                <th>Star</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>s
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Comment</th>
                                <th>Star</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.datatable').DataTable({
aaSorting: [[0, 'desc']],
                columnDefs: [
                    {"width": "30%", "targets": 3}
                ],
                processing: true,
                serverSide: true,
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'user_name',
                        render: function (data, type, row) {
                            return '<a href="{{ url('/dashboard/user') }}' + '/' + row.user_id + '/edit' + '">' + data + '</a>';
                        }
                    },
                    {
                        data: 'product_name',
                        render: function (data, type, row) {
                            return '<a href="{{ url('/product2') }}' + '/' + row.product_id + '">' + data + '</a>';
                        }
                    },
                    {data: 'comment', name: 'comment'},
                    {data: 'star', name: 'star'},
                    {
                        data: 'status',
                        render: function (data, type, row) {
                            var updateLink = "{{ url('/dashboard/review/status') }}" + "/" + row.id;
                            var status = '<a href="javascript:void(0);" class="review-status" data-url="' + updateLink + '" data-status="' + data + '">';
                            status += data === 'ENABLED' ? '<span class="label label-success">' : '<span class="label label-danger">';
                            status += data + '</span></a>';
                            return status;
                        }
                    },
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempDeleteUrl = "{{ route('dashboard.review.destroy', ':id') }}";

                            tempDeleteUrl = tempDeleteUrl.replace(':id', data);

                            var actions = '';
                            actions += "<form action='" + tempDeleteUrl + "' method='post'>";
                            actions += "<input type='hidden' name='_token' value='{{ csrf_token() }}'>";
                            actions += "<input type='hidden' name='_method' value='DELETE'>";
                            actions += "<button type='submit' class='btn btn-xs btn-danger'>Delete</button>";
                            actions += "</form>";

                            return actions;
                        }
                    }
                ],
                ajax: '{{ route('dashboard.reviews.json') }}'
            });
        });

        $(document).on("click", ".review-status", function (e) {
            e.preventDefault();
            var $this = $(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: $this.attr('data-url'),
                data: {status: $this.attr('data-status')},
                success: function (data) {
                    if (data.success) {
                        $this.prop('disabled', true);
                        $('.callout.callout-danger').fadeOut();
                        $('.callout.callout-success').fadeIn().html(data.message);
                    }
                },
                complete: function () {
                    window.setTimeout(function () {
                        location.reload()
                    }, 1000);
                }
            });
        });

        $(document).on("click", ".btn-review-delete", function (e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to delete?')) {
                return false;
            }

            var $this = $(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: $this.attr('href'),
                data: {_method: 'DELETE'},
                success: function (data) {
                    if (data.success) {
                        $this.prop('disabled', true);
                        $('.callout.callout-danger').fadeOut();
                        $('.callout.callout-success').fadeIn().html(data.message);
                    }
                },
                complete: function () {
                    window.setTimeout(function () {
                        location.reload()
                    }, 1000);
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
            url: "{{route('dashboard.mail')}}",
            data: { email: $('#email').val(),subject: $('#subject').val(),message: $('#message').val()},

            beforeSend: function () {
                console.log($('#email').val());
                $this.button('loading');
            },
            success: function (data) {
                $(location).attr('href', '{{ route('dashboard.request.index') }}');

            },
            error: function (xhr, ajaxOptions, thrownError) {
                var errorsHolder = '';
                errorsHolder += '<ul>';

                var err = eval("(" + xhr.responseText + ")");
                $.each(err.errors, function (key, value) {
                    errorsHolder += '<li>' + value + '</li>';
                });;
               


                errorsHolder += '</ul>';

                $this.closest('form').find('.alert-account.alert-danger').fadeIn().html('Please fill all the Form');
//                $this.closest('form').find('.alert-account.alert-danger').fadeIn().html(errorsHolder);

            },
            complete: function () {
                $this.button('reset');
                $this.button('reset');
            }
        });

    });

</script>
@endpush