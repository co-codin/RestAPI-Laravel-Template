<?php

use Modules\Customer\Http\Controllers\CustomerReviewController;

Route::resource('customer-reviews', CustomerReviewController::class)->only(['index', 'show']);
