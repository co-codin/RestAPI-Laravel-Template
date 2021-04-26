<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Admin\ProductController;

Route::resource('products', ProductController::class)->except(['index', 'show']);
