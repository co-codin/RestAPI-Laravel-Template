<?php

use Illuminate\Support\Facades\Route;
use Modules\Seo\Http\Controllers\SeoRuleController;

Route::get('seo-rules', [SeoRuleController::class, 'index'])->name('seo_rules.index');
Route::get('seo-rules/{url}', [SeoRuleController::class, 'show'])->name('seo_rules.show');
