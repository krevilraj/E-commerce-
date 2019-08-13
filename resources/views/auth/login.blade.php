@extends('layouts.app')
<style>

</style>
@section('content')
    <section class="form-section">
        <div class="container">
            <h1 class="h2 heading-primary font-weight-normal mb-md mt-xlg">Login or Create an Account</h1>

            <div class="featured-box featured-box-primary featured-box-flat featured-box-text-left mt-md">
                <div class="box-content">
                    <form action="{{ route('login') }}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-content" style="min-height:0px">
                                    <h3 class="heading-text-color font-weight-normal">New Customers</h3>
                                    <p>By creating an account with our store, you will be able to move through the
                                        checkout process faster, store multiple shipping addresses, view and track
                                        your orders in your account and more.</p>
                                </div>
<div class="login-image">
                                                   <img src="{{ url('storage') . '/' . getConfiguration('login-img') }}"
                                          alt="Image" height="300px" width="100%"/>   </div>                             
                            </div>
                            <div class="col-sm-6">
                                <div class="form-content">
                                    <h3 class="heading-text-color font-weight-normal">Registered Customers</h3>
                                    <p>If you have an account with us, please log in.</p>

                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-facebook">
                                            <a href="{{ url('/login', ['facebook']) }}" class="btn btn-primary btn-block btn-facebook">
                                                <i class="fa fa-facebook mr-sm"></i>Facebook
                                            </a>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-google">
                                            <a href="{{ url('/login', ['google']) }}" class="btn btn-primary btn-block btn-google">
                                                <i class="fa fa-google-plus mr-sm"></i>Google
                                            </a>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="heading heading-border heading-middle-border heading-middle-border-center mt-sm mb-sm">
                                                <h1>or</h1>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="font-weight-normal">Email Address
                                            <span class="required">*</span>
                                        </label>
                                        <input type="email" name="email" id="email" class="form-control"
                                               value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{!! $errors->first('email') !!}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="font-weight-normal">Password
                                            <span class="required">*</span>
                                        </label>
                                        <input type="password" name="password" id="password" class="form-control"
                                               required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                     <div class="form-group">
                                        <div class="checkbox">
                                        <label>

                                                <input type="checkbox" style="zoom: 1.5;margin-left: -14px"  onchange="document.getElementById('send444').disabled = !this.checked" /> <div style="margin-top: 3px">Check If You Are A Human</div>

                                            </label >
                                           
                                        
                                            <label class="label-remember">
                                                <input style="zoom: 1.5;margin-left: -14px" type="checkbox" name="remember"> <div style="margin-top: 3px">Remember Me</div>
                                            </label>
                                        </div>
                                    </div>
                                    <p class="required">* Required Fields</p>
                                </div>

                                <div class="form-action clearfix">
                                    <a href="{{ route('password.request') }}" class="pull-left">Forgot Your Password?</a>
                                    <input type="submit" class="btn btn-primary" value="Login" id="send444"   data-loading-text="Loading..." disabled>
                                                                          </div>
{{--<div class="form-action clearfix">--}}
                                    <a href="{{ route('register') }}">Create an Account</a>
                                {{--</div>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection