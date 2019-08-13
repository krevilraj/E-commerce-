<div class="tab-pane" id="social">
    <div class="form-group{{ $errors->has('facebook_link') ? ' has-error' : '' }}">
        <label for="facebook_link" class="col-sm-2 control-label">Facebook Link</label>
        <div class="col-sm-10">
            <input type="text" name="facebook_link" class="form-control" id="facebook_link"
                   value="{{ getConfiguration('facebook_link') }}">
            @if ($errors->has('facebook_link'))
                <span class="help-block">
                    {{ $errors->first('facebook_link') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('twitter_link') ? ' has-error' : '' }}">
        <label for="twitter_link" class="col-sm-2 control-label">Twitter Link</label>
        <div class="col-sm-10">
            <input type="text" name="twitter_link" class="form-control" id="twitter_link"
                   value="{{ getConfiguration('twitter_link') }}">
            @if ($errors->has('twitter_link'))
                <span class="help-block">
                    {{ $errors->first('twitter_link') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('googleplus_link') ? ' has-error' : '' }}">
        <label for="googleplus_link" class="col-sm-2 control-label">Google Plus Link</label>
        <div class="col-sm-10">
            <input type="text" name="googleplus_link" class="form-control" id="googleplus_link"
                   value="{{ getConfiguration('googleplus_link') }}">
            @if ($errors->has('googleplus_link'))
                <span class="help-block">
                    {{ $errors->first('googleplus_link') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('instagram_link') ? ' has-error' : '' }}">
        <label for="instagram_link" class="col-sm-2 control-label">Instagram Link</label>
        <div class="col-sm-10">
            <input type="text" name="instagram_link" class="form-control" id="instagram_link"
                   value="{{ getConfiguration('instagram_link') }}">
            @if ($errors->has('instagram_link'))
                <span class="help-block">
                    {{ $errors->first('instagram_link') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('linkedin_link') ? ' has-error' : '' }}">
        <label for="linkedin_link" class="col-sm-2 control-label">Linkedin Link</label>
        <div class="col-sm-10">
            <input type="text" name="linkedin_link" class="form-control" id="linkedin_link"
                   value="{{ getConfiguration('linkedin_link') }}">
            @if ($errors->has('linkedin_link'))
                <span class="help-block">
                    {{ $errors->first('linkedin_link') }}
                </span>
            @endif
        </div>
    </div>
</div>
<!-- /.tab-pane -->