@extends('layouts.website')

@section('title', $product->name)

@section('content')
    @include('partials.page-heading', ['category' => $product->immediateCategory])
    <!-- BEGIN Main Container -->
    <div class="main-container col1-layout wow bounceInUp animated">
        <div class="main">
            <div class="col-main">
                <!-- Endif Next Previous Product -->
                <div class="product-view wow bounceInUp animated" itemscope="" itemtype="http://schema.org/Product" itemid="#product_base">
                    <div id="messages_product_view"></div>
                    <!--product-next-prev-->
                    <div class="product-essential container">
                        <div class="row">
                            <form action="#" method="post" id="product_addtocart_form">
                                <!--End For version 1, 2, 6 -->
                                @if($product->images->isNotEmpty())
                                <!-- For version 3 -->
                                <div class="col-sm-6 col-xs-12">
                                    <image-gallery item-url="{!! $product->permalink() !!}"></image-gallery>
                                </div>

                                @endif
                                <!-- For version 3 -->
                                <div class="product-shop col-sm-6 col-xs-12">
                                    <div class="product-name">
                                        <h1 itemprop="name">{{ $product->name }}</h1>
                                    </div>

                                    <div class="price-block">
                                        <div class="price-box">
                                            <span class="regular-price" id="product-price-123">
                                                <span class="price">৳{{ $product->price() }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    @if($product->availableEmi())
                                        <div>
                                            <em>{{ $product->emi->installment_duration }}</em> <a href="#" data-target=".emi-modal" data-toggle="modal">View Details</a>
                                        </div>
                                        <div class="modal fade emi-modal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">Emi Details</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                            @foreach($product->emi->installments as $installment)
                                                                <tr>
                                                                    <th>{{ $installment->name }}</th>
                                                                    <th>Tk {{ number_format($installment->installment, 2) }}</th>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                    @endif
                                    <!--price-block-->

                                    <single-add-to-cart :is-emi="{{ $product->availableEmi() ? 'true' : 'false' }}" class-name="{!! class_basename($product) !!}" product-id="{!! $product->id !!}"></single-add-to-cart>
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
                            <li class="active"> <a href="#product_tabs_description" data-toggle="tab"> Product Description </a> </li>
                            <li> <a href="#product_tabs_cash_back" data-toggle="tab">Cash back</a> </li>
                            <li> <a href="#product_tabs_nb" data-toggle="tab">NB</a> </li>
                        </ul>
                        <div id="productTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="product_tabs_description">
                                <div class="std">
                                    <p>
                                        {!! nl2br($product->description) !!}
                                    </p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="product_tabs_cash_back">
                                <div class="product-tabs-content-inner clearfix">
                                    <p>
                                        {!! nl2br($product->cash_back) !!}
                                    </p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="product_tabs_nb">
                                <div class="product-tabs-content-inner clearfix">
                                    <p>
                                        {!! nl2br($product->nb) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--product-collateral-->
                    <div class="box-additional">
                        <!-- BEGIN RELATED PRODUCTS -->
                        <div class="related-pro container">
                            <div class="slider-items-products">
                                <div class="new_title center">
                                    <h2>Related Products</h2>
                                </div>
                                <div id="related-slider" class="product-flexslider hidden-buttons">
                                    <div class="slider-items slider-width-col4 products-grid">
                                        @foreach($related_products as $related_product)
                                        <div class="item">
                                            <div class="item-inner">
                                                <div class="item-img">
                                                    <div class="item-img-info">
                                                        <a href="{!! $related_product->permalink() !!}" title="{{ $related_product->name }}" class="product-image">
                                                            <img src="{{ $related_product->firstImagePath() }}" alt="{{ $related_product->name }}">
                                                        </a>

                                                        <div class="item-box-hover">
                                                            <div class="box-inner">
                                                                <grid-product-option class-name="{{ class_basename($related_product) }}" slug="{{ $related_product->slug }}" product-id="{{ $related_product->id }}"></grid-product-option>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item-info">
                                                    <div class="info-inner">
                                                        <div class="item-title">
                                                            <a href="{!! $related_product->permalink() !!}" title="{{ $related_product->name }}">{{ $related_product->name }}</a> </div>
                                                        <div class="item-content">
                                                            <div class="item-price">
                                                                <div class="price-box">
                                                                    <span class="regular-price">
                                                                        <span class="price">৳{{ $related_product->price() }}</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <!-- End Item -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end related product -->
                    </div>
                    <!-- end related product -->
                </div>
                <!--box-additional-->
            </div>
        </div>
    </div>
    <div>
        <product-popup></product-popup>
    </div>
@endsection