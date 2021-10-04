<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Title here')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Default Description">
    <meta name="keywords" content="fashion, store, E-commerce">
    <meta name="robots" content="*">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <link rel="icon" href="#" type="image/x-icon">
    <link rel="shortcut icon" href="#" type="image/x-icon">

    <!-- CSS Style -->

    <link rel="stylesheet" href="/web/stylesheet/bootstrap.min.css">
    <link rel="stylesheet" href="/web/stylesheet/font-awesome.css">
    <link rel="stylesheet" href="/web/stylesheet/owl.carousel.css">
    <link rel="stylesheet" href="/web/stylesheet/jquery.mobile-menu.css">
    @stack('styles')
    <link rel="stylesheet" href="/web/stylesheet/style.css">
    <link rel="stylesheet" href="/web/stylesheet/responsive.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,400italic,700,800,900' rel='stylesheet' type='text/css'>

    <meta name="viewport" content="initial-scale=1.0, width=device-width">
</head>
<body>
<div id="page">
    <header>
        <div id="header">
            <div class="header-container container">
                <div class="row">
                    <div class="logo">
                        <a href="/" title="Logo">
                            <div><img src="/uploads/{!! $options->getOption('website_logo') !!}" alt="{{ $options->get('website_name') }}"></div>
                        </a>
                    </div>
                    <div class="fl-nav-menu">
                        <nav>
                            <div class="mm-toggle-wrap">
                                <div class="mm-toggle"><i class="icon-align-justify"></i><span class="mm-label">Menu</span> </div>
                            </div>
                            <div class="nav-inner">
                                @include('partials.nav-menu')
                            </div>
                        </nav>
                    </div>
                    <!--row-->
                </div>
                <div class="fl-header-right">
                    <div class="fl-links">
                        <div class="no-js"> <a title="Company" class="clicker"></a>
                            <div class="fl-nav-links">
                                <ul class="links">
                                    @auth
                                        <li><a href="/portal" title="My Account">My Account</a></li>
                                        <li><a href="/wishlist" title="Wishlist">Wishlist</a></li>
                                    @else
                                        <li><a href="/register" title="Checkout">Register</a></li>
                                        <li class="last"><a href="/login" title="Login"><span>Login</span></a></li>
                                    @endauth
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="fl-cart-contain">
                        <mini-cart></mini-cart>
                    </div>
                    <!--mini-cart-->
                    <div class="collapse navbar-collapse">
                        <form class="navbar-form" role="search">
                            <div class="input-group">
                                <input class="GlobalNavSearch js-globalSearchInput " placeholder="Search" id="desktopSearchInput"  data-reactid=".1.0.0.0">
                                <label class="GlobalNavSearch-searchIcon" for="desktopSearchInput" data-reactid=".1.0.0.1"></label>
                            </div>
                        </form>
                    </div>
                    <!--links-->
                </div>
            </div>
        </div>
    </header>
    @yield('content')

    @include('partials.footer')
    <!-- End For version 1,2,3,4,6 -->
</div>
<!--page-->
<!-- Mobile Menu-->
@include('partials.mobile-nav-menu')

<!-- JavaScript -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
    <script type="text/javascript" src="/web/js/bootstrap.min.js"></script>
{{--    <script type="text/javascript" src="/web/js/countdown.js"></script>--}}
{{--<script type="text/javascript" src="/web/js/jquery.bxslider.min.js"></script>--}}
<script type="text/javascript" src="/web/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="/web/js/jquery.mobile-menu.min.js"></script>
<script type="text/javascript" src="/web/web.js"></script>
@stack('scripts')
<script type="text/javascript" src="/web/js/common.js"></script>
</body>
</html>
