<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\AttributeValueController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\CourierController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DeliveryMethodController;
use App\Http\Controllers\Api\LookupController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Seller\SellerAccountController;
use App\Http\Controllers\Api\Seller\SellerBalanceController;
use App\Http\Controllers\Api\Seller\SellerController;
use App\Http\Controllers\Api\Seller\SellerTransactionController;
use App\Http\Controllers\Api\SlideController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');


    //Brands
    Route::apiResource('brands', BrandController::class);
    Route::delete('/brands/{id}/active', [BrandController::class, 'toggleActive'])->name('brands.active');

    // Categories
    Route::apiResource('categories', CategoryController::class);
    Route::delete('/categories/{id}/active', [CategoryController::class, 'toggleActive'])->name('categories.active');

    Route::get('/countries', [CountryController::class, 'index'])->name('getCountries');

    // products
    Route::apiResource('products', ProductController::class);
    Route::post('products/subcategories', [ProductController::class, 'getSubcategories'])->name('admin.products.getSubcategories');

    // users
    Route::apiResource('users', UserController::class);
    Route::delete('/users/{id}/active', [UserController::class, 'toggleActive'])->name('users.active');


    Route::put('users/updateActive/{id}', [UserController::class, 'updateActive'])->name('admin.users.updateActive');

    // slides
    Route::apiResource('slides', SlideController::class);
    Route::delete('/slides/{id}/active', [SlideController::class, 'toggleActive'])->name('slides.active');


    // messages
    Route::apiResource('messages', MessageController::class);

    // couriers
    Route::apiResource('couriers', CourierController::class);

    //delivery methods
    // messages
    Route::apiResource('delivery-methods', DeliveryMethodController::class);


    //orders
    Route::apiResource('orders', OrderController::class);
    Route::put('orders/details/{orderItemId}', [OrderController::class, 'updateItemDetails'])->name('admin.orders.updateItemDetails');
    Route::get('orders/logs/{orderId}', [OrderController::class, 'logs'])->name('admin.orders.updateItemDetails');

    //attributes
    Route::apiResource('attributes', AttributeController::class);

    //lookup
    Route::get('lookup/orders', [LookupController::class, 'getOrders'])->name('admin.dashboard');
    Route::get('lookup/categories/{parentOnly?}', [LookupController::class, 'getCategories'])->name('admin.dashboard');
    Route::get('lookup/brands', [LookupController::class, 'getBrands'])->name('admin.dashboard');
    Route::get('lookup/attributes', [LookupController::class, 'getAttributes'])->name('admin.dashboard');
    Route::get('lookup/attributes/{id}', [LookupController::class, 'getAttributesForCategory'])->name('admin.dashboard');
    Route::get('lookup/subcategories/{categoryId}', [LookupController::class, 'getSubcategories'])->name('admin.dashboard');

    // dashboard
    Route::get('dashboard', [DashboardController::class, 'get'])->name('admin.dashboard');

    //attribute values
    Route::apiResource('attribute-values', AttributeValueController::class);


    //coupons
    Route::apiResource('coupons', CouponController::class);

    //seller
    Route::apiResource('sellers', SellerController::class);
    Route::post('sellers/active', [SellerController::class, 'toggleActive'])->name('admin.sellers.toggleActive');
    Route::post('sellers/account/bank', [SellerAccountController::class, 'saveBankDetails'])->name('admin.sellers.updateBankDetails');
    Route::post('sellers/account/card', [SellerAccountController::class, 'saveCardDetails'])->name('admin.sellers.updateCardDetails');
    Route::get('sellers/account/bank', [SellerAccountController::class, 'getSellerBankAccountDetails'])->name('admin.sellers.getBankDetails');
    Route::get('sellers/account/card', [SellerAccountController::class, 'getSellerCardAccountDetails'])->name('admin.sellers.getCardDetails');
    Route::get('sellers/account/transactions', [SellerTransactionController::class, 'index'])->name('admin.sellers.getTransactions');
    Route::get('sellers/account/balance', [SellerBalanceController::class, 'show'])->name('admin.sellers.getBalance');
    Route::post('sellers/account/balance/withdraw', [SellerBalanceController::class, 'withdraw'])->name('admin.sellers.withdraw');
    Route::get('sellers/account/balance/withdraw', [SellerBalanceController::class, 'getWithdrawals'])->name('sellers.getWithdrawals');
    Route::post('sellers/billing', [\App\Http\Controllers\Api\Seller\SellerBillingInformationController::class, 'store'])->name('sellers.billing');
    Route::get('billing', [\App\Http\Controllers\Api\Seller\SellerBillingInformationController::class, 'show'])->name('sellers.billing');

});


