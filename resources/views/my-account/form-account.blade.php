<div class="form-col">
    <div class="row">
        <div class="col-xs-6 col-md-6">
            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                <label for="first_name">First Name<span class="required">*</span></label>
                <input type="text" name="first_name"
                       value="{{ isset($user->first_name) ? $user->first_name : old('first_name') }}"
                       id="first_name"
                       class="form-control" required>
                @if ($errors->has('first_name'))
                    <span class="help-block">
                        {{ $errors->first('first_name') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-xs-6 col-md-6">
            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                <label for="last_name">Last Name<span class="required">*</span></label>
                <input type="text" name="last_name"
                       value="{{ isset($user->last_name) ? $user->last_name : old('last_name') }}"
                       id="last_name"
                       class="form-control" required>
                @if ($errors->has('last_name'))
                    <span class="help-block">
                        {{ $errors->first('last_name') }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 col-md-6">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">Email<span class="required">*</span></label>
                <input type="email" name="email"
                       value="{{ isset($user->email) ? $user->email : old('email') }}" id="email"
                       class="form-control" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-xs-6 col-md-6">
            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <label for="phone">Phone</label>
                <input type="tel" name="phone"
                       value="{{ isset($user->phone) ? $user->phone : old('phone') }}" id="phone"
                       class="form-control">

                @if ($errors->has('phone'))
                    <span class="help-block">
                        {{ $errors->first('phone') }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row hidden">
        <div class="col-xs-12 col-md-12">
            <div class="form-group{{ $errors->has('profile_image') ? ' has-error' : '' }}">
                <label for="profile_image">Profile Image</label>
                <input type="file" name="profile_image" id="profile_image" class="form-control">

                @if ($errors->has('profile_image'))
                    <span class="help-block">
                        {{ $errors->first('profile_image') }}
                    </span>
                @endif
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <button type="submit" class="btn btn-primary pull-right">Update</button>
        </div>
    </div>
</div>