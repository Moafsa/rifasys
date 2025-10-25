<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Marketplace\MarketplaceController;
use App\Http\Controllers\Marketplace\CartController;
use App\Http\Controllers\Marketplace\WishlistController;

/*
|--------------------------------------------------------------------------
| Marketplace Routes
|--------------------------------------------------------------------------
|
| These routes handle the marketplace subsystem functionality.
| The marketplace is a separate subsystem focused on e-commerce for raffles.
|
*/

// Marketplace main routes (public access)
Route::prefix('marketplace')->name('marketplace.')->group(function () {
    
    // Test route
    Route::get('/test', function () {
        return view('marketplace.test');
    })->name('test');
    
    // Simple marketplace route
    Route::get('/simple', function () {
        return view('marketplace.simple');
    })->name('simple');
    
    // Debug route
    Route::get('/debug', function () {
        return response()->json([
            'status' => 'ok',
            'message' => 'Marketplace is working',
            'timestamp' => now()
        ]);
    })->name('debug');
    
    // Main marketplace page
    Route::get('/', [MarketplaceController::class, 'index'])->name('index');
    
    // Categories
    Route::get('/categories', [MarketplaceController::class, 'categories'])->name('categories');
    Route::get('/category/{category}', [MarketplaceController::class, 'category'])->name('category');
    
    // Search
    Route::get('/search', [MarketplaceController::class, 'search'])->name('search');
    
    // Recommendations API
    Route::get('/recommendations', [MarketplaceController::class, 'recommendations'])->name('recommendations');
    
    // Wishlist routes (require authentication)
    Route::middleware(['auth'])->group(function () {
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
        Route::post('/wishlist/{raffle}', [WishlistController::class, 'store'])->name('wishlist.add');
        Route::delete('/wishlist/{raffle}', [WishlistController::class, 'destroy'])->name('wishlist.remove');
        Route::post('/wishlist/{raffle}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
        Route::get('/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');
        Route::get('/wishlist/check/{raffle}', [WishlistController::class, 'check'])->name('wishlist.check');
    });
    
    // Cart routes (require authentication)
    Route::middleware(['auth'])->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart/{raffle}', [CartController::class, 'store'])->name('cart.add');
        Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.remove');
        Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
        Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
        Route::get('/cart/summary', [CartController::class, 'summary'])->name('cart.summary');
    });
});

// Legacy routes for backward compatibility
Route::get('/raffles', [MarketplaceController::class, 'index'])->name('raffles.index');
Route::get('/raffles/{raffle}', [App\Http\Controllers\RaffleController::class, 'show'])->name('raffles.show');
