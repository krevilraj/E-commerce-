<div class="tab-pane" id="ad">
    <div class="form-group{{ $errors->has('ad') ? ' has-error' : '' }}">
        <label for="footer_logo" class="col-sm-2 control-label">Ad</label>
        <div class="col-sm-10">
            <input type="file" name="ad" id="footer_logo" class="form-control">
            @if ($errors->has('ad'))
                <span class="help-block">
                    {{ $errors->first('ad') }}
                </span>
            @endif

            @if(getConfiguration('ad'))
                <div class="mt-15 half-width">
                    <img src="{{ url('storage') . '/' . getConfiguration('ad') }}"
                         class="thumbnail img-responsive">
                </div>
            @endif
        </div>
    </div>
</div>
