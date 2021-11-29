<?php

use Modules\Review\Http\Controllers\ProductReviewController;

Route::resource('product-reviews', ProductReviewController::class)->only('index', 'show', 'store');
