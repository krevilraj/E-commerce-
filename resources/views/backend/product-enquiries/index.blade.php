@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>All Enquiries</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Enquiries</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                @include('backend.partials.message-success')
                @include('backend.partials.message-error')

                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>User</th>
                                <th>Quantity</th>
                                <th>Original</th>

                                <th>Discount(%)</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>User</th>
                                <th>Quantity</th>
                                <th>Original</th>

                                <th>Discount(%)</th>
                                <th>Total</th>
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
                {"width": "2%", "targets": 0}
            ],
            processing: true,
            serverSide: true,
            columns: [
                {
                    data: 'id',
                    render: function (data, type, row) {
                        var enquiryEditUrl = "{{ route('dashboard.enquiries.edit', ':id') }}";

                        enquiryEditUrl = enquiryEditUrl.replace(':id', data);
                        return '<a href="' + enquiryEditUrl + '">#' + data + '</a>';
                    }
                },
                {
                    data: 'product_name',
                    render: function (data, type, row) {
                        var productEditUrl = "{{ route('dashboard.product.edit', ':id') }}";

                        productEditUrl = productEditUrl.replace(':id', row.product_id);
                        return '<a href="' + productEditUrl + '">' + data + '</a>';
                    }
                },
                {
                    data: 'client',
                    render: function (data, type, row) {
                        var userEditUrl = "{{ route('dashboard.users.edit', ':id') }}";

                        userEditUrl = userEditUrl.replace(':id', row.user_id);
                        return '<a href="' + userEditUrl + '">' + data + '</a>';
                    }
                },
                {data: 'quantity'},
                {data: 'original'},

                {data: 'discount_percentage'},
                {data: 'price'},

                {data: 'created_at'},
                {
                    data: 'id',
                    orderable: false,
                    render: function (data, type, row) {
                        var tempEditUrl = "{{ route('dashboard.enquiries.edit', ':id') }}";
                        var tempDeleteUrl = "{{ route('dashboard.enquiries.destroy', ':id') }}";

                        tempEditUrl = tempEditUrl.replace(':id', data);
                        tempDeleteUrl = tempDeleteUrl.replace(':id', data);

                        var actions = '';
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
            ajax: '{{ route('dashboard.enquiries.json') }}'
        });
    });
</script>
@endpush