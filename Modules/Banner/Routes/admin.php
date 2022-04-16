<?php

use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\Admin\BannerController;

Route::post('banners/sort', [BannerController::class, 'sort'])->name('banners.sort');
Route::resource('banners', BannerController::class)->except('index', 'show');
