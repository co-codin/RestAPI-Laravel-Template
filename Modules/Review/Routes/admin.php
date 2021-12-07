<?php

use Illuminate\Support\Facades\Route;
use Modules\Review\Http\Controllers\Admin\ProductReviewController;

Route::apiResource('product-reviews', ProductReviewController::class)->except(['index', 'show', 'store']);

Route::put('product-reviews/{product_review}/approve', [ProductReviewController::class, 'approve']);
Route::put('product-reviews/{product_review}/reject', [ProductReviewController::class, 'reject']);
