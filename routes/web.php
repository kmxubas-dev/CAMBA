<?php

use App\Http\Controllers\Web\AppController;
use App\Http\Controllers\Web\ProductAuctionController;
use App\Http\Controllers\Web\ProductBidController;
use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppController::class, 'welcome'])->middleware('guest');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('dashboard', [AppController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [AppController::class, 'profile'])->name('profile');

    Route::resource('products', ProductController::class);
    Route::resource('auctions', ProductAuctionController::class);
    Route::resource('bids', ProductBidController::class);
});
