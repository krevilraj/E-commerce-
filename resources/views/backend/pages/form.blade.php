<div class="col-md-9">
    <div class="box box-default">
        <div class="box-body">

            <div class="form-group @if ($errors->has('name')) has-error @endif">
                {!! Form::label('name','Name *', ['class' => 'control-label']) !!}
                {!! Form::text('name',null, ['class'=> 'form-control']) !!}
                @if ($errors->has('name'))
                    <span class="help-block">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>

            <div class="form-group @if ($errors->has('content')) has-error @endif">
                {!! Form::label('content','Content', ['class' => 'control-label']) !!}
                {{ Form::textarea('content', null, ['class' => 'form-control']) }}
                @if ($errors->has('content'))
                    <span class="help-block">
                        {{ $errors->first('content') }}
                    </span>
                @endif

            </div>

            <h4>SEO</h4>

            <div class="form-group @if ($errors->has('meta_title')) has-error @endif">
                {!! Form::label('meta_title','Meta Title', ['class' => 'control-label']) !!}
                {!! Form::text('meta_title',null, ['class'=> 'form-control']) !!}
                @if ($errors->has('meta_title'))
                    <span class="help-block">
                        {{ $errors->first('meta_title') }}
                    </span>
                @endif
            </div>

            <div class="form-group @if ($errors->has('meta_description')) has-error @endif">
                {!! Form::label('meta_description','Meta Description', ['class' => 'control-label']) !!}
                {!! Form::textarea('meta_description',null, ['class'=> 'form-control', 'rows' => '5']) !!}
                @if ($errors->has('meta_description'))
                    <span class="help-block">
                        {{ $errors->first('meta_description') }}
                    </span>
                @endif
            </div>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</div>

<div class="col-md-3">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Page Attributes</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="form-group @if ($errors->has('parent')) has-error @endif">
                {!! Form::label('parent','Parent', ['class' => 'control-label']) !!}
                {{ Form::select('parent', $pages, null, ['class' => 'form-control']) }}
                @if ($errors->has('parent'))
                    <span class="help-block">
                        {{ $errors->first('parent') }}
                    </span>
                @endif
            </div>

            <div class="form-group @if ($errors->has('template')) has-error @endif">
                {!! Form::label('template','Template *', ['class' => 'control-label']) !!}
                {{ Form::select('template', $templates, null, ['class' => 'form-control']) }}
                @if ($errors->has('template'))
                    <span class="help-block">
                        {{ $errors->first('template') }}
                    </span>
                @endif
            </div>

            <div class="form-group @if ($errors->has('featured_image')) has-error @endif">
                {!! Form::label('featured_image','Featured Image', ['class' => 'control-label']) !!}
                {!! Form::file('featured_image', ['class'=> 'form-control']) !!}
                @if ($errors->has('featured_image'))
                    <span class="help-block">
                        {{ $errors->first('featured_image') }}
                    </span>
                @endif

                @if(isset($page) && null !== $page->getImage())
                    <div class="mt-15">
                        <img src="{{ $page->getImage()->mediumUrl }}" class="thumbnail img-responsive mb-none">
                    </div>
                @endif

            </div>

        </div>
        <div class="box-footer">
            {!! Form::submit($submitButtonText, ['class'=>'btn btn-danger pull-right']) !!}
        </div>
    </div>
</div>