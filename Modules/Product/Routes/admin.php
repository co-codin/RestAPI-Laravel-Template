<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Admin\ProductController;
use Modules\Product\Http\Controllers\Admin\ProductPropertyController;

Route::put('products/{product}/properties', [ProductPropertyController::class, 'update'])->name('product.property.update');
Route::resource('products', ProductController::class)->except(['index', 'show']);
