<div class="col-md-3 col-md-pull-9">
    <aside class="sidebar my-account-sidebar">

        {{--<h4>My Account</h4>--}}
        <ul class="nav nav-list">
            @php($route = Route::currentRouteName())
            <li class="{{ $route == 'my-account' ? 'active': null }}">
                <a href="{{ route('my-account') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
            </li>
            <li class="{{ ($route == 'my-account.orders' || $route == 'my-account.order.view') ? 'active': null }}">
                <a href="{{ route('my-account.orders') }}"><i class="fa fa-shopping-cart"></i>Orders</a>
            </li>
            
            <li class="{{ ($route == 'my-account.edit-address' || $route == 'my-account.edit-address.shipping') ? 'active': null }}">
                <a href="{{ route('my-account.edit-address') }}"><i class="fa fa-map-marker"></i>Addresses</a>
            </li>
            <li class="{{ $route == 'my-account.edit-account' ? 'active': null }}">
                <a href="{{ route('my-account.edit-account') }}"><i class="fa fa-user"></i>Account Information</a>
            </li>
            @unless(isset(auth()->user()->provider))
                <li class="{{ $route == 'my-account.change-password' ? 'active': null }}">
                    <a href="{{ route('my-account.change-password') }}"><i class="fa fa-key"></i>Change Password</a>
                </li>
            @endunless
            <li class="{{ $route == 'my-account.wishlist' ? 'active': null }}">
                <a href="{{ route('my-account.wishlist') }}"><i class="fa fa-heart"></i>My Wishlist</a>
            </li>
            <li class="{{ $route == 'testimional.add' ? 'active': null }}">
                <a href="{{ route('testimional.add') }}"><i class="fa fa-comment"></i>Add Your Testimional</a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>Logout</a>
            </li>
        </ul>

    </aside>
</div>