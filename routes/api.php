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
use App\Http\Controllers\Api\FaqArticleController;
use App\Http\Controllers\Api\FaqCategoryController;
use App\Http\Controllers\Api\FaqQuestionController;
use App\Http\Controllers\Api\FaqTagController;
use App\Http\Controllers\Api\LookupController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\NotificationController;
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

    // Brands
    Route::apiResource('brands', BrandController::class);
    Route::delete('/brands/{id}/active', [BrandController::class, 'toggleActive'])->name('brands.active');

    // Categories
    Route::apiResource('categories', controller: CategoryController::class);
    Route::delete('/categories/{id}/active', [CategoryController::class, 'toggleActive'])->name('categories.active');

    Route::get('/countries', [CountryController::class, 'index'])->name('getCountries');

    // products
    Route::apiResource('products', ProductController::class);
    Route::post('products/subcategories', [ProductController::class, 'getSubcategories'])->name('admin.products.getSubcategories');
    Route::delete('/products/{id}/active', [ProductController::class, 'toggleActive'])->name('categories.active');
    Route::post('products/search', [ProductController::class, 'index'])->name('');


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
    Route::delete('/couriers/{id}/active', [CourierController::class, 'toggleActive'])->name('couriers.active');
    Route::post('couriers/search', [CourierController::class, 'index'])->name('');


    // delivery methods
    // messages
    Route::apiResource('delivery-methods', DeliveryMethodController::class);

    // orders
    Route::apiResource('orders', OrderController::class);
    Route::post('orders/search', [OrderController::class, 'index'])->name('');
    Route::put('orders/details/{orderItemId}', [OrderController::class, 'updateItemDetails'])->name('admin.orders.updateItemDetails');
    Route::get('orders/logs/{orderId}', [OrderController::class, 'logs'])->name('admin.orders.updateItemDetails');

    // attributes
    Route::apiResource('attributes', AttributeController::class);

    // lookup
    Route::get('lookup/countries', action: [LookupController::class, 'getCountries'])->name('admin.countries');
    Route::get('lookup/couriers/{countryId?}', action: [LookupController::class, 'getCouriers'])->name('admin.couriers');
    Route::get('lookup/orders', action: [LookupController::class, 'getOrders'])->name('admin.dashboard');
    Route::get('lookup/categories/{parentOnly?}', [LookupController::class, 'getCategories'])->name('admin.dashboard');
    Route::get('lookup/brands', [LookupController::class, 'getBrands'])->name('admin.dashboard');
    Route::get('lookup/attributes', [LookupController::class, 'getAttributes'])->name('admin.dashboard');
    Route::get('lookup/attributes/{id}', [LookupController::class, 'getAttributesForCategory'])->name('admin.dashboard');
    Route::get('lookup/subcategories/{categoryId}', [LookupController::class, 'getSubcategories'])->name('admin.dashboard');

    // dashboard
    Route::get('dashboard', [DashboardController::class, 'get'])->name('admin.dashboard');

    // attribute values
    Route::apiResource('attribute-values', AttributeValueController::class);

    // notificationss
    Route::apiResource('notifications', NotificationController::class);
    Route::get('notification-types', [NotificationController::class, 'getTypes'])->name('notifications.getTypes');

    // coupons
    Route::apiResource('coupons', CouponController::class);

    // seller
    Route::apiResource('sellers', SellerController::class);
    Route::post('sellers/active', [SellerController::class, 'toggleActive'])->name('admin.sellers.toggleActive');
    Route::post('sellers/account/bank', [SellerAccountController::class, 'saveBankDetails'])->name('admin.sellers.updateBankDetails');
    Route::post('sellers/account/card', [SellerAccountController::class, 'store'])->name('admin.sellers.updateCardDetails');
    Route::put('sellers/account/card/{id}', [SellerAccountController::class, 'update'])->name('admin.sellers.updateCardDetails');
    Route::delete('sellers/account/card/{id}', [SellerAccountController::class, 'destroy'])->name('admin.sellers.updateCardDetails');
    Route::get('sellers/account/bank', [SellerAccountController::class, 'getSellerBankAccountDetails'])->name('admin.sellers.getBankDetails');
    Route::delete('sellers/account/bank/{id}', [SellerAccountController::class, 'deleteBankAccount'])->name('admin.sellers.getBankDetails');
    Route::get('sellers/account/card', [SellerAccountController::class, 'index'])->name('admin.sellers.getCardDetails');
    Route::get('sellers/account/transactions', [SellerTransactionController::class, 'index'])->name('admin.sellers.getTransactions');
    Route::get('sellers/account/balance', [SellerBalanceController::class, 'show'])->name('admin.sellers.getBalance');
    Route::post('sellers/account/balance/withdraw', [SellerBalanceController::class, 'withdraw'])->name('admin.sellers.withdraw');
    Route::get('sellers/account/balance/withdraw', [SellerBalanceController::class, 'getWithdrawals'])->name('sellers.getWithdrawals');
    Route::post('sellers/billing', [App\Http\Controllers\Api\Seller\SellerBillingInformationController::class, 'store'])->name('sellers.billing');
    Route::get('billing', [App\Http\Controllers\Api\Seller\SellerBillingInformationController::class, 'show'])->name('sellers.billing');
    Route::get('reviews', [App\Http\Controllers\Api\Seller\ReviewController::class, 'index'])->name('sellers.reviews');
    Route::post('reviews/reply', [App\Http\Controllers\Api\Seller\ReviewController::class, 'createReply'])->name('sellers.reviews');
    Route::post('sellers/account/balance/activate', [SellerBalanceController::class, 'activate'])->name('sellers.getWithdrawals');
    Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('');


    // Faq Articles
    Route::apiResource('faq-articles', FaqArticleController::class);

    // Faq Categories
    Route::apiResource('faq-categories', FaqCategoryController::class);

    // Faq Questions
    Route::apiResource('faq-questions', FaqQuestionController::class);

    // Faq Tags
    Route::apiResource('faq-tags', FaqTagController::class);

});
