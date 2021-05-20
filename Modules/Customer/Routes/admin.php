<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\Admin\CustomerReviewController;

Route::resource('customer-reviews', CustomerReviewController::class)->except(['index', 'show']);
