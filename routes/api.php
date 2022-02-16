<?php

use App\Http\Controllers\FieldValueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentGroupController;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/user', [AuthController::class, 'user'])->name('user');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});

Route::resource('field-values', FieldValueController::class)
    ->only(['index', 'show']);


Route::resource('document-groups', DocumentGroupController::class)
    ->only(['index']);

