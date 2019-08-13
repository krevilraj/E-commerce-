<div class="panel-body">
    <ul>
        @foreach($childProduct as $category)
            <li>
                <a href="{{ route('welcome') . '/category/' . $category->slug }}">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
</div>