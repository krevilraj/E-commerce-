@if($category->subCategory->isNotEmpty())
    @foreach($category->subCategory as $child)
        <option value="{{ $child->slug }}" @if(request('category') == $child->slug) selected="selected" @endif>
            &nbsp;&nbsp;{{ categorySeperator('-', $loop->depth) }} {{ $child->name }}</option>
        @include('backend.categories.category-dropdown', ['category' => $child])
    @endforeach
@endif