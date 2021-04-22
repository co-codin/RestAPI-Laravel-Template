<?php

use Illuminate\Support\Facades\Route;
use Modules\Filter\Http\Controllers\Admin\FilterController;

Route::post('filters/sort', [FilterController::class, 'sort'])->name('filters.sort');
Route::resource('filters', FilterController::class)->except(['index', 'show']);
