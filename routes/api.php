<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
//    Route::group(['middleware' => ])
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
