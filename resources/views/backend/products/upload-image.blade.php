<div class="image-preview">
    <div class="actual-image-thumbnail">
        <img class="img-thumbnail img-tag img-responsive" src="{{ $image->smallUrl }}"
             data-path="{{ $image->relativePath }}"/>
        <input type="hidden" name="image[{{ $tmp }}][path]" value="{{ $image->relativePath }}"/>
        <input type="hidden" class="is_main_image_hidden_field" name="image[{{ $tmp }}][is_main_image]" value="0"/>

    </div>
    <div class="image-info">
        <div class="image-title">
            XYZ.jpg
        </div>
        <div class="actions">
            <div class="action-buttons">

                <button type="button"
                        class="btn btn-xs btn-info is_main_image_button  selected-icon"
                        title="Select as main image">
                    <i class="fa fa-check"></i>
                </button>
                <button type="button" class="btn btn-xs btn-danger destroy-image" title="Remove file">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    </div>

</div>