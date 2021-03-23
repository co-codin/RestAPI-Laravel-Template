<?php

use Illuminate\Support\Facades\Route;
use Modules\Brand\Http\Controllers\Admin\BrandController;

Route::resource('brands', BrandController::class);
