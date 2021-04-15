<?php

use Illuminate\Support\Facades\Route;
use Modules\Seo\Http\Controllers\SeoRuleController;

Route::resource('seo-rules', SeoRuleController::class)->only(['index', 'show']);
