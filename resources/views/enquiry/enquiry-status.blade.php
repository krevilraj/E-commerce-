@extends('layouts.app')

@section('content')
    <section class="page-header mb-lg">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li class="active">Enquiry Status</li>
            </ul>
        </div>
    </section>

    <div class="checkout">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(session('enquiry'))
                        <div class="alert alert-success mb-none">
                            <strong><i class="fa fa-thumbs-o-up"></i>Success!</strong>
                            Thank you. We have received your enquiry.
                            <p><a href="{{ route('my-account.enquiries') }}">View enquiry details</a></p>
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