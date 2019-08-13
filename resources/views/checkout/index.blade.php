@extends('layouts.app')

@section('content')
    <section class="page-header mb-lg">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li class="active">Checkout</li>
            </ul>
        </div>
    </section>


    <div class="checkout">
        <div class="container">
            <div class="row">
                @if(Cart::instance('default')->count())
                    <form action="{{ route('checkout.store') }}" method="post">
                        {{ csrf_field() }}
                        @if(isset($address->id))
                            <input type="hidden" name="address_id" value="{{ $address->id }}">
                        @endif
                        @include('checkout.form')
                    </form>
                @else
                    <div class="col-md-12">
                        <div class="well">
                            <p><strong>No items found in cart.</strong></p>
                            <p><a href="{{ url('/shop') }}" class="btn btn-sm btn-primary">Back to shop</a></p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush