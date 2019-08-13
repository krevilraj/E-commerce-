@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('my-account') }}">My Account</a></li>
                <li class="active">Edit Address</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 my-account">
                <h1 class="h2 heading-primary font-weight-normal">Edit Address</h1>

                @include('partials.message-success')

                <form action="{{ route('my-account.update-address.shipping') }}" method="post">
                    {{ csrf_field() }}
                    @include('my-account.form-address')
                </form>

            </div>
            @include('my-account.sidebar')
        </div>
    </div>
@endsection
