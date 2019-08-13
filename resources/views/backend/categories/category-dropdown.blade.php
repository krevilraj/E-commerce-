@if($category->subCategory->isNotEmpty())
    @foreach($category->subCategory as $child)
        <option value="{{ $child->id }}" @if(isset($cat->parent) && $cat->parent->id == $child->id) selected="selected" @endif>
            &nbsp;&nbsp;{{ categorySeperator('-', $loop->depth) }} {{ $child->name }}</option>
        @include('backend.categories.category-dropdown', ['category' => $child])
    @endforeach
@endif