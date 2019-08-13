@if(count($reviews = $product->getReviews()) >0)
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Rating</th>
            <th>Comment</th>
        </tr>

        @foreach($reviews as $review)

            <tr>
                <td>{{$review->user->getFullNameAttribute() }} </td>
                <td>{{ $review->star }}</td>
                <td>{{ $review->comment }}</td>
            </tr>
        @endforeach
    </table>
@else
    <div class="collateral-box">
        <ul class="list-unstyled">
            <li>Be the first to review this product</li>
        </ul>
    </div>
@endif

<div class="add-product-review">
    <h3 class="text-uppercase heading-text-color font-weight-semibold">WRITE YOUR OWN REVIEW</h3>
    <p>How do you rate this product? *</p>

    <form action="{{ route('review.store') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="product_id" value="{{ $product->id }}"/>

        <div class="form-group{{ $errors->has('star') ? ' has-error' : '' }}">

            <input type="text" name="star" id="rating" value="{{ old('star') }}" required/>

            @if ($errors->has('star'))
                <p>
                    <span class="help-block">
                        {{ $errors->first('star') }}
                    </span>
                </p>
            @endif
        </div>

        <div class="form-group mb-xlg{{ $errors->has('comment') ? ' has-error' : '' }}">
            <label for="comment">Review<span class="required">*</span></label>
            <textarea cols="5" rows="6" name="comment" id="comment" class="form-control"
                      required>{{ old('comment') }}</textarea>

            @if ($errors->has('comment'))
                <span class="help-block">
                    {{ $errors->first('comment') }}
                </span>
            @endif
        </div>

        <div class="text-right">
            <input type="submit" class="btn btn-primary" value="Submit Review">
        </div>
    </form>
</div>