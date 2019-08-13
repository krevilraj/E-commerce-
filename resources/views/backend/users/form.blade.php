<div class="box-body">

    <div class="form-group @if ($errors->has('first_name')) has-error @endif">
        {!! Form::label('first_name','First Name *', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('first_name',null, ['class'=> 'form-control']) !!}
            @if ($errors->has('first_name'))
                <span class="help-block">
                    {{ $errors->first('first_name') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group @if ($errors->has('last_name')) has-error @endif">
        {!! Form::label('last_name','Last Name *', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('last_name',null, ['class'=> 'form-control']) !!}
            @if ($errors->has('last_name'))
                <span class="help-block">
                    {{ $errors->first('last_name') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group @if ($errors->has('email')) has-error @endif">
        {!! Form::label('email','Email *', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('email',null, ['class'=> 'form-control']) !!}
            @if ($errors->has('email'))
                <span class="help-block">
                    {{ $errors->first('email') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group @if ($errors->has('phone')) has-error @endif">
        {!! Form::label('phone','Phone', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('phone',null, ['class'=> 'form-control']) !!}
            @if ($errors->has('phone'))
                <span class="help-block">
                    {{ $errors->first('phone') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group @if ($errors->has('role')) has-error @endif">
        {!! Form::label('role','Role *', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('role', ['' => 'Select Role'] + $roles + [0 => 'Client'], [isset($activeRole)? $activeRole->id:null], ['class' => 'form-control']) !!}
            @if ($errors->has('role'))
                <span class="help-block">
                    {{ $errors->first('role') }}
                </span>
            @endif
        </div>
    </div>

    @if(isset($user))
        <div class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <h4 class="m-none">Leave Password field blank to keep unchanged.</h4>
            </div>
        </div>
    @endif

    <div class="form-group @if ($errors->has('password')) has-error @endif">
        {!! Form::label('password','Password *', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::password('password', ['class'=> 'form-control']) !!}
            @if ($errors->has('password'))
                <span class="help-block">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('password_confirmation','Confirm Password *', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::password('password_confirmation', ['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="form-group @if ($errors->has('active')) has-error @endif">
        {!! Form::label('active','Active *', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('active', ['' => 'User','1'=>'Active','0'=>'Not-active'], [($user->active==1)?1:0], ['class' => 'form-control']) !!}
            @if ($errors->has('active'))
                <span class="help-block">
                    {{ $errors->first('active') }}
                </span
            @endif
        </div>
    </div>

    <div class="form-group @if ($errors->has('image_path')) has-error @endif">
        {!! Form::label('image_path','Profile Image', ['class' => 'col-sm-2 control-label']) !!}

        {!! Form::file('image_path', ['class'=> 'form-control']) !!}

        @if ($errors->has('image_path'))
            <span class="help-block">
                        {{ $errors->first('image_path') }}
                    </span>
        @endif

        @if(isset($user) && null !== $user->getImage())
            <div class="mt-15">
                <img src="{{ $user->getImage()->mediumUrl }}" class="thumbnail img-responsive mb-none">
            </div>
        @endif

    </div>

</div>
<!-- /.box-body -->
<div class="box-footer">
    <a href="{{ route('dashboard.users.index') }}" class="btn btn-default">Cancel</a>
    {!! Form::submit($submitButtonText, ['class'=>'btn btn-danger pull-right']) !!}
</div>
<!-- /.box-footer -->