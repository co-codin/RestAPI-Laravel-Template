<?php

use Modules\Client\Http\Controllers\ClientRegisterController;
use Modules\Client\Http\Controllers\PhoneVerificationController;
use Modules\Client\Http\Controllers\ClientController;
use Modules\Client\Http\Controllers\ClientPhoneUpdateController;

Route::prefix('clients')->group(function() {
    Route::post('fast-register', [ClientRegisterController::class, 'fastRegister']);
    Route::post('register', [ClientRegisterController::class, 'register']);

    Route::post('send-code', [PhoneVerificationController::class, 'sendCode']);
    Route::post('verify', [PhoneVerificationController::class, 'verifyCode']);

    Route::middleware('auth:client-api')->group(function () {
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
});
