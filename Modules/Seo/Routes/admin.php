<?php

use Illuminate\Support\Facades\Route;
use Modules\Seo\Http\Controllers\Admin\CanonicalController;
use Modules\Seo\Http\Controllers\Admin\SeoRuleController;
use Modules\Seo\Http\Controllers\Admin\SeoRuleSeoController;

Route::patch('seo-rules/{seo_rule}/seo', [SeoRuleSeoController::class, 'update']);

Route::resource('seo-rules', SeoRuleController::class)->except(['index', 'show']);
Route::resource('canonicals', CanonicalController::class)->except(['index', 'show']);
