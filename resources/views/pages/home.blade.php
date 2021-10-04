@extends('layouts.website')

@section('title', 'Home Page')

@push('styles')
    <link rel="stylesheet" href="/web/stylesheet/revslider.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
@endpush

@section('content')
    <!--container-->
    <div class="content">
        @if($slides->isNotEmpty())
        <div id="tmg-slideshow" class="tmg-slideshow">
            <div class="container">
                <div id='thm_slider_wrapper' class='thm_slider_wrapper fullwidthbanner-container' >
                    <div id='thm-rev-slider' class='rev_slider fullwidthabanner'>
                        <ul>
                            @foreach($slides as $slide)
                            <li data-transition='random' data-slotamount='7' data-masterspeed='1000' data-thumb='{!! $slide->path() !!}'>
                                <img src='{!! $slide->path() !!}'  data-bgposition='left top'  data-bgfit='cover' data-bgrepeat='no-repeat' alt="slider-image1" />
                                <div class="info">
                                    <div class='tp-caption LargeTitle sfl tp-resizeme' data-x='0'  data-y='230'  data-endspeed='500'  data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' ><span>{{ $slide->title }}</span></div>
                                    <div class='tp-caption sfb tp-resizeme' data-x='0'  data-y='420'  data-endspeed='500'  data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1'><a href='{{ $slide->link }}' class="buy-btn">{{ $slide->button_text }}</a></div>
                                    <div class='tp-caption Title sft tp-resizeme' data-x='0'  data-y='320'  data-endspeed='500'  data-speed='500' data-start='1500' data-easing='Power2.easeInOut' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1'>{!! nl2br($slide->description) !!}</div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @include('partials.package-slider', compact('packages'))

        <div class="box-additional mt-4 CollectionGrid-container">
           @foreach($home_categories as $category)
            <div class="related-pro container">
                <div class="slider-items-products">
                    <div class="new_title center">
                        <h2><a href="{!! $category->permalink() !!}">{{ $category->name }}</a></h2>
                    </div>
                    <div id="related-slider" class="product-flexslider hidden-buttons">
                        <div class="slider-items slider-width-col4 products-grid owl-carousel owl-theme">
                            @foreach($category->products as $product)
                            <div class="item">
                                <div class="item-inner">
                                    <div class="item-img">
                                        <div class="item-img-info">
                                            <a href="{!! $product->permalink() !!}" title="{{ $product->name }}" class="product-image">
                                                <img src="{!! $product->firstImagePath() !!}" alt="{{ $product->name }}">
                                            </a>
                                            <div class="item-box-hover">
                                                <div class="box-inner">
                                                    <grid-product-option class-name="{{ class_basename($product) }}" slug="{{ $product->slug }}" product-id="{{ $product->id }}"></grid-product-option>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-info">
                                        <div class="info-inner">
                                            <div class="item-title">
                                                <a href="{!! $product->permalink() !!}" >{{ $product->name }}</a>
                                            </div>
                                            <div class="item-content">
                                                <div class="item-price">
                                                    <div class="price-box">
                                                        <span class="regular-price">
                                                            <span class="price">৳{{ $product->price() }}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- end related product -->
        </div>
    </div>
    <div>
        <product-popup></product-popup>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="/web/js/revslider.js"></script>
    <script type="text/javascript" src="/web/js/custom.js"></script>
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