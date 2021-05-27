<?php

use App\Http\Middleware\ClientAuth;
use Modules\Form\Http\Controllers\FormController;

Route::prefix('form')->group(function () {
    Route::post('/{formName}/send', function (string $formName) {
        $controller = App::make(Modules\Form\Http\Controllers\FormController::class);
        $container = \Illuminate\Container\Container::getInstance();

        if (method_exists(FormController::class, Str::camel($formName))) {
            return $container->call([$controller, Str::camel($formName)]);
        }

        return $container->call([$controller, 'send']);
    })
        ->middleware(ClientAuth::class)
        ->where('formName', '[a-z0-9_-]+')
        ->name('form-send');
});
