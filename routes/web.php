<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Test route to verify server is working
Route::get('/test', function () {
    return 'Server is working!';
});

// Ultra simple test
Route::get('/ping', function () {
    return 'pong';
});

// Public routes (no authentication required)
Route::get('/welcome', [HomeController::class, 'index'])->name('welcome'); // Unverified home
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// Include marketplace routes
require __DIR__.'/marketplace.php';

// Include WuzAPI Manager routes
require __DIR__.'/wuzapi-manager.php';

// Temporary route to clear sessions
Route::get('/clear-session', function () {
    session()->flush();
    return redirect('/')->with('success', 'Sessão limpa com sucesso!');
})->name('clear.session');

// Force clear everything
Route::get('/force-clear', function () {
    session()->flush();
    cache()->flush();
    return redirect('/simple-login')->with('success', 'Sistema limpo!');
})->name('force.clear');

// Test route for login
Route::get('/test-login', function () {
    return view('auth.login');
})->name('test.login');

// Bypass CSRF completely
Route::get('/bypass-login', function () {
    return redirect('/simple-login');
})->name('bypass.login');

// Simple login route without CSRF
Route::get('/simple-login', function () {
    return '<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Rifassys</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Login</h1>
            <p class="text-gray-600 mt-2">Acesse sua conta</p>
        </div>
        
        <form method="POST" action="/simple-login-post" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" id="password" name="password" required 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" 
                           class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">Lembrar-me</label>
                </div>
                
                <div class="text-sm">
                    <a href="#" class="font-medium text-purple-600 hover:text-purple-500">Esqueceu a senha?</a>
                </div>
            </div>
            
            <button type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Entrar
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Não tem uma conta? 
                <a href="/register" class="font-medium text-purple-600 hover:text-purple-500">Registre-se</a>
            </p>
        </div>
    </div>
</body>
</html>';
})->name('simple.login');

// Simple login POST route without CSRF
Route::post('/simple-login-post', function (Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->route('home')->with('success', 'Login realizado com sucesso!');
    }
    
    return back()->withErrors([
        'email' => 'Credenciais inválidas.',
    ])->withInput();
})->name('simple.login.post');

// Public raffle viewing routes (legacy - redirect to marketplace)
Route::get('/raffles', function () {
    return redirect()->route('marketplace.index');
})->name('raffles.index');
Route::get('/raffles/{raffle}', [App\Http\Controllers\RaffleController::class, 'show'])->name('raffles.show');

// Home page route (temporarily without verification for debugging)
Route::get('/', [HomeController::class, 'index'])->name('home');

// ALL ROUTES REQUIRE VERIFICATION
Route::middleware(['auth', 'verified'])->group(function () {
    
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
    $status = $wuzapiService->getStatus();
    return response()->json([
        'connected' => $wuzapiService->isConnected(),
        'status' => $status,
        'timestamp' => now()
    ]);
});

Route::get('/api/wuzapi/qr', function () {
    $wuzapiService = app(App\Services\WuzapiService::class);
    $qrCode = $wuzapiService->getQRCode();
    return response()->json([
        'qr' => $qrCode,
        'status' => $qrCode ? 'available' : 'not_available',
        'connected' => $wuzapiService->isConnected()
    ]);
});

// WhatsApp webhook routes (WuzAPI integration)
Route::post('/api/webhooks/whatsapp', [App\Http\Controllers\Api\WebhookController::class, 'handleWhatsApp']);
Route::get('/api/webhooks/whatsapp/status', function () {
    return response()->json(['status' => 'active', 'timestamp' => now()]);
});

// WuzAPI management routes (admin only)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/wuzapi', [App\Http\Controllers\Admin\WuzapiController::class, 'dashboard'])->name('admin.wuzapi.dashboard');
    Route::get('/admin/wuzapi/test-connection', [App\Http\Controllers\Admin\WuzapiController::class, 'testConnection'])->name('admin.wuzapi.test-connection');
    Route::post('/admin/wuzapi/test-message', [App\Http\Controllers\Admin\WuzapiController::class, 'sendTestMessage'])->name('admin.wuzapi.test-message');
    Route::post('/admin/wuzapi/test-raffle-message', [App\Http\Controllers\Admin\WuzapiController::class, 'sendTestRaffleMessage'])->name('admin.wuzapi.test-raffle-message');
    Route::get('/admin/wuzapi/qr-code', [App\Http\Controllers\Admin\WuzapiController::class, 'getQRCode'])->name('admin.wuzapi.qr-code');
    Route::get('/admin/wuzapi/webhook-status', [App\Http\Controllers\Admin\WuzapiController::class, 'getWebhookStatus'])->name('admin.wuzapi.webhook-status');
});

// System Health Monitoring routes (admin only)
Route::middleware(['auth'])->prefix('admin/health')->group(function () {
    Route::get('/', [App\Http\Controllers\SystemHealthController::class, 'dashboard'])->name('admin.health.dashboard');
    Route::get('/status', [App\Http\Controllers\SystemHealthController::class, 'status'])->name('admin.health.status');
    Route::get('/metrics', [App\Http\Controllers\SystemHealthController::class, 'metrics'])->name('admin.health.metrics');
    Route::get('/service', [App\Http\Controllers\SystemHealthController::class, 'serviceHealth'])->name('admin.health.service');
    Route::post('/cleanup', [App\Http\Controllers\SystemHealthController::class, 'cleanup'])->name('admin.health.cleanup');
    Route::get('/test-database', [App\Http\Controllers\SystemHealthController::class, 'testDatabase'])->name('admin.health.test-database');
    Route::get('/test-cache', [App\Http\Controllers\SystemHealthController::class, 'testCache'])->name('admin.health.test-cache');
    Route::get('/test-external', [App\Http\Controllers\SystemHealthController::class, 'testExternalServices'])->name('admin.health.test-external');
});

// Auth routes (temporarily without CSRF for debugging)
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->withoutMiddleware(['web']);
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->withoutMiddleware(['web']);
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