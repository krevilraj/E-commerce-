@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('my-account') }}">My Account</a></li>
                <li class="active">Enquiries</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 my-account">
                <h1 class="h2 heading-primary font-weight-normal">Product Enquiries</h1>

                @include('partials.message-success')

                @if(count($productEnquiries) <= 0)
                    <div class="alert alert-danger">
                        <p>No enquiries has been made yet.</p>
                    </div>
                @else


                    <table class="table table-bordered table-order-list table-content-align-center mb-none">
                        <thead>
                        <tr>
                            <td>I.D</td>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Original Price</th>
                            <th>Discount(%)</th>
                            <th>Price</th>

                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($productEnquiries as $enquiry)

                            <tr>
                                <td><a href="">{{ $enquiry->id }}</a></td>

                                <td>{{ \Carbon\Carbon::parse($enquiry->created_at)->format('F j, Y')}}</td>

                                <td>
                                    <a href="{{ route('product.show',$enquiry->product->slug )}}">{{ $enquiry->product->name }}</a>
                                </td>
                                <td>
                                    {{ $enquiry->quantity }}
                                </td>
                                <td>
                                    @if(isset($enquiry->discount))
                                        {{\App\Product::where('id',$enquiry->product_id)->first()->regular_price}}
                                        @else
                                        -
                                @endif</td>
                                <td>
                                    {{ $enquiry->discount or '-' }}
                                </td>
                                <td>
                                    @if(isset($enquiry->discount))
                                        @php
                                            $price      = $enquiry->quantity * $enquiry->product->getPrice();
                                            $priceTotal = $price - ( $price * ( $enquiry->discount / 100 ) );
                                            $priceTotal = 'RS ' . $priceTotal;
                                        @endphp
                                        {{ $priceTotal }}
                                    @else
                                        <span class="label label-danger">
                                        Pending Enquiry
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($enquiry->discount) && !$enquiry->ordered)
                                        <form action="{{ route('my-account.enquiries.order') }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">
                                            <input type="hidden" name="product_id" value="{{ $enquiry->product_id }}">
                                            <button type="submit" class="btn btn-sm btn-primary p-6-12">Order Now
                                            </button>
                                        </form>
                                    @else
                                        -
                                    @endif
<form action="{{ route('my-account.enquiries.cancel') }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">
                                            <button type="submit" class="btn btn-sm btn-primary p-6-12">Cancel
                                            </button>
                                        </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="pull-right">
                        {{ $productEnquiries->setPath('enquiries')->render() }}
                    </div>
                @endif

            </div>

            @include('my-account.sidebar')
        </div>
    </div>
@endsection
