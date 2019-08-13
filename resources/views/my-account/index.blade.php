@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li class="active">My-Account</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 my-account">
                <h1 class=" heading-primary font-weight-normal" style="text-align: center;border-bottom: 2px sol">Welcome
                                            @if(isset($shippingAddress))
 {{ $shippingAddress->first_name . ' ' . $shippingAddress->last_name }}
@endif
</h1>



                <div class="row">
                    <div class="col-xs-12 col-md-6">
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
                                              <h2 style="color: #57BC90">  {{ $shippingAddress->first_name . ' ' . $shippingAddress->last_name }}
                                              </h2>
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
                    <div class="col-sm-6">
                        @include('blog.sidebar2')

                    </div>
                </div>
            </div>

            @include('my-account.sidebar')


        </div>
    </div>

@endsection
