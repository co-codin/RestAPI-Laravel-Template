<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
