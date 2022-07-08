<?php

use Modules\Customer\Http\Controllers\CustomerReviewController;
use Modules\Customer\Http\Controllers\CustomerReviewPageController;

Route::get('page/customer-reviews', [CustomerReviewPageController::class, 'index']);

Route::resource('customer-reviews', CustomerReviewController::class)->only(['index', 'show']);
