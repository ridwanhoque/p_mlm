<ol class="products-list" id="products-list">
    @foreach($products as $product)
    <li class="item">
        <div class="product-image">
            <a href="{!! $product->permalink() !!}" title="{{ $product->name }}">
                <img class="small-image" src="{!! $product->firstImagePath() !!}" alt="{{ $product->name }}">
            </a>
        </div>
        <div class="product-shop">
            <h2 class="product-name">
                <a href="{!! $product->permalink() !!}" title="{{ $product->name }}">{{ $product->name }}</a>
            </h2>
            <div class="desc std">
                <p>
                    {{ $product->shortDescription() }}
                </p>
            </div>
            <div class="price-box">
                <p class="special-price">
                    <span class="price-label"></span> <span id="product-price-212" class="price"> ৳{{ $product->price() }} </span>
                </p>
            </div>
            <div>
                <list-product-option class-name="{{ class_basename($product) }}" product-id="{{ $product->id }}"></list-product-option>
            </div>
        </div>
    </li>
    @endforeach
</ol>