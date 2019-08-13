@if($category->subCategory->isNotEmpty())
    <ul>
        @foreach($category->subCategory as $child)
            <li>
                {{ Form::checkbox('category[]', $child->id, (isset($selectedCategories) && in_array($child->id, $selectedCategories)) ? $child->id : null, ['class' => 'minimal-red']) }}
                {{ $child->name }}
            </li>
            @include('backend.products.category', ['category' => $child])
        @endforeach
    </ul>
@endif