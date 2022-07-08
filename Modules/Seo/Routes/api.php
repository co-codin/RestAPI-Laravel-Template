<?php

use Illuminate\Support\Facades\Route;
use Modules\Seo\Http\Controllers\CanonicalController;
use Modules\Seo\Http\Controllers\SeoRuleController;
use Modules\Seo\Http\Controllers\SeoRulePageController;

Route::get('page/seo-rules/{seo_rule}', [SeoRulePageController::class, 'show'])
    ->where('seo_rule', '.*');;

Route::resource('seo-rules', SeoRuleController::class)->only(['index', 'show']);
Route::resource('canonicals', CanonicalController::class)->only(['index', 'show']);
