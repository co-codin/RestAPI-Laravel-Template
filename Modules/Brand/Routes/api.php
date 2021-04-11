<?php

use Illuminate\Support\Facades\Route;
use Modules\Brand\Http\Controllers\BrandController;

Route::resource('brands', BrandController::class)->only('index', 'show');
