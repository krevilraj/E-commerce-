@if(!empty($menu['child']))
    <span class="mmenu-toggle"></span>
    <ul>
        @foreach($menu['child'] as $child)
            <li>
                <a href="{{ $child['link'] }}">{{ $child['label'] }}</a>
                @include('partials.menu-mobile', ['menu' => $child])
            </li>
        @endforeach
    </ul>
@endif