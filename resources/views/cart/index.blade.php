@extends('layouts.website')

@section('title', 'Cart')

@section('content')
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title">
                        <h2>Shopping Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- BEGIN Main Container -->
        <div class="main-container col1-layout wow bounceInUp animated">

            <div class="main container">
                <div class="cart wow bounceInUp animated">
                    <div class="table-responsive shopping-cart-tbl  container">
                        <cart-page></cart-page>
                    </div>
                    @if(!Cart::isEmpty())
                        <!-- BEGIN CART COLLATERAL -->
                        <check-out-form></check-out-form>
                        <!--cart-collaterals-->
                    @endif
                </div>
                <!--cart-->
            </div>
            <!--main-container-->
        </div>
    <!--col1-layout-->
@endsection