@extends('layouts.website')

@section('title', $package->name)

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
@endpush

@section('content')
    @include('partials.page-heading', ['category' => $package->immediateCategory])
    <!-- BEGIN Main Container -->
    <div class="main-container col1-layout">
        <div class="main">
            <div class="col-main">
                <!-- Endif Next Previous Product -->
                <div class="product-view" itemtype="http://schema.org/Product" itemid="#product_base">
                    <div id="messages_product_view"></div>
                    <!--product-next-prev-->
                    <div class="product-essential container">
                        <div class="row">
                            <form action="#" method="post" id="product_addtocart_form">
                                <!--End For version 1, 2, 6 -->
                            @if($package->images->isNotEmpty())
                                <!-- For version 3 -->
                                <div class="col-sm-6 col-xs-12">
                                    <div class="packages">
                                        @foreach($package->images as $image)
                                            <img src="{!! $image->path() !!}" alt="">
                                        @endforeach
                                    </div>
                                    <!-- end: more-images -->
                                </div>
                                    <!--End For version 1,2,6-->
                            @endif
                            <!-- For version 3 -->
                                <div class="product-shop col-sm-6 col-xs-12 package-shop">
                                    <div class="product-name">
                                        <h1 itemprop="name">{{ $package->name }}</h1>
                                    </div>

                                    <div class="price-block">
                                        <div class="price-box">
                                            <span class="regular-price" id="product-price-123">
                                                <span class="price">৳{{ $package->price() }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <!--price-block-->
                                    <div class="short-description">
                                        <h2>Products</h2>
                                        <ul>
                                            @foreach($package->products as $product)
                                                <li><a target="_blank" href="{!! $product->permalink() !!}">{{ $product->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <single-add-to-cart class-name="{!! class_basename($package) !!}" product-id="{!! $package->id !!}"></single-add-to-cart>
                                    <!--add-to-box-->
                                    <!-- thm-mart Social Share-->
                                    <div class="social">
                                        <ul class="link">
                                            <li class="fb">
                                                <a href="http://www.facebook.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a>
                                            </li>
                                            <li class="linkedin">
                                                <a href="http://www.linkedin.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a>
                                            </li>
                                            <li class="tw">
                                                <a href="http://twitter.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a>
                                            </li>
                                            <li class="pintrest">
                                                <a href="http://pinterest.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a>
                                            </li>
                                            <li class="googleplus">
                                                <a href="https://plus.google.com/" rel="nofollow" target="_blank" style="text-decoration:none;"> </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- thm-mart Social Share Close-->
                                </div>
                                <!--product-shop-->
                                <!--Detail page static block for version 3-->
                            </form>
                        </div>
                    </div>
                    <!--product-essential-->
                    <div class="product-collateral container">
                        <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                            <li class="active"> <a href="#product_tabs_cash_back" data-toggle="tab">Cash back</a> </li>
                            <li> <a href="#product_tabs_nb" data-toggle="tab">NB</a> </li>
                        </ul>
                        <div id="productTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="product_tabs_cash_back">
                                <div class="product-tabs-content-inner clearfix">
                                    <p>
                                        {!! nl2br($package->cash_back) !!}
                                    </p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="product_tabs_nb">
                                <div class="product-tabs-content-inner clearfix">
                                    <p>
                                        {!! nl2br($package->nb) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--box-additional-->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script>
        $('.packages').flickity({
            pageDots: false,
            contain: true,
            cellAlign: 'left',
            autoPlay: 1500
        });
    </script>
@endpush