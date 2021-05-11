<?php

use Illuminate\Support\Facades\Route;
use Modules\Seo\Http\Controllers\CanonicalController;
use Modules\Seo\Http\Controllers\SeoRuleController;

Route::resource('seo-rules', SeoRuleController::class)->only(['index', 'show']);
Route::resource('canonicals', CanonicalController::class)->only(['index', 'show']);
