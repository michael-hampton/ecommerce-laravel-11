<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\AttributeValueController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LookupController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SellerController;
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
// Categories
    Route::apiResource('categories', CategoryController::class);

// products
    Route::apiResource('products', ProductController::class);
    Route::post('products/subcategories', [ProductController::class, 'getSubcategories'])->name('admin.products.getSubcategories');

// users
    Route::apiResource('users', UserController::class);

    Route::put('users/updateActive/{id}', [UserController::class, 'updateActive'])->name('admin.users.updateActive');

// slides
    Route::apiResource('slides', SlideController::class);

    // messages
    Route::apiResource('messages', MessageController::class);


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
    Route::get('lookup/subcategories/{categoryId}', [LookupController::class, 'getSubcategories'])->name('admin.dashboard');

    // dashboard
    Route::get('dashboard', [DashboardController::class, 'get'])->name('admin.dashboard');

//attribute values
    Route::apiResource('attribute-values', AttributeValueController::class);


//coupons
    Route::apiResource('coupons', CouponController::class);

    //seller
    Route::apiResource('sellers', SellerController::class);

});


