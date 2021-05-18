<?php

use Illuminate\Support\Facades\Route;
use Modules\Seo\Http\Controllers\Admin\CanonicalController;
use Modules\Seo\Http\Controllers\Admin\SeoRuleController;

Route::resource('seo-rules', SeoRuleController::class)->except(['index', 'show']);
Route::resource('canonicals', CanonicalController::class)->except(['index', 'show']);
