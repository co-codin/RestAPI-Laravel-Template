<?php

use Illuminate\Support\Facades\Route;
use Modules\Review\Http\Controllers\Admin\ProductReviewController;

Route::resource('product-reviews', ProductReviewController::class)->except(['index', 'show', 'store']);
