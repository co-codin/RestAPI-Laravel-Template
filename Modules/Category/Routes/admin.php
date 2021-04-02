<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Admin\CategoryController;
use Modules\Category\Http\Controllers\Admin\CategorySeoController;

Route::patch('categories/{category}/seo', [CategorySeoController::class, 'update']);

Route::resource('categories', CategoryController::class);
