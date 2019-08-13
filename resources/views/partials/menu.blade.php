@if(!empty($menu['child']))
    <ul class="dropdown-menu">
        @foreach($menu['child'] as $child)
            <li class="{{ !empty($child['child']) ? ' dropdown-submenu' : '' }}">
                <a href="{{ $child['link'] }}">{{ $child['label'] }}
                    @if(isset($menu_id) && !empty($child['child']))
                        <i class="fa fa-caret-right"></i>
                    @endif
                </a>
                @include('partials.menu', ['menu' => $child])
            </li>
        @endforeach
    </ul>
@endif