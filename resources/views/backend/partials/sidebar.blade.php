<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ null !== auth()->user()->getImage() ? auth()->user()->getImage()->smallUrl : url('/uploads/avatar.jpg') }}"
                     class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->full_name }}</p>
                <a href="{{ route('dashboard.profile') }}"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            @php($route = Route::currentRouteName())
            <li class="{{ $route == 'dashboard.index' ? 'active': null }}">
                <a href="{{ route('dashboard.index') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            @role(['admin'])

            <li class="treeview {{ ($route == 'dashboard.slideshows.index' || $route == 'dashboard.slideshows.create' || $route == 'dashboard.slideshows.edit') ? 'active': null }}">
                <a href="#">
                    <i class="fa fa-picture-o"></i>
                    <span>Slideshows</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'dashboard.slideshows.index' ? 'active': null }}">
                        <a href="{{ route('dashboard.slideshows.index') }}"><i class="fa fa-table"></i> All
                            Slideshows</a>
                    </li>
                    <li class="{{ $route == 'dashboard.slideshows.create' ? 'active': null }}">
                        <a href="{{ route('dashboard.slideshows.create') }}"><i class="fa fa-plus-square-o"></i> Add New</a>
                    </li>
                </ul>
            </li>
            @endrole
            @role(['admin','manager'])

            <li class="treeview {{ ($route == 'dashboard.page.index' || $route == 'dashboard.page.create' || $route == 'dashboard.page.edit') ? 'active': null }}">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Pages</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'dashboard.page.index' ? 'active': null }}">
                        <a href="{{ route('dashboard.page.index') }}"><i class="fa fa-table"></i> All Pages</a>
                    </li>
                    <li class="{{ $route == 'dashboard.page.create' ? 'active': null }}">
                        <a href="{{ route('dashboard.page.create') }}"><i class="fa fa-plus-square-o"></i> Add New</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ ($route == 'dashboard.posts.index' || $route == 'dashboard.posts.create' || $route == 'dashboard.posts.edit') ? 'active': null }}">
                <a href="#">
                    <i class="fa fa-tags"></i>
                    <span>Posts</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'dashboard.posts.index' ? 'active': null }}">
                        <a href="{{ route('dashboard.posts.index') }}"><i class="fa fa-table"></i> All Posts</a>
                    </li>
                    <li class="{{ $route == 'dashboard.posts.create' ? 'active': null }}">
                        <a href="{{ route('dashboard.posts.create') }}"><i class="fa fa-plus-square-o"></i> Add New</a>
                    </li>
                </ul>
            </li>
            @endrole
            @role(['admin'])

            <li class="{{ $route == 'dashboard.menus.show' ? 'active': null }}">
                <a href="{{ route('dashboard.menus.show') }}">
                    <i class="fa fa-bars"></i>
                    <span>Menu</span>
                </a>
            </li>
            @endrole
            @role(['admin', 'manager','shop-manager'])

            <li class="treeview {{ ($route == 'dashboard.product.index' || $route == 'dashboard.product.create' || $route == 'dashboard.product.edit' || $route == 'dashboard.categories.index' || $route == 'dashboard.categories.edit') ? 'active': null }}">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Products</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'dashboard.product.index' ? 'active': null }}">
                        <a href="{{ route('dashboard.product.index') }}"><i class="fa fa-table"></i> All Products</a>
                    </li>
                    <li class="{{ $route == 'dashboard.product.create' ? 'active': null }}">
                        <a href="{{ route('dashboard.product.create') }}"><i class="fa fa-plus-square-o"></i> Add
                            New</a>
                    </li>
                    @endrole
                    @role(['admin', 'manager','shop-manager'])

                    <li><a href="{{ route('dashboard.categories.index') }}"><i class="fa fa-camera"></i> Categories</a>
                    </li>
                    {{--<li><a href=""><i class="fa fa-tags"></i> Tags</a></li>--}}
                </ul>
            </li>
            @endrole
            @role(['admin', 'manager','shop-manager'])

            <li class="treeview {{ ($route == 'dashboard.order.index' || $route == 'dashboard.order.create' || $route == 'dashboard.order.edit') ? 'active': null }}">
                <a href="#">
                    <i class="fa fa-file-text-o"></i>
                    <span>Orders</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'dashboard.order.index' ? 'active': null }}">
                        <a href="{{ route('dashboard.order.index') }}"><i class="fa fa-table"></i> All Orders</a>
                    </li>
                    <li class="{{ $route == 'dashboard.order.create' ? 'active': null }}">
                        <a href="{{ route('dashboard.order.create') }}"><i class="fa fa-plus-square-o"></i> Add
                            New</a>
                    </li>
                </ul>
            </li>
            @endrole
               {{--@role(['admin', 'manager','shop-manager'])--}}


            {{--<li class="{{ $route == 'dashboard.enquiries.index' || $route == 'dashboard.enquiries.edit' ? 'active': null }}">--}}
                {{--<a href="{{ route('dashboard.enquiries.index') }}">--}}
                    {{--<i class="fa fa-question-circle-o"></i>--}}
                    {{--<span>Product Enquiries</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endrole--}}

            @role(['admin', 'manager'])

            <li class="treeview {{ ($route == 'dashboard.brands.index' || $route == 'dashboard.brands.create' || $route == 'dashboard.brands.edit') ? 'active': null }}">
                <a href="#">
                    <i class="fa fa-apple"></i>
                    <span>Brands</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'dashboard.brands.index' ? 'active': null }}">
                        <a href="{{ route('dashboard.brands.index') }}"><i class="fa fa-table"></i>All Brands</a>
                    </li>
                    <li class="{{ $route == 'dashboard.brands.create' ? 'active': null }}">
                        <a href="{{ route('dashboard.brands.create') }}"><i class="fa fa-plus-square-o"></i> Add
                            New</a>
                    </li>
                </ul>
            </li>
@endrole
            @role(['admin', 'manager'])

            <li class="treeview {{ ($route == 'dashboard.testimonials.index' || $route == 'dashboard.testimonials.create' || $route == 'dashboard.testimonials.edit') ? 'active': null }}">
                <a href="#">
                    <i class="fa fa-quote-left"></i>
                    <span>Testimonials</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'dashboard.testimonials.index' ? 'active': null }}">
                        <a href="{{ route('dashboard.testimonials.index') }}"><i class="fa fa-table"></i>All
                            Testimonials</a>
                    </li>
                    <li class="{{ $route == 'dashboard.testimonials.create' ? 'active': null }}">
                        <a href="{{ route('dashboard.testimonials.create') }}"><i class="fa fa-plus-square-o"></i> Add
                            New</a>
                    </li>
                </ul>
            </li>
            @endrole
            @role(['admin'])


            <li class="treeview {{ ($route == 'dashboard.team.index' || $route == 'dashboard.team.create' || $route == 'dashboard.team.edit') ? 'active': null }}">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Team</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'dashboard.team.index' ? 'active': null }}">
                        <a href="{{ route('dashboard.team.index') }}"><i class="fa fa-table"></i>All Team Members</a>
                    </li>
                    <li class="{{ $route == 'dashboard.team.create' ? 'active': null }}">
                        <a href="{{ route('dashboard.team.create') }}"><i class="fa fa-plus-square-o"></i> Add New</a>
                    </li>
                </ul>
            </li>

            <li class="treeview {{ request()->has('role') || $route == 'dashboard.users.index' || $route == 'dashboard.users.create' || $route == 'dashboard.users.edit' ? 'active': null }}">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Users</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->has('role') && request('role') === 'admin' ? 'active': null }}">
                        <a href="{{ route('dashboard.users.index', 'role=' . 'admin') }}"><i class="fa fa-table"></i>Administrators</a>
                    </li>
                    <li class="{{ request()->has('role') && request('role') === 'manager' ? 'active': null }}">
                        <a href="{{ route('dashboard.users.index', 'role=' . 'manager') }}"><i class="fa fa-table"></i>Managers</a>
                    </li>
                    <li class="{{ request()->has('role') && request('role') === 'shop-manager' ? 'active': null }}">
                        <a href="{{ route('dashboard.users.index', 'role=' . 'shop-manager') }}"><i class="fa fa-table"></i>Shop-Manager</a>
                    </li>
                    <li class="{{ request()->has('role') && request('role') === 'client' ? 'active': null }}">
                        <a href="{{ route('dashboard.users.index', 'role=' . 'client') }}"><i class="fa fa-table"></i>Clients</a>
                    </li>
<li class="{{ request()->has('role') && request('role') === 'client' ? 'active': null }}">
                        <a href="{{ route('dashboard.users.index', 'role=' . 'non-active') }}"><i class="fa fa-table"></i>Not-Active</a>
                    </li>
                    <li class="{{ $route == 'dashboard.users.create' ? 'active': null }}">
                        <a href="{{ route('dashboard.users.create') }}"><i class="fa fa-plus-square-o"></i> Add New</a>
                    </li>
                </ul>
            </li>
            @endrole
            @role(['admin', 'manager'])

            <li class="{{ ($route == 'dashboard.review.index') ? 'active': null }}">
                <a href="{{ route('dashboard.review.index') }}">
                    <i class="fa fa-comment"></i>
                    <span>Product Reviews</span>
                </a>
            </li>
            @endrole
            @role(['admin', 'manager','shop-manager'])

            <li class="{{ ($route == 'Request') ? 'active': null }}">
                <a href="{{ route('dashboard.request.index') }}">
                    <i class="fa fa-comment"></i>
                    <span>Request Products</span>
                </a>
            </li>
            <li class="{{ ($route == 'Message') ? 'active': null }}">
                <a href="{{ route('dashboard.message.index') }}">
                    <i class="fa fa-comment"></i>
                    <span>Message From Contat Us</span>
                </a>
            </li>
            @endrole
            @role(['admin', 'manager'])

            <li class="{{ ($route == 'About-Us') ? 'active': null }}">
                <a href="{{ route('dashboard.about.index') }}">
                    <i class="fa fa-comment"></i>
                    <span>Message From Founder</span>
                </a>
            </li>
            @endrole
 @role(['admin'])

            <li class="{{ $route == 'dashboard.suscriber' ? 'active': null }}">
                <a href="{{ route('dashboard.suscriber') }}">
                    <i class="fa fa-cogs"></i>
                    <span>Suscribers</span>
                </a>
            </li>
            @endrole
            @role(['admin'])

            <li class="{{ $route == 'dashboard.settings' ? 'active': null }}">
                <a href="{{ route('dashboard.settings') }}">
                    <i class="fa fa-cogs"></i>
                    <span>Settings</span>
                </a>
            </li>
            @endrole
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>