@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>All Pages
            <small>({{ $aboutCount }})</small>
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
                        <h3 class="box-title">All Messages</h3>
                        <a href="{{ route('dashboard.about.create') }}" class="btn btn-sm btn-danger pull-right" style="margin-top: 10px">Add New</a>

                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Ttile</th>
                                <th>Content</th>
                                <th>Author</th>

                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Ttile</th>
                                <th>Content</th>
                                <th>Author</th>
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
                    {data: 'title', name: 'title'},
                    {data: 'content', name: 'content'},
                    {data: 'author', name: 'author'},

                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempDeleteUrl = "{{ route('dashboard.about.destroy', ':id') }}";

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
                ajax: '{{ route('dashboard.about.json') }}'
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
@endpush