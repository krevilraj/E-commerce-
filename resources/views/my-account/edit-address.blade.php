@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('my-account') }}">My Account</a></li>
                <li class="active">Address</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 my-account">
                <h1 class="h2 heading-primary font-weight-normal">My Address</h1>

                <div class="alert alert-success mb-xlg" role="alert">
                    The following addresses will be used on the checkout page by default.
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel-box">
                            <div class="panel-box-title">
                                <h3>ADDRESS BOOK</h3>
                                <a href="{{ route('my-account.edit-address.shipping') }}" class="panel-box-edit">Edit
                                    Address</a>
                            </div>

                            <div class="panel-box-content">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <address>
                                            @if(!isset($shippingAddress))
                                                You have not set a default address.
                                            @else
                                                {{ $shippingAddress->first_name . ' ' . $shippingAddress->last_name }}
                                                <br>
                                                {{ $shippingAddress->address1 . ' ' . $shippingAddress->address2 }}
                                                <br>
                                                {!! isset($shippingAddress->city) ? $shippingAddress->city .'<br/>' : '' !!}
                                                {!! isset($shippingAddress->state_id->name) ? $shippingAddress->state_id->name . '<br/>' : '' !!}
                                                {{ $shippingAddress->postcode }}
                                            @endif
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('my-account.sidebar')
        </div>
    </div>
@endsection
