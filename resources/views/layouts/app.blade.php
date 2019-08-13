<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113997706-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-113997706-1');
</script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
@yield('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    @if(getConfiguration('site_favicon'))
        <link rel="shortcut icon" href="{{ url('storage') . '/' . getConfiguration('site_favicon') }}"
              type="image/x-icon"/>
    @endif

    <title>{{ getConfiguration('site_title') ? getConfiguration('site_title') : env('APP_NAME') }}{{ getConfiguration('site_description') ? ' - ' . getConfiguration('site_description') : '' }}</title>

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light"
          rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl.carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl.carousel/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.min.css') }}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-elements.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-blog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-shop.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" media="all">
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
        new WOW().init();
    </script>

    @stack('styles')

    {{--Skin CSS--}}
    <link rel="stylesheet" href="{{ asset('css/skin-shop.css') }}">

    <!-- Demo CSS -->
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">

    <!-- Head Libs -->
    <script src="{{ asset('vendor/modernizr/modernizr.min.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<div class="body">
    <header id="header"
            data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyStartAt': 147, 'stickySetTop': '-147px', 'stickyChangeLogo': false}">
        <div class="header-body">
            <div class="header-top" style="background-color: #A5A5A;">
                <div class="container">
                    <div class="dropdowns-container">
                        <div id="compare-dropdown" class="compare-dropdown">
                            <a href="#">
                                <i class="fa fa-retweet"></i> Compare ({{ count(Cart::instance('compare')->content()) }})
                            </a>

                            <div class="compare-dropdownmenu">
                                <div class="dropdownmenu-wrapper">
                                    @if(count(Cart::instance('compare')->content()))
                                        <ul class="compare-products">
                                            @foreach(Cart::instance('compare')->content() as $compare)
                                                <li class="product">
                                                    <form action="{{ route('compare.clear', $compare->rowId) }}"
                                                          method="post">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn-link btn-remove">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
                                                    <h4 class="product-name">
                                                        <a href="{{ route('product.show', getProductSlug($compare->id)) }}">{{ $compare->name }}</a>
                                                    </h4>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="compare-actions">
                                            <form action="{{ route('compare.clearall') }}" method="post">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn-link action-link">Clear All</button>
                                            </form>
                                            <a href="{{ route('compare') }}" class="btn btn-primary">Compare</a>
                                        </div>
                                    @else
                                        <div class="compare-list-empty">
                                            <span>No products in compare list.</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="top-menu-area">
                        <a href="#">Links <i class="fa fa-caret-down"></i></a>
                        <ul class="top-menu">
                            @if(!Auth::check())
                                <li><a href="#" data-toggle="modal" data-target="#accountModal">Login / Register</a>
                                </li>
                            @else
                                @role(['admin', 'manager','shop-manager'])
                                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                @endrole
                                <li><a href="{{ route('my-account') }}">My Account</a></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <p class="welcome-msg">WELCOME TO {{getConfiguration('company_name') ? getConfiguration('company_name') : env('APP_NAME')}} !</p>
                </div>
            </div>
            <div class="header-container container">
                <div class="header-row">
                    <div class="header-column" style="width: 12%;">
                        <div class="header-logo wow flip" data-wow-duration="2s">
                            <a href="{{ route('welcome') }}">
                                {{--Himalayan <span>Solution</span>--}}

                                <?php if(getConfiguration('site_logo')): ?>
                                    <img width="150px" src="<?php echo e(url('storage') . '/' . getConfiguration('site_logo')); ?>"
                                         >
                                <?php endif; ?>
                            </a>
                        </div>
                    </div>
                    <div class="header-column">
                        <div class="row">
                            <div class="cart-area">
                                <div class="custom-block">
                                    <i class="fa fa-phone"></i>
                                    <span>{{getConfiguration('site_primary_phone')}}</span>
                                    <span class="split"></span>
                                    <a href="{{ url('/contact-us') }}">CONTACT US</a>
                                </div>

                                <div id="mini-cart" class="cart-dropdown">
                                    <a href="{{ route('cart.index') }}" class="cart-dropdown-icon">
                                        <i class="minicart-icon"></i>
                                        <span class="cart-info">
                                            <span class="cart-qty">{{ Cart::instance('default')->count() }}</span>
                                            <span class="cart-text">item(s)</span>
                                        </span>
                                    </a>
                                    <div class="cart-dropdownmenu right">
                                        <div class="dropdownmenu-wrapper">
                                            @if(Cart::instance('default')->count())
                                                <div class="cart-products">
                                                    @foreach(Cart::content() as $cartContent)
                                                        <div class="product product-sm">
                                                            <a href="#" class="btn-remove" title="Remove Product">
                                                                <i class="fa fa-times"></i>
                                                            </a>
                                                            <figure class="product-image-area">
                                                                <a href="{{ url('/product' . '/' . getProductSlug($cartContent->id)) }}"
                                                                   title="{{ $cartContent->name }}"
                                                                   class="product-image">
                                                                    <img src="{{ asset(getProductImage($cartContent->id, 'small')) }}"
                                                                         alt="{{ $cartContent->name }}">
                                                                </a>
                                                            </figure>
                                                            <div class="product-details-area">
                                                                <h2 class="product-name">
                                                                    <a href="{{ url('/product' . '/' . getProductSlug($cartContent->id)) }}"
                                                                       title="{{ $cartContent->name }}">{{ $cartContent->name }}</a>
                                                                </h2>

                                                                <div class="cart-qty-price">
                                                                    {{ $cartContent->qty }} X
                                                                    <span class="product-price">Rs{{ $cartContent->price }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="cart-totals">
                                                    Total: <span>Rs {{ Cart::instance('default')->total() }}</span>
                                                </div>

                                                <div class="cart-actions">
                                                    <a href="{{ route('cart.index') }}" class="btn btn-primary">View
                                                        Cart</a>
                                                    <a href="{{ route('checkout') }}"
                                                       class="btn btn-primary">Checkout</a>
                                                </div>
                                            @else
                                                <div class="cart-empty">
                                                    <p class="mb-none">No products in cart.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="header-search">
                                <a href="#" class="search-toggle"><i class="fa fa-search"></i></a>
                                <form action="{{ route('search') }}" method="get">

                                    <div class="header-search-wrapper">
                                        <input type="text" class="form-control" name="q" id="q" placeholder="Search..."
                                               required>
                                        <select id="cat" name="cat">
                                            <option value="">All Categories</option>
                                            @foreach($productCategories as $productCategory)
                                                <option value="{{ $productCategory->id }}">{{ $productCategory->name }}</option>
                                                @include('partials.dropdown-categories')
                                            @endforeach
                                        </select>
                                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <a href="#" class="mmenu-toggle-btn" title="Toggle menu">
                                <i class="fa fa-bars"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
 @if(Route::currentRouteName() != 'login')
                <div style="text-align: center">
                    <div class="hidden-md hidden-lg searchByCtaegory" style="text-align: center;display: inline-block;position: relative;margin-bottom: 10px">
                        <a href="#" class="dropdown-toggle btn btn-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="margin-left: 20px;border-color: #fa2600;padding:5px 10px 5px 10px;" >Search By Category &nbsp;</a>
                        <ul class="dropdown-menu" style="font-size: 1em;position:absolute;top: 31px;left: -6px;text-align:center">
                                 @foreach($mainCategory as $productCategory)

                <li ><a href="{{$productCategory->link}}">{{$productCategory->label}}</a></li>
                    @endforeach

                        </ul>
                    </div>
                </div>
            @endif
            <div class="header-container header-nav" style="background-color: #015249;">
                <div class="container">
                    <div class="header-nav-main">
                        <nav>
                            <ul class="nav nav-pills" id="mainNav">
                                @if(Route::currentRouteName() != 'welcome')
                                    <li class="vertical-menu-toggle">
                                        <div class="dropdown hidden-xs">
                                            <button class="btn btn-default dropdown-toggle" type="button"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-bars" aria-hidden="true"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-large pt-none pb-none">
                                                <li class="home-side-menu-container">
                                                    <h2 class="side-menu-title">CATEGORIES</h2>
                                                    <ul class="home-side-menu">
                                                        @foreach($categoryMenuList as $menu)
                                                            <li class="{{ !empty($menu['child']) ? ' dropdown-full-color dropdown-primary' : '' }}">
                                                                <a class="{{ !empty($menu['child']) ? 'dropdown-toggle' : '' }}"
                                                                   href="{{ $menu['link'] }}">
                                                                    {{ $menu['label'] }} @if(!empty($menu['child'])) <i
                                                                            class="fa fa-caret-right"></i> @endif
                                                                </a>
                                                                @include('partials.menu', ['menu' => $menu, 'menu_id' => 'category'])
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                                @foreach($menuList as $menu)
                                    <li class="{{ !empty($menu['child']) ? ' dropdown dropdown-full-color dropdown-primary' : '' }}">
                                        <a class="{{ !empty($menu['child']) ? 'dropdown-toggle' : '' }}"
                                           href="{{ $menu['link'] }}">
                                            {{ $menu['label'] }}
                                        </a>
                                        @include('partials.menu', ['menu' => $menu])
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="mobile-nav">
        <div class="mobile-nav-wrapper">
            <ul class="mobile-side-menu">
                @foreach($menuList as $menu)
                    <li>
                        <a href="{{ $menu['link'] }}">{{ $menu['label'] }}</a>
                        @include('partials.menu-mobile', ['menu' => $menu])
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div id="mobile-menu-overlay"></div>

    <div role="main" class="main">

        @yield('content')

    </div>

    {{--Account Modal--}}
    @if (auth()->guest())
        <div id="accountModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="tabs tabs-bottom tabs-center tabs-simple">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#loginTab" data-toggle="tab">
                                        <p class="mb-none pb-none">Login</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#registerTab" data-toggle="tab">
                                        <p class="mb-none pb-none">Register</p>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="loginTab">
                                    <form action="{{ route('login') }}" method="post" id="form-login">
                                        {{ csrf_field() }}
                                        <div class="form-content">
                                            <div class="row">
                                                <div class="col-xs-6 col-facebook">
                                                    <a href="{{ url('/login', ['facebook']) }}"
                                                       class="btn btn-primary btn-block btn-facebook">
                                                        <i class="fa fa-facebook mr-sm"></i>Facebook
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 col-google">
                                                    <a href="{{ url('/login', ['google']) }}"
                                                       class="btn btn-primary btn-block btn-google">
                                                        <i class="fa fa-google-plus mr-sm"></i>Google
                                                    </a>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div class="heading heading-border heading-middle-border heading-middle-border-center mt-sm mb-sm">
                                                        <h1>or</h1>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="alert alert-danger alert-account"></div>

                                            <div class="form-group">
                                                <label for="email" class="font-weight-normal">Email Address
                                                    <span class="required">*</span>
                                                </label>
                                                <input type="email" name="email" id="email" class="form-control"
                                                       required
                                                       autofocus>
                                            </div>

                                            <div class="form-group">

                                                <label for="password" class="font-weight-normal">Password
                                                    <span class="required">*</span>
                                                </label>
                                                <input type="password" name="password" id="password"
                                                       class="form-control"
                                                       required>
                                            </div>

                                            <div class="form-group">
                                        <div class="checkbox">
                                            <label>

                                                <input type="checkbox" style="zoom: 1.5;margin-left: -14px"  onchange="document.getElementById('send111').disabled = !this.checked" /> <div style="margin-top: 3px">Check If You Are A Human</div>

                                            </label >
                                            <label class="lebel-remember">
                                                <input style="zoom: 1.5;margin-left: -14px" type="checkbox" name="remember"> <div style="margin-top: 3px">Remember Me</div>
                                            </label>
                                        </div>
                                    </div>

                                            <button type="button" id="send111" class="btn btn-primary btn-account"
                                                    data-loading-text="Loading..." disabled>Login
                                            </button>
                                            <a href="{{ route('password.request')}}" class="ml-sm">Forgot Your  Password?</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="registerTab">
                                    <form action="{{ route('register') }}" method="post" id="form-register">
                                        {{ csrf_field() }}
                                        <div class="form-content">
                                            <div class="row">
                                                <div class="col-xs-6 col-facebook">
                                                    <a href="{{ url('/login', ['facebook']) }}"
                                                       class="btn btn-primary btn-block btn-facebook">
                                                        <i class="fa fa-facebook mr-sm"></i>Facebook
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 col-google">
                                                    <a href="{{ url('/login', ['google']) }}"
                                                       class="btn btn-primary btn-block btn-google">
                                                        <i class="fa fa-google-plus mr-sm"></i>Google
                                                    </a>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div class="heading heading-border heading-middle-border heading-middle-border-center mt-sm mb-sm">
                                                        <h1>or</h1>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="alert alert-danger alert-account"></div>

                                            <h4 class="heading-primary text-uppercase mb-lg">PERSONAL INFORMATION</h4>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="first_name" class="font-weight-normal">First Name
                                                            <span class="required">*</span>
                                                        </label>
                                                        <input type="text" name="first_name" id="first_name"
                                                               class="form-control" value="{{ old('first_name') }}"
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="last_name" class="font-weight-normal">Last Name
                                                            <span class="required">*</span></label>
                                                        <input name="last_name" id="last_name" type="text"
                                                               class="form-control" {{ old('last_name') }} required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <label for="email" class="font-weight-normal">Email Address
                                                            <span class="required">*</span>
                                                        </label>
                                                        <input type="email" name="email" id="email" class="form-control"
                                                               required>
                                                    </div>

                                                    <h4 class="heading-primary text-uppercase mb-lg">LOGIN
                                                        INFORMATION</h4>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <label for="phone" class="font-weight-normal">Phone
                                                            <span class="required">*</span>
                                                        </label>
                                                        <input type="tel" name="phone" id="phone" class="form-control"
                                                               required>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="password" class="font-weight-normal">Password <span
                                                                    class="required">*</span></label>
                                                        <input type="password" name="password" id="password"
                                                               class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="password-confirm" class="font-weight-normal">Confirm
                                                            Password <span
                                                                    class="required">*</span></label>
                                                        <input type="password" name="password_confirmation"
                                                               id="password-confirm"
                                                               class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                    <input type="checkbox"   onchange="document.getElementById('send222').disabled = !this.checked" /> Check If You Are A Human


                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="form-action clearfix mt-none">
                                                        <input type="submit" id="send222" class="btn btn-primary btn-account2" 
                                                                data-loading-text="Loading..."  value="Register" disabled>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="contact-details">
                        <h4>Contact Information</h4>
                        <ul class="contact">
                            <li>
                                <p>
                                    <i class="fa fa-map-marker"></i>
                                    <strong>Address:</strong>

                                    <span style="display: inline-block;margin-left: 20px;margin-top: -10px">{{ getConfiguration('site_address') }}</span>
                                </p>
                            </li>
                            <li>
                                <p>
                                    <i class="fa fa-phone"></i>
                                    <strong>Phone:</strong><br>
                                    <a href="tel:{{ getConfiguration('site_primary_phone') }}">{{ getConfiguration('site_primary_phone') }}</a>,
                                    <a href="tel:{{ getConfiguration('site_secondary_phone') }}">{{ getConfiguration('site_secondary_phone') }}</a>
                                </p>
                            </li>
                            <li>
                                <p>
                                    <i class="fa fa-envelope-o"></i>
                                    <strong>Email:</strong><br>
                                    <a href="mailto:{{ getConfiguration('site_primary_email') }}">{{ getConfiguration('site_primary_email') }}</a>
                                </p>
                            </li>
                            <li>
                                <p>
                                    <i class="fa fa-clock-o"></i>
                                    <strong>Working Days/Hours:</strong>
                                    <br> Sun - Fri /10:00AM - 5:00PM
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <h4>Information</h4>
                    <ul class="links">
                        <li>
                            <i class="fa fa-check text-color-primary"></i>
                            <a href="{{ route('blog') }}">Blog</a>
                        </li>
                        <li>
                            <i class="fa fa-check text-color-primary"></i>
                            <a href="{{ url('/testimonials') }}">Testimonials</a>
                        </li>
                        <li>
                            <i class="fa fa-check text-color-primary"></i>
                            <a href="{{ url('/about-us') }}">About Us</a>
                        </li>
                        <li>
                            <i class="fa fa-check text-color-primary"></i>
                            <a href="{{ url('contact-us') }}">Contact Us</a>
                        </li>
                        <li>
                            <i class="fa fa-check text-color-primary"></i>
                            <a href="#">Delivery Information</a>
                        </li>
                        <li>
                            <i class="fa fa-check text-color-primary"></i>
                            <a href="#">Terms & Conditions</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4>My Account</h4>
                    <ul class="features">
                        <li>
                            <i class="fa fa-check text-color-primary"></i>
                            <a href="{{ route('my-account') }}">My Account</a>
                        </li>
                        <li>
                            <i class="fa fa-check text-color-primary"></i>
                            <a href="{{ route('my-account.orders') }}">Orders History</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <div class="newsletter">
                        <h4>Be the First to Know</h4>
                        <p class="newsletter-info">Get all the latest information on Events,<br> Sales and Offers. Sign
                            up for newsletter today.</p>

                        <div class="alert alert-success hidden" id="newsletterSuccess">
                            <strong>Success!</strong> You've been added to our email list.
                        </div>

                        <div class="alert alert-danger hidden" id="newsletterError"></div>


                        <p>Enter your e-mail Address:</p>
                        <form id="newsletterForm111" action="/suscriber" method="POST">
   {{csrf_field()}}
                            <div class="input-group">
                                <input class="form-control" placeholder="Email Address" name="newsletterEmail"
                                       id="newsletterEmail" type="text">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <a href="#" class="logo">
                    <span>{{getConfiguration('company_name')}}</span>
                </a>
                @if(getConfiguration('facebook_link') || getConfiguration('twitter_link') || getConfiguration('googleplus_link') || getConfiguration('instagram_link') || getConfiguration('linkedin_link'))
                    <ul class="social-icons">
                        @if(getConfiguration('facebook_link'))
                            <li class="social-icons-facebook">
                                <a href="{{ getConfiguration('facebook_link') }}" target="_blank"
                                   title="Facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                        @endif
                        @if(getConfiguration('twitter_link'))
                            <li class="social-icons-twitter">
                                <a href="{{ getConfiguration('twitter_link') }}" target="_blank" title="Twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                        @endif
                        @if(getConfiguration('googleplus_link'))
                            <li class="social-icons-instagram">
                                <a href="{{ getConfiguration('googleplus_link') }}" target="_blank" title="Instagram">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                        @endif
                        @if(getConfiguration('linkedin_link'))
                            <li class="social-icons-linkedin">
                                <a href="{{ getConfiguration('linkedin_link') }}" target="_blank" title="Linkedin">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                @endif

                {{--<img alt="Payments" src="http://localhost:8000/storage/{{ getConfiguration('payments_logo') }}" class="footer-payment">--}}

                <p class="copyright-text">
                    @if(getConfiguration('copyright'))
                        {{ getConfiguration('copyright') }}
                    @else
                        © Copyright {{ date('Y') }}. All Rights Reserved.
                    @endif
                </p>
            </div>

        </div>
        <p class="dev_by">Developed by <a href="http://nextaussie.com"> Next Aussie Tech</a></p>
    </footer>
</div>

<!-- Vendor -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/jquery.appear/jquery.appear.min.js') }}"></script>
<script src="{{ asset('vendor/jquery.easing/jquery.easing.min.js') }}"></script>
{{--<script src="{{ asset('vendor/jquery-cookie/jquery-cookie.min.js') }}"></script>--}}
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/common/common.min.js') }}"></script>
<script src="{{ asset('vendor/jquery.validation/jquery.validation.min.js') }}"></script>
{{--<script src="{{ asset('vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>--}}
<script src="{{ asset('vendor/jquery.gmap/jquery.gmap.min.js') }}"></script>
<script src="{{ asset('vendor/jquery.lazyload/jquery.lazyload.min.js') }}"></script>
<script src="{{ asset('vendor/isotope/jquery.isotope.min.js') }}"></script>
<script src="{{ asset('vendor/owl.carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('vendor/vide/vide.min.js') }}"></script>

<!-- Theme Base, Components and Settings -->
<script src="{{ asset('js/theme.js') }}"></script>

@stack('scripts')

<!-- Demo -->
<script src="{{ asset('js/shop.js') }}"></script>

<!-- Theme Custom -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- Theme Initialization Files -->
<script src="{{ asset('js/theme.init.js') }}"></script>

<script>
    {{--Login/Register--}}
    @if (auth()->guest())
    $(document).on("click", ".btn-account", function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: $this.closest('form').attr('action'),
            data: $this.closest('form').serialize(),
            beforeSend: function () {
                $this.button('loading');
            },
            success: function (data) {
                $(location).attr('href', '{{ route('welcome') }}');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var errorsHolder = '';
                errorsHolder += '<ul>';

                var err = eval("(" + xhr.responseText + ")");
                $.each(err.errors, function (key, value) {
                    errorsHolder += '<li>' + value + '</li>';
                });
              

                errorsHolder += '</ul>';

                $this.closest('form').find('.alert-account.alert-danger').fadeIn().html(errorsHolder);
            },
            complete: function () {
                $this.button('reset');
            }
        });

    });
    @endif
</script>
<script>
    {{--Login/Register--}}
    @if (auth()->guest())
    $(document).on("click", ".btn-account2", function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: $this.closest('form').attr('action'),
            data: $this.closest('form').serialize(),
            beforeSend: function () {
                $this.button('loading');
            },
            success: function (data) {
                $(location).attr('href', '{{ route('vertification') }}');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                var errorsHolder = '';
                errorsHolder += '<ul>';

                var err = eval("(" + xhr.responseText + ")");
                $.each(err.errors, function (key, value) {
                    errorsHolder += '<li>' + value + '</li>';
                });
              

                errorsHolder += '</ul>';

                $this.closest('form').find('.alert-account.alert-danger').fadeIn().html(errorsHolder);
            },
            complete: function () {
                $this.button('reset');
            }
        });

    });
    @endif
</script>
</body>