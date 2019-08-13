<div class="form-col">
    <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
        <label for="current_password">Current Password<span class="required">*</span></label>
        <input type="password" name="current_password" id="current_password" class="form-control" required>

        @if ($errors->has('current_password'))
            <span class="help-block">
                {{ $errors->first('current_password') }}
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password">New Password<span class="required">*</span></label>
        <input type="password" name="password" id="password" class="form-control" required>

        @if ($errors->has('password'))
            <span class="help-block">
                {{ $errors->first('password') }}
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label for="password_confirmation">Confirm New Password<span class="required">*</span></label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>

        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                {{ $errors->first('password_confirmation') }}
            </span>
        @endif
    </div>

    <button type="submit" class="btn btn-primary pull-right">Change Password</button>
</div>