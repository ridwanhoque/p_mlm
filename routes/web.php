<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes([
    'verify' => true
]);

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified'], 'as' => 'admin.', 'namespace' => 'Dashboard'], function (){

    Route::view('/', 'layouts.dashboard');

    Route::get('user', 'UserController');
    Route::get('users/{user?}', 'UserController@show');

    Route::apiResources([
        'brands' => 'BrandController',
        'suppliers' => 'SupplierController',
        'categories' => 'CategoryController',
        'slides' => 'SlideController',
        'products' => 'ProductController',
        'packages' => 'PackageController',
        'courses' => 'CourseController',
        'commission-hands' => 'CommissionHandController',
        'promotional-designations' => 'PromotionalDesignationController',
        'bonus-commissions' => 'BonusCommissionController',
    ]);

    Route::apiResource('delivery-centers', 'DeliveryCenterController');


    Route::get('promotional-designations/{promotionalDesignation}/{user}', 'PromotionalDesignationController@users');

    Route::apiResource('purchases', 'PurchaseController')->except('update');
    
    Route::get('wallets', 'WalletController@index');
    Route::get('wallets/{wallet}', 'WalletController@show');

    Route::get('purchases/{purchase}/payments', 'PurchasePaymentController@index');
    Route::post('purchases/{purchase}/payments', 'PurchasePaymentController@store');

    Route::get('delivery-modes', 'DeliveryModeController@index')->name('delivery-modes.index');

    Route::delete('images/{image}', 'ImageController@destroy')->name('images.destroy');

    Route::get('options', 'OptionController@index');
    Route::post('options', 'OptionController@update');

    Route::get('orders', 'OrderController@index');
    Route::put('orders/{order}/update-status', 'OrderController@updateStatus');
    Route::get('orders/{order}', 'OrderController@show');
});


Route::get('/', 'HomeController@index');

Route::get('categories/{category}', 'CategoryController@show');

Route::get('products/{product}', 'ProductController@show');

Route::get('packages/{package}', 'PackageController@show');



Route::group(['middleware' => ['auth', 'verified']], function (){
    Route::get('cart', 'CartController@index');
    Route::put('cart', 'CartController@update');
    Route::post('cart/{item}', 'CartController@store');
    Route::delete('cart/{item}', 'CartController@remove');
    Route::post('cart/{district}/set-district', 'CartController@setDistrict');

    Route::get('shipping-address', 'ShippingController@index');

    Route::get('wishlist', 'WishlistController@index');
    Route::post('wishlist/{itemId}/{itemClass}', 'WishlistController@store');
    Route::delete('wishlist/{itemId}/{itemClass}', 'WishlistController@destroy');

    Route::put('password', 'PasswordController@update');
    
});

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'portal', 'namespace' => 'Portal', 'as' => 'portal.'], function (){
    Route::get('/', 'HomeController@index');

    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::get('profile', 'ProfileController@show');
    Route::put('profile', 'ProfileController@update');

    Route::get('wallet/cash-in', 'WalletController@cashInIndex')->name('wallet.cash-in');
    Route::post('wallet/cash-in', 'WalletController@cashIn');
    Route::get('wallet/history', 'WalletController@history')->name('wallet.history');

    Route::get('orders', 'OrderController@index');
    Route::post('orders', 'OrderController@store');
    Route::get('orders/{order}', 'OrderController@show')->name('orders.show');

    Route::get('reference-users/{user?}', 'UserController@references');

    Route::get('commission/{type}', 'CommissionController@index')->where([
        'type' => 'bonus|general'
    ]);

    Route::get('promotion', 'PromotionController@index');

    Route::get('products', 'ProductController@index');

    Route::get('upgrade-membership', 'UpgradeMembershipController@edit');
    Route::put('upgrade-membership', 'UpgradeMembershipController@update');

    Route::get('send-sms/{user}', 'UserController@sendSms')->name('sms.send');

    Route::get('conversations/{conversation}', 'ConversationController@show')->name('conversations.show');

    // Payments Routes

    Route::post('payments/{order}/failed', 'PaymentController@failed')->name('payment.failed');

    Route::post('payments/{order}/success', 'PaymentController@success')->name('payment.success');
    Route::post('payments/{order}/cancel', 'PaymentController@cancel')->name('payment.cancel');

});


