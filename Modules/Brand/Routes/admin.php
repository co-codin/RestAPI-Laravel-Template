<?php

use Illuminate\Support\Facades\Route;
use Modules\Brand\Http\Controllers\Admin\BrandController;
use Modules\Brand\Http\Controllers\Admin\BrandSeoController;

Route::patch('brands/{brand}/seo', [BrandSeoController::class, 'update']);

Route::resource('brands', BrandController::class)->except('index', 'show');
