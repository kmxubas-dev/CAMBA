<?php

use App\Http\Controllers\Web\AppController;
use App\Http\Controllers\Web\ProductAuctionController;
use App\Http\Controllers\Web\ProductBidController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ProductPurchaseController;
use App\Http\Controllers\Web\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppController::class, 'welcome'])->middleware('guest');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('dashboard', [AppController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [AppController::class, 'profile'])->name('profile');
    Route::get('profile-show/{user}', [AppController::class, 'showProfile'])
        ->name('custom.profile.show');
    Route::put('profile-update', [AppController::class, 'updateProfile'])
        ->name('custom.profile.update');

    Route::resource('products', ProductController::class);
    Route::resource('auctions', ProductAuctionController::class);
    Route::resource('bids', ProductBidController::class);
    Route::resource('purchases', ProductPurchaseController::class);
    Route::resource('sales', SaleController::class);

    Route::get('products-buyer', [ProductController::class, 'index_buyer'])
        ->name('products.index.buyer');
    Route::get('auctions-buyer', [ProductAuctionController::class, 'index_buyer'])
        ->name('auctions.index.buyer');

    Route::post('auctions/{auction}/bid', [ProductBidController::class, 'storeOrUpdate'])
        ->name('auctions.bid');

    Route::prefix('purchases')->name('purchases.')->group(function () {
        Route::get('{purchase}/edit-payment', [ProductPurchaseController::class, 'paymentEdit'])
            ->name('edit.payment');
        Route::put('{purchase}/edit-payment', [ProductPurchaseController::class, 'paymentUpdate'])
            ->name('update.payment');
    });

    Route::prefix('purchases/paymongo')->name('purchases.paymongo.')->group(function () {
        Route::get('/success', [ProductPurchaseController::class, 'paymongoSuccess'])
            ->name('success');
        Route::get('/failed', [ProductPurchaseController::class, 'paymongoFailed'])
            ->name('failed');
    });
    
    Route::get('search', [AppController::class, 'search'])->name('search');

    Route::prefix('export')->name('export.')->group(function () {
        Route::get('purchases-monthly', [AppController::class, 'exportPurchasesMonthly'])
            ->name('purchases.monthly');
    });
});
