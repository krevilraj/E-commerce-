@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('my-account') }}">My Account</a></li>
                <li class="active">Order</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 my-account">
                <h1 class="h2 heading-primary font-weight-normal">View Order</h1>
                <p>Order #{{ $order->id }} was placed
                    on {{ \Carbon\Carbon::parse($order->order_date)->format('F j, Y')}} and is
                    <span class="label label-{{ getOrderStatusClass($order->orderStatus->name) }}">
                        {{ $order->orderStatus->name }}
                    </span>
                </p>

                <div class="order-details">
                    <h2>Order Details</h2>

                    @if(count($order->products) <= 0)
                        <p>Sorry no products found.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Total</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $priceTotal = 0.00;
                            @endphp
                            @foreach($order->products as $product)
                                @php
                                    $discount = $product->pivot->discount;
                                    $actualPrice = $product->pivot->price * $product->pivot->qty;

                                    $discountAmount = $actualPrice * ( $discount / 100 );
                                    $productSubTotal = $actualPrice - ( $discountAmount );
                                    $priceTotal += $actualPrice - ( $discountAmount );
                                @endphp

                                <tr>
                                    <td>
                                        <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                        <strong>x {{ $product->pivot->qty }}</strong>
                                    </td>
                                    <td>RS {{ number_format($product->pivot->price, 2) }}</td>
                                    <td>RS {{ number_format($discountAmount, 2) }}</td>
                                    <td>RS {{ number_format($productSubTotal, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                @php
                                    $subTotal = $priceTotal;
                                    $tax = 0;
                                    if ($order->enable_tax) {
                                        $tax = ($subTotal * $order->tax_percentage) / 100;
                                    }
                                    $grandTotal = $subTotal + $tax;
                                @endphp
                                <tr>
                                    <td colspan="3">Subtotal:</td>
                                    <td>RS {{ number_format($subTotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">Tax:</td>
                                    <td>RS {{ number_format($tax, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">Total:</td>
                                    <td>RS {{ number_format($grandTotal, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    @endif
                </div>

                <div class="customer-details">
                    <h2>Customer Details</h2>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>Email</td>
                            <td>
                                <a href="mailto:{{ $order->getShippingAddressAttribute()->email }}">
                                    {{ $order->getShippingAddressAttribute()->email }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $order->getShippingAddressAttribute()->phone }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="address-details">
                    <h2>Address Details</h2>
                    <address class="mb-none">
                        {{ $order->getShippingAddressAttribute()->first_name . ' ' . $order->getShippingAddressAttribute()->last_name }}
                        <br>
                        {{ $order->getShippingAddressAttribute()->address1 . ' ' . $order->getShippingAddressAttribute()->address2 }}
                        <br>
                        {!! isset($order->getShippingAddressAttribute()->city) ? $order->getShippingAddressAttribute()->city .'<br/>' : '' !!}
                        {!! isset($order->getShippingAddressAttribute()->state_id->name) ? $order->getShippingAddressAttribute()->state_id->name . '<br/>' : '' !!}
                        {{ $order->getShippingAddressAttribute()->postcode }}
                    </address>
                </div>

            </div>

            @include('my-account.sidebar')

        </div>
    </div>
@endsection
