<?php

use App\Http\Controllers\Web\AuthController;

Route::get('/login', [AuthController::class, 'loginPage'])->name('web.login');
Route::post('/login', [AuthController::class, 'login']);
