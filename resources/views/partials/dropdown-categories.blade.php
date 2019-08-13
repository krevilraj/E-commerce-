@if($productCategory->subCategory->isNotEmpty())
    @foreach($productCategory->subCategory as $child)
        <option value="{{ $child->id }}">{{ categorySeperator('-', $loop->depth) }} {{ $child->name }}</option>
        @include('partials.dropdown-categories', ['productCategory' => $child])
    @endforeach
@endif