@extends('layouts.app')

@section('content')
    <section class="form-section register-form">
        <div class="container">
            <h1 class="h2 heading-primary font-weight-normal mb-md mt-xlg">Reset Password</h1>

            <div class="featured-box featured-box-primary featured-box-flat featured-box-text-left mt-md">
                <div class="box-content">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('password.email') }}" method="post">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-12{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="form-group">
                                    <label for="email" class="font-weight-normal">Email Address
                                        <span class="required">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" class="form-control" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">

                                <div class="form-action clearfix mt-none">
                                    <a href="{{ route('login') }}" class="pull-left">
                                        <i class="fa fa-angle-double-left"></i> Back</a>

                                    <input type="submit" class="btn btn-primary" value="Send Password Reset Link">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
