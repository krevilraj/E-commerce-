@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('my-account') }}">My Account</a></li>
                <li class="active">Edit Password</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 my-account">
                <h1 class="h2 heading-primary font-weight-normal">Edit Password</h1>

                @include('partials.message-success')
                @include('partials.message-error')

                <form action="{{ route('my-account.update-password') }}" method="post">
                    {{ csrf_field() }}
                    @include('my-account.form-password')
                </form>

            </div>
            @include('my-account.sidebar')
        </div>
    </div>
@endsection
