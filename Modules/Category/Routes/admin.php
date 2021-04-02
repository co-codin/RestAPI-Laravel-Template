<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Admin\CategoryController;
use Modules\Category\Http\Controllers\Admin\CategorySeoController;

Route::patch('categories/{parent_category}/seo', [CategorySeoController::class, 'parentUpdate']);
Route::patch('categories/{child_category}/seo', [CategorySeoController::class, 'childUpdate']);

Route::resource('categories', CategoryController::class);
