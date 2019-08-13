<!-- general form elements -->
<div class="box">
    <div class="box-body">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::text('name',null, ['class'=> 'form-control', 'placeholder' => 'Name', 'required' => 'required', 'autofocus' => 'autofocus']) !!}

            @if ($errors->has('name'))
                <span class="help-block">
                    {{ $errors->first('name') }}
                </span>
            @endif
        </div>

        <div class="form-group mb-none{{ $errors->has('parent_id') ? ' has-error' : '' }}">
            <select name="parent_id" id="parent" class="form-control select2">
                <option value="0">Select Parent Category</option>
                @foreach($allCategories as $category)
                    <option value="{{ $category->id }}" @if(isset($cat->parent) && $cat->parent->id == $category->id) selected="selected" @endif>{{ $category->name }}</option>
                    @include('backend.categories.category-dropdown')
                @endforeach
            </select>

            @if ($errors->has('parent_id'))
                <span class="help-block">
                    {{ $errors->first('parent_id') }}
                </span>
            @endif
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        {!! Form::submit($submitButtonText, ['class'=>'btn btn-danger pull-right']) !!}
    </div>
</div>
<!-- /.box -->