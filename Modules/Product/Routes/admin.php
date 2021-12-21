<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Admin\ProductAnswerController;
use Modules\Product\Http\Controllers\Admin\ProductConfiguratorController;
use Modules\Product\Http\Controllers\Admin\ProductController;
use Modules\Product\Http\Controllers\Admin\ProductImageController;
use Modules\Product\Http\Controllers\Admin\ProductPropertyController;
use Modules\Product\Http\Controllers\Admin\ProductQuestionController;
use Modules\Product\Http\Controllers\Admin\ProductSeoController;

Route::patch('products/{product}/seo', [ProductSeoController::class, 'update']);
Route::put('products/{product}/properties', [ProductPropertyController::class, 'update'])->name('product.property.update');
Route::put('products/{product}/configurator', [ProductConfiguratorController::class, 'update'])->name('product.configurator.update');
Route::put('products/{product}/images', [ProductImageController::class, 'update'])->name('product.images.update');

Route::resource('products', ProductController::class)->except(['index', 'show']);


Route::apiResource('product-answers', ProductAnswerController::class)->except(['index', 'show']);

Route::apiResource('product-questions', ProductQuestionController::class)->except(['index', 'show']);

Route::put('product-questions/{product_question}/approve', [ProductQuestionController::class, 'approve'])->name('product-questions.approve');
Route::put('product-questions/{product_question}/reject', [ProductQuestionController::class, 'reject'])->name('product-questions.reject');



