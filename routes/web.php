<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;
use App\Http\Controllers\Admin\FeaturedItemsController as AdminFeaturedItemsController;
use App\Http\Controllers\Admin\RevenueController as AdminRevenueController;

use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\ProfileController;
use App\Http\Controllers\Guest\BookController;
use App\Http\Controllers\Guest\CartController;
use App\Http\Controllers\Guest\WishlistController;
use App\Http\Controllers\Guest\OrderController;
use App\Http\Controllers\Guest\CheckoutController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\StripeWebhookController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', function(){return view ('guest.contact');})->name('contact');
Route::get('/search-books', [BookController::class, 'search']);
Route::get('/categories', function (){ return view ('guest.categories');})->name('categories');

Route::prefix('books')->group(function(){
    Route::controller(BookController::class)->group(function(){
        Route::get('/','index')->name('books');
        Route::get('/{id}','show')->name('book.show');
    });
});
Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function(){
        Route::controller(ProfileController::class)->group(function(){
            Route::get('/','edit')->name('profile.edit');
            Route::patch('/','update')->name('profile.update');
            Route::patch('/addresses/update/', 'updateAddresses')->name('addresses.update');
            Route::delete('/','destroy')->name('profile.destroy');
        });
    });
});

Route::middleware(['auth','verified'])->group(function () {
    Route::prefix('books')->group(function(){
        Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/add-to-wishlist', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
        Route::post('/remove-from-wishlist', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');

    });

    Route::prefix('wishlist')->group(function(){
        Route::get('/', [WishlistController::class, 'index'])->name('wishlist.index');
    });

    Route::prefix('cart')->group(function(){
        Route::controller(CartController::class)->group(function(){
            Route::get('/', 'index')->name('cart.index');
            Route::delete('/delete/{id}', 'destroy')->name('cart.destroy');
            Route::post('/update-quantity', 'updateQuantity')->name('cart.updateQuantity');
        });
    });

    Route::prefix('checkout')->group(function(){
        Route::controller(CheckoutController::class)->group(function(){
            Route::get('/', 'index')->name('checkout.index');
            Route::post('/', 'processCheckout')->name('processCheckout');
            Route::get('/success', function(){return view ('guest.checkout.order_success');})->name('order.success');
        });
    });

    Route::prefix('orders')->group(function(){
        Route::controller(OrderController::class)->group(function(){
            Route::get('/', 'index')->name('client.orders');
            Route::get('/{id}', 'show')->name('client.orders.show');
            Route::put('/{id}', 'cancel')->name('client.order.cancel');
        });
    });
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'can:access-admin']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::prefix('users')->group(function () {
        Route::controller(UserController::class)->group(function() {
            Route::get('/', 'index')->name('users');
            Route::get('/create', 'create')->name('user.create');
            Route::post('/store', 'store')->name('user.store');
            Route::get('/show/{id}', 'show')->name('user.show');
            Route::put('/edit/{id}', 'edit')->name('user.edit');
            Route::delete('/delete/{id}', 'delete')->name('user.delete');
        });
    });
    Route::prefix('books')->group(function () {
        Route::controller(AdminBookController::class)->group(function() {
            Route::get('/', 'index')->name('admin.books.index');
            Route::get('/create', 'create')->name('books.create');
            Route::get('/{book}/edit', 'edit')->name('books.edit');
            Route::put('/{book}', 'update')->name('books.update');
            Route::delete('/{book}', 'destroy')->name('books.destroy');
            Route::post('/', 'store')->name('books.store');
            Route::patch('/{book}/toggle-status', 'toggleStatus')->name('books.toggleStatus');
        });
    });
    Route::prefix('orders')->group(function () {
        Route::controller(AdminOrderController::class)->group(function() {
            Route::get('/', 'index')->name('admin.orders.index');
            Route::get('/{id}', 'show')->name('admin.orders.show');
            Route::delete('/{id}', 'destroy')->name('admin.orders.destroy');
            Route::put('/{id}', 'update')->name('admin.orders.update');

        });
    });
    Route::prefix('authors')->group(function () {
        Route::controller(AdminAuthorController::class)->group(function() {
            Route::get('/', 'index')->name('admin.authors.index');
            Route::get('/{id}', 'show')->name('admin.authors.show');
            Route::delete('/{id}', 'destroy')->name('admin.authors.destroy');
            Route::put('/{id}', 'update')->name('admin.authors.update');
        });
    });

    Route::prefix('featured_items')->group(function () {
        Route::controller(AdminFeaturedItemsController::class)->group(function() {
            Route::get('/', 'index')->name('admin.featured_items.index');
            Route::get('/create', 'create')->name('admin.featured_items.create');
            Route::post('/store', 'store')->name('admin.featured_items.store');
            Route::get('/{id}', 'show')->name('admin.featured_items.show');
            Route::delete('/{id}', 'destroy')->name('admin.featured_items.destroy');
            Route::put('/{id}', 'update')->name('admin.featured_items.update');
        });
    });

    Route::prefix('revenue')->group(function (){
        Route::controller(AdminRevenueController::class)->group(function(){
            Route::get('/', 'index')->name('admin.revenue');
        });
    });
});

require __DIR__.'/auth.php';
