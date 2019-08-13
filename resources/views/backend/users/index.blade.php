@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>All {{ request()->has('role') ? ucfirst(request()->input('role')) . 's' : 'Clients' }}
            <small>({{ $usersCount }})</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Users</li>
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
                        <h3 class="box-title">Users</h3>
                        <!--<select name="sort-users" id="sort-users" class="form-control input-sm">
                            <option value="all">All</option>
                            @role('admin')
                            <option value="admin">Admin</option>
                            @endrole
                            <option value="manager">Manager</option>
                            <option value="visitor">Visitor</option>
                        </select>-->

                        <a href="{{ route('dashboard.users.create') }}" class="btn btn-sm btn-danger pull-right">Add New</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="sorting-false text-center"><i class="fa fa-image"></i></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Active</th>

                                <th>Date</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th class="sorting-false text-center"><i class="fa fa-image"></i></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Active</th>

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

            var sortSelector = $('#sort-users');

            var Table = $('.datatable').DataTable({
                aaSorting: [[7, 'desc']],
                columnDefs: [
                    {"width": "2%", "targets": 0},
                    {"width": "5%", "targets": 1}
                ],
                processing: true,
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            var userEditUrl = "{{ route('dashboard.users.edit', ':id') }}";

                            userEditUrl = userEditUrl.replace(':id', data);
                            return '<a href="' + userEditUrl + '">#' + data + '</a>';
                        }
                    },
                    {
                        data: 'avatar',
                        orderable: false,
                        render: function (data, type, row) {
                            return '<img src="' + data + '" width="50">';
                        }
                    },
                    {
                        data: 'name',
                        render: function (data, type, row) {
                            return '<a href="{{ url('/dashboard/users') }}' + '/' + row.id + '/edit' + '">' + data + '</a>';
                        }
                    },
                    {data: 'email'},
                    {data: 'phone'},
                    {data: 'role'},
 {
                        data: 'active',
                        name: 'active',
                        render: function (data, type, row) {
                            return data === '1' ? ' <span class="label label-success"> Active</span>' : ' <span class="label label-danger"> Not-Active</span>';
                        }
                    },
                    {data: 'created_at'},
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempViewUrl = "{{ route('dashboard.users.show', ':id') }}";
                            var tempEditUrl = "{{ route('dashboard.users.edit', ':id') }}";
                            var tempDeleteUrl = "{{ route('dashboard.users.destroy', ':id') }}";

                            tempViewUrl = tempViewUrl.replace(':id', data);
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
                ajax: "{{ request()->has('role') ? route('dashboard.users.json', 'role=' . request('role')) : route('dashboard.users.json', 'role=' . 'client')  }}"
            });

            //sortSelector.on("change", function () {
            //var role = sortSelector.find("option:selected").val();
            //Table.ajax.url('{{-- route('dashboard.users.json') --}}?role=' + role).load();
            //});
        });
    </script>
@endpush