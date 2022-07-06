<?php

use Illuminate\Support\Facades\Route;
use Modules\Brand\Http\Controllers\BrandController;
use Modules\Brand\Http\Controllers\BrandPageController;


Route::get('/page/brands', [BrandPageController::class, 'index']);
Route::get('/page/brands/{brand}', [BrandPageController::class, 'show'])
    ->where('brand', '.*');;

Route::resource('brands', BrandController::class)->only('index', 'show');
