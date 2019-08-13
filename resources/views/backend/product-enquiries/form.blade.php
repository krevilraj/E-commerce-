<div class="col-md-9">
    <div class="box box-default">
        <div class="box-body">

            <div class="form-group">
                {!! Form::label('product','Product', ['class' => 'control-label']) !!}
                {!! Form::text('product', $enquiry->product->name, ['class'=> 'form-control', 'disabled' => 'disabled']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('quantity','Quantity', ['class' => 'control-label']) !!}
                {!! Form::text('quantity', $enquiry->quantity, ['class'=> 'form-control', 'disabled' => 'disabled']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('price','Price', ['class' => 'control-label']) !!}
                {!! Form::text('price', 'RS '. $enquiry->product->getPrice(), ['class'=> 'form-control', 'disabled' => 'disabled']) !!}
            </div>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</div>

<div class="col-md-3">
    <div class="box box-default">
        <div class="box-body">

            <div class="form-group">
                {!! Form::label('discount','Discount %', ['class' => 'control-label']) !!}
                {!! Form::number('discount', null, ['class'=> 'form-control', 'min' => 0]) !!}
            </div>

            @if(isset($enquiry->discount))
                @php
                    $price      = $enquiry->quantity * $enquiry->product->getPrice();
                    $priceTotal = $price - ( $price * ( $enquiry->discount / 100 ) );
                    $priceTotal = 'RS ' . $priceTotal;
                @endphp
                <div class="form-group">
                    {!! Form::label('price_total','Price Total', ['class' => 'control-label']) !!}
                    {!! Form::text('price_total', $priceTotal, ['class'=> 'form-control', 'disabled' => 'disabled']) !!}
                </div>
            @endif

        </div>
        <div class="box-footer">
            {!! Form::submit($submitButtonText, ['class'=>'btn btn-danger pull-right']) !!}
        </div>
    </div>
</div>