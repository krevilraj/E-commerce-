@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>All Posts
            <small>({{ $postsCount }})</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Posts</li>
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
                        <h3 class="box-title">All Posts</h3>
                        <a href="{{ route('dashboard.posts.create') }}" class="btn btn-sm btn-danger pull-right">Add New</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="sorting-false text-center"><i class="fa fa-image"></i></th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Tags</th>


                                <th>Status</th>
                                <th>Author</th>
                                <th>Created at</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th class="sorting-false text-center"><i class="fa fa-image"></i></th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Tags</th>

                                <th>Status</th>
                                <th>Author</th>
                                <th>Created at</th>
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
     aaSorting: [[6, 'desc']],
                columnDefs: [
                    {"width": "2%", "targets": 0},
                    {"width": "5%", "targets": 1},
                    {"width": "28%", "targets": 2}
                ],
                processing: true,
                serverSide: true,
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            var postEditUrl = "{{ route('dashboard.posts.edit', ':id') }}";

                            postEditUrl = postEditUrl.replace(':id', data);
                            return '<a href="' + postEditUrl + '">#' + data + '</a>';
                        }
                    },
                    {
                        data: 'featured_image',
                        orderable: false,
                        render: function (data, type, row) {
                            return '<img src="' + data + '" width="50">';
                        }
                    },
                    {
                        data: 'title',
                        render: function (data, type, row) {
                            return '<a href="{{ url('/dashboard/posts') }}' + '/' + row.id + '/edit' + '">' + data + '</a>';
                        }
                    },
                    {data: 'content', name: 'content'},

                    {data: 'tags', name: 'tags'},

                    {
                        data: 'status',
                        name: 'status',
                        render: function (data, type, row) {
                            return data === '0' ? ' <span class="label label-danger"> Disabled</span>' : ' <span class="label label-success"> Enabled</span>';
                        }
                    },
                    {data: 'author', name: 'author'},
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempEditUrl = "{{ route('dashboard.posts.edit', ':id') }}";
                            var tempDeleteUrl = "{{ route('dashboard.posts.destroy', ':id') }}";

                            var tempViewUrl = "{{ url('/blog') }}" + "/" + row.slug;
                            tempEditUrl = tempEditUrl.replace(':id', data);
                            tempDeleteUrl = tempDeleteUrl.replace(':id', data);

                            var actions = '';
                            actions += "<a href='" + tempViewUrl + "' class='btn btn-xs btn-warning mr-5' target='_blank'>View</a>";
                            actions += "<a href='" + tempEditUrl + "' class='btn btn-xs btn-info mr-5'>Edit</a>";
                            actions += "<form action='" + tempDeleteUrl + "' method='post'>";
                            actions += "<input type='hidden' name='_token' value='{{ csrf_token() }}'>";
                            actions += "<input type='hidden' name='_method' value='DELETE'>";
                            actions += "<button type='submit' class='btn btn-xs btn-danger'>Delete</button>";
                            actions += "</form>";

                            return actions;
                        }
                    }
                ],
                ajax: '{{ route('dashboard.posts.json') }}'
            });
        });
    </script>
@endpush