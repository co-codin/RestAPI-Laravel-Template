<?php

use Modules\Client\Http\Controllers\ClientRegisterController;

Route::prefix('clients')->group(function() {
    Route::post('fast-register', [ClientRegisterController::class, 'fastRegister']);
    Route::post('register', [ClientRegisterController::class, 'register']);
});
