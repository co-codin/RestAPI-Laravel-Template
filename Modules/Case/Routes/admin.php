<?php

use Illuminate\Support\Facades\Route;
use Modules\Case\Http\Controllers\Admin\CaseController;
use Modules\Case\Http\Controllers\Admin\CaseSeoController;

Route::patch('case_models/{case}/seo', [CaseSeoController::class, 'update']);
Route::put('case_models/{case}/images', [CaseController::class, 'updateImages']);
Route::resource('case_models', CaseController::class)->except(['index', 'show']);
