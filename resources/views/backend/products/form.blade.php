<div class="col-md-9">
    <!-- general form elements -->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Product</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name','Name *') !!}
                {!! Form::text('name',null, ['class'=> 'form-control']) !!}

                @if ($errors->has('name'))
                    <span class="help-block">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }}">
                {!! Form::label('short_description','Short Description') !!}
                {{ Form::textarea('short_description', null, ['rows' => 6, 'class' => 'form-control ckeditor']) }}

                @if ($errors->has('short_description'))
                    <span class="help-block">
                        {{ $errors->first('short_description') }}
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description','Description') !!}
                {{ Form::textarea('description', null, ['rows' => 10, 'class' => 'form-control ckeditor']) }}

                @if ($errors->has('description'))
                    <span class="help-block">
                        {{ $errors->first('description') }}
                    </span>
                @endif
            </div>

            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse1">Images</a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                        <div class="panel-body">
                            @include('backend.products.images')
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-tab-content">
                <ul class="nav nav-tabs">
                    <li class="general active">
                        <a href="#tab_general" data-toggle="tab"
                           aria-expanded="true">General</a>
                    </li>
                    <li class="inventory">
                        <a href="#tab_stock" data-toggle="tab"
                           aria-expanded="false">Inventory</a>
                    </li>
                    <li class="faqs">
                        <a href="#tab_specification" data-toggle="tab"
                           aria-expanded="false">Specification</a>
                    </li>
                    <li class="faqs">
                        <a href="#tab_faqs" data-toggle="tab"
                           aria-expanded="false">FAQs</a>
                    </li>
                    <li class="faqs">
                        <a href="#tab_downloads" data-toggle="tab"
                           aria-expanded="false">Downloads</a>
                    </li>
                    <li class="seo">
                        <a href="#tab_seo" data-toggle="tab">SEO</a>
                    </li>
                    <li class="advanced">
                        <a href="#tab_advanced" data-toggle="tab">Advanced</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-general tab-pane active" id="tab_general">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
                                    {!! Form::label('sku','SKU', ['class' => 'control-label col-sm-3']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('sku',null, ['class'=> 'form-control']) !!}

                                        @if ($errors->has('sku'))
                                            <span class="help-block">
                                                {{ $errors->first('sku') }}
                                            </span>
                                        @endif
                                    </div>

                                </div>
                                <div class="form-group{{ $errors->has('regular_price') ? ' has-error' : '' }}">
                                    {!! Form::label('regular_price','Regular Price', ['class' => 'control-label col-sm-3']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::number('regular_price',null, ['class'=> 'form-control', 'min' => 0, 'step' => 'any']) !!}

                                        @if ($errors->has('regular_price'))
                                            <span class="help-block">
                                                {{ $errors->first('regular_price') }}
                                            </span>
                                        @endif
                                    </div>

                                </div>
                                <div class="form-group{{ $errors->has('sale_price') ? ' has-error' : '' }}">
                                    {!! Form::label('sale_price','Sale Price', ['class' => 'control-label col-sm-3']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::number('sale_price',null, ['class'=> 'form-control', 'min' => 0, 'step' => 'any']) !!}

                                        @if ($errors->has('sale_price'))
                                            <span class="help-block">
                                            {{ $errors->first('sale_price') }}
                                            </span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-stock tab-pane" id="tab_stock">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="inputManageStock">Manage
                                        Stock</label>
                                    <div class="col-sm-9">
                                        <label class="mb-15">
                                            {{ Form::checkbox('track_stock', 1, null, ['class' => 'track-stock minimal-red']) }}
                                            Enable stock management
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group stock-qty" style="">
                                    <label class="col-sm-3 control-label" for="qty">Stock Qty</label>
                                    <div class="col-sm-9">
                                        {!! Form::number('stock_qty', null , ['min' => '0' ,'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"
                                           for="stock_availability_status">Stock Availability</label>
                                    <div class="col-sm-9">
                                        {{ Form::select('in_stock', [ '1' => 'In Stock', '0' => 'Out of Stock'], null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-specification tab-pane" id="tab_specification">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-specifications">
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($product->specifications))
                                        @foreach($product->specifications as $specification)
                                            <tr data-row="{{ $loop->iteration }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" name="specifications[title][{{ $specification->id }}]"
                                                               value="{{ $specification->title }}"
                                                               class="form-control" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                    <input type="text" name="specifications[description][{{ $specification->id }}]"
                                                               value="{{ $specification->description }}"
                                                               class="form-control" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-xs btn-delete-specification"
                                                            data-specification="{{ $specification->id }}"><i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <button class="btn btn-danger btn-sm btn-add-specification">Add New</button>
                                        </th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-faqs tab-pane" id="tab_faqs">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-faqs">
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($product->faqs))
                                        @foreach($product->faqs as $faq)
                                            <tr data-row="{{ $loop->iteration }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" name="faqs[question][{{ $faq->id }}]"
                                                               value="{{ $faq->question }}"
                                                               class="form-control" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                    <textarea name="faqs[answer][{{ $faq->id }}]" class="form-control"
                                                              rows="3" required>{{ $faq->answer }}</textarea>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger btn-xs btn-delete-faq"
                                                            data-faq="{{ $faq->id }}"><i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <button type="button" class="btn btn-danger btn-sm btn-faqs">Add New</button>
                                        </th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-downloads tab-pane" id="tab_downloads">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-downloads">
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($product->downloads))
                                            @foreach($product->downloads as $download)
                                                <tr data-row="{{ $loop->iteration }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" name="downloads[title][{{ $download->id }}]"
                                                                   value="{{ $download->title }}"
                                                                   class="form-control" required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="file" name="file" class="form-control mb-15 download-file">
                                                            <input type="text" name="downloads[link][{{ $download->id }}]"
                                                                       value="{{ $download->link }}"
                                                                       class="form-control download-file-link" required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-xs btn-delete-download"
                                                                data-download="{{ $download->id }}"><i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <button class="btn btn-danger btn-sm btn-add-download">Add New</button>
                                        </th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-seo tab-pane" id="tab_seo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('page_title') ? ' has-error' : '' }}">
                                    {!! Form::label('page_title','Page Title', ['class' => 'control-label col-sm-3']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('page_title',null, ['class'=> 'form-control']) !!}

                                        @if ($errors->has('page_title'))
                                            <span class="help-block">
                                                {{ $errors->first('page_title') }}
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="form-group{{ $errors->has('page_description') ? ' has-error' : '' }}">
                                    {!! Form::label('page_description','Page Description', ['class' => 'control-label col-sm-3']) !!}
                                    <div class="col-sm-9">
                                        {{ Form::textarea('page_description', null, ['rows' => 3, 'class' => 'form-control']) }}

                                        @if ($errors->has('page_description'))
                                            <span class="help-block">
                                                {{ $errors->first('page_description') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-advanced tab-pane" id="tab_advanced">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"
                                           for="disable_price">Disable Price</label>
                                    <div class="col-sm-9">
                                        <label class="mb-15">
                                            {{ Form::checkbox('disable_price', 1, null, ['class' => 'minimal-red']) }}
                                            Disable product price
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"
                                           for="featured">Featured Product</label>
                                    <div class="col-sm-9">
                                        <label class="mb-15">
                                            {{ Form::checkbox('is_featured', 1, null, ['class' => 'minimal-red']) }}
                                            Enable as featured product
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a href="{{ route('dashboard.product.index') }}" class="btn btn-default">Cancel</a>
            {!! Form::submit($submitButtonText, ['class'=>'btn btn-danger pull-right']) !!}
        </div>
    </div>
    <!-- /.box -->
</div>
<div class="col-md-3">
    <!-- general form elements -->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Status</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group mb-none{{ $errors->has('status') ? ' has-error' : '' }}">
                {{ Form::select('status', [ '1' => 'Enabled', '0' => 'Disabled'], null, ['class' => 'form-control']) }}

                @if ($errors->has('status'))
                    <span class="help-block">
                        {{ $errors->first('status') }}
                    </span>
                @endif
            </div>
        </div>
    </div>
    <!-- /.box -->
    <!-- general form elements -->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Product Categories</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="product-categories">
                <ul class="pl-none">
                    @foreach($categories as $category)
                        <li>
                            {{ Form::checkbox('category[]', $category->id, (isset($selectedCategories) && in_array($category->id, $selectedCategories)) ? $category->id : null, ['class' => 'minimal-red']) }}{{ $category->name }}
                        </li>
                        @include('backend.products.category')
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- /.box -->
</div>