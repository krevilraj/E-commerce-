@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>All Products
            <small>({{ $productsCount }})</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Products</li>
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
                        <h3 class="box-title">All Products</h3>
                        <div class="pull-right">
                            <form action="" method="get" class="search-form">
                                <div class="input-group">
                                    <input name="product" class="form-control search-input" value="{{ request()->has('product') ? request('product') : '' }}" placeholder="Enter keywork here..." type="text">
                                    <div class="input-group-btn">
                                        <div class="input-group">
                                            <select name="category" class="form-control search-select" title="" style="min-width: 150px;" autocomplete="off">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->slug }}" @if(request('category') == $category->slug) selected="selected" @endif>{{ $category->name }}</option>
                                                    @include('backend.products.category-dropdown')
                                                @endforeach
                                            </select>
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-danger btn-block">
                                                    <i class="fa fa-search font-16"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="sorting-false text-center"><i class="fa fa-image"></i></th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Stock</th>
                                <th>Featured</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th class="sorting-false text-center"><i class="fa fa-image"></i></th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Stock</th>
                                <th>Featured</th>
                                <th>Price</th>
                                <th>Status</th>
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
    @php
        if (request()->has('product') || request()->has('category')){
            $route = route('dashboard.products.json') . '?product=' . request('product') . '&category=' . request('category');
        }
        else
            $route = route('dashboard.products.json');
    @endphp
    <script>
        $(document).ready(function () {
            $('.datatable').DataTable({
 aaSorting: [[0, 'desc']],
                columnDefs: [
                    { "width": "2%", "targets": 0 },
                    { "width": "5%", "targets": 1 },
                    { "width": "22%", "targets": 2 }
                ],
                processing: true,
                serverSide: true,
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            var productEditUrl = "{{ route('dashboard.product.edit', ':id') }}";

                            productEditUrl = productEditUrl.replace(':id', data);
                            return '<a href="' + productEditUrl + '">#' + data + '</a>';
                        }
                    },
                    {
                        data: 'path',
                        orderable: false,
                        render: function (data, type, row) {
                            return '<img src="' + data + '" width="50">';
                        }
                    },
                    {
                        data: 'name',
                        render: function (data, type, row) {
                            return '<a href="{{ url('/product2') }}' + '/' + row.id +  '">' + data + '</a>';
                        }
                    },
                    {
                        data: 'sku',
                        render: function (data, type, row) {
                            return null !== data ? data : '-';
                        }
                    },
                    {
                        data: 'in_stock',
                        render: function (data, type, row) {
                            var stock = data === '1' ? 'In stock' : 'Out of stock';
                            stock += row.stock_qty !== null ? '('+ row.stock_qty +')' : '';
                            return stock;
                        }
                    },
                    {
                        data: 'is_featured',
                        name: 'is_featured',
                        render: function (data, type, row) {
                            return data === '1' ? 'Featured' : '-';
                        }
                    },
                    {data: 'price', name: 'price'},
                    {
                        data: 'disable_price',
                        name: 'disable_price',
                        render: function (data, type, row) {
                            return data === '1' ? ' <span class="label label-danger"> Disabled</span>' : ' <span class="label label-success"> Enabled</span>';
                        }
                    },
                   


                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempViewUrl = "{{ route('product.show', ':slug') }}";
                            var tempEditUrl = "{{ route('dashboard.product.edit', ':id') }}";
                            var tempDeleteUrl = "{{ route('dashboard.product.destroy', ':id') }}";

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
                ajax: "{!! $route  !!}"
            });
        });
    </script>
@endpush