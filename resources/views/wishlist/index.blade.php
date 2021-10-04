@extends('layouts.website')

@section('title', 'Wishlist')

@section('content')
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title">
                        <h2>My Wishlist</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 col-xs-12">
                    <div class="my-account">
                        <div class="my-wishlist">
                            <fieldset>
                                <div class="table-responsive">
                                    <table class="clean-table linearize-table data-table table-striped" id="wishlist-table">
                                        <thead>
                                        <tr class="first last">
                                            <th class="customer-wishlist-item-image">Product</th>
                                            <th class="customer-wishlist-item-info">Description</th>
                                            <th class="customer-wishlist-item-price">Price</th>
                                            <th class="customer-wishlist-item-cart"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($wishlistProducts as $product)
                                            <tr class="first odd">
                                                <td class="wishlist-cell0 customer-wishlist-item-image">
                                                    <a class="product-image" href="{{ $product->permalink() }}" title="{{ $product->name }}">
                                                        <img src="{{ $product->firstImagePath() }}" width="80" height="80" alt="{{ $product->name }}">
                                                    </a>
                                                </td>
                                                <td class="wishlist-cell1 customer-wishlist-item-info">
                                                    <h3 class="product-name">
                                                        <a href="{{ $product->permalink() }}" title="{{ $product->name }}">{{ $product->name }}</a>
                                                    </h3>
                                                    <div class="description std">
                                                        <div class="inner">
                                                            {{ $product->shortDescription() }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="wishlist-cell3 customer-wishlist-item-price">
                                                    <div class="cart-cell">
                                                        <div class="price-box">
                                                            <span class="regular-price">
                                                                <span class="price">৳{{ $product->price() }}</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="wishlist-cell4 customer-wishlist-item-cart">
                                                    <div class="cart-cell">
                                                        <form action="/wishlist/{!! $product->id !!}/{!! class_basename($product) !!}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="javascript:void(0)" onclick="this.parentElement.submit();" title="Remove From Wishlist" class="remove-item"></a>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <br>
                            <fieldset>
                                <div class="table-responsive">
                                    <table class="clean-table linearize-table data-table table-striped" id="wishlist-table">
                                        <thead>
                                        <tr class="first last">
                                            <th class="customer-wishlist-item-image">Package</th>
                                            <th class="customer-wishlist-item-price">Price</th>
                                            <th class="customer-wishlist-item-cart"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($wishlistPackages as $package)
                                            <tr class="first odd">
                                                <td class="wishlist-cell0 customer-wishlist-item-image">
                                                    <a class="product-image" href="{{ $package->permalink() }}" title="{{ $package->name }}">
                                                        <img src="{{ $package->firstImagePath() }}" width="80" height="80" alt="{{ $package->name }}">
                                                    </a>
                                                </td>
                                                <td class="wishlist-cell1 customer-wishlist-item-info">
                                                    <h3 class="product-name">
                                                        <a href="{{ $package->permalink() }}" title="{{ $package->name }}">{{ $package->name }}</a>
                                                    </h3>
                                                </td>
                                                <td class="wishlist-cell3 customer-wishlist-item-price">
                                                    <div class="cart-cell">
                                                        <div class="price-box">
                                                            <span class="regular-price">
                                                                <span class="price">৳{{ $package->price() }}</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="wishlist-cell4 customer-wishlist-item-cart">
                                                    <div class="cart-cell">
                                                        <form action="/wishlist/{!! $package->id !!}/{!! class_basename($package) !!}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="javascript:void(0)" onclick="this.parentElement.submit();" title="Remove From Wishlist" class="remove-item"></a>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </section>
            </div>
            <!--row-->
        </div>
        <!--main container-->
    </section>
@endsection
@push('scripts')
    <script>
        $('.remove-item').click(function (e) {
            e.preventDefault();
            $(this).parents('form').submit();
        });
    </script>
@endpush