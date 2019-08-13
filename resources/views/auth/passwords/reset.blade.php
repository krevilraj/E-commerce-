@extends('layouts.app')

@section('content')
    <section class="form-section register-form">
        <div class="container">
            <h1 class="h2 heading-primary font-weight-normal mb-md mt-xlg">Reset Password</h1>

            <div class="featured-box featured-box-primary featured-box-flat featured-box-text-left mt-md">
                <div class="box-content">
                    <form action="{{ route('password.request') }}" method="post">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row">
                            <div class="col-xs-4{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="form-group">
                                    <label for="email" class="font-weight-normal">Email Address
                                        <span class="required">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" class="form-control"value="{{ $email or old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="font-weight-normal">Password <span
                                                class="required">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="password-confirm" class="font-weight-normal">Confirm Password <span
                                                class="required">*</span></label>
                                    <input type="password" name="password_confirmation" id="password-confirm"
                                           class="form-control" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <p class="required mt-lg mb-none">* Required Fields</p>

                                <div class="form-action clearfix mt-none">
                                    <a href="{{ route('login') }}" class="pull-left"><i
                                                class="fa fa-angle-double-left"></i> Back</a>

                                    <input type="submit" class="btn btn-primary" value="Reset Password">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
