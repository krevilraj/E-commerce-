@extends('layouts.app')

@section('content')
    <div class="checkout">
        <div class="container">
            <h1 class="h2 heading-primary mt-lg mb-md clearfix">
                {{ $title }}
            </h1>

            <div class="row">
                <div class="col-md-12">
                    @if(session('order'))
                        <div class="alert alert-success mb-none">
                            <strong><i class="fa fa-thumbs-o-up"></i> Success!</strong>
                            Thank you. Your order has been received.
                            <p><a href="{{ url('my-account/orders') }}">View order details</a></p>
                        </div>
                    @else
                        <div class="alert alert-primary mb-none">
                            <strong><i class="fa fa-warning"></i>Oh snap!</strong>
                            <span class="text-light">Something went wrong! Please try again.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush