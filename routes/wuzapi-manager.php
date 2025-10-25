<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WuzapiManagerController;

/*
|--------------------------------------------------------------------------
| WuzAPI Manager Routes
|--------------------------------------------------------------------------
|
| Routes for the WuzAPI Manager system
| Similar to wuzapidiv.conext.click
|
*/

// Main dashboard
Route::get('/wuzapi-manager', [WuzapiManagerController::class, 'dashboard'])
    ->name('wuzapi-manager.dashboard')
    ->middleware('auth');

// Instructions page
Route::get('/wuzapi-manager/instructions', function () {
    return view('wuzapi-manager.instructions');
})->name('wuzapi-manager.instructions');

// Instances management
Route::prefix('wuzapi-manager/instances')->middleware('auth')->group(function () {
    Route::get('/', [WuzapiManagerController::class, 'instances'])
        ->name('wuzapi-manager.instances');
    Route::get('/create', [WuzapiManagerController::class, 'createInstance'])
        ->name('wuzapi-manager.instances.create');
    Route::post('/', [WuzapiManagerController::class, 'storeInstance'])
        ->name('wuzapi-manager.instances.store');
    Route::get('/{instance}', [WuzapiManagerController::class, 'showInstance'])
        ->name('wuzapi-manager.instances.show');
    Route::delete('/{instance}', [WuzapiManagerController::class, 'deleteInstance'])
        ->name('wuzapi-manager.instances.delete');
    
    // Instance actions
    Route::get('/{instance}/test-connection', [WuzapiManagerController::class, 'testConnection'])
        ->name('wuzapi-manager.instances.test-connection');
    Route::post('/{instance}/test-message', [WuzapiManagerController::class, 'sendTestMessage'])
        ->name('wuzapi-manager.instances.test-message');
    Route::put('/{instance}/settings', [WuzapiManagerController::class, 'updateSettings'])
        ->name('wuzapi-manager.instances.update-settings');
    
    // Logs and analytics
    Route::get('/{instance}/webhook-logs', [WuzapiManagerController::class, 'webhookLogs'])
        ->name('wuzapi-manager.instances.webhook-logs');
    Route::get('/{instance}/message-logs', [WuzapiManagerController::class, 'messageLogs'])
        ->name('wuzapi-manager.instances.message-logs');
    Route::get('/{instance}/analytics', [WuzapiManagerController::class, 'analytics'])
        ->name('wuzapi-manager.instances.analytics');
});
