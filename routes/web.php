<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Public routes (no authentication required)
Route::get('/welcome', [HomeController::class, 'index'])->name('welcome'); // Unverified home
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// Public raffle viewing routes
Route::get('/raffles', [App\Http\Controllers\RaffleController::class, 'index'])->name('raffles.index');
Route::get('/raffles/{raffle}', [App\Http\Controllers\RaffleController::class, 'show'])->name('raffles.show');

// ALL ROUTES REQUIRE VERIFICATION
Route::middleware(['auth', 'verified'])->group(function () {
    // Home page (requires verification)
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    // Payment routes (require verification)
    Route::get('/payment/methods', [App\Http\Controllers\PaymentController::class, 'methods'])->name('payment.methods');
    Route::post('/payment/process', [App\Http\Controllers\PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    
    // User raffles management (require verification)
    Route::get('/my-raffles', [App\Http\Controllers\UserRaffleController::class, 'index'])->name('user.raffles');
    
    // Raffle operations (require verification)
    Route::post('/raffles/{raffle}/add-to-cart', [App\Http\Controllers\RaffleController::class, 'addToCart'])->name('raffles.add-to-cart');
    Route::post('/raffles/{raffle}/purchase', [App\Http\Controllers\RaffleController::class, 'purchase'])->name('raffles.purchase');
    
    // Cart operations (require verification)
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cart}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');
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

// API routes for WuzAPI
Route::get('/api/wuzapi/status', function () {
    $wuzapiService = app(App\Services\WuzapiService::class);
    return response()->json($wuzapiService->checkConnection());
});

Route::get('/api/wuzapi/qr', function () {
    $wuzapiService = app(App\Services\WuzapiService::class);
    $qrCode = $wuzapiService->getQRCode();
    return response()->json([
        'qr' => $qrCode,
        'status' => $qrCode ? 'available' : 'not_available'
    ]);
});

// WhatsApp webhook routes
Route::post('/api/webhooks/whatsapp', [App\Http\Controllers\Api\WebhookController::class, 'handleWhatsApp']);
Route::get('/api/webhooks/whatsapp/status', [App\Http\Controllers\Api\WebhookController::class, 'getWebhookStatus']);

// WuzAPI management routes (admin only)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/wuzapi/status', function () {
        return view('admin.wuzapi-status');
    })->name('admin.wuzapi.status');
});

// Auth routes
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Verification routes (Email + WhatsApp)
Route::get('/email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'notice'])->name('verification.notice');
Route::post('/email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'verifyWhatsApp'])->name('verification.verify');
Route::post('/email/verification-notification', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');
Route::get('/email/verify/confirm', [App\Http\Controllers\Auth\VerificationController::class, 'showConfirm'])->name('verification.confirm.show');
Route::post('/email/verify/confirm', [App\Http\Controllers\Auth\VerificationController::class, 'confirm'])->name('verification.confirm');

// Verification method selection
Route::get('/verification/method', [App\Http\Controllers\Auth\VerificationController::class, 'showMethodSelection'])->name('verification.method');
Route::post('/verification/method', [App\Http\Controllers\Auth\VerificationController::class, 'setMethod'])->name('verification.set-method');

// WhatsApp verification
Route::get('/whatsapp/verify', [App\Http\Controllers\Auth\VerificationController::class, 'sendWhatsAppVerification'])->name('whatsapp.verify');
Route::post('/whatsapp/verify', [App\Http\Controllers\Auth\VerificationController::class, 'verifyWhatsApp'])->name('whatsapp.verify-code');

// Password reset routes
Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Temporary route to clear login cache
Route::get('/clear-login', [App\Http\Controllers\TempController::class, 'clearLogin'])->name('clear.login');
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

// WhatsApp integration test page
Route::get('/whatsapp-test', function () {
    return view('whatsapp-test');
})->name('whatsapp.test');

// WhatsApp examples page
Route::get('/whatsapp-examples', function () {
    return view('whatsapp-examples');
})->name('whatsapp.examples');

// WhatsApp configuration page
Route::get('/whatsapp-config', function () {
    return view('whatsapp-config');
})->name('whatsapp.config');

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