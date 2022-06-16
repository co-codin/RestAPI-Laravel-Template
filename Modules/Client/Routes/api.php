<?php

use Modules\Client\Http\Controllers\ClientRegisterController;
use Modules\Client\Http\Controllers\PhoneVerificationController;

Route::prefix('clients')->group(function() {
    Route::post('fast-register', [ClientRegisterController::class, 'fastRegister']);
    Route::post('register', [ClientRegisterController::class, 'register']);

    Route::post('send-code', [PhoneVerificationController::class, 'sendCode']);
    Route::post('verify', [PhoneVerificationController::class, 'verifyCode']);
});
