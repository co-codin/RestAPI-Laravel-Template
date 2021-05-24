<?php

use Modules\Client\Http\Middleware\ClientAuthWithPhone;
use Modules\Form\Http\Controllers\FormController;

Route::prefix('form')->group(function() {
    Route::post('/{formName}/send', [FormController::class, 'send'])
//        ->middleware(ClientAuthWithPhone::class)
        ->where('formName', '[a-z0-9_-]+')
        ->name('form-send');
});
