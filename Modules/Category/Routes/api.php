<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\CategoryController;

Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('categories/{slug?}', [CategoryController::class, 'show'])
    ->name('categories.show')
    ->where('slug', '(.*)');
