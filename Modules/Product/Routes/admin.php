<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Admin\ProductController;
use Modules\Product\Http\Controllers\Admin\ProductPropertyController;
use Modules\Product\Http\Controllers\Admin\ProductSeoController;
use Modules\Product\Http\Controllers\Admin\ProductConfiguratorController;

Route::patch('products/{product}/seo', [ProductSeoController::class, 'update']);
Route::put('products/{product}/properties', [ProductPropertyController::class, 'update'])->name('product.property.update');
Route::put('products/{product}/configurator', [ProductConfiguratorController::class, 'update'])->name('product.configurator.update');
Route::resource('products', ProductController::class)->except(['index', 'show']);
