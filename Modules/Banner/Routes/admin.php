<?php

use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\Admin\BannerController;

Route::resource('banners', BannerController::class)->except('index', 'show');
