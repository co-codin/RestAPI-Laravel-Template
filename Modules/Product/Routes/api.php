<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\ProductFilterController;

Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::get('products/{product_slug}/{category_slug}/filters/{filters?}', [ProductFilterController::class, ['index']])->name('products.filter');
