<div class="col-md-6">
    <div class="form-col">
        <h3>Address Details</h3>
        <div class="row">
            <div class="col-xs-6 col-md-6">
                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label for="first_name">First Name<span class="required">*</span></label>
                    <input type="text" name="first_name"
                           value="{{ isset($address->first_name) ? $address->first_name : auth()->user()->first_name }}"
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
                           value="{{ isset($address->last_name) ? $address->last_name : auth()->user()->last_name }}"
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
                           value="{{ isset($address->email) ? $address->email : auth()->user()->email }}" id="email"
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
                    <label for="phone">Phone<span class="required">*</span></label>
                    <input type="tel" name="phone"
                           value="{{ isset($address->phone) ? $address->phone : auth()->user()->phone }}" id="phone"
                           class="form-control" required>

                    @if ($errors->has('phone'))
                        <span class="help-block">
                            {{ $errors->first('phone') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="form-group wide{{ $errors->has('address1') ? ' has-error' : '' }}">
                    <label for="address1">Address<span class="required">*</span></label>
                    <input type="text" name="address1"
                           value="{{ isset($address->address1) ? $address->address1 : old('address1') }}" id="address1"
                           class="form-control" required>

                    @if ($errors->has('address1'))
                        <span class="help-block">
                            {{ $errors->first('address1') }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-md-12">
                <div class="form-group wide">
                    <input type="text" name="address2"
                           value="{{ isset($address->address2) ? $address->address2 : old('address2') }}" id="address2"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-md-6">
                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                    <label for="city">City<span class="required">*</span></label>
                    <input type="text" name="city"
                           value="{{ isset($address->city) ? $address->city : old('city') }}" id="city"
                           class="form-control" required>

                    @if ($errors->has('city'))
                        <span class="help-block">
                            {{ $errors->first('city') }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-xs-6 col-md-6">
                <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                    <label for="state">State/Province<span class="required">*</span></label>
                    {{ Form::select('state', $states, isset($address->state_id) ? $address->state_id : old('state'), ['class' => 'form-control']) }}

                    @if ($errors->has('state'))
                        <span class="help-block">
                            {{ $errors->first('state') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-md-6">
                <div class="form-group">
                    <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
                        <label for="postcode">Zip/Postal Code</label>
                        <input type="text" name="postcode"
                               value="{{ isset($address->postcode) ? $address->postcode : old('postcode') }}"
                               id="postcode" class="form-control">

                        @if ($errors->has('postcode'))
                            <span class="help-block">
                                {{ $errors->first('postcode') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-6">
                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                    <label for="country">Country<span class="required">*</span></label>
                    {{ Form::select('country', $countries, isset($address->country_id) ? $address->country_id : 1, ['class' => 'form-control', 'disabled' => 'disabled']) }}

                    @if ($errors->has('country'))
                        <span class="help-block">
                            {{ $errors->first('country') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="form-group wide{{ $errors->has('enquiry_note') ? ' has-error' : '' }}">
                    <label for="enquiry_note">Enquiry Note</label>
                    <textarea name="enquiry_note" id="enquiry_note" class="form-control" rows="5">{{ old('enquiry_note') }}</textarea>

                    @if ($errors->has('enquiry_note'))
                        <span class="help-block">
                            {{ $errors->first('enquiry_note') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
<div class="col-md-6">
    <div class="form-col">
        <h3>Product Details</h3>
        <table class="table table-striped table-product-enquiry mb-none">
            <thead>
            <tr>
                <th>Product Name</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>

            <tbody>
                @foreach(Cart::instance('enquiry')->content() as $enquiry)
                    <tr data-row="{{ $enquiry->rowId }}">
                    <td>
                        <a href="{{ route('product.show', getProductSlug($enquiry->id)) }}">{{ $enquiry->name }}</a>
                    </td>
                    <td class="text-center">
                        <div class="qty-holder">
                            <a href="javascript:void(0);" class="qty-dec-btn" title="Dec">-</a>
                            <input type="text" class="qty-input" name="quantity"
                                   value="{{ $enquiry->qty }}">
                            <a href="javascript:void(0);" class="qty-inc-btn" title="Inc">+</a>
                        </div>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-xs btn-enquiry-list p-6-12" data-row="{{ $enquiry->rowId }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="checkout-review-action no-borders pull-right">
            <button class="btn btn-primary mt-lg mr-sm btn-update-enquiry-list" data-loading-text="Loading..." disabled>Update Quantity</button>
            <button type="submit" class="btn btn-primary mt-lg">Enquiry Now</button>
        </div>

    </div>
</div>