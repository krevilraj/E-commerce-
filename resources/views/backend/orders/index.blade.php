@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>All Orders
            <small>({{ $ordersCount }})</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Orders</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All Orders</h3>
                        <a href="{{ route('dashboard.order.create') }}" class="btn btn-sm btn-danger pull-right">Add New</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Purchased</th>
                                <th>Address</th>
                                <th>Date</th>

                                <th>Total</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Purchased</th>
                                <th>Address</th>
                                <th>Date</th>

                                <th>Total</th>
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
                columnDefs: [],
                processing: true,
                serverSide: true,
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            var orderEditUrl = "{{ route('dashboard.order.edit', ':id') }}";

                            orderEditUrl = orderEditUrl.replace(':id', data);
                            return '<a href="' + orderEditUrl + '">#' + data + '</a>';
                        }
                    },
                    {
                        data: 'order_status',
                        render: function (data, type, row) {
                            var statusClass = '';
                            switch (data) {
                                case 'Pending':
                                    statusClass = "warning";
                                    break;
                                case 'Delivered':
                                    statusClass = "success";
                                    break;
                                case 'Received':
                                    statusClass = "info";
                                    break;
                                case 'Canceled':
                                    statusClass = "danger";
                                    break;
                                default:
                                    statusClass = "info";
                            }

                            return '<span class="label label-' + statusClass + '">' + data + '</span>';
                        }
                    },
                    {
                        data: 'userOrder',
                        render: function (data, type, row) {
                            var orderId = data.order_id;
                            var userId = data.user_id;
                            var userFirstName = data.user_first_name;
                            var userLastName = data.user_last_name;
                            var userEmail = data.user_email;

                            var orderLink = "{{ url('/dashboard/order') }}" + "/" + orderId + "/edit";
                            var userLink = userId ? "{{ url('/dashboard/user') }}" + "/" + userId + "/edit" : "javascript:void(0);";

                            var userOrder = "<ul class='no-margin no-padding no-list-style'>";
                            userOrder += "<li><a href='" + orderLink + "'>#" + orderId + "</a> by ";
                            userOrder += "<a href='" + userLink + "'>";
                            userOrder += userFirstName ? userFirstName + " " : "Guest";
                            userOrder += userLastName ? userLastName : "";
                            userOrder += "</a></li>";
                            userOrder += userEmail ? "<li><a href='mailto:" + userEmail + "'> " + userEmail + "</a></li>" : "";
                            userOrder += "</ul>";

                            return userOrder;
                        }
                    },
                    {
                        data: 'products',
                        render: function (data, type, row) {
                            var products = '<ul class="no-margin no-padding no-list-style">';
                            $.each(data, function (index, value) {
                                var productLink = "{{ url('/dashboard/product') }}" + "/" + value.product_id + "/edit";
                                products += "<li><a href='" + productLink + "'><label class='label label-default'>" + value.qty + "</label> " + value.product_name + "</a></li>";
                            });

                            products += "</ul>";

                            return products;
                        }
                    },
                    {
                        data: 'address',
                        render: function (data, type, row) {
                            var first_name = data.address_first_name;
                            var last_name = data.address_last_name;
                            var address1 = data.address_address1;
                            var address2 = data.address_address2;
                            var city = data.address_city;
                            var state = data.address_state;
                            var postcode = data.address_postcode;

                            var address = first_name + ' ' + last_name;
                            address += address1 ? '<br>' + address1 : '';
                            address += address2 ? '<br>' + address2 : '';
                            address += city ? '<br>' + city : '';
                            address += state ? '<br>' + state : '';
                            address += postcode ? '<br>' + postcode : '';

                            return "<a href='javascript:void(0);'>" + address + "</a>";
                        }
                    },
                    {
                        data: 'order_date',
                        render: function (data, type, row) {

                            return data;
                        }
                    },
                    {
                        data: 'price_total',
                        render: function (data, type, row) {

                            return 'RS ' + data;
                        }
                    },
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempInvoiceUrl = "{{ route('dashboard.order.invoice', ':id') }}";
                            var tempEditUrl = "{{ route('dashboard.order.edit', ':id') }}";
                            var tempDeleteUrl = "{{ route('dashboard.order.destroy', ':id') }}";

                            tempInvoiceUrl = tempInvoiceUrl.replace(':id', data);
                            tempEditUrl = tempEditUrl.replace(':id', data);
                            tempDeleteUrl = tempDeleteUrl.replace(':id', data);

                            var actions = '';
                            actions += "<a href='" + tempInvoiceUrl + "' class='btn btn-xs btn-default mr-5' target='_blank'>Invoice</a>";
                            actions += "<a href='" + tempEditUrl + "' class='btn btn-xs btn-info mr-5'>Edit</a>";
                            actions += "<form action='" + tempDeleteUrl + "' method='post'>";
                            actions += "<input type='hidden' name='_token' value='{{ csrf_token() }}'>";
                            actions += "<input type='hidden' name='_method' value='DELETE'>";
                            actions += "<button type='submit' class='btn btn-xs btn-danger btn-delete'>Delete</button>";
                            actions += "</form>";

                            return actions;
                        }
                    }
                ],
                ajax: '{{ route('dashboard.orders.json') }}'
            });
        });

        $(document).on("click", ".btn-delete", function (e) {
            e.preventDefault();
            if (confirm("Are you sure to delete?") == true) {
                $(this).closest('form').submit();
            } else {
                return false;
            }
        });
    </script>
@endpush