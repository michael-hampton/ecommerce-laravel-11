<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PaymentProviders\PaypalController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/test', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');


Auth::routes();
//Paypal
Route::get('paypal/payment/success/{orderId}', [PayPalController::class, 'paymentSuccess'])->name('paypal.payment.success');
Route::get('paypal/payment/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.payment/cancel');

//Route::get('/login', [LoginController::class, 'authenticate'])->name('login');


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');

//Shop
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/search', [App\Http\Controllers\ProductController::class, 'productSearch'])->name('shop.searchProducts');
Route::get('/shop/{slug}', [App\Http\Controllers\ShopController::class, 'details'])->name('shop.product.details');

//wishlist
Route::post('/wishlist/add', [App\Http\Controllers\WishListController::class, 'addToWishList'])->name('wishlist.add');
Route::get('/wishlist', [App\Http\Controllers\WishListController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/item/remove/{rowId}', [App\Http\Controllers\WishListController::class, 'removeFromWishList'])->name('wishlist.removeFromWishList');
Route::delete('/wishlist/clear', [App\Http\Controllers\WishListController::class, 'emptyWishList'])->name('wishlist.emptyWishList');
Route::post('/wishlist/move-to-cart/{rowId}', [App\Http\Controllers\WishListController::class, 'moveToCart'])->name('wishlist.moveToCart');
Route::get('seller/{id}', [App\Http\Controllers\SellerController::class, 'index'])->name('seller.details');
Route::post('/seller/review/{sellerId}', [App\Http\Controllers\SellerController::class, 'store'])->name('storeSellerReview');


//Cart
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
Route::put('/cart/increase-quantity/{rowId}', [App\Http\Controllers\CartController::class, 'increaseCartQuantity'])->name('cart.increaseCartQuantity');
Route::put('/cart/decrease-quantity/{rowId}', [App\Http\Controllers\CartController::class, 'decreaseCartQuantity'])->name('cart.decreaseCartQuantity');
Route::put('/cart/update-shipping/{rowId}', [App\Http\Controllers\CartController::class, 'updateShipping'])->name('cart.updateShipping');
Route::delete('/cart/remove/{rowId}', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.removeFromCart');
Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'emptyCart'])->name('cart.emptyCart');

Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/orders', [App\Http\Controllers\UserAccountController::class, 'orders'])->name('orders.ordersCustomer');
    Route::get('/order-details/{orderId}', [App\Http\Controllers\UserAccountController::class, 'orderDetails'])->name('orders.orderDetailsCustomer');
    Route::put('/order/cancel/{orderId}', [App\Http\Controllers\UserAccountController::class, 'cancelOrder'])->name('orders.cancelOrder');
    Route::get('/review/{orderItemId}', [App\Http\Controllers\ReviewController::class, 'create'])->name('createReview');
    Route::post('/review/{productId}/create', [App\Http\Controllers\ReviewController::class, 'store'])->name('storeReview');

    //account

    //aaddresses
    Route::get('/account-dashboard/address', [App\Http\Controllers\UserAccountController::class, 'address'])->name('user.address');
    Route::get('/account-dashboard/address/add', [App\Http\Controllers\UserAccountController::class, 'addAddress'])->name('user.addAddress');
    Route::post('/account-dashboard/address/store', [App\Http\Controllers\UserAccountController::class, 'storeAddress'])->name('user.storeAddress');
    Route::get('/account-dashboard/address/edit/{addressId}', [App\Http\Controllers\UserAccountController::class, 'editAddress'])->name('user.editAddress');
    Route::put('/account-dashboard/address/updateAddress/{addressId}', [App\Http\Controllers\UserAccountController::class, 'updateAddress'])->name('user.updateAddress');


    Route::get('/account-dashboard/reviews', [App\Http\Controllers\UserAccountController::class, 'reviews'])->name('user.reviews');
    Route::get('/account-dashboard/wishlist', [App\Http\Controllers\UserAccountController::class, 'wishlist'])->name('user.wishlist');
    Route::get('/account-dashboard/questions', [App\Http\Controllers\UserAccountController::class, 'askQuestion'])->name('user.askQuestion');
    Route::get('/account-dashboard/questions/details/{questionId}', [App\Http\Controllers\UserAccountController::class, 'askQuestionDetails'])->name('user.askQuestionDetails');
    Route::post('/account-dashboard/questions/create', [App\Http\Controllers\UserAccountController::class, 'createQuestion'])->name('user.createQuestion');
    Route::post('/account-dashboard/post-reply', [\App\Http\Controllers\UserAccountController::class, 'postReply'])->name('user.postReply');
});

Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::get('/profile', [App\Http\Controllers\AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/profile/update', [App\Http\Controllers\AdminController::class, 'updateProfile'])->name('admin.profile.update');


    //Brands
    Route::get('/admin/brands', [App\Http\Controllers\BrandController::class, 'index'])->name('admin.brands');
    Route::get('/admin/brands/create', [App\Http\Controllers\BrandController::class, 'create'])->name('admin.brands.create');
    Route::get('/admin/brands/edit/{id}', [App\Http\Controllers\BrandController::class, 'edit'])->name('admin.brands.edit');
    Route::put('/admin/brands/update/{id}', [App\Http\Controllers\BrandController::class, 'update'])->name('admin.brands.update');
    Route::delete('/admin/brands/{id}/delete', [App\Http\Controllers\BrandController::class, 'destroy'])->name('admin.brands.destroy');
    Route::post('/admin/brands/store', [App\Http\Controllers\BrandController::class, 'store'])->name('admin.brands.store');

    // Categories
    Route::get('/admin/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('admin.categories');
    Route::get('/admin/categories/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('admin.categories.create');
    Route::get('/admin/categories/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/update/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}/delete', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    Route::post('/admin/categories/store', [App\Http\Controllers\CategoryController::class, 'store'])->name('admin.categories.store');

    // products
    Route::get('/admin/products', [App\Http\Controllers\ProductController::class, 'index'])->name('admin.products');
    Route::get('/admin/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('admin.products.create');
    Route::get('/admin/products/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}/delete', [App\Http\Controllers\ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::post('/admin/products/store', [App\Http\Controllers\ProductController::class, 'store'])->name('admin.products.store');
    Route::post('/admin/products/subcategories', [App\Http\Controllers\ProductController::class, 'getSubcategories'])->name('admin.products.getSubcategories');

    // users
    Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('admin.users.create');
    Route::get('/admin/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}/delete', [App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/admin/users/store', [App\Http\Controllers\UserController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/updateActive/{id}', [App\Http\Controllers\UserController::class, 'updateActive'])->name('admin.users.updateActive');

    // slides
    Route::get('/admin/slides', [App\Http\Controllers\SlideController::class, 'index'])->name('admin.slides');
    Route::get('/admin/slides/create', [App\Http\Controllers\SlideController::class, 'create'])->name('admin.slides.create');
    Route::get('/admin/slides/edit/{id}', [App\Http\Controllers\SlideController::class, 'edit'])->name('admin.slides.edit');
    Route::put('/admin/slides/update/{id}', [App\Http\Controllers\SlideController::class, 'update'])->name('admin.slides.update');
    Route::delete('/admin/slides/{id}/delete', [App\Http\Controllers\SlideController::class, 'destroy'])->name('admin.slides.destroy');
    Route::post('/admin/slides/store', [App\Http\Controllers\SlideController::class, 'store'])->name('admin.slides.store');

    //orders
    Route::get('/admin/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('admin.orders');
    Route::get('/admin/order/{orderId}/details', [App\Http\Controllers\OrderController::class, 'orderDetails'])->name('admin.orderDetails');
    Route::get('/admin/orders/create', [App\Http\Controllers\OrderController::class, 'create'])->name('admin.orders.create');
    Route::get('/admin/orders/edit/{id}', [App\Http\Controllers\OrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/admin/orders/update/{id}', [App\Http\Controllers\OrderController::class, 'update'])->name('admin.orders.update');
    Route::put('/admin/order/details/update/{orderItemId}', [App\Http\Controllers\OrderController::class, 'updateItemDetails'])->name('admin.orders.updateItemDetails');
    Route::delete('/admin/orders/{id}/delete', [App\Http\Controllers\OrderController::class, 'destroy'])->name('admin.orders.destroy');
    Route::post('/admin/orders/store', [App\Http\Controllers\OrderController::class, 'store'])->name('admin.orders.store');
    Route::put('/admin/orders/update/{id}', [App\Http\Controllers\OrderController::class, 'update'])->name('admin.orders.update');

   //attributes
    Route::get('/admin/attributes', [AttributeController::class, 'index'])->name('admin.attributes');
   Route::get('/admin/attribute/add',[AttributeController::class, 'create'])->name('admin.add_attribute');
    Route::get('/admin/attribute/edit/{attribute_id}',[AttributeController::class, 'edit'])->name('admin.edit_attribute');
    Route::post('/admin/attribute/store',[AttributeController::class, 'store'])->name('admin.create_attribute');
    Route::delete('/admin/attribute/{id}/delete', [App\Http\Controllers\AttributeController::class, 'destroy'])->name('admin.attributes.destroy');

    Route::get('/admin/ask-a-question', [\App\Http\Controllers\AdminController::class, 'askQuestion'])->name('admin.askQuestion');
    Route::get('/admin/ask-a-question/details/{questionId}', [\App\Http\Controllers\AdminController::class, 'askQuestionDetails'])->name('admin.askQuestionDetails');
    Route::post('/admin/post-reply', [\App\Http\Controllers\AdminController::class, 'postReply'])->name('admin.postReply');

});

//coupons
Route::get('/admin/coupons', [App\Http\Controllers\CouponController::class, 'index'])->name('admin.coupons');
Route::get('/admin/coupons/create', [App\Http\Controllers\CouponController::class, 'create'])->name('admin.coupons.create');
Route::get('/admin/coupons/edit/{id}', [App\Http\Controllers\CouponController::class, 'edit'])->name('admin.coupons.edit');
Route::put('/admin/coupons/update/{id}', [App\Http\Controllers\CouponController::class, 'update'])->name('admin.coupons.update');
Route::delete('/admin/coupons/{id}/delete', [App\Http\Controllers\CouponController::class, 'destroy'])->name('admin.coupons.destroy');
Route::post('/admin/coupons/store', [App\Http\Controllers\CouponController::class, 'store'])->name('admin.coupons.store');
Route::post('/cart/applyCoupon', [App\Http\Controllers\CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::delete('/cart/removeCoupon', [App\Http\Controllers\CartController::class, 'removeCoupon'])->name('cart.removeCoupon');

//checkout
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::get('/checkout/card', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.card');
Route::post('/checkout/place-order', [App\Http\Controllers\CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::post('/checkout/place-card-order', [App\Http\Controllers\CheckoutController::class, 'placeCardOrder'])->name('checkout.placeCardOrder');
Route::get('/checkout/order-confirmation', [App\Http\Controllers\CheckoutController::class, 'orderConfirmation'])->name('checkout.orderConfirmation');

Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update-password');


