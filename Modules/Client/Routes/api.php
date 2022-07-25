<?php

use Modules\Client\Http\Controllers\ClientRegisterController;
use Modules\Client\Http\Controllers\PhoneVerificationController;
use Modules\Client\Http\Controllers\ClientController;
use Modules\Client\Http\Controllers\ClientPhoneUpdateController;
use Modules\Client\Http\Controllers\ClientEmailUpdateController;
use Modules\Client\Http\Controllers\ClientAvatarUpdateController;
use Modules\Client\Http\Controllers\ClientPayerController;
use Modules\Client\Http\Controllers\ClientAuthController;

Route::prefix('clients')->group(function() {
    Route::post('fast-register', [ClientRegisterController::class, 'fastRegister']);
    Route::post('register', [ClientRegisterController::class, 'register']);

    Route::post('send-code', [PhoneVerificationController::class, 'sendCode']);
    Route::post('verify', [PhoneVerificationController::class, 'verifyCode']);

    Route::middleware('auth:client')->group(function () {
        // обновление данных клиента
        Route::match(['put', 'patch'], 'update', [ClientController::class, 'update']);
        Route::get('show', [ClientController::class, 'show']);
    });

    // изменение телефона
    Route::prefix('phone')->group(function() {
        Route::post('validate-phone', [ClientPhoneUpdateController::class, 'validatePhone']);
        Route::post('send-code', [ClientPhoneUpdateController::class, 'sendCode']);
        Route::post('verify-code', [ClientPhoneUpdateController::class, 'verifyCode']);
    });

    // изменение почты
    Route::prefix('email')->group(function() {
        Route::post('send-code', [ClientEmailUpdateController::class, 'send'])
            ->middleware('throttle:5,1')
            ->name('client.code.send');
        Route::post('verify-code', [ClientEmailUpdateController::class, 'verify'])
            ->name('client.code.verify');
    });

    Route::post('upload-image', [ClientAvatarUpdateController::class, 'update'])
        ->name('client.image.update');
    Route::delete('delete-image', [ClientAvatarUpdateController::class, 'destroy'])
        ->name('client.image.delete');

    Route::post('activity', [ClientController::class, 'activity'])->name('clients.activity.store');

    Route::apiResource('payers', ClientPayerController::class);

    Route::post('logout', [ClientAuthController::class, 'logout']);
});
