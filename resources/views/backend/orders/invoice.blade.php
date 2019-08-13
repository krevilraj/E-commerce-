@extends('backend.layouts.invoice')

@section('content')
        <!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <img src="{{ asset('img/logo.png') }}" alt="" width="166" height="58">

            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>{{getConfiguration('company_name') ? getConfiguration('company_name') : env('APP_NAME')}}</strong><br>
                {{getConfiguration('site_address') ? getConfiguration('site_address') : ''}} <br>
                {{getConfiguration('site_primary_phone') ? getConfiguration('site_primary_phone') : ''}}{{getConfiguration('site_secondary_phone') ? ', '.getConfiguration('site_secondary_phone') : ''}}
                <br>
                {{getConfiguration('site_primary_email') ? getConfiguration('site_primary_email') : ''}}{{getConfiguration('site_secondary_email') ? ', '.getConfiguration('site_secondary_email') : ''}}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong>{{ $userDetails->first_name . ' ' . $userDetails->last_name }}</strong><br>
                {{ $userDetails->address1 }}<br>
                {{ isset($userDetails->address2) ? $userDetails->address2 . '<br>' : '' }}
                {{ $userDetails->city }}<br>
                {{ $state->name }}{{ isset($userDetails->postcode) ? ', ' . $userDetails->postcode : '' }}<br>
                Phone: {{ $userDetails->phone }}<br>
                Email: {{ $userDetails->email }}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Invoice #{{ $order->id }}</b><br>
            <b>Order Status:</b> {{ $order->orderStatus->name }}<br>
            <b>Created:</b> {{ Carbon\Carbon::now()->format('d/m/Y') }}
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Discount Amount</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                @php
                $discountAmount_ = 0;
                $productSubTotal_ = 0;
                @endphp
                @foreach($products = $order->products as $product)
                    @php
                    $discount = $product->pivot->discount;
                    $actualPrice = $product->getPrice() * $product->pivot->qty;

                    $discountAmount = $actualPrice * ( $discount / 100 );
                    //$discountAmount_ += $actualPrice * ( $discount / 100 );
                    $productSubTotal = $actualPrice - ( $discountAmount );
                    $productSubTotal_ += $actualPrice - ( $discountAmount );
                    @endphp

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->qty }}</td>
                        <td>RS {{ number_format($actualPrice, 2) }}</td>
                        <td>RS {{ number_format($discountAmount, 2) }}</td>
                        <td>RS {{ number_format($productSubTotal, 2) }}</td>
                    </tr>
                @endforeach

                @php
                $tax = 0;
                if ($order->enable_tax) {
                $tax = ($productSubTotal_ * $order->tax_percentage) / 100;
                }

                $grandTotal = $productSubTotal_ + $tax;
                @endphp
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-8">

        </div>
        <!-- /.col -->
        <div class="col-xs-4">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Subtotal:</th>
                        <td>RS {{ number_format($productSubTotal_, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Tax:</th>
                        <td>RS {{ number_format($tax, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td>RS {{ number_format($grandTotal, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection