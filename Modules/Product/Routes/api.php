<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\ProductFilterController;

Route::get('products/{category_slug}/filters/{filters?}', [ProductFilterController::class, 'index'])
    ->name('products.filter')
    ->where('filters', '(.*)')
    ;

Route::resource('products', ProductController::class)->only(['index', 'show']);
