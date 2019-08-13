<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

<form action="{{ route('login') }}" method="post" id="form-login">
    {{ csrf_field() }}
    <div class="form-content">
        <div class="row">
            <div class="col-xs-6 col-facebook">
                <a href="{{ url('/login', ['facebook']) }}"
                   class="btn btn-primary btn-block btn-facebook">
                    <i class="fa fa-facebook mr-sm"></i>Facebook
                </a>
            </div>
            <div class="col-xs-6 col-google">
                <a href="{{ url('/login', ['google']) }}"
                   class="btn btn-primary btn-block btn-google">
                    <i class="fa fa-google-plus mr-sm"></i>Google
                </a>
            </div>
            <div class="col-xs-12">
                <div class="heading heading-border heading-middle-border heading-middle-border-center mt-sm mb-sm">
                    <h1>or</h1>
                </div>
            </div>
        </div>

        <div class="alert alert-danger alert-account"></div>

        <div class="form-group">
            <label for="email" class="font-weight-normal">Email Address
                <span class="required">*</span>
            </label>
            <input type="email" name="email" id="email" class="form-control"
                   required
                   autofocus>
        </div>

        <div class="form-group">

            <label for="password" class="font-weight-normal">Password
                <span class="required">*</span>
            </label>
            <input type="password" name="password" id="password"
                   class="form-control"
                   required>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>

                    <input type="checkbox" style="zoom: 1.5;margin-left: -14px"  onchange="document.getElementById('send111').disabled = !this.checked" /> <div style="margin-top: 3px">Check If You Are A Human</div>

                </label >
                <label class="lebel-remember">
                    <input style="zoom: 1.5;margin-left: -14px" type="checkbox" name="remember"> <div style="margin-top: 3px">Remember Me</div>
                </label>
            </div>
        </div>

        <button type="submit" id="send111" class="btn btn-primary btn-account"
                data-loading-text="Loading...">Login
        </button>
        <a href="{{ route('password.request')}}" class="ml-sm">Forgot Your  Password?</a>
    </div>
</form>

<form action="{{ route('register') }}" method="post">
    {{ csrf_field() }}

    <h4 class="heading-primary text-uppercase mb-lg">PERSONAL INFORMATIONs</h4>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                <label for="first_name" class="font-weight-normal">First Name
                    <span class="required">*</span>
                </label>
                <input type="text" name="first_name" id="first_name" class="form-control"
                       value="{{ old('first_name') }}" required>

                @if ($errors->has('first_name'))
                    <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                <label for="last_name" class="font-weight-normal">Last Name
                    <span class="required">*</span></label>
                <input name="last_name" id="last_name" type="text" class="form-control"
                       {{ old('last_name') }} required>

                @if ($errors->has('last_name'))
                    <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6{{ $errors->has('email') ? ' has-error' : '' }}">
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

            <h4 class="heading-primary text-uppercase mb-lg">LOGIN INFORMATION</h4>
        </div>
        <div class="col-xs-6{{ $errors->has('phone') ? ' has-error' : '' }}">
            <div class="form-group">
                <label for="phone" class="font-weight-normal">Phone
                    <span class="required">*</span>
                </label>
                <input type="tel" name="phone" id="phone" class="form-control" required>

                @if ($errors->has('phone'))
                    <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                @endif
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
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

        <div class="col-sm-6">
            <div class="form-group">
                <label for="password-confirm" class="font-weight-normal">Confirm Password <span
                            class="required">*</span></label>
                <input type="password" name="password_confirmation" id="password-confirm"
                       class="form-control" required>
            </div>
        </div>
    </div>
    <input type="checkbox" style="margin-bottom:10px"   onchange="document.getElementById('send').disabled = !this.checked" /> Check If You Are A Human


    <div class="row">
        <div class="col-xs-12">
            <p class="required mt-lg mb-none">* Required Fields</p>

            <div class="form-action clearfix mt-none">
                <a href="{{ route('login') }}" class="pull-left"><i
                            class="fa fa-angle-double-left"></i> Back</a>

                <input type="submit" class="btn btn-primary" value="Submit" id="send" disabled>
            </div>
        </div>
    </div>
</form>

</body>
</html>