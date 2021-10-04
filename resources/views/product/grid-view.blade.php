<ul class="products-grid">
    @foreach($products as $product)
        <li class="item col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <div class="item-inner">
                <div class="item-img">
                    <div class="item-img-info">
                        <a href="{!! $product->permalink() !!}" title="{{ $product->name }}" class="product-image">
                            <img src="{!! $product->firstImagePath() !!}" alt="{{ $product->name }}">
                        </a>
                        <div class="item-box-hover">
                            <grid-product-option class-name="{{ class_basename($product) }}" slug="{{ $product->slug }}" product-id="{{ $product->id }}"></grid-product-option>
                        </div>
                    </div>
                </div>
                <div class="item-info">
                    <div class="info-inner">
                        <div class="item-title">
                            <a href="{!! $product->permalink() !!}" title="{{ $product->name }}">{{ $product->name }}</a>
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
        </li>
    @endforeach
</ul>
<div>
    <product-popup></product-popup>
</div>