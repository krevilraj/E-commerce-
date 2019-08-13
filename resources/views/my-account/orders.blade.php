@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('my-account') }}">My Account</a></li>
                <li class="active">Orders</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 my-account">
                <h1 class="h2 heading-primary font-weight-normal">My Orders</h1>

                @include('partials.message-success')

                @if(count($orders) <= 0)
                    <div class="alert alert-danger">
                        <p>No order has been made yet.</p>
                    </div>
                @else


                    <table class="table table-bordered table-order-list table-content-align-center mb-none">
                        <thead>
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><a href="{{ route('my-account.order.view',$order->id )}}">#{{ $order->id }}</a></td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('F j, Y')}}</td>
                                <td>
                                    <span class="label label-{{ getOrderStatusClass($order->orderStatus->name) }}">
                                        {{ $order->orderStatus->name }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $priceTotal = 0.00;
                                        foreach ($order->products as $product){
                                            $discount = $product->pivot->discount;
                                            $actualPrice = $product->pivot->price * $product->pivot->qty;

                                            $discountAmount = $actualPrice * ( $discount / 100 );
                                            $productSubTotal = $actualPrice - ( $discountAmount );
                                            $priceTotal += $actualPrice - ( $discountAmount );
                                        }

                                        $subTotal = $priceTotal;
                                        $tax = 0;
                                        if ($order->enable_tax) {
                                            $tax = ($subTotal * $order->tax_percentage) / 100;
                                        }
                                        
                                        $grandTotal = $subTotal + $tax;
                                    @endphp
                                    RS <span class="label label-default">{{ number_format($grandTotal, 2) }}</span> for
                                    <strong>{{ count($order->products) }}</strong> Products
                                </td>
                                <td>
                                    @if($order->orderStatus->name == 'Pending')
                                        <a href="{{ route('my-account.order.cancel',$order->id )}}"
                                           class="btn btn-sm btn-primary p-6-12"
                                           onclick="return confirm('Are you sure you want to cancel this order?');">Cancel</a>
                                    @endif
                                    <a href="{{ route('my-account.order.view',$order->id )}}"
                                       class="btn btn-sm btn-primary p-6-12">View</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="pull-right">
                        {{ $orders->setPath('orders')->render() }}
                    </div>
                @endif

            </div>

            @include('my-account.sidebar')
        </div>
    </div>
@endsection
