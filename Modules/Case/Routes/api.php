<?php

use Illuminate\Support\Facades\Route;
use Modules\Case\Http\Controllers\CaseController;
use Modules\Case\Http\Controllers\CasePageController;

Route::get('page/cases', [CasePageController::class, 'index']);
Route::get('page/cases/{case}', [CasePageController::class, 'show']);

Route::resource('case_models', CaseController::class)->only(['index', 'show']);
