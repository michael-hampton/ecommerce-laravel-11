<?php

use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\AttributeValueController;
use App\Http\Controllers\API\AuthController;
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
    Route::get('/admin', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.index');
    Route::get('/profile', [\App\Http\Controllers\Admin\AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/profile/update', [\App\Http\Controllers\Admin\AdminController::class, 'updateProfile'])->name('admin.profile.update');


//Brands
    Route::apiResource('brands', \App\Http\Controllers\Api\BrandController::class);
// Categories
    Route::apiResource('categories', \App\Http\Controllers\Api\CategoryController::class);

// products
    Route::apiResource('products', \App\Http\Controllers\Api\ProductController::class);
    Route::post('products/subcategories', [\App\Http\Controllers\Api\ProductController::class, 'getSubcategories'])->name('admin.products.getSubcategories');

// users
    Route::apiResource('users', \App\Http\Controllers\Api\UserController::class);

    Route::put('users/updateActive/{id}', [\App\Http\Controllers\Api\UserController::class, 'updateActive'])->name('admin.users.updateActive');

// slides
    Route::apiResource('slides', \App\Http\Controllers\Api\SlideController::class);


//orders
    Route::apiResource('orders', \App\Http\Controllers\Api\OrderController::class);
    Route::get('orders/{orderId}/details', [\App\Http\Controllers\Api\OrderController::class, 'orderDetails'])->name('admin.orderDetails');
    Route::put('orders/details/update/{orderItemId}', [\App\Http\Controllers\Api\OrderController::class, 'updateItemDetails'])->name('admin.orders.updateItemDetails');

//attributes
    Route::apiResource('attributes', \App\Http\Controllers\Api\AttributeController::class);

    //lookup
    Route::get('lookup/orders', [\App\Http\Controllers\Api\LookupController::class, 'getOrders'])->name('admin.dashboard');
    Route::get('lookup/categories', [\App\Http\Controllers\Api\LookupController::class, 'getCategories'])->name('admin.dashboard');
    Route::get('lookup/brands', [\App\Http\Controllers\Api\LookupController::class, 'getBrands'])->name('admin.dashboard');
    Route::get('lookup/attributes', [\App\Http\Controllers\Api\LookupController::class, 'getAttributes'])->name('admin.dashboard');
    Route::get('lookup/subcategories/{categoryId}', [\App\Http\Controllers\Api\LookupController::class, 'getSubcategories'])->name('admin.dashboard');

    // dashboard
    Route::get('dashboard', [\App\Http\Controllers\Api\DashboardController::class, 'get'])->name('admin.dashboard');

//attribute values
    Route::apiResource('attribute-values', \App\Http\Controllers\Api\AttributeValueController::class);


//coupons
    Route::apiResource('coupons', \App\Http\Controllers\Api\CouponController::class);

    //seller
    Route::apiResource('sellers', \App\Http\Controllers\Api\SellerController::class);

});


