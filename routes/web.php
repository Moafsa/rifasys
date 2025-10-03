<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// Public raffle routes
Route::get('/raffles', [App\Http\Controllers\RaffleController::class, 'index'])->name('raffles.index');
Route::get('/raffles/{raffle}', [App\Http\Controllers\RaffleController::class, 'show'])->name('raffles.show');

// Protected raffle purchase routes
Route::post('/raffles/{raffle}/add-to-cart', [App\Http\Controllers\RaffleController::class, 'addToCart'])->name('raffles.add-to-cart');
Route::post('/raffles/{raffle}/purchase', [App\Http\Controllers\RaffleController::class, 'purchase'])->name('raffles.purchase');

// Cart routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
Route::put('/cart/{cart}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('/cart', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');

// Payment routes
Route::middleware('auth')->group(function () {
    Route::get('/payment/methods', [App\Http\Controllers\PaymentController::class, 'methods'])->name('payment.methods');
    Route::post('/payment/process', [App\Http\Controllers\PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
});

// User raffles management (protected)
Route::middleware('auth')->group(function () {
    Route::get('/my-raffles', [App\Http\Controllers\UserRaffleController::class, 'index'])->name('user.raffles');
});

// API routes for states and cities
Route::get('/api/states/{stateName}/cities', function ($stateName) {
    $state = App\Models\BrazilState::where('name', $stateName)->first();
    if (!$state) {
        return response()->json(['cities' => []], 404);
    }
    
    $cities = $state->cities()->orderBy('name')->get();
    return response()->json(['cities' => $cities]);
});

// Auth routes
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Email verification routes
Route::get('/email/verify', [App\Http\Controllers\Auth\EmailVerificationController::class, 'notice'])->name('verification.notice');
Route::post('/email/verify', [App\Http\Controllers\Auth\EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/verification-notification', [App\Http\Controllers\Auth\EmailVerificationController::class, 'resend'])->name('verification.resend');
Route::get('/email/verify/confirm', [App\Http\Controllers\Auth\EmailVerificationController::class, 'showConfirm'])->name('verification.confirm.show');
Route::post('/email/verify/confirm', [App\Http\Controllers\Auth\EmailVerificationController::class, 'confirm'])->name('verification.confirm');

// Password reset routes
Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/check-email', function() { return view('auth.check-email'); })->name('password.check-email');
Route::get('/password/reset-form', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/verify-code', [App\Http\Controllers\Auth\ResetPasswordController::class, 'verifyCode'])->name('password.verify-code');
Route::get('/password/reset/confirm', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showConfirm'])->name('password.confirm.show');
Route::post('/password/reset/confirm', [App\Http\Controllers\Auth\ResetPasswordController::class, 'confirmReset'])->name('password.confirm-reset');
Route::get('/password/reset-step2', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetStep2'])->name('password.reset-step2');
Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Test route for email
Route::get('/test-email', [App\Http\Controllers\TestEmailController::class, 'testEmail'])->name('test.email');

// Dashboard routes (protected - temporarily disabled)
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
//     
//     // Organizer routes
//     Route::middleware(['role:organizer'])->group(function () {
//         Route::resource('organizer/raffles', App\Http\Controllers\Organizer\RaffleController::class);
//         Route::resource('organizer/tickets', App\Http\Controllers\Organizer\TicketController::class);
//     });
//     
//     // Admin routes
//     Route::middleware(['role:admin'])->group(function () {
//         Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class);
//         Route::resource('admin/raffles', App\Http\Controllers\Admin\RaffleController::class);
//         Route::resource('admin/categories', App\Http\Controllers\Admin\CategoryController::class);
//     });
// });