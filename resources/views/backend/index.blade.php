@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @if(count($lessQtyProducts) > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissable">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <ul class="pl-20">
                          @foreach($lessQtyProducts as $lessQtyProduct)
                            <li>Only {{ $lessQtyProduct->stock_qty }} <a href="{{ route('dashboard.product.edit', $lessQtyProduct->id) }}">{{ $lessQtyProduct->name }}</a> are remaining in stock.</li>
                          @endforeach
                      </ul>
                    </div>
                </div>
            </div>
        @endif
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $ordersCount }}</h3>
                        <p>Total Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('dashboard.order.index') }}" class="small-box-footer">View All
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $productsCount }}<sup style="font-size: 20px">%</sup></h3>
                        <p>Total Products</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-cart"></i>
                    </div>
                    <a href="{{ route('dashboard.product.index') }}" class="small-box-footer">View All
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $usersCount }}</h3>
                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">View All
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $reviewsCount }}</h3>
                        <p>Reviews</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-chat"></i>
                    </div>
                    <a href="{{ route('dashboard.review.index') }}" class="small-box-footer">View All
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-6 connectedSortable">

                <!-- TABLE: LATEST ORDERS -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Latest Orders</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Item</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($latestOrders as $latestOrder)
                                    <tr>
                                        <td>
                                            <a href="{{ route('dashboard.order.edit', $latestOrder->id) }}">#{{ $latestOrder->id }}</a>
                                        </td>
                                        <td>
                                            <ul class="p-none no-list-style">
                                                @foreach($latestOrder->products as $product)
                                                    <li><i class="fa fa-angle-right mr-5"></i>{{ $product->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="label label-{{ getOrderStatusClass($latestOrder->orderStatus->name) }}">
                                                {{ $latestOrder->orderStatus->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                {{ humanizeDate($latestOrder->created_at) }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="{{ route('dashboard.order.create') }}" class="btn btn-sm btn-info btn-flat pull-left">Place
                            New Order</a>
                        <a href="{{ route('dashboard.order.index') }}"
                           class="btn btn-sm btn-default btn-flat pull-right">View All
                            Orders</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->

                <!-- PRODUCT LIST -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Recently Added Products</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            @foreach($recentProducts as $recentProduct)
                                @php
                                    $productImage = $recentProduct->getImageAttribute();
                                @endphp
                                <li class="item">
                                    <div class="product-img">
                                        <img src="{{ $productImage->smallUrl }}"
                                             alt="{{ $recentProduct->name }}">
                                    </div>
                                    <div class="product-info">
                                        <a href="{{ route('dashboard.product.edit', $recentProduct) }}"
                                           class="product-title">{{ $recentProduct->name }}
                                            <span class="label label-default pull-right">RS{{ $recentProduct->getPrice() }}</span>
                                        </a>
                                        <span class="product-description">{{ $recentProduct->in_stock != 1 ? 'Out of stock' : 'In stock' }}</span>
                                    </div>
                                </li>
                                <!-- /.item -->
                            @endforeach
                        </ul>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                        <a href="{{ route('dashboard.product.index') }}" class="uppercase">View All Products</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->

            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-6 connectedSortable">

            @include('backend.partials.message-success')
            @include('backend.partials.message-error')

            <!-- quick email widget -->
                <form action="{{ route('dashboard.mail') }}" method="post">
                    <div class="box box-default">
                        <div class="box-header">
                            <i class="fa fa-envelope"></i>

                            <h3 class="box-title">Quick Email</h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"
                                        data-toggle="tooltip"
                                        title="Remove">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <!-- /. tools -->
                        </div>
                        <div class="box-body">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email to:">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                <input type="text" name="subject" value="{{ old('subject') }}" class="form-control" placeholder="Subject">

                                @if ($errors->has('subject'))
                                    <span class="help-block">
                                        {{ $errors->first('subject') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message">{{ old('message') }}</textarea>

                                @if ($errors->has('message'))
                                    <span class="help-block">
                                        {{ $errors->first('message') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <button type="submit" class="pull-right btn btn-danger" id="sendEmail">Send
                                <i class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    </div>
                </form>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
@endsection