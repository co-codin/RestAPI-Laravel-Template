<?php

use Illuminate\Support\Facades\Route;
use Modules\Review\Http\Controllers\Admin\ProductReviewController;

Route::apiResource('product-reviews', ProductReviewController::class)->except(['index', 'show', 'store']);
