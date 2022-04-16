<?php

use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\BannerController;

Route::resource('banners', BannerController::class)->only('index', 'show');
