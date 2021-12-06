<?php

use App\Http\Middleware\ClientAuth;
use Modules\Review\Http\Controllers\ProductReviewController;
use Modules\Review\Http\Controllers\ProductReviewRateController;
use Modules\Review\Http\Middleware\ProductReviewRateMiddleware;

Route::apiResource('product-reviews', ProductReviewController::class)
    ->only('index', 'show');

Route::post('product-reviews', [ProductReviewController::class, 'store'])
    ->middleware(ClientAuth::class);

Route::middleware(ProductReviewRateMiddleware::class)->group(function () {
    Route::match(['put', 'patch'], 'product-reviews-rate/?id={product_review}', [ProductReviewRateController::class, 'rate']);
});
