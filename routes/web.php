<?php

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'loginPage'])->name('web.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
