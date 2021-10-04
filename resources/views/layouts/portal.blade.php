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
    <link rel="stylesheet" href="/web/stylesheet/jquery.mobile-menu.css">
    <link rel="stylesheet" href="/web/stylesheet/style.css">
    <link rel="stylesheet" href="/web/stylesheet/responsive.css">
    @stack('styles')
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
                                <ul id="nav" class="hidden-xs">
                                    <li><a class="level-top" href="/"><span>Home</span></a></li>
                                    <li class="level0 parent drop-menu"><a href="#"><span>Commission</span> </a>
                                        <!--sub sub category-->
                                        <ul class="level1">
                                            <li class="level1 first">
                                                <a href="/portal/commission/bonus"><span>Commission & Bonus</span></a>
                                            </li>
                                            <li class="level1 first">
                                                <a href="/portal/commission/general"><span>General Commission</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a class="level-top" href="/portal/promotion"><span>Promotion</span></a></li>
                                    <li class="level0 parent drop-menu"><a href="#"><span>Products</span> </a>
                                        <!--sub sub category-->
                                        <ul class="level1">
                                            <li class="level1 first">
                                                <a href="/portal/products"><span>Regular Product</span></a>
                                            </li>
                                            <li class="level1 first">
                                                <a href="/portal/products?joining=true"><span>Joining Product</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="level0 parent drop-menu"><a href="#"><span>Wallet</span> </a>
                                        <!--sub sub category-->
                                        <ul class="level1">
                                            <li class="level1 first"><a href="{!! route('portal.wallet.history') !!}"><span>History</span></a></li>
                                            <li class="level1 first"><a href="{!! route('portal.wallet.cash-in') !!}"><span>Cash In</span></a></li>
                                        </ul>
                                    </li>
                                    <li><a class="level-top" href="/portal/orders"><span>Orders</span></a></li>
                                    <li><a class="level-top" href="/portal/reference-users"><span>My Team</span></a></li>
                                </ul>
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
                                    <li><a href="/portal" title="My Account">Dashboard</a></li>
                                    <li><a href="/portal/profile/edit" title="My Account">Profile</a></li>
                                    <li><a href="/portal/upgrade-membership" title="Upgrade Membership">Upgrade Membership</a></li>
                                    <li><a href="/wishlist" title="Wishlist">Wishlist</a></li>
                                   <li><a onclick="document.getElementById('logout-form').submit()" href="javascript:void(0)">Logout</a></li>
                                </ul>
                                <form action="/logout" id="logout-form" method="post">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="fl-cart-contain">
                        <b style="margin-top: 10px;display: inline-block">
                            ৳{!! number_format($wallet_amount, 2) !!}
                        </b>
                    </div>
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
@stack('scripts')
<script type="text/javascript" src="/web/web.js"></script>
<script type="text/javascript" src="/web/js/common.js"></script>
</body>
</html>
