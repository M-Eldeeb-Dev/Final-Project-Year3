<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');

    Route::get('/{product:slug}', [ProductController::class, 'show'])
        ->name('show')
        ->middleware('track.view');
});

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',        [CartController::class, 'index'])  ->name('index');
    Route::post('/add',    [CartController::class, 'add'])    ->name('add');
    Route::post('/update', [CartController::class, 'update']) ->name('update');
    Route::post('/remove', [CartController::class, 'remove']) ->name('remove');
    Route::get('/count',   [CartController::class, 'count'])  ->name('count');
});

/*
|--------------------------------------------------------------------------
| Wishlist
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\WishlistController;
Route::prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/toggle', [WishlistController::class, 'toggle'])->name('toggle');
});

/*
|--------------------------------------------------------------------------
| Checkout & Orders
|--------------------------------------------------------------------------
*/
Route::get('/checkout', [OrderController::class, 'checkout'])
    ->name('checkout')
    ->middleware('cart.not.empty');

Route::post('/checkout/place', [OrderController::class, 'store'])
    ->name('order.store');

Route::get('/order/success/{order}', [OrderController::class, 'success'])
    ->name('order.success');

// Order Tracking (public)
Route::get('/orders/track',  [OrderController::class, 'trackForm'])->name('orders.track');
Route::post('/orders/track', [OrderController::class, 'track'])->name('orders.track.search');

/*
|--------------------------------------------------------------------------
| Static Pages
|--------------------------------------------------------------------------
*/
Route::get('/about', fn () => view('about'))->name('about');

Route::get('/contact',  [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Admin Panel
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\{
    AdminAuthController,
    AdminDashboardController,
    AdminProductController,
    AdminCategoryController,
    AdminOrderController,
    AdminMessageController,
    AdminUserController,
};

// Admin Auth (no middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout',[AdminAuthController::class, 'logout'])->name('logout');
});

// Admin Panel (protected)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', AdminProductController::class);
    Route::patch('products/{product}/toggle',
        [AdminProductController::class, 'toggle'])->name('products.toggle');
    Route::patch('products/{product}/featured',
        [AdminProductController::class, 'toggleFeatured'])->name('products.featured');

    // Categories
    Route::resource('categories', AdminCategoryController::class);
    Route::patch('categories/{category}/toggle',
        [AdminCategoryController::class, 'toggle'])->name('categories.toggle');

    // Orders
    Route::get('orders',                [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}',        [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status',[AdminOrderController::class, 'updateStatus'])->name('orders.status');

    // Contact Messages
    Route::get('messages',              [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}',    [AdminMessageController::class, 'show'])->name('messages.show');
    Route::patch('messages/{message}/read',  [AdminMessageController::class, 'markRead'])->name('messages.read');
    Route::delete('messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

    // Users
    Route::get('users',                 [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/{user}',          [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('users/{user}/role',   [AdminUserController::class, 'updateRole'])->name('users.role');
});
