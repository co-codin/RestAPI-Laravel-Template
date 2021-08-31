<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\ProductFilterController;

Route::post('/products/filter', [ProductFilterController::class, 'index'])
    ->name('products.filter');

Route::resource('products', ProductController::class)->only(['index', 'show']);
