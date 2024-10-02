<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;


// Auth::routes(['verify' => true]);

Route::get('/', function(){return view ('home');})->name('home');
Route::get('/contact', function(){return view ('contact');})->name('contact');

Route::prefix('books')->group(function(){
    Route::controller(BookController::class)->group(function(){
        Route::get('/','index')->name('books');
        Route::get('/{id}','show')->name('book.show');
        Route::get('/search-books', 'search');
    });
});
Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function(){
        Route::controller(ProfileController::class)->group(function(){
            Route::get('/','edit')->name('profile.edit');
            Route::patch('/','update')->name('profile.update');
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
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::delete('/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::post('/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    });

});

require __DIR__.'/auth.php';