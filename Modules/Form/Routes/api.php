<?php

use App\Http\Middleware\ClientAuth;
use Modules\Form\Http\Controllers\FormController;

Route::prefix('form')->group(function() {
    Route::post('/{formName}/send', [FormController::class, 'send'])
        ->middleware(ClientAuth::class)
        ->where('formName', '[a-z0-9_-]+')
        ->name('form-send');
});
