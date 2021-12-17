<?php

use Modules\Review\Http\Controllers\ProductReviewController;
use Modules\Review\Http\Controllers\ProductReviewRateController;
use Modules\Review\Http\Middleware\ProductReviewRateMiddleware;

Route::apiResource('product-reviews', ProductReviewController::class)
    ->only('index', 'show', 'store');

Route::middleware(ProductReviewRateMiddleware::class)->group(function () {
    Route::match(['put', 'patch'], 'product-reviews-rate/{product_review}', [ProductReviewRateController::class, 'rate'])
        ->name('product-reviews.rate');
});
