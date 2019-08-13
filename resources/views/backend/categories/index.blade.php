@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Product Categories
            <small>({{ $categoriesCount }})</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Categories</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @include('backend.partials.message-success')
                @include('backend.partials.message-error')
            </div>
            <div class="col-md-4">
                {!! Form::open(['route'=>'dashboard.categories.store', 'files' => true, 'class' => '']) !!}
                @include('backend.categories.form-create', ['submitButtonText' => 'Save'])
                {!! Form::close() !!}
            </div>
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All Categories</h3>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Created at</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th class="sorting-false">Parent</th>
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
            $('.select2').select2();

            $('.datatable').DataTable({
aaSorting: [[0, 'desc']],
                processing: true,
                serverSide: true,
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            var categoryEditUrl = "{{ route('dashboard.categories.edit', ':id') }}";

                            categoryEditUrl = categoryEditUrl.replace(':id', data);
                            return '<a href="' + categoryEditUrl + '">#' + data + '</a>';
                        }
                    },
                    {
                        data: 'name',
                        render: function (data, type, row) {
                            var categoryEditUrl = "{{ route('dashboard.categories.edit', ':id') }}";

                            categoryEditUrl = categoryEditUrl.replace(':id', row.id);

                            return '<a href="' + categoryEditUrl + '">' + data + '</a>';
                        }
                    },
                    {
                        data: 'parent',
                        render: function (data, type, row) {
                            if (data !== null) {
                                var parentCategoryEditUrl = "{{ route('dashboard.categories.edit', ':id') }}";

                                parentCategoryEditUrl = parentCategoryEditUrl.replace(':id', data.id);

                                return '<a href="' + parentCategoryEditUrl + '">' + data.name + '</a>';
                            } else {
                                return '-';
                            }
                        }
                    },
                    {data: 'created_at'},
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempViewUrl = "{{ route('category', ':slug') }}";
                            var tempEditUrl = "{{ route('dashboard.categories.edit', ':id') }}";
                            var tempDeleteUrl = "{{ route('dashboard.categories.destroy', ':id') }}";

                            tempViewUrl = tempViewUrl.replace(':slug', row.slug);
                            tempEditUrl = tempEditUrl.replace(':id', data);
                            tempDeleteUrl = tempDeleteUrl.replace(':id', data);

                            var actions = '';
                            actions += "<a href='" + tempViewUrl + "' class='btn btn-xs btn-warning mr-5' target='_blank'>View</a>";
            @role(['admin','manager'])

                            actions += "<a href='" + tempEditUrl + "' class='btn btn-xs btn-info mr-5'>Edit</a>";
                            actions += "<form action='" + tempDeleteUrl + "' method='post'>";
                            actions += "<input type='hidden' name='_token' value='{{ csrf_token() }}'>";
                            actions += "<input type='hidden' name='_method' value='DELETE'>";
                            actions += "<button type='submit' class='btn btn-xs btn-danger'>Delete</button>";
                            actions += "</form>";
@endrole
                            return actions;
                        }
                    }
                ],
                ajax: '{{ route('dashboard.categories.json') }}'
            });
        });
    </script>
@endpush