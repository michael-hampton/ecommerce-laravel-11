<?php

use App\Http\Controllers\AngularController;
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

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');


Route::get('/', [\App\Http\Controllers\Front\HomeController::class, 'index'])->name('home.index');

//Shop
Route::get('/shop', [\App\Http\Controllers\Front\ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/search', [\App\Http\Controllers\Api\ProductController::class, 'productSearch'])->name('shop.searchProducts');
Route::get('/shop/{slug}', [\App\Http\Controllers\Front\ShopController::class, 'details'])->name('shop.product.details');
Route::get('/refresh-topbar', [\App\Http\Controllers\Front\ShopController::class, 'refreshShopBreadcrumbs'])->name('shop.refreshShopBreadcrumbs');


//wishlist
Route::post('/wishlist/add', [\App\Http\Controllers\Front\WishListController::class, 'addToWishList'])->name('wishlist.add');
Route::get('/wishlist', [\App\Http\Controllers\Front\WishListController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/item/remove/{rowId}', [\App\Http\Controllers\Front\WishListController::class, 'removeFromWishList'])->name('wishlist.removeFromWishList');
Route::delete('/wishlist/clear', [\App\Http\Controllers\Front\WishListController::class, 'emptyWishList'])->name('wishlist.emptyWishList');
Route::post('/wishlist/move-to-cart/{rowId}', [\App\Http\Controllers\Front\WishListController::class, 'moveToCart'])->name('wishlist.moveToCart');
Route::get('seller/{id}', [\App\Http\Controllers\Front\SellerController::class, 'index'])->name('seller.details');
Route::post('/seller/review/{sellerId}', [\App\Http\Controllers\Front\SellerController::class, 'store'])->name('storeSellerReview');


//Cart
Route::get('/cart', [\App\Http\Controllers\Front\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [\App\Http\Controllers\Front\CartController::class, 'addToCart'])->name('cart.add');
Route::put('/cart/increase-quantity/{rowId}', [\App\Http\Controllers\Front\CartController::class, 'increaseCartQuantity'])->name('cart.increaseCartQuantity');
Route::put('/cart/decrease-quantity/{rowId}', [\App\Http\Controllers\Front\CartController::class, 'decreaseCartQuantity'])->name('cart.decreaseCartQuantity');
Route::put('/cart/update-shipping/{rowId}', [\App\Http\Controllers\Front\CartController::class, 'updateShipping'])->name('cart.updateShipping');
Route::delete('/cart/remove/{rowId}', [\App\Http\Controllers\Front\CartController::class, 'removeFromCart'])->name('cart.removeFromCart');
Route::delete('/cart/clear', [\App\Http\Controllers\Front\CartController::class, 'emptyCart'])->name('cart.emptyCart');

Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [\App\Http\Controllers\Front\UserAccountController::class, 'index'])->name('user.index');
    Route::get('/orders', [\App\Http\Controllers\Front\UserAccountController::class, 'orders'])->name('orders.ordersCustomer');
    Route::get('/order-details/{orderId}', [\App\Http\Controllers\Front\UserAccountController::class, 'orderDetails'])->name('orders.orderDetailsCustomer');
    Route::put('/order/cancel/{orderId}', [\App\Http\Controllers\Front\UserAccountController::class, 'cancelOrder'])->name('orders.cancelOrder');
    Route::get('/order/approve/{orderId}', [\App\Http\Controllers\Front\UserAccountController::class, 'approveOrder'])->name('orders.approveOrder');
    Route::get('/order/report/{orderItemId}', [\App\Http\Controllers\Front\UserAccountController::class, 'reportOrder'])->name('orders.reportOrder');
    Route::get('/review/{orderItemId}', [\App\Http\Controllers\Front\ReviewController::class, 'create'])->name('createReview');
    Route::post('/review/{productId}/create', [\App\Http\Controllers\Front\ReviewController::class, 'store'])->name('storeReview');

    //account

    //aaddresses
    Route::get('/account-dashboard/address', [\App\Http\Controllers\Front\UserAccountController::class, 'address'])->name('user.address');
    Route::get('/account-dashboard/address/add', [\App\Http\Controllers\Front\UserAccountController::class, 'addAddress'])->name('user.addAddress');
    Route::post('/account-dashboard/address/store', [\App\Http\Controllers\Front\UserAccountController::class, 'storeAddress'])->name('user.storeAddress');
    Route::get('/account-dashboard/address/edit/{addressId}', [\App\Http\Controllers\Front\UserAccountController::class, 'editAddress'])->name('user.editAddress');
    Route::put('/account-dashboard/address/updateAddress/{addressId}', [\App\Http\Controllers\Front\UserAccountController::class, 'updateAddress'])->name('user.updateAddress');


    Route::get('/account-dashboard/reviews', [\App\Http\Controllers\Front\UserAccountController::class, 'reviews'])->name('user.reviews');
    Route::get('/account-dashboard/wishlist', [\App\Http\Controllers\Front\UserAccountController::class, 'wishlist'])->name('user.wishlist');
    Route::get('/account-dashboard/questions', [\App\Http\Controllers\Front\UserAccountController::class, 'askQuestion'])->name('user.askQuestion');
    Route::get('/account-dashboard/questions/details/{questionId}', [\App\Http\Controllers\Front\UserAccountController::class, 'askQuestionDetails'])->name('user.askQuestionDetails');
    Route::post('/account-dashboard/questions/create', [\App\Http\Controllers\Front\UserAccountController::class, 'createQuestion'])->name('user.createQuestion');
    Route::post('/account-dashboard/post-reply', [\App\Http\Controllers\Front\UserAccountController::class, 'postReply'])->name('user.postReply');
});

Route::middleware(['auth', AuthAdmin::class])->group(function () {

    Route::get('/admin/ask-a-question', [\App\Http\Controllers\Admin\AdminController::class, 'askQuestion'])->name('admin.askQuestion');
    Route::get('/admin/ask-a-question/details/{questionId}', [\App\Http\Controllers\Admin\AdminController::class, 'askQuestionDetails'])->name('admin.askQuestionDetails');
    Route::post('/admin/post-reply', [\App\Http\Controllers\Admin\AdminController::class, 'postReply'])->name('admin.postReply');

});

// coupons
Route::post('/cart/applyCoupon', [\App\Http\Controllers\Front\CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::delete('/cart/removeCoupon', [\App\Http\Controllers\Front\CartController::class, 'removeCoupon'])->name('cart.removeCoupon');

Route::post('/checkout', [\App\Http\Controllers\Front\CheckoutController::class, 'index'])->name('checkout.post');

//checkout
Route::get('/checkout', [\App\Http\Controllers\Front\CheckoutController::class, 'index'])->name('checkout.index');
Route::get('/checkout/card', [\App\Http\Controllers\Front\CheckoutController::class, 'index'])->name('checkout.card');
Route::post('/checkout/place-order', [\App\Http\Controllers\Front\CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::post('/checkout/place-card-order', [\App\Http\Controllers\Front\CheckoutController::class, 'placeCardOrder'])->name('checkout.placeCardOrder');
Route::get('/checkout/order-confirmation', [\App\Http\Controllers\Front\CheckoutController::class, 'orderConfirmation'])->name('checkout.orderConfirmation');

Route::get('/change-password', [\App\Http\Controllers\Front\HomeController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [\App\Http\Controllers\Front\HomeController::class, 'updatePassword'])->name('update-password');

Route::any('/angular/{any}', [AngularController::class, 'index']);


