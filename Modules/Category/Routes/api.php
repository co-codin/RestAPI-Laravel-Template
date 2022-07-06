<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\CategoryController;
use Modules\Category\Http\Controllers\CategoryPageController;

Route::resource('/page/categories', CategoryPageController::class)->only(['index', 'show']);

Route::get('categories/all', [CategoryController::class, 'all'])->name('categories.all');
Route::resource('categories', CategoryController::class)->only(['index', 'show']);
