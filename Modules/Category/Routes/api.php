<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\CategoryController;
use Modules\Category\Http\Controllers\CategoryPageController;

Route::get('/page/categories', [CategoryPageController::class, 'index']);
Route::get('/page/categories/{category}', [CategoryPageController::class, 'show'])
    ->where('category', '.*');

Route::get('categories/all', [CategoryController::class, 'all'])->name('categories.all');
Route::resource('categories', CategoryController::class)->only(['index', 'show']);
