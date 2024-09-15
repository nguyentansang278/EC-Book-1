<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){return view ('home');})->name('home');
Route::get('/books', function(){return view ('books/index');})->name('books');
Route::get('/contact', function(){return view ('contact');})->name('contact');


Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function(){
        Route::controller(ProfileController::class)->group(function(){
            Route::get('/','edit')->name('profile.edit');
            Route::patch('/','update')->name('profile.update');
            Route::delete('/','destroy')->name('profile.destroy');
        });
    });
});

Route::prefix('books')->group(function(){
    Route::controller(BookController::class)->group(function(){
        Route::get('/','index')->name('books');
        Route::get('/{id}','show')->name('book-description');
    });
});

require __DIR__.'/auth.php';
