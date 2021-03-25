<?php

use Illuminate\Support\Facades\Route;
use Modules\Brand\Http\Controllers\BrandController;

Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('brands/{slug}', [BrandController::class, 'show'])->name('brands.show');
