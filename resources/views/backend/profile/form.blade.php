<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
    <label for="first_name" class="col-sm-2 control-label">First Name *</label>
    <div class="col-sm-10">
        <input type="text" name="first_name" class="form-control" id="first_name"
               value="{{ $user->first_name or old('first_name') }}" required>
        @if ($errors->has('first_name'))
            <span class="help-block">
                {{ $errors->first('first_name') }}
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
    <label for="last_name" class="col-sm-2 control-label">Last Name *</label>
    <div class="col-sm-10">
        <input type="text" name="last_name" id="last_name" class="form-control"
               value="{{ $user->last_name or old('last_name') }}" required>
        @if ($errors->has('last_name'))
            <span class="help-block">
                {{ $errors->first('last_name') }}
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label for="email" class="col-sm-2 control-label">Email *</label>
    <div class="col-sm-10">
        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email or old('email') }}"
               required>
        @if ($errors->has('email'))
            <span class="help-block">
                {{ $errors->first('email') }}
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
    <label for="phone" class="col-sm-2 control-label">Phone</label>
    <div class="col-sm-10">
        <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone or old('phone') }}">
        @if ($errors->has('phone'))
            <span class="help-block">
                    {{ $errors->first('phone') }}
                </span>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2"></div>
    <div class="col-sm-10">
        <h4 class="m-none">Leave Password field blank to keep unchanged.</h4>
    </div>
</div>

<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    <label for="password" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
        <input type="text" name="password" id="password" class="form-control">
        @if ($errors->has('password'))
            <span class="help-block">
                {{ $errors->first('password') }}
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="password_confirmation" class="col-sm-2 control-label">Confirm Password</label>
    <div class="col-sm-10">
        <input type="text" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>
</div>

<div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
    <label for="avatar" class="col-sm-2 control-label">Avatar</label>
    <div class="col-sm-10">
        <input type="file" name="avatar" id="avatar" class="form-control">
        @if ($errors->has('avatar'))
            <span class="help-block">
                {{ $errors->first('avatar') }}
            </span>
        @endif

        @if(optional($user->getImage())->smallUrl)
            <div class="mt-15">
                <img src="{{ optional($user->getImage())->smallUrl  }}"
                     class="thumbnail img-responsive">
            </div>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger pull-right">Update</button>
    </div>
</div>