<div class="col-md-12">
    <div class="callout callout-danger mb-15"></div>
    <div class="callout callout-success mb-15"></div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Order Details</h3>
            @if(isset($products))
                <a href="{{ route('dashboard.order.invoice', $order->id) }}" class="btn btn-default pull-right" title="Generate a pdf invoice" target="_blank">
                    <i class="fa fa-print"></i> Print Invoice
                </a>
            @endif
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <div class="col-md-5">
                <h4>General Details</h4>

                <div class="form-group{{ $errors->has('order_date') ? ' has-error' : '' }}">
                    {!! Form::label('order_date','Order Date', ['class' => 'control-label']) !!}
                    {!! Form::text('order_date',isset($order->order_date) ? $order->order_date : null, ['class'=> 'form-control', 'placeholder' => 'Order Date']) !!}

                    @if ($errors->has('order_date'))
                        <span class="help-block">
                            {{ $errors->first('order_date') }}
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('order_status') ? ' has-error' : '' }}">
                    {!! Form::label('order_status','Order Status', ['class' => 'control-label']) !!}
                    {{ Form::select('order_status', $orderStatuses, isset($order->order_status_id) ? $order->order_status_id : null, ['class' => 'form-control select2']) }}

                    @if ($errors->has('order_status'))
                        <span class="help-block">
                            {{ $errors->first('order_status') }}
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('customer') ? ' has-error' : '' }}">
                    {!! Form::label('customer','Customer', ['class' => 'control-label']) !!}
                    {{ Form::select('customer', isset($userDetails->user_id) ? [$userDetails->user_id => $userDetails->user_first_name . ' ' . $userDetails->user_last_name ] : [], isset($order->user_id) ? $order->user_id : null, ['class' => 'form-control']) }}

                    @if ($errors->has('customer'))
                        <span class="help-block">
                            {{ $errors->first('customer') }}
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('order_note') ? ' has-error' : '' }}">
                    {!! Form::label('order_note','Order Note', ['class' => 'control-label']) !!}
                    {{ Form::textarea('order_note', isset($order->order_note) ? $order->order_note : null, ['rows' => 3, 'class' => 'form-control', 'placeholder' => 'Order Note']) }}

                    @if ($errors->has('order_note'))
                        <span class="help-order_note">
                        {{ $errors->first('order_note') }}
                    </span>
                    @endif
                </div>

            </div>
            <div class="col-md-7">
                <h4>Address Details</h4>
                <div class="address-details">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                {!! Form::label('first_name','First Name', ['class' => 'control-label']) !!}
                                {!! Form::text('first_name',isset($userDetails->first_name) ? $userDetails->first_name : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                    {{ $errors->first('first_name') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                {!! Form::label('last_name','Last Name', ['class' => 'control-label']) !!}
                                {!! Form::text('last_name',isset($userDetails->last_name) ? $userDetails->last_name : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                    {{ $errors->first('last_name') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {!! Form::label('email','Email', ['class' => 'control-label']) !!}
                                {!! Form::text('email',isset($userDetails->email) ? $userDetails->email : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    {{ $errors->first('email') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                {!! Form::label('phone','Phone', ['class' => 'control-label']) !!}
                                {!! Form::text('phone',isset($userDetails->phone) ? $userDetails->phone : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                    {{ $errors->first('phone') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('address1') ? ' has-error' : '' }}">
                                {!! Form::label('address1','Address Line 1', ['class' => 'control-label']) !!}
                                {!! Form::text('address1',isset($userDetails->address1) ? $userDetails->address1 : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('address1'))
                                    <span class="help-block">
                                    {{ $errors->first('address1') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                                {!! Form::label('address2','Address Line 2', ['class' => 'control-label']) !!}
                                {!! Form::text('address2',isset($userDetails->address2) ? $userDetails->address2 : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('address2'))
                                    <span class="help-block">
                                    {{ $errors->first('address2') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                {!! Form::label('country','Country', ['class' => 'control-label']) !!}
                                {{ Form::select('country', $countries, 1, ['class' => 'form-control', 'disabled' => 'disabled']) }}

                                @if ($errors->has('country'))
                                    <span class="help-block">
                                    {{ $errors->first('country') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                {!! Form::label('state','State', ['class' => 'control-label']) !!}
                                {{ Form::select('state', $states, isset($userDetails->state_id) ? $userDetails->state_id : null, ['class' => 'form-control']) }}

                                @if ($errors->has('state'))
                                    <span class="help-block">
                                    {{ $errors->first('state') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                {!! Form::label('city','City', ['class' => 'control-label']) !!}
                                {!! Form::text('city',isset($userDetails->city) ? $userDetails->city : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                    {{ $errors->first('city') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
                                {!! Form::label('postcode','Postcode / ZIP', ['class' => 'control-label']) !!}
                                {!! Form::text('postcode',isset($userDetails->postcode) ? $userDetails->postcode : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('postcode'))
                                    <span class="help-block">
                                    {{ $errors->first('postcode') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <div class="box box-order-product">
        <div class="box-header with-border">
            <h3 class="box-title">Product Details</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <table class="table table-hover table-order">
                <thead>
                <tr>
                    <th colspan="2">Item</th>
                    <th>Cost</th>
                    <th>Quantity</th>
                    <th>Discount(%)</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($products))
                    @include('backend.orders.products', ['products' => $products])
                @endif
                </tbody>
            </table>

            <div class="hs-order-data-row">
                <table class="table-order-summary">
                    <tbody></tbody>
                </table>
                <div class="clear"></div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-sm-6">
                <select name="products" id="products" class="form-control" multiple></select>
                <button type="button" id="btn-product-add" class="btn btn-danger">Add</button>
            </div>
            <div class="col-sm-6 text-right">
                {{--<button type="button" class="btn btn-default">Add shipping cost</button>--}}
            </div>
        </div>
    </div>
    <!-- /.box -->

    <div class="box">
        <div class="box-header">
            {{ Form::submit($submitButtonText, array('id' => 'btn-order-save','class' => 'btn btn-danger pull-right', 'data-loading-text' => 'Loading...')) }}
        </div>
    </div>
</div>